<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Proses;
use App\Models\Material;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TargetController extends Controller
{
    public function index()
    {
        $materials = Material::pluck('id_material')->toArray();
        $proseses = Proses::pluck('id_proses')->toArray();

        // Ambil semua kombinasi data yang sudah ada di dalam tabel "target"
        $existingCombinations = Target::pluck('id_material', 'id_proses')->toArray();

        foreach ($materials as $materialId) {
        foreach ($proseses as $prosesId) {
            $combinationExists = isset($existingCombinations[$materialId]) && $existingCombinations[$materialId] === $prosesId;

            if (!$combinationExists) {
                // Masukkan kombinasi baru ke dalam tabel "target"
                Target::updateOrCreate(
                    ['id_material' => $materialId, 'id_proses' => $prosesId,'minimal_target'=>0]
                );
            }
        }
    }

    // Hapus data yang tidak ada dalam kombinasi dari tabel "material" dan "proses"
    Target::whereNotIn('id_material', $materials)
        ->orWhereNotIn('id_proses', $proseses)
        ->delete();
        

            

        $target = Target::with('Material','proses')->orderBy('id_material','asc')->orderBy('id_proses','asc')->get();
        return view('target',compact('target'));
    }


    public function show($id)
    {
        $target=Target::with('material','proses')->find($id);

        return view('showtarget',compact('target'));
    }


    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'minimal_target' => ['max:255'],
        ]);
        
        
        Target::where('id_minimaltarget',$id)
        ->update([
            'minimal_target' => $attributes['minimal_target'],
            
        ]);


        return redirect('/target');
    }
}
