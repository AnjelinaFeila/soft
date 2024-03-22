<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Stockraw;
use App\Models\Wip;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Delivery;
use App\Models\Laporan;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MaterialController extends Controller
{
    public function index()
    {
        $material = Material::with('Customer','Supplier')->orderBy('nama_barang','asc')->get();
        return view('material',compact('material'));
    }

    public function index2()
    {
        $customer = Customer::all();
        $supplier = Supplier::all();
        return view('material_add',compact('customer','supplier'));
    }

    public function destroy($id)
    {
        $material = Material::find($id);

        $laporan = Laporan::where('id_material', $id)->exists();
        $stockraw = Stockraw::where('id_material', $id)->exists();
        $wip = Wip::where('id_material', $id)->exists();
        $delivery = Delivery::where('id_material', $id)->exists();

        if ($laporan) {
            return redirect('/material')->with('success','Gagal Menghapus,Material Terhubung Dengan Laporan Produksi');
        }
        if ($stockraw) {
            return redirect('/material')->with('success','Gagal Menghapus,Material Terhubung Dengan Stockraw');
        }
        if ($wip) {
            return redirect('/material')->with('success','Gagal Menghapus,Material Terhubung Dengan WIP');
        }
        if ($delivery) {
            return redirect('/material')->with('success','Gagal Menghapus,Material Terhubung Dengan Delivery');
        }
        else{
            $material->delete();

            return redirect('/material');
        }
        
    }

    public function show($id)
    {
        $material = Material::find($id);
        $customer = Customer::all();
        $supplier = Supplier::all();
        return view('/showmat',compact('material','customer','supplier'));
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'nama_barang' => ['required', 'max:255'],
            'kg_persheet'     => ['max:50'],
            'kg_perpart'     => ['max:50'],
            'ukuran'     => ['max:100'],
            'id_supplier' => ['max:255'],
            'id_customer' => ['max:255'],
        ]);
        
        
        Material::create($attributes);


        return redirect('/material');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_barang' => ['max:255'],
            'kg_persheet'     => ['max:50'],
            'kg_perpart'     => ['max:50'],
            'ukuran'     => ['max:100'],
            'id_supplier' => ['max:255'],
            'id_customer' => ['max:255'],
        ]);
        
        
        Material::where('id_material',$id)
        ->update([
            'nama_barang'    => $attributes['nama_barang'],
            'kg_persheet' => $attributes['kg_persheet'],
            'kg_perpart'     => $attributes['kg_perpart'],
            'ukuran' => $attributes['ukuran'],
            'id_supplier' => $attributes['id_supplier'],
            'id_customer' => $attributes['id_customer'],
        ]);


        return redirect('/material');
    }
}
