<?php

namespace App\Http\Controllers;

use App\Models\Stockraw;
use App\Models\Material;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockRawController extends Controller
{
    public function index()
    {
        $stockraw = Stockraw::with('Material','Customer','Supplier')->orderBy('id_material','asc')->get();
        return view('stockraw',compact('stockraw'));
    }

    public function index2()
    {
        $material = Material::all();
        $customer = Customer::all();
        $supplier = Supplier::all();
        return view('stockraw_add',compact('material','customer','supplier'));
    }

    public function destroy($id)
    {
        $stockraw = Stockraw::find($id);

        $stockraw->delete();

        return redirect('/stockraw');
    }

    public function show($id)
    {
        $stockraw=Stockraw::with('material')->find($id);
        $material = Material::all();
        $customer = Customer::all();
        $supplier = Supplier::all();

        return view('showstock',compact('stockraw','material','customer','supplier'));
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'no_preorder' => ['max:50'],
            'id_material'     => ['max:10'],
            'jumlah_sheet'=> ['max:100'],
            'kg_persheet'     => ['max:100'],
            'jumlah_nutt'     => ['max:100'],
            'id_supplier'     => ['max:100'],
            'id_customer'     => ['max:100'],
        ]);
        
        
        Stockraw::create($attributes);


        return redirect('/stockraw');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'no_preorder' => ['max:50'],
            'id_material'     => ['max:10'],
            'jumlah_sheet'=>['max:10'],
            'kg_persheet'     => ['max:100'],
            'jumlah_nutt'     => ['max:100'],
            'id_supplier'     => ['max:100'],
            'id_customer'     => ['max:100'],
        ]);
        
        
        Stockraw::where('id_stock_raw',$id)
        ->update([
            'no_preorder'    => $attributes['no_preorder'],
            'id_material' => $attributes['id_material'],
            'jumlah_sheet' => $attributes['jumlah_sheet'],
            'kg_persheet' => $attributes['kg_persheet'],
            'jumlah_nutt' => $attributes['jumlah_nutt'],
            'id_supplier' => $attributes['id_supplier'],
            'id_customer' => $attributes['id_customer'],
        ]);


        return redirect('/stockraw');
    }
}
