<?php

namespace App\Http\Controllers;

use App\Models\Proses;
use App\Models\Laporan;
use App\Models\Wip;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProsesController extends Controller
{
    public function index()
    {
        $proses = Proses::all();

        return view('proses', ['proses' => $proses]);
    }

    public function destroy($id)
    {
        $proses = Proses::find($id);

        $laporan = Laporan::where('id_proses', $id)->exists();
        $wip = Wip::where('id_proses', $id)->exists();

        if ($laporan) {
            return redirect('/proses')->with('success','Gagal Menghapus,Proses Terhubung Dengan Laporan Produksi');
        }
        if ($wip) {
            return redirect('/proses')->with('success','Gagal Menghapus,Proses Terhubung Dengan WIP');
        }
        else{
            $proses->delete();
            return redirect('/proses');
        }

            
    }

    public function show($id)
    {
        $proses = Proses::find($id);

        return view('/showproses',['proses'=>$proses]);
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'nama_proses' => ['required', 'max:255'],
        ]);
        
        
        Proses::create($attributes);


        return redirect('/proses');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_proses' => ['required', 'max:255'],
        ]);
        
        
        Proses::where('id_proses',$id)
        ->update([
            'nama_proses'    => $attributes['nama_proses'],
        ]);


        return redirect('/proses');
    }
}
