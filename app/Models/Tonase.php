<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Laporan_produksi;

class Tonase extends Model
{
    use HasFactory;

    public function Laporan_produksi(){
        return $this->hasOne(Laporan_produksi::class,'id_tonase');
    }
    protected $table='tonase';
    protected $primaryKey='id_tonase';

    protected $fillable = [
        'id_tonase',
        'nama_tonase',
    ];
}
