<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Material;
use App\Models\Customer;
use App\Models\Proses;
use App\Models\Wip;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishController extends Controller
{
    public function index()
    {
        $finish = Finish::with('Material','Customer')->orderBy('id_material','asc')->get();
        return view('finish',compact('finish'));
    }

    public function index2()
    {
        $material = Material::all();
        $customer = Customer::all();
        return view('finish_add',compact('material','customer'));
    }

    public function destroy($id)
    {
        $material = Finish::find($id);

        $material->delete();

        return redirect('/finish');
    }

    public function show($id)
    {
        $finish=Finish::with('material','customer')->find($id);
        $material = Material::all();
        $customer = Customer::all();

        return view('showfinish',compact('finish','material','customer'));
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'nama_pegawai'     => ['max:255'],
            'id_material'     => ['max:10'],
            'jumlah'     => ['max:10'],
            'id_customer' => ['max:10'],
            'qc' => ['max:100'],
        ]);
        $blanking=Proses::where('nama_proses','blanking')->first();
        $bending=Proses::where('nama_proses','bending')->first();
        $bending2=Proses::where('nama_proses','bending2')->orWhere('nama_proses','bending 2')->first();
        $no_proses=Proses::where('nama_proses','no proses')->orWhere('nama_proses','non proses')->first();
        $spot_nut=Proses::where('nama_proses','spot nut')->first();
        $piercing=Proses::where('nama_proses','piercing')->first();
        $spot_assy=Proses::where('nama_proses','spot assy')->first();
        $robot_welding=Proses::where('nama_proses','robot welding')->first();
        
        $wip = Wip::where('id_material', $attributes['id_material'])
            ->where('id_proses', $spot_nut->id_proses)
            ->first();
        
        if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $robot_welding->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $no_proses->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $piercing->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $spot_assy->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $bending2->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $bending->id_proses)
                ->first();
        }
        else if(!$wip){
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $blanking->id_proses)
                ->first();
        }

        
            
        if ($wip) {
            $sheet=$wip->jumlah_part;
            if ($sheet<$attributes['jumlah']) {
                return redirect('/finish_add')->with('success','Jumlah part melebihi stock yang tersisa');
            }
            else{
               $jumlah=$sheet-$attributes['jumlah'];

                Wip::where('id_material',$attributes['id_material'])->where('id_proses',$wip->id_proses)->update([
                'jumlah_part'    => $jumlah,
                ]); 
            }
        }
        else{
             return redirect('/finish_add')->with('success','Tidak Ada Stock Dari WIP'); 
        }
            
        
        Finish::create($attributes);


        return redirect('/finish');
        
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_pegawai'     => ['max:255'],
            'id_material'     => ['max:10'],
            'jumlah'     => ['max:10'],
            'id_customer' => ['max:10'],
            'qc' => ['max:100'],
        ]);

        $ngd = request()->validate([
            'id_material'     => ['max:50'],
            'jumlah' => ['max:10'],
        ]);

        $ngmat=$ngd['id_material'];
        $ng=$ngd['jumlah'];

        $blanking=Proses::where('nama_proses','blanking')->first();
        $bending=Proses::where('nama_proses','bending')->first();
        $bending2=Proses::where('nama_proses','bending2')->orWhere('nama_proses','bending 2')->first();
        $no_proses=Proses::where('nama_proses','no proses')->orWhere('nama_proses','non proses')->first();
        $spot_nut=Proses::where('nama_proses','spot nut')->first();
        $piercing=Proses::where('nama_proses','piercing')->first();
        $spot_assy=Proses::where('nama_proses','spot assy')->first();
        $robot_welding=Proses::where('nama_proses','robot welding')->first();
        
        $wip = Wip::where('id_material', $attributes['id_material'])
            ->where('id_proses', $spot_nut->id_proses)
            ->first();
        
        if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $robot_welding->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $no_proses->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $piercing->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $spot_assy->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $bending2->id_proses)
                ->first();
        }
        else if (!$wip) {
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $bending->id_proses)
                ->first();
        }
        else if(!$wip){
            $wip = Wip::where('id_material', $attributes['id_material'])
                ->where('id_proses', $blanking->id_proses)
                ->first();
        }

        $finished=Finish::find($id);

        if ($ngd['jumlah']<$finished->jumlah) {
            $exng=$finished->jumlah-$ngd['jumlah'];
            $jumlah=$wip->jumlah_part+$exng;
            Wip::where('id_wip',$wip->id_wip)
        ->update([
            'jumlah_part' => $jumlah,
            
        ]);
        }
        if ($ngd['jumlah']>$finished->jumlah) {
            
            $exng=$ngd['jumlah']-$finished->jumlah;
            $jumlah=$wip->jumlah_part-$exng;
            if ($jumlah<0) {
                return redirect('/showfinish/'.$id)->with('success','Jumlah part melebihi stock yang tersisa');
            }

            Wip::where('id_wip',$wip->id_wip)
            ->update([
                'jumlah_part' => $jumlah,
                
            ]);
        }
        
        
        Finish::where('id_finishgood',$id)
        ->update([
            'nama_pegawai' => $attributes['nama_pegawai'],
            'id_material' => $attributes['id_material'],
            'jumlah' => $attributes['jumlah'],
            'id_customer' => $attributes['id_customer'],
            'qc'     => $attributes['qc'],
            
        ]);


        return redirect('/finish');
    }
}
