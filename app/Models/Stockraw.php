<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Laporan;

class Stockraw extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier');
    }
    public function laporan(){
        return $this->hasOne(Laporan::class,'id_laporan_produksi');
    }
    protected $table='stock_raw_material';
    protected $primaryKey='id_stock_raw';

    protected $fillable = [
        'id_stock_raw',
        'no_preorder',
        'id_material',
        'jumlah_sheet',
        'kg_persheet',
        'jumlah_nutt',
        'id_supplier',
        'id_customer',
    ];
}
