<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Material;

class Riwayat extends Model
{
    use HasFactory;

    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier');
    }
    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    protected $table='riwayat_barang';
    protected $primaryKey='id_riwayat';

    protected $fillable = [
        'id_riwayat',
        'id_supplier',
        'nomor',
        'nomor_so',
        'tanggal_terima',
        'nomor_preorder',
        'kode_part',
        'id_material',
        'part_number',
        'jumlah_part',
    ];
}
