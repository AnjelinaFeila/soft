<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;

class InfoUserController extends Controller
{

    public function create()
    {
        return view('laravel-examples/user-profile');
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'phone'     => ['max:50'],
            'id_pegawai' => ['max:50'],
            'posisi' => ['max:70'],
            'password' => ['max:255'],
        ]);
        
        if ($attributes['password']=="") {
            $attributes['password']=Auth::user()->password;
        }
        else{
            $attributes['password']=Hash::make($attributes['password']);
        }

        User::where('id',Auth::user()->id)
        ->update([
            'name'    => $attributes['name'],
            'id_pegawai' => $attributes['id_pegawai'],
            'phone'     => $attributes['phone'],
            'position' => $attributes['posisi'],
            'password' => $attributes['password'],
        ]);



        return redirect('/user-profile')->with('success','Profile updated successfully');
    }
}
