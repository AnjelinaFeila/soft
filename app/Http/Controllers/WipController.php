<?php

namespace App\Http\Controllers;

use App\Models\Wip;
use App\Models\Material;
use App\Models\Proses;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WipController extends Controller
{
    public function index()
    {
        $workin = Wip::with('Material','Proses')->orderBy('id_material','asc')->get();
        return view('wip',compact('workin'));
    }

    public function index2()
    {
        $material = Material::all();
        $proses = Proses::all();
        return view('wip_add',compact('material','proses'));
    }

    public function destroy($id)
    {
        $material = Wip::find($id);

        $material->delete();

        return redirect('/wip');
    }

    public function show($id)
    {
        $wip=Wip::with('material')->find($id);
        $material = Material::all();
        $proses = Proses::all();

        return view('showwip',compact('wip','material','proses'));
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'id_material'     => ['max:10'],
            'kg_perpart'     => ['max:10'],
            'jumlah_part' => ['max:10'],
            'last_produksi' => ['max:100'],
            'id_proses' => ['max:10'],
        ]);
        
        
        Wip::create($attributes);


        return redirect('/wip');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'id_material'     => ['max:10'],
            'kg_perpart'     => ['max:10'],
            'jumlah_part' => ['max:10'],
            'last_produksi' => ['max:100'],
            'id_proses' => ['max:10'],
        ]);
        
        
        Wip::where('id_wip',$id)
        ->update([
            'id_material' => $attributes['id_material'],
            'kg_perpart' => $attributes['kg_perpart'],
            'jumlah_part' => $attributes['jumlah_part'],
            'last_produksi'     => $attributes['last_produksi'],
            'id_proses' => $attributes['id_proses'],
        ]);


        return redirect('/wip');
    }
}
