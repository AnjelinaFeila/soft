<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Material;
use App\Models\Customer;

class Delivery extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
    protected $table='delivery';
    protected $primaryKey='id_delivery';

    protected $fillable = [
        'id_delivery',
        'no_surat_jalan',
        'no_preorder',
        'id_material',
        'kg_perpart',
        'id_customer',
        'jumlah_part',
        'tanggal_produksi',
        'tanggal_delivery',
        'qc',
    ];
}
