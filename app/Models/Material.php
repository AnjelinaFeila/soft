<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Stockraw;
use App\Models\Wip;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Delivery;
use App\Models\Laporan;
use App\Models\Finish;
use App\Models\Notgood;
use App\Models\Target;

class Material extends Model
{
    use HasFactory;

    public function stockraw(){
        return $this->hasOne(Stockraw::class,'id_material');
    }
    public function finish(){
        return $this->hasOne(Finish::class,'id_material');
    }
    public function notgood(){
        return $this->hasOne(Notgood::class,'id_material');
    }
    public function target(){
        return $this->hasOne(Target::class,'id_material');
    }
    public function wip(){
        return $this->hasOne(Wip::class,'id_material');
    }
    public function delivery(){
        return $this->hasOne(Delivery::class,'id_material');
    }
    public function laporan(){
        return $this->hasOne(Laporan::class,'id_material');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier');
    }
    protected $table='material';
    protected $primaryKey='id_material';

    protected $fillable = [
        'id_material',
        'nama_barang',
        'kg_persheet',
        'kg_perpart',
        'jumlah_persheet',
        'ukuran',
        'id_supplier',
        'id_customer',
    ];
}
