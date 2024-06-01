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
use App\Models\Delivery;
use App\Models\Finish;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function exportToExcel1(Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Laporan::with('Material','Proses','Tonase','Operator','Target')->whereYear('tanggal',$year)->whereMonth('tanggal',$month)->orderBy('tanggal','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/laporan')->with('success','Tidak ada data dengan bulan yang dipilih');
            }
        }
        else{
            $data = Laporan::with('Material','Proses','Tonase','Operator','Target')->orderBy('tanggal','asc')->get();
        }

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Nama Material');
        $sheet->setCellValue('C1', 'Proses');
        $sheet->setCellValue('D1', 'Tonase');
        $sheet->setCellValue('E1', 'Target pcs/jam');
        $sheet->setCellValue('F1', 'Jumlah Sheet');
        $sheet->setCellValue('G1', 'Operator');
        $sheet->setCellValue('H1', 'Jam Mulai');
        $sheet->setCellValue('I1', 'Jam Selesai');
        $sheet->setCellValue('J1', 'Jumlah Jam');
        $sheet->setCellValue('K1', 'Jumlah OK');
        $sheet->setCellValue('L1', 'Jumlah NG');
        $sheet->setCellValue('M1', 'Target');
        $sheet->setCellValue('N1', '+/-');
        $sheet->setCellValue('O1', 'Keterangan');
     

     
        $row = 2;
        foreach ($data as $item) {
            $targetPerWorkingHour = ($item->target->minimal_target / 60) * (Carbon::parse($item->jumlah_jam)->hour * 60 + Carbon::parse($item->jumlah_jam)->minute);
            $selisih=$targetPerWorkingHour-$item->jumlah_ok;
            if ($targetPerWorkingHour <= $item->jumlah_ok) {
                $target='✔';
            }
            else{
                 $target='✖';
            }
            if ($selisih<0) {
                $value=$item->jumlah_ok-$targetPerWorkingHour;
            }
            else{
                $value=$selisih;
            }
            $sheet->setCellValue('A' . $row, $item->tanggal);
            $sheet->setCellValue('B' . $row, $item->material->nama_barang);
            $sheet->setCellValue('C' . $row, $item->proses->nama_proses);
            $sheet->setCellValue('D' . $row, $item->tonase->nama_tonase);
            $sheet->setCellValue('E' . $row, $item->target->minimal_target);
            $sheet->setCellValue('F' . $row, $item->jumlah_sheet);
            $sheet->setCellValue('G' . $row, $item->operator->nama_operator);
            $sheet->setCellValue('H' . $row, $item->jam_mulai);
            $sheet->setCellValue('I' . $row, $item->jam_selesai);
            $sheet->setCellValue('J' . $row, $item->jumlah_jam);
            $sheet->setCellValue('K' . $row, $item->jumlah_ok);
            $sheet->setCellValue('L' . $row, $item->jumlah_ng);
            $sheet->setCellValue('M' . $row, $target);
            $sheet->setCellValue('N' . $row, $value);
            $sheet->setCellValue('O' . $row, $item->keterangan);
     
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

    public function exportToExcel2(Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Stockraw::with('Material','Customer','Supplier')->whereYear('updated_at',$year)->whereMonth('updated_at',$month)->orderBy('id_material','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/stockraw')->with('success','Tidak ada data dengan bulan yang dipilih');
            }
        }
        else{
            $data = Stockraw::with('Material','Customer','Supplier')->orderBy('id_material','asc')->get();
        }
        

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

    public function exportToExcel3(Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Wip::with('Material','Proses')->whereYear('last_produksi',$year)->whereMonth('last_produksi',$month)->orderBy('id_material','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/wip')->with('success','Tidak ada data last produksi dengan bulan yang dipilih');
            }
        }
        else{
            $data = Wip::with('Material','Proses')->orderBy('id_material','asc')->get();
        }
        

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

    public function exportToExcel4(Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Delivery::with('Material','Customer')->whereYear('tanggal_delivery',$year)->whereMonth('tanggal_delivery',$month)->orderBy('tanggal_delivery','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/delivery')->with('success','Tidak ada data dengan bulan yang dipilih');
            }
        }
        else{
            $data = Delivery::with('Material','Customer')->orderBy('tanggal_delivery','asc')->get();
        }

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No Surat Jalan');
        $sheet->setCellValue('B1', 'No Preorder');
        $sheet->setCellValue('C1', 'Nama Material');
        $sheet->setCellValue('D1', 'Jumlah Part');
        $sheet->setCellValue('E1', 'KG PerPart');
        $sheet->setCellValue('F1', 'Customer');
        $sheet->setCellValue('G1', 'Tanggal Produksi');
        $sheet->setCellValue('H1', 'Tanggal Delivery');
        $sheet->setCellValue('I1', 'Qc');

     
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->no_surat_jalan);
            $sheet->setCellValue('B' . $row, $item->no_preorder);
            $sheet->setCellValue('C' . $row, $item->material->nama_barang);
            $sheet->setCellValue('D' . $row, $item->jumlah_part);
            $sheet->setCellValue('E' . $row, $item->material->kg_perpart);
            $sheet->setCellValue('F' . $row, $item->customer->nama_customer);
            $sheet->setCellValue('G' . $row, $item->tanggal_produksi);
            $sheet->setCellValue('H' . $row, $item->tanggal_delivery);
            $sheet->setCellValue('I' . $row, $item->qc);
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

        return response()->download($tempFilePath, 'delivery.xlsx', $headers);
    }

    public function exportToExcel5(Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Finish::with('Material','Customer')->whereYear('updated_at',$year)->whereMonth('updated_at',$month)->orderBy('id_material','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/finish')->with('success','Tidak ada data dengan bulan yang dipilih');
            }
        }
        else{
           $data = Finish::with('Material','Customer')->orderBy('id_material','asc')->get();
        }
        

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Pegawai');
        $sheet->setCellValue('B1', 'Nama Material');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Customer');
        $sheet->setCellValue('E1', 'Qc');

     
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->nama_pegawai);
            $sheet->setCellValue('B' . $row, $item->material->nama_barang);
            $sheet->setCellValue('C' . $row, $item->jumlah);
            $sheet->setCellValue('D' . $row, $item->customer->nama_customer);
            $sheet->setCellValue('E' . $row, $item->qc);
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

        return response()->download($tempFilePath, 'finish_good.xlsx', $headers);
    }

    public function exportToExcel6($id, Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Laporan::with('Operator')->whereYear('tanggal',$year)->whereMonth('tanggal',$month)->where('id_operator',$id)->orderBy('tanggal','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/operator')->with('success','Tidak ada data dengan bulan yang dipilih');
            }
        }
        else{
           $data = Laporan::with('Operator')->where('id_operator',$id)->orderBy('tanggal','asc')->get();
        }

        
        $nama = Laporan::with('Operator')->where('id_operator',$id)->first();

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Operator');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Material');
        $sheet->setCellValue('D1', 'Proses');
        $sheet->setCellValue('E1', 'Tonase');
        $sheet->setCellValue('F1', 'Target pcs/jam');
        $sheet->setCellValue('J1', 'Jumlah Sheet');
        $sheet->setCellValue('G1', 'Jam Mulai');
        $sheet->setCellValue('H1', 'Jam Selesai');
        $sheet->setCellValue('I1', 'Jumlah Jam');
        $sheet->setCellValue('K1', 'Jumlah OK');
        $sheet->setCellValue('L1', 'Jumlah NG');
        $sheet->setCellValue('M1', 'Target');
        $sheet->setCellValue('N1', '+/-');
        $sheet->setCellValue('O1', 'Keterangan');

     
        $row = 2;
        foreach ($data as $item) {
            $targetPerWorkingHour = ($item->target->minimal_target / 60) * (Carbon::parse($item->jumlah_jam)->hour * 60 + Carbon::parse($item->jumlah_jam)->minute);
            $selisih=$targetPerWorkingHour-$item->jumlah_ok;
            if ($targetPerWorkingHour <= $item->jumlah_ok) {
                $target='✔';
            }
            else{
                 $target='✖';
            }
            if ($selisih<0) {
                $value=$item->jumlah_ok-$targetPerWorkingHour;
            }
            else{
                $value=$selisih;
            }
            
            $sheet->setCellValue('A' . $row, $item->operator->nama_operator);
            $sheet->setCellValue('B' . $row, $item->tanggal);
            $sheet->setCellValue('C' . $row, $item->material->nama_barang);
            $sheet->setCellValue('D' . $row, $item->proses->nama_proses);
            $sheet->setCellValue('E' . $row, $item->tonase->nama_tonase);
            $sheet->setCellValue('F' . $row, $item->target->minimal_target);
            $sheet->setCellValue('G' . $row, $item->jam_mulai);
            $sheet->setCellValue('H' . $row, $item->jam_selesai);
            $sheet->setCellValue('I' . $row, $item->jumlah_jam);
            $sheet->setCellValue('J' . $row, $item->jumlah_sheet);
            $sheet->setCellValue('K' . $row, $item->jumlah_ok);
            $sheet->setCellValue('L' . $row, $item->jumlah_ng);
            $sheet->setCellValue('M' . $row, $target);
            $sheet->setCellValue('N' . $row, $value);
            $sheet->setCellValue('O' . $row, $item->keterangan);
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

        return response()->download($tempFilePath, $nama->operator->nama_operator.'.xlsx', $headers);
    }

    public function exportToExcel7(Request $request)
    {
        $date = $request->input('date_filter');
        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data = Riwayat::with('Material','Supplier')->whereYear('tanggal_terima',$year)->whereMonth('tanggal_terima',$month)->orderBy('id_riwayat','asc')->get();
            if ($data->isEmpty()) {
                return redirect('/riwayat')->with('success','Tidak ada data dengan bulan yang dipilih');
            }
        }
        else{
           $data = Riwayat::with('Material','Supplier')->orderBy('id_riwayat','asc')->get();
        }
        

        $spreadsheet = new Spreadsheet();


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Supplier');
        $sheet->setCellValue('B1', 'Nomor');
        $sheet->setCellValue('C1', 'Nomor SO');
        $sheet->setCellValue('D1', 'Tanggal Terima');
        $sheet->setCellValue('E1', 'Nomor Preorder');
        $sheet->setCellValue('F1', 'Kode Part');
        $sheet->setCellValue('G1', 'Nama Material');
        $sheet->setCellValue('H1', 'Part Number');
        $sheet->setCellValue('I1', 'Jumlah Part');

     
        $row = 2;
        $previous_materials = [];

        foreach ($data as $item) {
            $id_materials = explode(',', $item->id_material);

            $material_names = [];
            foreach ($id_materials as $id) {
                $material = Material::find($id);

                if ($material) {
                    $material_names[] = $material->nama_barang;
                }
            }

            // Gabungkan nama material menjadi satu string dengan baris baru
            $merged_materials = implode("\n", $material_names);

            // Tampilkan data lainnya dengan nama material yang sudah digabungkan
            $sheet->setCellValue('A' . $row, $item->supplier->nama_supplier);
            $sheet->setCellValue('B' . $row, $item->nomor);
            $sheet->setCellValue('C' . $row, $item->nomor_so);
            $sheet->setCellValue('D' . $row, $item->tanggal_terima);
            $sheet->setCellValue('E' . $row, $item->nomor_preorder);
            $sheet->setCellValue('F' . $row, $item->kode_part);
            $sheet->setCellValue('G' . $row, $merged_materials); // Nama Material dengan baris baru

            // Set wrap text untuk sel G
            $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue('H' . $row, $item->part_number);
            $sheet->setCellValue('I' . $row, $item->jumlah_part);

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

        return response()->download($tempFilePath, 'riwayat.xlsx', $headers);
    }
}


