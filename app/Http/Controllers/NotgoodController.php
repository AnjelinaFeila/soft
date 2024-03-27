<?php

namespace App\Http\Controllers;

use App\Models\Notgood;
use App\Models\Material;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotgoodController extends Controller
{
    public function index()
    {
        $notgood = Notgood::with('Material')->orderBy('id_material','asc')->get();
        return view('notgood',compact('notgood'));
    }

    public function destroy($id)
    {
        $material = Notgood::find($id);

        $material->delete();

        return redirect('/notgood');
    }

    public function show($id)
    {
        $notgood=Notgood::with('material')->find($id);
        $material = Material::all();

        return view('shownotgood',compact('notgood','material'));
    }


    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'id_material'     => ['max:10'],
            'jumlah_ng'     => ['max:10'],
            'keterangan' => ['max:255'],
        ]);
        
        
        Notgood::where('id_notgood',$id)
        ->update([
            'id_material' => $attributes['id_material'],
            'jumlah_ng' => $attributes['jumlah_ng'],
            'keterangan' => $attributes['keterangan'],
            
        ]);


        return redirect('/notgood');
    }
}
