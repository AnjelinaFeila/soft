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
            $laporan = Laporan::with('Material','Proses','Tonase','Operator','Target')->orderBy('tanggal','desc')->orderBy('id_material','asc')->orderBy('id_proses','asc')->paginate(8);
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
    $laporan = Laporan::findOrFail($id);

    // Get the corresponding Notgood record for the material used in the Laporan
    $notgood = Notgood::where('id_material', $laporan->id_material)->first();

    // Check if the Notgood record exists before trying to update its jumlah_ng property
    if ($notgood) {
        // Calculate the new value of jumlah_ng for the Notgood record
        $jumlah = $notgood->jumlah_ng - $laporan->jumlah_ng;

        if ($jumlah < 0) {
            $jumlah=0;
        }

        // Update the Notgood record with the new value of jumlah_ng
        Notgood::where('id_notgood', $notgood->id_notgood)
            ->update([
                'jumlah_ng' => $jumlah,
            ]);
    }

    // Delete the Laporan record
    $laporan->delete();

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
        $exh6 = Carbon::createFromTimeString('01:00:00');

        $exh7 = Carbon::createFromTimeString('04:30:00');
        $exh8 = Carbon::createFromTimeString('05:00:00');

        $ret=0;

        if ($jamm->lt($jams)) {

            if ($jamm->lt($exh1) && $jams->gt($exh2)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=60;
            }

            if ($jamm->lt($exh3) && $jams->gt($exh4)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }

            if ($jamm->lt($exh5) && $jams->gt($exh6)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $jams->addMinutes(1380);
            }

            
            if ($jamm->lt($exh7) && $jams->gt($exh8)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }
        }
        else {

            if ($jamm->lt($exh1) || $jams->gt($exh2)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=60;
            }

            if ($jamm->lt($exh3) || $jams->gt($exh4)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }

            
            if ($jamm->lt($exh7) || $jams->gt($exh8)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }
        $jams->addMinutes(1380);


        }

        $jams->subMinutes($ret);

        $difference = $jamm->diff($jams);

        $selisih = $difference->format('%H:%I:%S');
        
        $attributes['jumlah_jam']=$selisih;


        $idproses="";
        if ($proses=Proses::where('nama_proses','blanking')->first()) {
            $idproses=$proses->id_proses;
        }

        if ($attributes['id_proses']==$idproses) {

            $persheet=Material::where('id_material',$attributes['id_material'])->first();
            $valok=$persheet->jumlah_persheet*$attributes['jumlah_sheet'];

            if ($attributes['jumlah_ok']>$valok) {
                return redirect('/laporan_add')->with('success','Jumlah ok melebihi total sheet yang di kerjakan');
            }

            if ($stockraw=Stockraw::where('id_material',$attributes['id_material'])->first()) {
                $sheet=$stockraw->jumlah_sheet;
            }
            else{
                return redirect('/laporan_add')->with('success','Material tidak terdata di stockraw');
            }
            
            
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





        if ($blanking=Proses::where('nama_proses','blanking')->first()) {
            $idblanking=$blanking->id_proses;
        }
        if ($bending=Proses::where('nama_proses','bending')->first()) {
            $idbending=$bending->id_proses;
        }
        if ($bending2=Proses::where('nama_proses','bending2')->orWhere('nama_proses','bending 2')->first()) {
            $idbending2=$bending2->id_proses;
        }

        $nextproses=Proses::where('id_proses',$attributes['id_proses'])->first();
        
        if ($attributes['id_material']==4 || $attributes['id_material']==8 || $attributes['id_material']==9 || $attributes['id_material']==11 || $attributes['id_material']==15 || $attributes['id_material']==16 || $attributes['id_material']==17 || $attributes['id_material']==27 || $attributes['id_material']==28 || $attributes['id_material']==25 || $attributes['id_material']==29 || $attributes['id_material']==30) {
             if ($nextproses->nama_proses=='bending') {
                $idmaterial=$attributes['id_material'];
                if ($attributes['id_material']==8 || $attributes['id_material']==9) {
                    $idmaterial=54;
                }
                else if ($attributes['id_material']==15 || $attributes['id_material']==16) {
                    $idmaterial=39;
                }
                else if ($attributes['id_material']==27 || $attributes['id_material']==28) {
                    $idmaterial=60;
                }
                if ($nextwip=Wip::where('id_material',$idmaterial)->where('id_proses',$idblanking)->first()) {
                    $jmlpart=$nextwip->jumlah_part;
                    $nexttotal=$jmlpart-$attributes['jumlah_ok'];

                    if ($nexttotal<0) {
                         return redirect('/laporan_add')->with('success','Jumlah part melebihi stock blanking yang tersisa');
                    }

                    Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $nexttotal,
                    ]);

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        $work=$newwip->jumlah_part+$attributes['jumlah_ok'];
                        Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                        ->update([
                            'jumlah_part' => $work,
                        ]);
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/laporan_add')->with('success','Material tersebut tidak dalam proses blanking'); 
                }
            }
            else if ($nextproses->nama_proses=='bending2' || $nextproses->nama_proses=='bending 2') {
                if ($nextwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$idbending)->first()) {
                    $jmlpart=$nextwip->jumlah_part;
                    $nexttotal=$jmlpart-$attributes['jumlah_ok'];

                    if ($nexttotal<0) {
                         return redirect('/laporan_add')->with('success','Jumlah part melebihi stock bending yang tersisa');
                    }

                    Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $nexttotal,
                    ]);

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        $work=$newwip->jumlah_part+$attributes['jumlah_ok'];
                        Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                        ->update([
                            'jumlah_part' => $work,
                        ]);
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/laporan_add')->with('success','Material tersebut tidak dalam proses bending'); 
                }
            }
            else if ($nextproses->nama_proses=='spot nut') {
                if ($nextwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$idbending2)->first()) {
                    $jmlpart=$nextwip->jumlah_part;
                    $nexttotal=$jmlpart-$attributes['jumlah_ok'];

                    if ($nexttotal<0) {
                         return redirect('/laporan_add')->with('success','Jumlah part melebihi stock bending 2 yang tersisa');
                    }

                    Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $nexttotal,
                    ]);

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        $work=$newwip->jumlah_part+$attributes['jumlah_ok'];
                        Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                        ->update([
                            'jumlah_part' => $work,
                        ]);
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/laporan_add')->with('success','Material tersebut tidak dalam proses bending 2'); 
                }
            }
            else{
                $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();
                
                if ($wip) {
                    $part=$wip->jumlah_part;
                    $jumlah=$part+$attributes['jumlah_ok'];

                    Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->update([
                    'jumlah_part'    => $jumlah,
                    ]);
                }
                else{
                    $nextwip = new Wip();
                    $nextwip->id_material = $attributes['id_material'];
                    $nextwip->kg_perpart = 0;
                    $nextwip->jumlah_part = $attributes['jumlah_ok'];
                    $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                    $nextwip->id_proses = $attributes['id_proses'];

                    $nextwip->save();
                }
            }
        }
        else if ($attributes['id_material']==22 || $attributes['id_material']==23 || $attributes['id_material']==57 || $attributes['id_material']==21 || $attributes['id_material']==18 || $attributes['id_material']==19 || $attributes['id_material']==10 || $attributes['id_material']==6 || $attributes['id_material']==7 || $attributes['id_material']==36 || $attributes['id_material']==37) {
             if ($nextproses->nama_proses=='bending') {
                $idmaterial=$attributes['id_material'];
                if ($attributes['id_material']==22 || $attributes['id_material']==23) {
                    $idmaterial=58;
                }
                else if ($attributes['id_material']==18 || $attributes['id_material']==19) {
                    $idmaterial=56;
                }
                else if ($attributes['id_material']==6 || $attributes['id_material']==7) {
                    $idmaterial=55;
                }
                if ($nextwip=Wip::where('id_material',$idmaterial)->where('id_proses',$idblanking)->first()) {
                    $jmlpart=$nextwip->jumlah_part;
                    $nexttotal=$jmlpart-$attributes['jumlah_ok'];

                    if ($nexttotal<0) {
                         return redirect('/laporan_add')->with('success','Jumlah part melebihi stock blanking yang tersisa');
                    }

                    Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $nexttotal,
                    ]);

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        $work=$newwip->jumlah_part+$attributes['jumlah_ok'];
                        Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                        ->update([
                            'jumlah_part' => $work,
                        ]);
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/laporan_add')->with('success','Material tersebut tidak dalam proses blanking'); 
                }
            }
            else if ($nextproses->nama_proses=='bending2' || $nextproses->nama_proses=='bending 2') {
                if ($nextwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$idbending)->first()) {
                    $jmlpart=$nextwip->jumlah_part;
                    $nexttotal=$jmlpart-$attributes['jumlah_ok'];

                    if ($nexttotal<0) {
                         return redirect('/laporan_add')->with('success','Jumlah part melebihi stock bending yang tersisa');
                    }

                    Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $nexttotal,
                    ]);

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        $work=$newwip->jumlah_part+$attributes['jumlah_ok'];
                        Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                        ->update([
                            'jumlah_part' => $work,
                        ]);
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/laporan_add')->with('success','Material tersebut tidak dalam proses bending'); 
                }
            }
            else{
                $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();
                
                if ($wip) {
                    $part=$wip->jumlah_part;
                    $jumlah=$part+$attributes['jumlah_ok'];

                    Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->update([
                    'jumlah_part'    => $jumlah,
                    ]);
                }
                else{
                    $nextwip = new Wip();
                    $nextwip->id_material = $attributes['id_material'];
                    $nextwip->kg_perpart = 0;
                    $nextwip->jumlah_part = $attributes['jumlah_ok'];
                    $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                    $nextwip->id_proses = $attributes['id_proses'];

                    $nextwip->save();
                }
            }
        }
        else if ($nextproses->nama_proses=='bending') {
            $idmaterial=$attributes['id_material'];
            if ($attributes['id_material']==13 || $attributes['id_material']==14) {
                $idmaterial=38;
            }
            else if ($attributes['id_material']==33 || $attributes['id_material']==34) {
                $idmaterial=59;
            }
            if ($nextwip=Wip::where('id_material',$idmaterial)->where('id_proses',$idblanking)->first()) {
                $jmlpart=$nextwip->jumlah_part;
                $nexttotal=$jmlpart-$attributes['jumlah_ok'];

                if ($nexttotal<0) {
                        return redirect('/laporan_add')->with('success','Jumlah part melebihi stock blanking yang tersisa');
                }

                Wip::where('id_wip',$nextwip->id_wip)
                ->update([
                    'jumlah_part' => $nexttotal,
                ]);

                if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                    $work=$newwip->jumlah_part+$attributes['jumlah_ok'];
                    Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                    ->update([
                        'jumlah_part' => $work,
                    ]);
                }
                else{
                    $nextwip = new Wip();
                    $nextwip->id_material = $attributes['id_material'];
                    $nextwip->kg_perpart = 0;
                    $nextwip->jumlah_part = $attributes['jumlah_ok'];
                    $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                    $nextwip->id_proses = $attributes['id_proses'];

                    $nextwip->save(); 
                }

            }
            else{
                return redirect('/laporan_add')->with('success','Material tersebut tidak dalam proses blanking'); 
            }
        }
        else{
            $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();
            
            if ($wip) {
                $part=$wip->jumlah_part;
                $jumlah=$part+$attributes['jumlah_ok'];

                Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->update([
                'jumlah_part'    => $jumlah,
                ]);
            }
            else{
                $nextwip = new Wip();
                $nextwip->id_material = $attributes['id_material'];
                $nextwip->kg_perpart = 0;
                $nextwip->jumlah_part = $attributes['jumlah_ok'];
                $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                $nextwip->id_proses = $attributes['id_proses'];

                $nextwip->save();
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
            if ($jumlah<0) {
               $jumlah=0;
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

        $exh1 = Carbon::createFromTimeString('12:00:00');
        $exh2 = Carbon::createFromTimeString('13:00:00');

        $exh3 = Carbon::createFromTimeString('18:00:00');
        $exh4 = Carbon::createFromTimeString('18:30:00');

        $exh5 = Carbon::createFromTimeString('00:00:00');
        $exh6 = Carbon::createFromTimeString('01:00:00');

        $exh7 = Carbon::createFromTimeString('04:30:00');
        $exh8 = Carbon::createFromTimeString('05:00:00');

        $ret=0;

        if ($jamm->lt($jams)) {

            if ($jamm->lt($exh1) && $jams->gt($exh2)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=60;
            }

            if ($jamm->lt($exh3) && $jams->gt($exh4)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }

            if ($jamm->lt($exh5) && $jams->gt($exh6)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $jams->addMinutes(1380);
            }

            
            if ($jamm->lt($exh7) && $jams->gt($exh8)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }
        }
        else {

            if ($jamm->lt($exh1) || $jams->gt($exh2)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=60;
            }

            if ($jamm->lt($exh3) || $jams->gt($exh4)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }

            
            if ($jamm->lt($exh7) || $jams->gt($exh8)) {
        // Kurangi 60 menit dari waktu selesai jika ada waktu pengecualian
                $ret+=30;
            }
        $jams->addMinutes(1380);


        }

        $jams->subMinutes($ret);

        $difference = $jamm->diff($jams);

        $selisih = $difference->format('%H:%I:%S');
        $attributes['jumlah_jam']=$selisih;

        $idproses="";
        if ($proses=Proses::where('nama_proses','blanking')->first()) {
            $idproses=$proses->id_proses;

            
        }

        if ($attributes['id_proses']==$idproses) {

            $persheet=Material::where('id_material',$attributes['id_material'])->first();
            $valok=$persheet->jumlah_persheet*$attributes['jumlah_sheet'];

            if ($attributes['jumlah_ok']>$valok) {
                return redirect('/laporan_add')->with('success','Jumlah ok melebihi total sheet yang di kerjakan');
            } 

            $laporan=Laporan::find($id);
            $sheet=$laporan->jumlah_sheet;


            if ($sheet<$attributes['jumlah_sheet']) {
                $ngmat=$attributes['id_material'];
                $ng=$attributes['jumlah_sheet'];

                $stockraw=Stockraw::where('id_material',$ngmat)->first();
                $laporan=Laporan::find($id);

                if ($attributes['jumlah_sheet']<$laporan->jumlah_sheet) {
                    $exng=$laporan->jumlah_sheet-$attributes['jumlah_sheet'];
                    $jumlah=$stockraw->jumlah_sheet+$exng;
                    


                    Stockraw::where('id_material',$laporan->id_material)
                ->update([
                    'jumlah_sheet' => $jumlah,
                    
                ]);
                }
                if ($attributes['jumlah_sheet']>$laporan->jumlah_sheet) {
                    $exng=$attributes['jumlah_sheet']-$laporan->jumlah_sheet;
                    $jumlah=$stockraw->jumlah_sheet-$exng;

                    if ($jumlah<0) {
                        return redirect('/showlaporan/'.$id)->with('success','Jumlah Sheet melebihi stock yang tersisa');
                    }

                    Stockraw::where('id_material',$laporan->id_material)
                    ->update([
                        'jumlah_sheet' => $jumlah,
                        
                    ]);
                }
            }
            if ($sheet>$attributes['jumlah_sheet']){
                $ngmat=$attributes['id_material'];
                $ng=$attributes['jumlah_sheet'];

                $stockraw=Stockraw::where('id_material',$ngmat)->first();
                $laporan=Laporan::find($id);

                if ($attributes['jumlah_sheet']<$laporan->jumlah_sheet) {
                    $exng=$laporan->jumlah_sheet-$attributes['jumlah_sheet'];
                    $jumlah=$stockraw->jumlah_sheet+$exng;
                    
                    Stockraw::where('id_material',$laporan->id_material)
                ->update([
                    'jumlah_sheet' => $jumlah,
                    
                ]);
                }
                if ($attributes['jumlah_sheet']>$laporan->jumlah_sheet) {
                    $exng=$attributes['jumlah_sheet']-$laporan->jumlah_sheet;
                    $jumlah=$stockraw->jumlah_sheet-$exng;

                    if ($jumlah<0) {
                        return redirect('/showlaporan/'.$id)->with('success','Jumlah Sheet melebihi stock yang tersisa');
                    }
                    

                    Stockraw::where('id_material',$laporan->id_material)
                    ->update([
                        'jumlah_sheet' => $jumlah,
                        
                    ]);
                }
            }

            

        }


        if ($blanking=Proses::where('nama_proses','blanking')->first()) {
            $idblanking=$blanking->id_proses;
        }
        if ($bending=Proses::where('nama_proses','bending')->first()) {
            $idbending=$bending->id_proses;
        }
        if ($bending2=Proses::where('nama_proses','bending2')->orWhere('nama_proses','bending 2')->first()) {
            $idbending2=$bending2->id_proses;
        }

        $nextproses=Proses::where('id_proses',$attributes['id_proses'])->first();
        
        if ($attributes['id_material']==4 || $attributes['id_material']==8 || $attributes['id_material']==9 || $attributes['id_material']==11 || $attributes['id_material']==15 || $attributes['id_material']==16 || $attributes['id_material']==17 || $attributes['id_material']==27 || $attributes['id_material']==28 || $attributes['id_material']==25 || $attributes['id_material']==29 || $attributes['id_material']==30) {
             if ($nextproses->nama_proses=='bending') {
                $idmaterial=$attributes['id_material'];
                if ($attributes['id_material']==8 || $attributes['id_material']==9) {
                    $idmaterial=54;
                }
                else if ($attributes['id_material']==15 || $attributes['id_material']==16) {
                    $idmaterial=39;
                }
                else if ($attributes['id_material']==27 || $attributes['id_material']==28) {
                    $idmaterial=60;
                }
                if ($nextwip=Wip::where('id_material',$idmaterial)->where('id_proses',$idblanking)->first()) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$nextwip->jumlah_part+$exng;

                        
                        Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$nextwip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock bending 2 yang tersisa');
                        }

                        Wip::where('id_wip',$nextwip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                            $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                            $work=$newwip->jumlah_part-$exng;

                            if ($work<0) {
                                return redirect('/showlaporan/'.$id)->with('success','Jumlah ok tidak bisa minus');
                            }

                            Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                            $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                            $work=$newwip->jumlah_part+$exng;

                            

                            Wip::where('id_proses',$newwip->id_proses)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/showlaporan/'.$id)->with('success','Material tersebut tidak dalam proses blanking'); 
                }
            }
            else if ($nextproses->nama_proses=='bending2' || $nextproses->nama_proses=='bending 2') {
                if ($nextwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$idbending)->first()) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$nextwip->jumlah_part+$exng;

                        

                        Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$nextwip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock bending yang tersisa');
                        }

                        Wip::where('id_wip',$nextwip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                            $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                            $work=$newwip->jumlah_part-$exng;

                            if ($work<0) {
                                return redirect('/showlaporan/'.$id)->with('success','Jumlah ok tidak bisa minus');
                            }

                            Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                            $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                            $work=$newwip->jumlah_part+$exng;

                            

                            Wip::where('id_proses',$newwip->id_proses)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/showlaporan/'.$id)->with('success','Material tersebut tidak dalam proses bending'); 
                }
            }
            else if ($nextproses->nama_proses=='spot nut') {
                if ($nextwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$idbending2)->first()) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$nextwip->jumlah_part+$exng;

                        

                        Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$nextwip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock bending 2 yang tersisa');
                        }

                        Wip::where('id_wip',$nextwip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                            $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                            $work=$newwip->jumlah_part-$exng;

                            if ($work<0) {
                                return redirect('/showlaporan/'.$id)->with('success','Jumlah ok tidak bisa minus');
                            }

                            Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                            $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                            $work=$newwip->jumlah_part+$exng;

                            

                            Wip::where('id_proses',$newwip->id_proses)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        

                            
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/showlaporan/'.$id)->with('success','Material tersebut tidak dalam proses bending 2'); 
                }
            }
            else{
                $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();
                
                if ($wip) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$wip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock yang tersisa');
                        }

                        Wip::where('id_wip',$wip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$wip->jumlah_part+$exng;

                        

                        Wip::where('id_wip',$wip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }
                }
                else{
                    $nextwip = new Wip();
                    $nextwip->id_material = $attributes['id_material'];
                    $nextwip->kg_perpart = 0;
                    $nextwip->jumlah_part = $attributes['jumlah_ok'];
                    $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                    $nextwip->id_proses = $attributes['id_proses'];

                    $nextwip->save();
                }
                
                
            }
        }
        else if ($attributes['id_material']==22 || $attributes['id_material']==23 || $attributes['id_material']==57 || $attributes['id_material']==21 || $attributes['id_material']==18 || $attributes['id_material']==19 || $attributes['id_material']==10 || $attributes['id_material']==6 || $attributes['id_material']==7 || $attributes['id_material']==36 || $attributes['id_material']==37) {
             if ($nextproses->nama_proses=='bending') {
                $idmaterial=$attributes['id_material'];
                if ($attributes['id_material']==22 || $attributes['id_material']==23) {
                    $idmaterial=58;
                }
                else if ($attributes['id_material']==18 || $attributes['id_material']==19) {
                    $idmaterial=56;
                }
                else if ($attributes['id_material']==6 || $attributes['id_material']==7) {
                    $idmaterial=55;
                }
                if ($nextwip=Wip::where('id_material',$idmaterial)->where('id_proses',$idblanking)->first()) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$nextwip->jumlah_part+$exng;

                        

                        Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$nextwip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock bending 2 yang tersisa');
                        }

                        Wip::where('id_wip',$nextwip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                            $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                            $work=$newwip->jumlah_part-$exng;

                            if ($work<0) {
                                return redirect('/showlaporan/'.$id)->with('success','Jumlah ok tidak bisa minus');
                            }

                            Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                            $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                            $work=$newwip->jumlah_part+$exng;

                            

                            Wip::where('id_proses',$newwip->id_proses)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/showlaporan/'.$id)->with('success','Material tersebut tidak dalam proses blanking'); 
                }
            }
            else if ($nextproses->nama_proses=='bending2' || $nextproses->nama_proses=='bending 2') {
                if ($nextwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$idbending)->first()) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$nextwip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock bending yang tersisa');
                        }

                        Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$nextwip->jumlah_part+$exng;

                        Wip::where('id_wip',$nextwip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                            $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                            $work=$newwip->jumlah_part-$exng;

                            if ($work<0) {
                                return redirect('/showlaporan/'.$id)->with('success','Jumlah ok tidak bisa minus');
                            }
                            

                            Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                            $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                            $work=$newwip->jumlah_part+$exng;

                            

                            Wip::where('id_proses',$newwip->id_proses)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/showlaporan/'.$id)->with('success','Material tersebut tidak dalam proses bending'); 
                }
            }
            else{
                $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();
                
                if ($wip) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$wip->jumlah_part+$exng;

                        

                        Wip::where('id_wip',$wip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$wip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock yang tersisa');
                        }

                        Wip::where('id_wip',$wip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }
                }
                else{
                    $nextwip = new Wip();
                    $nextwip->id_material = $attributes['id_material'];
                    $nextwip->kg_perpart = 0;
                    $nextwip->jumlah_part = $attributes['jumlah_ok'];
                    $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                    $nextwip->id_proses = $attributes['id_proses'];

                    $nextwip->save();
                }
                
                
            }
        }
        else if ($nextproses->nama_proses=='bending') {
                $idmaterial=$attributes['id_material'];
                if ($attributes['id_material']==13 || $attributes['id_material']==14) {
                    $idmaterial=38;
                }
                else if ($attributes['id_material']==33 || $attributes['id_material']==34) {
                    $idmaterial=59;
                }
                if ($nextwip=Wip::where('id_material',$idmaterial)->where('id_proses',$idblanking)->first()) {
                    $laporan=Laporan::find($id);

                    if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                        $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                        $jumlah=$nextwip->jumlah_part+$exng;

                        Wip::where('id_wip',$nextwip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                    }
                    if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                        $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                        $jumlah=$nextwip->jumlah_part-$exng;

                        if ($jumlah<0) {
                            return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock bending 2 yang tersisa');
                        }

                        Wip::where('id_wip',$nextwip->id_wip)
                        ->update([
                            'jumlah_part' => $jumlah,
                            
                        ]);
                    }

                    if ($newwip=Wip::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first()) {
                        if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                            $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                            $work=$newwip->jumlah_part-$exng;

                            if ($work<0) {
                                return redirect('/showlaporan/'.$id)->with('success','Jumlah ok tidak bisa minus');
                            }
                            

                            Wip::where('id_proses',$newwip->id_proses)->where('id_material',$newwip->id_material)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                        if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                            $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                            $work=$newwip->jumlah_part+$exng;

                            

                            Wip::where('id_proses',$newwip->id_proses)
                            ->update([
                                'jumlah_part' => $work,
                            ]);
                        }
                    }
                    else{
                       $nextwip = new Wip();
                        $nextwip->id_material = $attributes['id_material'];
                        $nextwip->kg_perpart = 0;
                        $nextwip->jumlah_part = $attributes['jumlah_ok'];
                        $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                        $nextwip->id_proses = $attributes['id_proses'];

                        $nextwip->save(); 
                    }

                }
                else{
                   return redirect('/showlaporan/'.$id)->with('success','Material tersebut tidak dalam proses blanking'); 
                }
            }
        else{
            $wip=Wip::with('Proses')->where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();
            
            if ($wip) {
                $laporan=Laporan::find($id);

                if ($attributes['jumlah_ok']<$laporan->jumlah_ok) {
                    $exng=$laporan->jumlah_ok-$attributes['jumlah_ok'];
                    $jumlah=$wip->jumlah_part+$exng;


                    Wip::where('id_wip',$wip->id_wip)
                ->update([
                    'jumlah_part' => $jumlah,
                    
                ]);
                }
                if ($attributes['jumlah_ok']>$laporan->jumlah_ok) {
                    $exng=$attributes['jumlah_ok']-$laporan->jumlah_ok;
                    $jumlah=$wip->jumlah_part-$exng;

                    if ($jumlah<0) {
                        return redirect('/showlaporan/'.$id)->with('success','Jumlah part melebihi stock yang tersisa');
                    }

                    Wip::where('id_wip',$wip->id_wip)
                    ->update([
                        'jumlah_part' => $jumlah,
                        
                    ]);
                }
            }
            else{
                $nextwip = new Wip();
                $nextwip->id_material = $attributes['id_material'];
                $nextwip->kg_perpart = 0;
                $nextwip->jumlah_part = $attributes['jumlah_ok'];
                $nextwip->last_produksi = now(); // Assuming 'last_produksi' is a timestamp field
                $nextwip->id_proses = $attributes['id_proses'];

                $nextwip->save();
            }


        }


        $targ=Target::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();

        if (!$targ) {
            Target::create([
                'id_material' => $attributes['id_material'],
                'id_proses' => $attributes['id_proses'],
                'minimal_target' => 0,
            ]);
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
