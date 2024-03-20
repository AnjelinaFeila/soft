<?php

namespace App\Http\Controllers;

use App\Models\Operator;
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

        $operator->delete();

        return redirect('/operator');
    }

    public function show($id)
    {
        $operator = Operator::find($id);

        return view('/showoperator',['operator'=>$operator]);
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
