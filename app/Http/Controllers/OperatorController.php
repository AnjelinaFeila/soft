<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Laporan;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OperatorController extends Controller
{
    public function index()
    {
        $operator = Operator::all();

        return view('operator', ['operator' => $operator]);
    }

    public function destroy($id)
    {
        $operator = Operator::find($id);

        $laporan = Laporan::where('id_operator', $id)->exists();

        if ($laporan) {
            return redirect('/operator')->with('success','Gagal Menghapus,Operator Terhubung Dengan Laporan Produksi');
        }
        else{
            $operator->delete();

            return redirect('/operator');
        }

            
    }

    public function show($id)
    {
        $operator = Operator::find($id);

        return view('/showoperator',['operator'=>$operator]);
    }

    public function show2($id)
    {
        $laporan=Laporan::with('Operator')->where('id_operator',$id)->orderBy('tanggal','desc')->get();
        $op=Laporan::where('id_operator',$id)->first();

        if (!$laporan || !$op) {
            return redirect('/operator')->with('success','Operator tidak terdeteksi dalam laporan produksi');
        }

        return view('peroperator', ['laporan' => $laporan,'op' => $op]);
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'nama_operator' => ['required', 'max:255'],
            'contact'     => ['max:50'],
        ]);
        
        
        Operator::create($attributes);


        return redirect('/operator');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_operator' => ['required', 'max:255'],
            'contact'     => ['max:50'],
        ]);
        
        
        Operator::where('id_operator',$id)
        ->update([
            'nama_operator'    => $attributes['nama_operator'],
            'contact'     => $attributes['contact'],
        ]);


        return redirect('/operator');
    }
}
