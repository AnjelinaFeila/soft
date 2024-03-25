<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Stockraw;
use App\Models\Wip;
use App\Models\Material;
use App\Models\Finish;

class Customer extends Model
{
    use HasFactory;

    public function stockraw(){
        return $this->hasOne(Stockraw::class,'id_customer');
    }
    public function wip(){
        return $this->hasOne(Wip::class,'id_customer');
    }
    public function material(){
        return $this->hasOne(Material::class,'id_customer');
    }
    public function finish(){
        return $this->hasOne(Finish::class,'id_customer');
    }
    protected $table='customer';
    protected $primaryKey='id_customer';

    protected $fillable = [
        'id_customer',
        'nama_customer',
        'alamat',
        'contact',
        'email',
    ];
}
