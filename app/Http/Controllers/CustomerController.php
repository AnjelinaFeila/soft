<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stockraw;
use App\Models\Delivery;
use App\Models\Material;
use App\Models\Finish;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();

        return view('customer', ['customer' => $customer]);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        $stockraw = Stockraw::where('id_customer', $id)->exists();
        $material = Material::where('id_customer', $id)->exists();
        $delivery = Delivery::where('id_customer', $id)->exists();
        $finish = Finish::where('id_customer', $id)->exists();

        
        if ($stockraw) {
            return redirect('/customer')->with('success','Gagal Menghapus,Customer Terhubung Dengan Stockraw');
        }
        if ($material) {
            return redirect('/customer')->with('success','Gagal Menghapus,Customer Terhubung Dengan Material');
        }if ($delivery) {
            return redirect('/customer')->with('success','Gagal Menghapus,Customer Terhubung Dengan Delivery');
        }
        if ($finish) {
            return redirect('/customer')->with('success','Gagal Menghapus,Customer Terhubung Dengan Finish Good');
        }
        else{
            $customer->delete();
            return redirect('/customer'); 
        }

            
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        return view('/showcustomer',['customer'=>$customer]);
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'nama_customer' => ['required', 'max:255'],
            'alamat'     => ['required'],
            'contact'     => ['max:50'],
            'email'     => ['max:255'],
        ]);
        
        
        Customer::create($attributes);


        return redirect('/customer');
    }

    public function update(Request $request, $id)
    {

        $attributes = request()->validate([
            'nama_customer' => ['required', 'max:255'],
            'alamat'     => ['required'],
            'contact'     => ['max:50'],
            'email'     => ['max:255'],
        ]);
        
        
        Customer::where('id_customer',$id)
        ->update([
            'nama_customer'    => $attributes['nama_customer'],
            'alamat' => $attributes['alamat'],
            'contact'     => $attributes['contact'],
            'email' => $attributes['email'],
        ]);


        return redirect('/customer');
    }
}
