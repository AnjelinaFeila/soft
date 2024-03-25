<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Material;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishController extends Controller
{
    public function index()
    {
        $finish = Finish::with('Material','Customer')->get();
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
            'id_material'     => ['max:10'],
            'jumlah'     => ['max:10'],
            'id_customer' => ['max:10'],
            'qc' => ['max:100'],
        ]);
        
        
        Finish::create($attributes);


        return redirect('/finish');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'id_material'     => ['max:10'],
            'jumlah'     => ['max:10'],
            'id_customer' => ['max:10'],
            'qc' => ['max:100'],
        ]);
        
        
        Finish::where('id_finishgood',$id)
        ->update([
            'id_material' => $attributes['id_material'],
            'jumlah' => $attributes['jumlah'],
            'id_customer' => $attributes['id_customer'],
            'qc'     => $attributes['qc'],
            
        ]);


        return redirect('/finish');
    }
}
