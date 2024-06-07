<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Riwayat::with('Material','Supplier')->orderBy('id_riwayat','asc')->get();
        return view('riwayat',compact('riwayat'));
    }

    public function index2()
    {
        $material = Material::all();
        $supplier = Supplier::all();
        return view('riwayat_add',compact('material','supplier'));
    }

    public function index3($id)
    {
        $riwayat = Riwayat::with('supplier')->find($id);

        $materialIds = explode(',', $riwayat->id_material);
        $materials = Material::whereIn('id_material', $materialIds)->get();

        $jumlah_materials = explode(',', $riwayat->jumlah_barang);

        return view('riwayatshow', compact('riwayat', 'materials','materialIds','jumlah_materials'));
    }

    public function destroy($id)
    {
        $riwayat = Riwayat::find($id);

        $riwayat->delete();

        return redirect('/riwayat');
    }

    public function show($id)
    {
        $riwayat = Riwayat::with('supplier')->find($id);
        $material = Material::all();
        $supplier = Supplier::all();

        $materialIds = explode(',', $riwayat->id_material);
        $materials = Material::whereIn('id_material', $materialIds)->get();

        $jumlah_barangs = explode(',', $riwayat->jumlah_barang);

        return view('showriwayat',compact('riwayat','material','supplier','materials','materialIds','jumlah_barangs'));
    }

    public function store(Request $request)
    {  

        $attributes = request()->validate([
            'id_supplier'     => ['max:30'],
            'nomor'           => ['max:100'],
            'nomor_so'        => ['max:100'],
            'tanggal_terima'  => ['max:20'],
            'nomor_preorder'  => ['max:100'],
            'kode_part'       => ['max:50'],
            'id_materials'     => ['array'],
            'id_materials.*'   => ['max:10'],
            'jumlah_barangs'     => ['array'],
            'jumlah_barangs.*'   => ['max:10'],
            'part_number'     => ['max:100'],
            'jumlah_part'     => ['max:100'],
        ]);

        $materials = $attributes['id_materials'];
        $id_materials = implode(',', $materials);
        $attributes['id_material'] = $id_materials;

        $jumlah = $attributes['jumlah_barangs'];
        $jumlah_barangs = implode(',', $jumlah);
        $attributes['jumlah_barang'] = $jumlah_barangs;

        Riwayat::create($attributes);


        return redirect('/riwayat');
    }

    public function update(Request $request, $id)
    {
        $attributes = request()->validate([
            'id_supplier'     => ['max:30'],
            'nomor'           => ['max:100'],
            'nomor_so'        => ['max:100'],
            'tanggal_terima'  => ['max:20'],
            'nomor_preorder'  => ['max:100'],
            'kode_part'       => ['max:50'],
            'id_materials'     => ['array'],
            'id_materials.*'   => ['max:10'],
            'jumlah_barangs'     => ['array'],
            'jumlah_barangs.*'   => ['max:10'],
            'part_number'     => ['max:100'],
            'jumlah_part'     => ['max:100'],
        ]);

        $materials = $attributes['id_materials'];
        $id_materials = implode(',', $materials);
        $attributes['id_material'] = $id_materials;

        $jumlah = $attributes['jumlah_barangs'];
        $jumlah_barangs = implode(',', $jumlah);
        $attributes['jumlah_barang'] = $jumlah_barangs;

        
        Riwayat::where('id_riwayat',$id)
        ->update([
            'id_supplier' => $attributes['id_supplier'],
            'nomor' => $attributes['nomor'],
            'nomor_so' => $attributes['nomor_so'],
            'tanggal_terima' => $attributes['tanggal_terima'],
            'nomor_preorder' => $attributes['nomor_preorder'],
            'kode_part' => $attributes['kode_part'],
            'id_material' => $attributes['id_material'],
            'jumlah_barang' => $attributes['jumlah_barang'],
            'part_number' => $attributes['part_number'],
            'jumlah_part' => $attributes['jumlah_part'],
        ]);


        return redirect('/riwayat');
    }
}
