<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Material;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index()
    {
        $delivery = Delivery::with('Material','Customer')->orderBy('id_delivery','asc')->get();
        return view('delivery',compact('delivery'));
    }

    public function index2()
    {
        $material = Material::all();
        $customer = Customer::all();
        return view('delivery_add',compact('material','customer'));
    }

    public function destroy($id)
    {
        $delivery = Delivery::find($id);

        $delivery->delete();

        return redirect('/delivery');
    }

    public function show($id)
    {
        $delivery=Delivery::with('material')->find($id);
        $material = Material::all();
        $customer = Customer::all();

        return view('showdelivery',compact('delivery','material','customer'));
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'no_surat_jalan'     => ['max:10'],
            'no_preorder'     => ['max:10'],
            'id_material'     => ['max:10'],
            'kg_perpart'=> ['max:100'],
            'id_customer'     => ['max:100'],
            'jumlah_part'      =>  ['max:50'],
            'tanggal_produksi'     => ['max:100'],
            'tanggal_delivery'     => ['max:100'],
            'qc'     => ['max:100'],
        ]);
        
        
        Delivery::create($attributes);


        return redirect('/delivery');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'no_surat_jalan'     => ['max:10'],
            'no_preorder'     => ['max:10'],
            'id_material'     => ['max:10'],
            'kg_perpart'=> ['max:100'],
            'id_customer'     => ['max:100'],
            'jumlah_part'      =>  ['max:50'],
            'tanggal_produksi'     => ['max:100'],
            'tanggal_delivery'     => ['max:100'],
            'qc'     => ['max:100'],
        ]);
        
        
        Delivery::where('id_delivery',$id)
        ->update([
            'no_surat_jalan' => $attributes['no_surat_jalan'],
            'no_preorder' => $attributes['no_preorder'],
            'id_material' => $attributes['id_material'],
            'kg_perpart' => $attributes['kg_perpart'],
            'id_customer' => $attributes['id_customer'],
            'jumlah_part' => $attributes['jumlah_part'],
            'tanggal_produksi' => $attributes['tanggal_produksi'],
            'tanggal_delivery' => $attributes['tanggal_delivery'],
            'qc' => $attributes['qc'],
        ]);


        return redirect('/delivery');
    }
}
