<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Material;
use App\Models\Stockraw;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();

        return view('supplier', ['supplier' => $supplier]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        $stockraw = Stockraw::where('id_supplier', $id)->exists();
        $material = Material::where('id_supplier', $id)->exists();

        
        if ($stockraw) {
            return redirect('/supplier')->with('success','Gagal Menghapus,Supplier Terhubung Dengan Stockraw');
        }
        if ($material) {
            return redirect('/supplier')->with('success','Gagal Menghapus,Supplier Terhubung Dengan Material');
        }
        else{
            $supplier->delete();
            return redirect('/supplier');
        }
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);

        return view('/showsupplier',['supplier'=>$supplier]);
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'nama_supplier' => ['required', 'max:255'],
            'alamat'     => ['required'],
            'contact'     => ['max:50'],
            'email'     => ['max:255'],
        ]);
        
        
        Supplier::create($attributes);


        return redirect('/supplier');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_supplier' => ['required', 'max:255'],
            'alamat'     => ['required'],
            'contact'     => ['max:50'],
            'email'     => ['max:255'],
        ]);
        
        
        Supplier::where('id_supplier',$id)
        ->update([
            'nama_supplier'    => $attributes['nama_supplier'],
            'alamat' => $attributes['alamat'],
            'contact'     => $attributes['contact'],
            'email' => $attributes['email'],
        ]);


        return redirect('/supplier');
    }
}
