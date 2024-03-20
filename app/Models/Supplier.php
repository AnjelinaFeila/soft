<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Stockraw;
use App\Models\Wip;
use App\Models\Material;

class Supplier extends Model
{
    use HasFactory;

    public function stockraw(){
        return $this->hasOne(Stockraw::class,'id_supplier');
    }
    public function wip(){
        return $this->hasOne(Wip::class,'id_supplier');
    }
    public function material(){
        return $this->hasOne(Material::class,'id_supplier');
    }
    protected $table='supplier';
    protected $primaryKey='id_supplier';

    protected $fillable = [
        'id_supplier',
        'nama_supplier',
        'alamat',
        'contact',
        'email',
    ];
}
