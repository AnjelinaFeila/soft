<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserManageController extends Controller
{
    public function index()
    {
        $user = User::all();

        return view('laravel-examples/user-management', ['user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect('user-management');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('laravel-examples/showuser',['user'=>$user]);
    }

    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'name' => ['required', 'max:255'],
            'id_pegawai' => ['required', 'max:255'],
            'password' => ['required', 'max:255'],
            'position' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
        ]);
        
        $attributes['password']=Hash::make($attributes['password']);

        $exists = User::where('id_pegawai', $attributes['id_pegawai'])->exists();

        if ($exists) {
            return redirect('/add_user')->with('success','Id Pegawai Sudah Ada');
        }

        User::create($attributes);


        return redirect('user-management');
    }

    public function update(Request $request, $id)
    {
        $users=User::find($id);

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'phone'     => ['max:50'],
            'id_pegawai' => ['max:50'],
            'position' => ['max:70'],
            'password' => ['max:255'],
        ]);
        
        if ($attributes['password']=="") {
            $attributes['password']=$users->password;
        }
        else{
            $attributes['password']=Hash::make($attributes['password']);
        }

        User::where('id',$id)
        ->update([
            'name'    => $attributes['name'],
            'id_pegawai' => $attributes['id_pegawai'],
            'phone'     => $attributes['phone'],
            'position' => $attributes['position'],
            'password' => $attributes['password'],
        ]);


        return redirect('user-management');
    }
}
