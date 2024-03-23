<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Material;
use App\Models\Proses;
use App\Models\Tonase;
use App\Models\Operator;
use App\Models\Stockraw;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Wip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ExhandlerController extends Controller
{
    public function Handler1()
    {
        $data = Laporan::with('Material','Proses','Tonase','Operator','Stockraw.Material')->orderBy('tanggal','desc')->get();

       return view('exportlaporan',['data'=>$data]);

    }   
    public function Handler2()
    {
        $data = Stockraw::with('Material','Customer','Supplier')->orderBy('id_material','asc')->get();

       return view('exportstockraw',['data'=>$data]);
    }

    public function Handler3()
    {
        $data = Wip::with('Material','Proses')->orderBy('id_material','asc')->get();

       return view('exportwip',['data'=>$data]);
    }
}
