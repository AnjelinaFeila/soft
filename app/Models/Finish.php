<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Customer;
use App\Models\Material;

class Finish extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
    protected $table='finishgood';
    protected $primaryKey='id_finishgood';

    protected $fillable = [
        'id_finishgood',
        'nama_pegawai',
        'id_material',
        'jumlah',
        'id_customer',
        'qc',
    ];
}
