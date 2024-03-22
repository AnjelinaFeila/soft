<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    public function collection(): Collection
    {
        return Laporan::all();
    }
}