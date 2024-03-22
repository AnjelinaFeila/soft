<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Material;
use App\Models\Proses;
use App\Models\Tonase;
use App\Models\Operator;
use App\Models\Stockraw;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Wip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function exportToExcel1()
    {
        $data = Laporan::with('Material','Proses','Tonase','Operator','Stockraw.Material')->orderBy('tanggal','desc')->get();

        $fileName = 'Laporan_produksi.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('tanggal', 'nama material', 'proses','tonase','jumlah sheet','operator','jam mulai','jam selesai','jumlah jam','jumlah ok','jumlah ng','keterangan')); 

        
        foreach ($data as $row) {
            fputcsv($handle, array($row->tanggal, $row->material->nama_barang, $row->proses->nama_proses,$row->tonase->nama_tonase,$row->jumlah_sheet,$row->operator->nama_operator,$row->jam_mulai,$row->jam_selesai,$row->jumlah_jam,$row->jumlah_ok,$row->jumlah_ng,$row->keterangan)); // Adjust column names as needed
        }

        fclose($handle);



        return Response::make('', 200, $headers);
    }

    public function exportToExcel2()
    {
        $data = Stockraw::with('Material','Customer','Supplier')->orderBy('id_material','asc')->get();

        $fileName = 'stockraw.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('no preorder', 'nama material','jumlah sheet','kg persheet','ukuran','jumlah nutt','supplier','customer')); // Add column headers

        
        foreach ($data as $row) {
            fputcsv($handle, array($row->no_preorder,$row->material->nama_barang,$row->jumlah_sheet,$row->ukuran,$row->kg_persheet,$row->jumlah_nutt,$row->supplier->nama_supplier,$row->customer->nama_customer)); // Adjust column names as needed
        }

        fclose($handle);



        return Response::make('', 200, $headers);
    }

    public function exportToExcel3()
    {
        $data = Wip::with('Material','Proses')->orderBy('id_material','asc')->get();

        $fileName = 'wip.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('nama material','kg perpart','jumlah part','last produksi','proses')); // Add column headers

        
        foreach ($data as $row) {
            fputcsv($handle, array($row->material->nama_barang,$row->kg_perpart,$row->jumlah_part,$row->last_produksi,$row->proses->nama_proses)); // Adjust column names as needed
        }

        fclose($handle);



        return Response::make('', 200, $headers);
    }
}
