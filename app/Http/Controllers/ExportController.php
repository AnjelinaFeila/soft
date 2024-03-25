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
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function exportToExcel1()
    {
        $data = Laporan::with('Material','Proses','Tonase','Operator','Target')->orderBy('tanggal','desc')->get();

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Nama Material');
        $sheet->setCellValue('C1', 'Proses');
        $sheet->setCellValue('D1', 'Tonase');
        $sheet->setCellValue('E1', 'Jumlah Sheet');
        $sheet->setCellValue('F1', 'Operator');
        $sheet->setCellValue('G1', 'Jam Mulai');
        $sheet->setCellValue('H1', 'Jam Selesai');
        $sheet->setCellValue('I1', 'Target');
        $sheet->setCellValue('J1', 'Jumlah Jam');
        $sheet->setCellValue('K1', 'Jumlah OK');
        $sheet->setCellValue('L1', 'Jumlah NG');
        $sheet->setCellValue('M1', 'Keterangan');
     

     
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->tanggal);
            $sheet->setCellValue('B' . $row, $item->material->nama_barang);
            $sheet->setCellValue('C' . $row, $item->proses->nama_proses);
            $sheet->setCellValue('D' . $row, $item->tonase->nama_tonase);
            $sheet->setCellValue('E' . $row, $item->jumlah_sheet);
            $sheet->setCellValue('F' . $row, $item->operator->nama_operator);
            $sheet->setCellValue('G' . $row, $item->jam_mulai);
            $sheet->setCellValue('H' . $row, $item->jam_selesai);
            $sheet->setCellValue('I' . $row, $item->jumlah_jam);
            $sheet->setCellValue('J' . $row, $targetPerWorkingHour = ($item->target->minimal_target / 60) * (Carbon::parse($item->jumlah_jam)->hour * 60 + Carbon::parse($item->jumlah_jam)->minute));
            $sheet->setCellValue('K' . $row, $item->jumlah_ok);
            $sheet->setCellValue('L' . $row, $item->jumlah_ng);
            $sheet->setCellValue('M' . $row, $item->keterangan);
     
            $row++;
        }


        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFilePath);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="data.xlsx"',
        ];

        return response()->download($tempFilePath, 'laporan_produksi.xlsx', $headers);

    }

    public function exportToExcel2()
    {
        $data = Stockraw::with('Material','Customer','Supplier')->orderBy('id_material','asc')->get();

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No Preorder');
        $sheet->setCellValue('B1', 'Nama Material');
        $sheet->setCellValue('C1', 'Jumlah Sheet');
        $sheet->setCellValue('D1', 'Jumlah PartperSheet');
        $sheet->setCellValue('E1', 'KG PerSheet');
        $sheet->setCellValue('F1', 'Ukuran');
        $sheet->setCellValue('G1', 'Jumlah Nutt');
        $sheet->setCellValue('H1', 'Supplier');
        $sheet->setCellValue('I1', 'Customer');
     

     
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->no_preorder);
            $sheet->setCellValue('B' . $row, $item->material->nama_barang);
            $sheet->setCellValue('C' . $row, $item->jumlah_sheet);
            $sheet->setCellValue('D' . $row, $item->jumlah_sheet*$item->material->jumlah_persheet);
            $sheet->setCellValue('E' . $row, $item->kg_persheet);
            $sheet->setCellValue('F' . $row, $item->material->ukuran);
            $sheet->setCellValue('G' . $row, $item->jumlah_nutt);
            $sheet->setCellValue('H' . $row, $item->supplier->nama_supplier);
            $sheet->setCellValue('I' . $row, $item->customer->nama_customer);
     
            $row++;
        }


        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFilePath);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="data.xlsx"',
        ];

        return response()->download($tempFilePath, 'stockraw.xlsx', $headers);
    }

    public function exportToExcel3()
    {
        $data = Wip::with('Material','Proses')->orderBy('id_material','asc')->get();

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Material');
        $sheet->setCellValue('B1', 'KG PerPart');
        $sheet->setCellValue('C1', 'Jumlah Part');
        $sheet->setCellValue('D1', 'Last Produksi');
        $sheet->setCellValue('E1', 'Proses');
     

     
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->material->nama_barang);
            $sheet->setCellValue('B' . $row, $item->material->kg_perpart);
            $sheet->setCellValue('C' . $row, $item->jumlah_part);
            $sheet->setCellValue('D' . $row, $item->last_produksi);
            $sheet->setCellValue('E' . $row, $item->proses->nama_proses);
     
            $row++;
        }


        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFilePath);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="data.xlsx"',
        ];

        return response()->download($tempFilePath, 'wip.xlsx', $headers);
    }
}
