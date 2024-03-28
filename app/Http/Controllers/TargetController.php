<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Proses;
use App\Models\Material;
use App\Models\Laporan;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TargetController extends Controller
{
    public function index()
    {
        $target = Target::with('Material','proses')->orderBy('id_material','asc')->orderBy('id_proses','asc')->get();

        foreach($target as $targ){
            if (empty($targ->material->nama_barang)) {
                 return redirect('/material')->with('success','Material yang di butuhkan tidak ada silahkan isi terlebih dahulu');
            }
        }
        return view('target',compact('target'));
    }

    public function index2()
    {
        $material = Material::all();
        $proses = Proses::all();
        return view('target_add',compact('material','proses'));
    }

    public function destroy($id)
    {
        $target = Target::find($id);

        $laporan = Laporan::where('id_material',$target->id_material)->where('id_proses',$target->id_proses)->exists();

        
        if ($laporan) {
            return redirect('/target')->with('success','Gagal Menghapus,Target Terhubung Dengan Laporan');
        }
        else{
            $target->delete();
            return redirect('/target'); 
        }

            
    }

    public function show($id)
    {
        $target = Target::find($id);
        $material = Material::all();
        $proses = Proses::all();
        return view('showtarget',compact('target','material','proses'));
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'id_material'     => ['max:255'],
            'id_proses'     => ['max:255'],
            'minimal_target'     => ['max:255'],
        ]);
        
        $targ=Target::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();

        if (!$targ) {
            Target::create($attributes);
        }
        else{
            return redirect('/target')->with('success','Gagal,Material dan Proses yang sama sudah ada');
        }
        
        
        return redirect('/target');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'id_material'     => ['max:255'],
            'id_proses'     => ['max:255'],
            'minimal_target'     => ['max:255'],
        ]);
        
        $targ=Target::where('id_material',$attributes['id_material'])->where('id_proses',$attributes['id_proses'])->first();

        $target = Target::find($id);

        $laporan = Laporan::where('id_material',$target->id_material)->where('id_proses',$target->id_proses)->first();

        if (!$targ && $target->id_material==$attributes['id_material'] || $target->id_proses==$attributes['id_proses']) {
            if ($laporan) {
                if ($laporan->id_material==$attributes['id_material'] && $laporan->id_proses==$attributes['id_proses']) {
                        Target::where('id_minimaltarget',$id)
                        ->update([
                            'minimal_target'    => $attributes['minimal_target'],
                        ]);
                }
                else{
                    return redirect('/target')->with('success','Gagal,Target Terhubung Dengan Laporan');
                }
                        
            }
            else{
                Target::where('id_minimaltarget',$id)
                ->update([
                    'id_material'    => $attributes['id_material'],
                    'id_proses'    => $attributes['id_proses'],
                    'minimal_target'    => $attributes['minimal_target'],
                ]);
            }

        }
        else{
            return redirect('/target')->with('success','Gagal,Material dan Proses yang sama sudah ada'); 
        }

                        
            
        

        return redirect('/target');
    }

}
