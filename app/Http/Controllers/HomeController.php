<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wip;
use App\Models\Material;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Laporan;

class HomeController extends Controller
{
    public function dash()
    {
        $wip=Wip::count();
        $material=Material::count();
        $customer=Customer::count();
        $supplier=Supplier::count();
        $user=User::where('position','superadmin')->count();
        $admin=User::where('position','admin')->count();
        $owner=User::where('position','owner')->count();
        $laporan = Laporan::orderBy('id_laporan_produksi', 'desc')->take(5)->get();
        $nomor=0;
        return view('dashboard',compact('wip','material','customer','supplier','user','admin','owner','laporan','nomor'));
    }

    public function home()
    {
        $wip=Wip::count();
        $material=Material::count();
        $customer=Customer::count();
        $supplier=Supplier::count();
        $user=User::where('position','superadmin')->count();
        $admin=User::where('position','admin')->count();
        $owner=User::where('position','owner')->count();
        $laporan = Laporan::orderBy('id_laporan_produksi', 'desc')->take(5)->get();
        $nomor=0;
        return view('dashboard',compact('wip','material','customer','supplier','user','admin','owner','laporan','nomor'));
    }


}
