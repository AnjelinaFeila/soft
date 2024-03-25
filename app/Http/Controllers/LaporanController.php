<?php


namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Material;
use App\Models\Proses;
use App\Models\Tonase;
use App\Models\Operator;
use App\Models\Stockraw;
use App\Models\Notgood;
use App\Models\Wip;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->input('search')=="") {
            $keyword = $request->input('search');
            $laporan = Laporan::whereHas('Material', function ($query) use ($keyword) {
                    $query->where('nama_barang', 'like', "$keyword");
                })
                ->orWhereHas('Proses', function ($query) use ($keyword) {
                    $query->where('nama_proses', 'like', "$keyword");
                })
                ->orWhereHas('Tonase', function ($query) use ($keyword) {
                    $query->where('nama_tonase', 'like', "$keyword");
                })
                ->orWhereHas('Operator', function ($query) use ($keyword) {
                    $query->where('nama_operator', 'like', "$keyword");
                })
                ->orWhere('jumlah_sheet', 'like', "$keyword")
                ->orWhere('jam_mulai', 'like', "$keyword")
                ->orWhere('jam_selesai', 'like', "$keyword")
                ->orWhere('jumlah_jam', 'like', "$keyword")
                ->orWhere('jumlah_ok', 'like', "$keyword")
                ->orWhere('jumlah_ng', 'like', "$keyword")
                ->orWhere('keterangan', 'like', "$keyword")
                ->orWhere('tanggal', 'like', "$keyword")
                ->paginate(5);
            return view('laporan',compact('laporan'));
        }
        else{
            $laporan = Laporan::with('Material','Proses','Tonase','Operator','Target')->orderBy('tanggal','desc')->paginate(5);
            return view('laporan',compact('laporan'));
    }
    }

    public function index2()
    {
        $material = Material::all();
        $proses = Proses::all();
        $tonase = Tonase::all();
        $operator = Operator::all();
        $stockraw = Stockraw::all();
        return view('laporan_add',compact('material','proses','tonase','operator','stockraw'));
    }

    public function destroy($id)
    {
        $laporan = Laporan::find($id);
        $ng=Notgood::where('id_material',$laporan->id_material)->first();
        $jumlah=$ng->jumlah_ng-$laporan->jumlah_ng;

        $laporan->delete();

        Notgood::where('id_notgood',$ng->id_notgood)
        ->update([
            'jumlah_ng' => $jumlah,
            
        ]);

        return redirect('/laporan');
    }

    public function show($id)
    {
        $laporan = Laporan::find($id);
        $material = Material::all();
        $proses = Proses::all();
        $tonase = Tonase::all();
        $operator = Operator::all();
        $stockraw = Stockraw::all();
        return view('/showlaporan',compact('laporan','material','proses','tonase','operator','stockraw'));
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'tanggal' => ['max:10'],
            'id_material'     => ['max:50'],
            'id_proses'     => ['max:50'],
            'id_tonase'     => ['max:100'],
            'jumlah_sheet'     => ['max:100'],
            'id_operator'     => ['max:100'],
            'jam_mulai' => ['max:10'],
            'jam_selesai' => ['max:10'],
            'jumlah_jam' => ['max:10'],
            'jumlah_ok' => ['max:10'],
            'jumlah_ng' => ['max:10'],
            'keterangan'=> ['max:255'],
        ]);

        $ngd = request()->validate([
            'id_material'     => ['max:50'],
            'jumlah_ng' => ['max:10'],
            'keterangan'=> ['max:255'],
        ]);

        $ngmat=$ngd['id_material'];
        $ng=$ngd['jumlah_ng'];
        $ngket=$ngd['keterangan'];

        $notgood=Notgood::where('id_material',$ngmat)->first();

        if ($notgood) {
            $exng=$notgood->jumlah_ng;
            $jumlah=$exng+$ng;
            if ($ngket=="") {
                $ngd['keterangan']=$notgood->keterangan;
            }
            Notgood::where('id_notgood',$notgood->id_notgood)
            ->update([
            'id_material' => $ngd['id_material'],
            'jumlah_ng' => $jumlah,
            'keterangan' => $ngd['keterangan'],
            ]);
        }
        else{
            Notgood::create($ngd);
        }

        $targ=Target::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();

        if (!$targ) {
            Target::create([
                'id_material' => $attributes['id_material'],
                'id_proses' => $attributes['id_proses'],
                'minimal_target' => 0,
            ]);
        }

        $jamm = Carbon::parse($attributes['jam_mulai']);
        $jams = Carbon::parse($attributes['jam_selesai']);

        $exh1 = Carbon::createFromTimeString('12:00:00');
        $exh2 = Carbon::createFromTimeString('13:00:00');

        $exh3 = Carbon::createFromTimeString('18:00:00');
        $exh4 = Carbon::createFromTimeString('18:30:00');

        $exh5 = Carbon::createFromTimeString('00:00:00');
        $exh6 = Carbon::createFromTimeString('04:30:00');

        $exh7 = Carbon::createFromTimeString('04:30:00');
        $exh8 = Carbon::createFromTimeString('05:00:00');

        if ($exh1->between($jamm, $jams) && $exh2->between($jamm, $jams)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->subMinutes(120);
        }

        if ($exh3->between($jamm, $jams) && $exh4->between($jamm, $jams)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->subMinutes(30);
        }

        if (!$jamm->between($exh5, $exh6) && $jams->between($exh5, $exh6)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->addMinutes(1410);
        }

        if ($exh7->between($jamm, $jams) && $exh8->between($jamm, $jams)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->subMinutes(30);
        }

        $difference = $jamm->diff($jams);

        $selisih = $difference->format('%H:%I:%S');
        
        $attributes['jumlah_jam']=$selisih;

        if ($attributes['id_proses']==1) {

            $stockraw=Stockraw::where('id_material',$attributes['id_material'])->first();
            $sheet=$stockraw->jumlah_sheet;
             $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->first();
            
            if ($sheet<$attributes['jumlah_sheet']) {
                return redirect('/laporan_add')->with('success','Jumlah sheet melebihi stock yang tersisa');
            }
            else{
               $jumlah=$sheet-$attributes['jumlah_sheet'];

                Stockraw::where('id_material',$attributes['id_material'])->update([
                'jumlah_sheet'    => $jumlah,
                ]); 
            }

            if ($wip) {
                $part=$wip->jumlah_part;
                $jumlah=$part+$attributes['jumlah_ok'];

                Wip::where('id_material',$attributes['id_material'])->update([
                'jumlah_part'    => $jumlah,
                ]);
            }
            else{
               return redirect('/laporan_add')->with('success','Material Tersebut Tidak ada di WIP'); 
            }
            
        }
        else{
            $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->first();
            
            if ($wip) {
                $part=$wip->jumlah_part;
                $jumlah=$part+$attributes['jumlah_ok'];

                Wip::where('id_material',$attributes['id_material'])->update([
                'jumlah_part'    => $jumlah,
                ]);
            }
            else{
               return redirect('/laporan_add')->with('success','Material Tersebut Tidak ada di WIP'); 
            }

             
        }


        
        Laporan::create($attributes);


        return redirect('/laporan');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'tanggal' => ['max:10'],
            'id_material'     => ['max:50'],
            'id_proses'     => ['max:50'],
            'id_tonase'     => ['max:100'],
            'jumlah_sheet'     => ['max:100'],
            'id_operator'     => ['max:100'],
            'jam_mulai' => ['max:10'],
            'jam_selesai' => ['max:10'],
            'jumlah_jam' => ['max:10'],
            'jumlah_ok' => ['max:10'],
            'jumlah_ng' => ['max:10'],
            'keterangan'=> ['max:255'],
        ]);

        $ngd = request()->validate([
            'id_material'     => ['max:50'],
            'jumlah_ng' => ['max:10'],
            'keterangan'=> ['max:255'],
        ]);

        $ngmat=$ngd['id_material'];
        $ng=$ngd['jumlah_ng'];
        $ngket=$ngd['keterangan'];

        $notgood=Notgood::where('id_material',$ngmat)->first();
        $ng_laporan=Laporan::find($id);

        if ($ngd['jumlah_ng']<$ng_laporan->jumlah_ng) {
            $exng=$ng_laporan->jumlah_ng-$ngd['jumlah_ng'];
            $jumlah=$notgood->jumlah_ng-$exng;
            if ($ngket=="") {
                $ngd['keterangan']=$notgood->keterangan;
            }
            Notgood::where('id_notgood',$notgood->id_notgood)
        ->update([
            'id_material' => $ngd['id_material'],
            'jumlah_ng' => $jumlah,
            'keterangan' => $ngd['keterangan'],
            
        ]);
        }
        if ($ngd['jumlah_ng']>$ng_laporan->jumlah_ng) {
            $exng=$ngd['jumlah_ng']-$ng_laporan->jumlah_ng;
            $jumlah=$notgood->jumlah_ng+$exng;
            if ($ngket=="") {
                $ngd['keterangan']=$notgood->keterangan;
            }
            Notgood::where('id_notgood',$notgood->id_notgood)
        ->update([
            'id_material' => $ngd['id_material'],
            'jumlah_ng' => $jumlah,
            'keterangan' => $ngd['keterangan'],
            
        ]);
        }

        $jamm = Carbon::parse($attributes['jam_mulai']);
        $jams = Carbon::parse($attributes['jam_selesai']);

        $jamm = Carbon::parse($attributes['jam_mulai']);
        $jams = Carbon::parse($attributes['jam_selesai']);

        $exh1 = Carbon::createFromTimeString('12:00:00');
        $exh2 = Carbon::createFromTimeString('13:00:00');
        $exh3 = Carbon::createFromTimeString('18:00:00');
        $exh4 = Carbon::createFromTimeString('18:30:00');
        $exh5 = Carbon::createFromTimeString('00:00:00');
        $exh6 = Carbon::createFromTimeString('01:00:00');
        $exh7 = Carbon::createFromTimeString('04:30:00');
        $exh8 = Carbon::createFromTimeString('05:00:00');

        if ($exh1->between($jamm, $jams) && $exh2->between($jamm, $jams)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->subMinutes(120);
        }

        if ($exh3->between($jamm, $jams) && $exh4->between($jamm, $jams)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->subMinutes(30);
        }

        if (!$jamm->between($exh5, $exh6) && $jams->between($exh5, $exh6)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->addMinutes(1410);
        }

        if ($exh7->between($jamm, $jams) && $exh8->between($jamm, $jams)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
            $jams->subMinutes(30);
        }

        $difference = $jamm->diff($jams);

        $selisih = $difference->format('%H:%I:%S');
        
        $attributes['jumlah_jam']=$selisih;
        
        if ($attributes['id_proses']==1) {

            $stockraw=Stockraw::where('id_material',$attributes['id_material'])->first();
            $sheet=$stockraw->jumlah_sheet;
            
            if ($sheet<$attributes['jumlah_sheet']) {
                return redirect('/laporan_add')->with('success','Jumlah sheet melebihi stock yang tersisa');
            }
            else{
               $jumlah=$sheet-$attributes['jumlah_sheet'];

                Stockraw::where('id_material',$attributes['id_material'])->update([
                'jumlah_sheet'    => $jumlah,
                ]); 
            }
            
        }
        else{
            $wip=Wip::where('id_material',$attributes['id_material'])->first();
            
            if ($wip) {
                $part=$wip->jumlah_part;
                $jumlah=$part+$attributes['jumlah_ok'];

                Wip::where('id_material',$attributes['id_material'])->update([
                'jumlah_part'    => $jumlah,
                ]);
            }
            else{
               return redirect('/laporan_add')->with('success','Material Tersebut Tidak ada di WIP'); 
            }

             
        }
        
        Laporan::where('id_laporan_produksi',$id)
        ->update([
            'tanggal'    => $attributes['tanggal'],
            'id_material' => $attributes['id_material'],
            'id_proses'     => $attributes['id_proses'],
            'id_tonase' => $attributes['id_tonase'],
            'jumlah_sheet' => $attributes['jumlah_sheet'],
            'id_operator' => $attributes['id_operator'],
            'jam_mulai' => $attributes['jam_mulai'],
            'jam_selesai' => $attributes['jam_selesai'],
            'jumlah_jam' => $attributes['jumlah_jam'],
            'jumlah_ok' => $attributes['jumlah_ok'],
            'jumlah_ng' => $attributes['jumlah_ng'],
            'keterangan' => $attributes['keterangan'],
        ]);


        return redirect('/laporan');
    }
}
