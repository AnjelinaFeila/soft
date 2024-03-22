<?php

namespace App\Http\Controllers;

use App\Models\Tonase;
use App\Models\Laporan;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TonaseController extends Controller
{
    public function index()
    {
        $tonase = Tonase::all();

        return view('tonase', ['tonase' => $tonase]);
    }

    public function destroy($id)
    {
        $tonase = Tonase::find($id);

        $laporan = Laporan::where('id_tonase', $id)->exists();

        
        if ($laporan) {
            return redirect('/tonase')->with('success','Gagal Menghapus,Tonase Terhubung Dengan Stockraw');
        }
        else{
            $tonase->delete();

            return redirect('/tonase');
        }
            
    }

    public function show($id)
    {
        $tonase = Tonase::find($id);

        return view('/showtonase',['tonase'=>$tonase]);
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'nama_tonase' => ['required', 'max:255'],
        ]);
        
        
        Tonase::create($attributes);


        return redirect('/tonase');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_tonase' => ['required', 'max:255'],
        ]);
        
        
        Tonase::where('id_tonase',$id)
        ->update([
            'nama_tonase'    => $attributes['nama_tonase'],
        ]);


        return redirect('/tonase');
    }
}
