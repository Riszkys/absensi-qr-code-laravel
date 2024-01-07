<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Report;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Requests\UpdateReportRequest;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportController extends Controller
{

    public function exportDataToExcel()
    {
        // Ambil data yang ingin diekspor (contoh: data dari model User)
        $data = User::all();

        // Inisialisasi PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Path ke file gambar di storage Laravel
        $imagePath = storage_path('app/public/header1.png');

        // Menyisipkan gambar ke dalam sel B2:C4
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($imagePath);
        $drawing->setCoordinates('B2');
        $drawing->setHeight(100); // Sesuaikan dengan ukuran yang diinginkan
        $drawing->setWidth(100);  // Sesuaikan dengan ukuran yang diinginkan

        // Menyisipkan gambar ke dalam worksheet
        $sheet->mergeCells('B2:C4');
        $sheet->getStyle('B2:C4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B2:C4')->getBorders()->getAllBorders()->setBorderStyle('medium');

        // Menambahkan gambar ke worksheet menggunakan addDrawing (alternatif dari addImage)
        // Menambahkan gambar ke collection
        $drawings = $sheet->getDrawingCollection();
        $drawings[] = $drawing;

        $sheet->mergeCells('D2:I3');
        $sheet->getStyle('D2:I3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D2:I3')->getFont()->setSize(26)->setName('Times New Roman')->setBold('bold');
        $sheet->setCellValue('D2', ' TRAINING REPORT');
        $sheet->getStyle('D2:I3')->getBorders()->getAllBorders()->setBorderStyle('medium');

        // Path ke file gambar di storage Laravel
        $imagePath = storage_path('app/public/header2.png');

        // Menyisipkan gambar ke dalam sel B2:C4
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($imagePath);
        $drawing->setCoordinates('J2');
        $drawing->setHeight(100); // Sesuaikan dengan ukuran yang diinginkan
        $drawing->setWidth(100);  // Sesuaikan dengan ukuran yang diinginkan

        // Menyisipkan gambar ke dalam worksheet
        $sheet->mergeCells('J2:k4');
        $sheet->getStyle('J2:k4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J2:k4')->getBorders()->getAllBorders()->setBorderStyle('medium');

        // Menambahkan gambar ke collection
        $drawings = $sheet->getDrawingCollection();
        $drawings[] = $drawing;

        $sheet->mergeCells('D4:I4');
        $sheet->getStyle('D4:I4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D4:I4')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->setCellValue('D4', 'PT PAN BROTHERS TBK');
        $sheet->getStyle('D4:I4')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('B7:K7');
        $sheet->getStyle('B7:K7')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:K7')->getFont()->setSize(20)->setName('Times New Roman')->setBold('bold');
        $sheet->setCellValue('B7', 'TRAINING BPJS');
        $sheet->getStyle('B7:K7')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('B8', '1');
        $sheet->getStyle('B8')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B8')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('C8:K8');
        $sheet->setCellValue('C8', 'Materi Training ');
        $sheet->getStyle('C8')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('C9:K9');
        $sheet->setCellValue('C9', 'Jenis BPJS dan macam produk,besaran presentase tarikan biaya BPJS dan prosedur klaim');
        $sheet->getStyle('C9')->getFont()->setSize(12)->setName('Times New Roman');

        $sheet->setCellValue('B11', '2');
        $sheet->getStyle('B11')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B11')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('C11:K11');
        $sheet->setCellValue('C11', 'Pelaksanaan Training');
        $sheet->getStyle('C11')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('B13:F13');
        $sheet->setCellValue('B13', 'Feedback');
        $sheet->getStyle('B13')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B13:F13')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('B13:F13')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98');
        $sheet->getStyle('B13')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('B14:F18');
        $sheet->getStyle('B14')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B14')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('B14', 'Karyawan mengetahui dan memahami perbedaan antara BPJS kesehatan dan BPJS ketenagakerjaan. Training ini juga memberikan pemahaman mengenai besaran tarikan bulanan untuk BPJS kesehatan maupun ketenagakerjaan');
        $sheet->getStyle('B14')->getFont()->setSize(12)->setName('Times New Roman');
        $sheet->getStyle('B14:F18')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('G13:H13');
        $sheet->setCellValue('G13', 'Tanggal & Tempat');
        $sheet->getStyle('G13')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G13:H13')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('G13:H13')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98');
        $sheet->getStyle('G13')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('G14:H14');
        $sheet->setCellValue('G14', '11/12/2023');
        $sheet->getStyle('G14')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G14:H14')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('G14')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('G15:H15');
        $sheet->setCellValue('G15', 'R. Training');
        $sheet->getStyle('G15')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G15')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('G14:H14')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('I13:J13');
        $sheet->setCellValue('I13', 'Fasilitator / Trainer');
        $sheet->getStyle('I13')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('I13:J13')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('I13:J13')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98');
        $sheet->getStyle('I13')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('I14:J15');
        $sheet->setCellValue('I14', 'Widiastuti');
        $sheet->getStyle('I14')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('I14')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('I14:J15')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->setCellValue('K13', 'Durasi');
        $sheet->getStyle('K13')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('K13')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98');
        $sheet->getStyle('K13')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('K13')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('K14:K15');
        $sheet->setCellValue('K14', '1 Jam');
        $sheet->getStyle('K14')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('K14')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('K14:K15')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('G16:K16');
        $sheet->setCellValue('G16', 'Alat');
        $sheet->getStyle('G16')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G16:K16')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('G16:K16')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98');
        $sheet->getStyle('G16')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('G17:K18');
        $sheet->setCellValue('G17', 'bit.ly/RefreshBPJS');
        $sheet->getStyle('G17')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G17')->getFont()->setSize(12)->setName('Times New Roman');
        $sheet->getStyle('G17:K18')->getBorders()->getAllBorders()->setBorderStyle('medium');




        $sheet->setCellValue('B20', '3');
        $sheet->getStyle('B20')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B20')->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('C20', 'Peserta');
        $sheet->getStyle('C20')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');


        $sheet->mergeCells('B22:E22');
        $sheet->setCellValue('B22', 'Nama');
        $sheet->getStyle('B22')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B22')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B22:E22')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('B22:E22')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98'); // Hijau Muda

        $sheet->mergeCells('F22:G22');
        $sheet->setCellValue('F22', 'NIK');
        $sheet->getStyle('F22:G22')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('F22:G22')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F22:G22')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('F22:G22')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98'); // Hijau Muda

        $sheet->mergeCells('H22:I22');
        $sheet->setCellValue('H22', 'PRE');
        $sheet->getStyle('H22:I22')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('H22:I22')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H22:I22')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('H22:I22')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98'); // Hijau Muda

        $sheet->mergeCells('J22:K22');
        $sheet->setCellValue('J22', 'POST');
        $sheet->getStyle('J22:K22')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('J22:K22')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J22:K22')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('J22:K22')->getFill()->setFillType('solid')->getStartColor()->setRGB('98FB98'); // Hijau Muda


        $sheet->mergeCells('B23:E23');
        $sheet->setCellValue('B23', 'Sindi Senora');
        $sheet->getStyle('B23:E23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B23:E23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B23:E23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('F23:G23');
        $sheet->setCellValue('F23', '092100483');
        $sheet->getStyle('F23:G23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F23:G23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F23:G23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('H23:I23');
        $sheet->setCellValue('H23', '6');
        $sheet->getStyle('H23:I23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('H23:I23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H23:I23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('J23:K23');
        $sheet->setCellValue('J23', '10');
        $sheet->getStyle('J23:K23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('J23:K23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J23:K23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('B23:E23');
        $sheet->setCellValue('B23', 'Sindi Senora');
        $sheet->getStyle('B23:E23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B23:E23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B23:E23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('F23:G23');
        $sheet->setCellValue('F23', '092100483');
        $sheet->getStyle('F23:G23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F23:G23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F23:G23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('H23:I23');
        $sheet->setCellValue('H23', '6');
        $sheet->getStyle('H23:I23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('H23:I23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H23:I23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('J23:K23');
        $sheet->setCellValue('J23', '10');
        $sheet->getStyle('J23:K23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('J23:K23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J23:K23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('B23:E23');
        $sheet->setCellValue('B23', 'Sindi Senora');
        $sheet->getStyle('B23:E23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B23:E23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B23:E23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('F23:G23');
        $sheet->setCellValue('F23', '092100483');
        $sheet->getStyle('F23:G23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F23:G23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F23:G23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('H23:I23');
        $sheet->setCellValue('H23', '6');
        $sheet->getStyle('H23:I23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('H23:I23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H23:I23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('J23:K23');
        $sheet->setCellValue('J23', '10');
        $sheet->getStyle('J23:K23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('J23:K23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J23:K23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('B23:E23');
        $sheet->setCellValue('B23', 'Sindi Senora');
        $sheet->getStyle('B23:E23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B23:E23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B23:E23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('F23:G23');
        $sheet->setCellValue('F23', '092100483');
        $sheet->getStyle('F23:G23')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F23:G23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F23:G23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('H23:I23');
        $sheet->setCellValue('H23', '6');
        $sheet->getStyle('H23:I23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('H23:I23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H23:I23')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('J23:K23');
        $sheet->setCellValue('J23', '10');
        $sheet->getStyle('J23:K23')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('J23:K23')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J23:K23')->getBorders()->getAllBorders()->setBorderStyle('thin');



        $sheet->setCellValue('B27', '4');
        $sheet->getStyle('B27')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B27')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C27', 'Evaluasi Training');
        $sheet->getStyle('C27')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C27')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('B29', 'Kehadiran');
        $sheet->getStyle('B29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('C29', '');
        $sheet->getStyle('C29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('C29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('D29', 'Test');
        $sheet->getStyle('D29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('D29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('E29', '');
        $sheet->getStyle('E29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('E29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('F29', 'Peserta');
        $sheet->getStyle('F29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('F29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('G29', '');
        $sheet->getStyle('G29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('G29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('H29', 'Evaluasi');
        $sheet->getStyle('H29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('H29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('I29', '');
        $sheet->getStyle('I29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('I29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('J29', '');
        $sheet->getStyle('J29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('J29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('K29', '');
        $sheet->getStyle('K29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('K29')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('L29', '');
        $sheet->getStyle('L29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M29', '');
        $sheet->getStyle('M29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N29', '');
        $sheet->getStyle('N29')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('O29', ' ');
        $sheet->getStyle('O29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P29', '');
        $sheet->getStyle('P29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q29', '');
        $sheet->getStyle('Q29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R29', '');
        $sheet->getStyle('R29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S29', '');
        $sheet->getStyle('S29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T29', '');
        $sheet->getStyle('T29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U29', '');
        $sheet->getStyle('U29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V29', '');
        $sheet->getStyle('V29')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('A30', '');
        $sheet->getStyle('A30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B30', 'Plan');
        $sheet->getStyle('B30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C30', 'Actual');
        $sheet->getStyle('C30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D30', 'Ave Pre');
        $sheet->getStyle('D30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E30', 'Ave Post');
        $sheet->getStyle('E30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F30', 'Male');
        $sheet->getStyle('F30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G30', 'Female');
        $sheet->getStyle('G30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H30', 'Berdasarkan hasil perhitungan rata-rata,terdapat peningkatan nilai dari pre test ke post test sebesar 3.7 poin.Maka dapat disimpulkan bahwa secara keseluruhan,peserta mengalami peningkatan pengetahuan mengenai materi yang ditrainingkan.Namun pelatihan ini tetap harus rutin dilakukan agar pemahaman dan kesadaran karyawan dapat terus meningkat');
        $sheet->getStyle('H30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');
        $sheet->getStyle('H30')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('I30', '');
        $sheet->getStyle('I30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');
        $sheet->getStyle('I30')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('J30', '');
        $sheet->getStyle('J30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');
        $sheet->getStyle('J30')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('K30', '');
        $sheet->getStyle('K30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');
        $sheet->getStyle('K30')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('L30', '');
        $sheet->getStyle('L30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M30', '');
        $sheet->getStyle('M30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N30', '');
        $sheet->getStyle('N30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O30', '');
        $sheet->getStyle('O30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P30', '');
        $sheet->getStyle('P30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q30', '');
        $sheet->getStyle('Q30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R30', '');
        $sheet->getStyle('R30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S30', '');
        $sheet->getStyle('S30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T30', '');
        $sheet->getStyle('T30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U30', '');
        $sheet->getStyle('U30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V30', '');
        $sheet->getStyle('V30')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A31', '');
        $sheet->getStyle('A31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B31', '6');
        $sheet->getStyle('B31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C31', '6');
        $sheet->getStyle('C31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D31', '6.3');
        $sheet->getStyle('D31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E31', '10');
        $sheet->getStyle('E31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F31', '4');
        $sheet->getStyle('F31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G31', '2');
        $sheet->getStyle('G31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('H31', '');
        $sheet->getStyle('H31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I31', '');
        $sheet->getStyle('I31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J31', '');
        $sheet->getStyle('J31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K31', '');
        $sheet->getStyle('K31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L31', '');
        $sheet->getStyle('L31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M31', '');
        $sheet->getStyle('M31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N31', '');
        $sheet->getStyle('N31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O31', '');
        $sheet->getStyle('O31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P31', '');
        $sheet->getStyle('P31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q31', '');
        $sheet->getStyle('Q31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R31', '');
        $sheet->getStyle('R31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S31', '');
        $sheet->getStyle('S31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T31', '');
        $sheet->getStyle('T31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U31', '');
        $sheet->getStyle('U31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V31', '');
        $sheet->getStyle('V31')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A32', '');
        $sheet->getStyle('A32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B32', '=C31/B31');
        $sheet->getStyle('B32')->getFont()->setSize(26)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C32', '');
        $sheet->getStyle('C32')->getFont()->setSize(26)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D32', '=E31-D31');
        $sheet->getStyle('D32')->getFont()->setSize(26)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E32', '');
        $sheet->getStyle('E32')->getFont()->setSize(26)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F32', '=F31/($F$31+$G$31)');
        $sheet->getStyle('F32')->getFont()->setSize(18)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G32', '=G31/($F$31+$G$31)');
        $sheet->getStyle('G32')->getFont()->setSize(18)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('H32', '');
        $sheet->getStyle('H32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I32', '');
        $sheet->getStyle('I32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J32', '');
        $sheet->getStyle('J32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K32', '');
        $sheet->getStyle('K32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L32', '');
        $sheet->getStyle('L32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M32', '');
        $sheet->getStyle('M32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N32', '');
        $sheet->getStyle('N32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O32', '');
        $sheet->getStyle('O32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P32', '');
        $sheet->getStyle('P32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q32', '');
        $sheet->getStyle('Q32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R32', '');
        $sheet->getStyle('R32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S32', '');
        $sheet->getStyle('S32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T32', '');
        $sheet->getStyle('T32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U32', '');
        $sheet->getStyle('U32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V32', '');
        $sheet->getStyle('V32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A33', '');
        $sheet->getStyle('A33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B33', 'Evaluasi Training');
        $sheet->getStyle('B33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('C33', '');
        $sheet->getStyle('C33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('C33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('D33', '');
        $sheet->getStyle('D33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('D33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('E33', '');
        $sheet->getStyle('E33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('E33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('F33', '');
        $sheet->getStyle('F33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G33', '');
        $sheet->getStyle('G33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('H33', '');
        $sheet->getStyle('H33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('H33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('I33', '');
        $sheet->getStyle('I33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('I33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('J33', '');
        $sheet->getStyle('J33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('J33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('K33', '');
        $sheet->getStyle('K33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('K33')->getBorders()->getTop()->setBorderStyle('medium');
        $sheet->setCellValue('L33', '');
        $sheet->getStyle('L33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M33', '');
        $sheet->getStyle('M33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N33', '');
        $sheet->getStyle('N33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O33', '');
        $sheet->getStyle('O33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P33', '');
        $sheet->getStyle('P33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q33', '');
        $sheet->getStyle('Q33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R33', '');
        $sheet->getStyle('R33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S33', '');
        $sheet->getStyle('S33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T33', '');
        $sheet->getStyle('T33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U33', '');
        $sheet->getStyle('U33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V33', '');
        $sheet->getStyle('V33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A34', '');
        $sheet->getStyle('A34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B34', 'Bagian');
        $sheet->getStyle('B34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C34', '');
        $sheet->getStyle('C34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D34', 'Program');
        $sheet->getStyle('D34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E34', '');
        $sheet->getStyle('E34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F34', 'Pelatih');
        $sheet->getStyle('F34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G34', '');
        $sheet->getStyle('G34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('H34', 'Metode Pelatihan');
        $sheet->getStyle('H34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('I34', '');
        $sheet->getStyle('I34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('J34', 'Kesan Umum');
        $sheet->getStyle('J34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('K34', '');
        $sheet->getStyle('K34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('L34', '');
        $sheet->getStyle('L34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M34', '');
        $sheet->getStyle('M34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N34', '');
        $sheet->getStyle('N34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O34', '');
        $sheet->getStyle('O34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P34', '');
        $sheet->getStyle('P34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q34', '');
        $sheet->getStyle('Q34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R34', '');
        $sheet->getStyle('R34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S34', '');
        $sheet->getStyle('S34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T34', '');
        $sheet->getStyle('T34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U34', '');
        $sheet->getStyle('U34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V34', '');
        $sheet->getStyle('V34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A35', '');
        $sheet->getStyle('A35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B35', 'Sangat Tidak Puas');
        $sheet->getStyle('B35')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('C35', '');
        $sheet->getStyle('C35')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('D35', '0');
        $sheet->getStyle('D35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E35', '0');
        $sheet->getStyle('E35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F35', '0');
        $sheet->getStyle('F35')->getFont()->setSize(11)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G35', '0');
        $sheet->getStyle('G35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H35', '0');
        $sheet->getStyle('H35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I35', '0');
        $sheet->getStyle('I35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J35', '0');
        $sheet->getStyle('J35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K35', '0');
        $sheet->getStyle('K35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L35', '');
        $sheet->getStyle('L35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M35', '');
        $sheet->getStyle('M35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N35', '');
        $sheet->getStyle('N35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O35', '');
        $sheet->getStyle('O35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P35', '');
        $sheet->getStyle('P35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q35', '');
        $sheet->getStyle('Q35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R35', '');
        $sheet->getStyle('R35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S35', '');
        $sheet->getStyle('S35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T35', '');
        $sheet->getStyle('T35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U35', '');
        $sheet->getStyle('U35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V35', '');
        $sheet->getStyle('V35')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A36', '');
        $sheet->getStyle('A36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B36', 'Tidak Puas');
        $sheet->getStyle('B36')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('C36', '');
        $sheet->getStyle('C36')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('D36', '0');
        $sheet->getStyle('D36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E36', '0');
        $sheet->getStyle('E36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F36', '0');
        $sheet->getStyle('F36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G36', '0');
        $sheet->getStyle('G36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H36', '0');
        $sheet->getStyle('H36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I36', '0');
        $sheet->getStyle('I36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J36', '0');
        $sheet->getStyle('J36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K36', '0');
        $sheet->getStyle('K36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L36', '');
        $sheet->getStyle('L36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M36', '');
        $sheet->getStyle('M36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N36', '');
        $sheet->getStyle('N36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O36', '');
        $sheet->getStyle('O36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P36', '');
        $sheet->getStyle('P36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q36', '');
        $sheet->getStyle('Q36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R36', '');
        $sheet->getStyle('R36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S36', '');
        $sheet->getStyle('S36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T36', '');
        $sheet->getStyle('T36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U36', '');
        $sheet->getStyle('U36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V36', '');
        $sheet->getStyle('V36')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A37', '');
        $sheet->getStyle('A37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B37', 'Netral');
        $sheet->getStyle('B37')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('C37', '');
        $sheet->getStyle('C37')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('D37', '0');
        $sheet->getStyle('D37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E37', '0');
        $sheet->getStyle('E37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F37', '0');
        $sheet->getStyle('F37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G37', '0');
        $sheet->getStyle('G37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H37', '0');
        $sheet->getStyle('H37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I37', '0');
        $sheet->getStyle('I37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J37', '0');
        $sheet->getStyle('J37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K37', '0');
        $sheet->getStyle('K37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L37', '');
        $sheet->getStyle('L37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M37', '');
        $sheet->getStyle('M37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N37', '');
        $sheet->getStyle('N37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O37', '');
        $sheet->getStyle('O37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P37', '');
        $sheet->getStyle('P37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q37', '');
        $sheet->getStyle('Q37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R37', '');
        $sheet->getStyle('R37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S37', '');
        $sheet->getStyle('S37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T37', '');
        $sheet->getStyle('T37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U37', '');
        $sheet->getStyle('U37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V37', '');
        $sheet->getStyle('V37')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A38', '');
        $sheet->getStyle('A38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B38', 'Puas');
        $sheet->getStyle('B38')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('C38', '');
        $sheet->getStyle('C38')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('D38', '9');
        $sheet->getStyle('D38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E38', '0.5');
        $sheet->getStyle('E38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F38', '0.17');
        $sheet->getStyle('F38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G38', '0.56666666666667');
        $sheet->getStyle('G38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H38', '19');
        $sheet->getStyle('H38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I38', '0.63333333333333');
        $sheet->getStyle('I38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J38', '18');
        $sheet->getStyle('J38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K38', '0.6');
        $sheet->getStyle('K38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L38', '');
        $sheet->getStyle('L38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M38', '');
        $sheet->getStyle('M38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N38', '');
        $sheet->getStyle('N38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O38', '');
        $sheet->getStyle('O38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P38', '');
        $sheet->getStyle('P38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q38', '');
        $sheet->getStyle('Q38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R38', '');
        $sheet->getStyle('R38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S38', '');
        $sheet->getStyle('S38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T38', '');
        $sheet->getStyle('T38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U38', '');
        $sheet->getStyle('U38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V38', '');
        $sheet->getStyle('V38')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A39', '');
        $sheet->getStyle('A39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B39', 'Sangat Puas');
        $sheet->getStyle('B39')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('C39', '');
        $sheet->getStyle('C39')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

        $sheet->setCellValue('D39', '9');
        $sheet->getStyle('D39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E39', '0.5');
        $sheet->getStyle('E39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F39', '0.13');
        $sheet->getStyle('F39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G39', '0.43333333333333');
        $sheet->getStyle('G39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H39', '11');
        $sheet->getStyle('H39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I39', '0.36666666666667');
        $sheet->getStyle('I39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J39', '12');
        $sheet->getStyle('J39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K39', '0.4');
        $sheet->getStyle('K39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L39', '');
        $sheet->getStyle('L39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M39', '');
        $sheet->getStyle('M39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N39', '');
        $sheet->getStyle('N39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O39', '');
        $sheet->getStyle('O39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P39', '');
        $sheet->getStyle('P39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q39', '');
        $sheet->getStyle('Q39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R39', '');
        $sheet->getStyle('R39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S39', '');
        $sheet->getStyle('S39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T39', '');
        $sheet->getStyle('T39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U39', '');
        $sheet->getStyle('U39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V39', '');
        $sheet->getStyle('V39')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A40', '');
        $sheet->getStyle('A40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B40', '');
        $sheet->getStyle('B40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C40', '');
        $sheet->getStyle('C40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D40', '');
        $sheet->getStyle('D40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E40', '');
        $sheet->getStyle('E40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F40', '');
        $sheet->getStyle('F40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G40', '');
        $sheet->getStyle('G40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H40', '');
        $sheet->getStyle('H40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I40', '');
        $sheet->getStyle('I40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J40', '');
        $sheet->getStyle('J40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K40', '');
        $sheet->getStyle('K40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L40', '');
        $sheet->getStyle('L40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M40', '');
        $sheet->getStyle('M40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N40', '');
        $sheet->getStyle('N40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O40', '');
        $sheet->getStyle('O40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P40', '');
        $sheet->getStyle('P40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q40', '');
        $sheet->getStyle('Q40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R40', '');
        $sheet->getStyle('R40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S40', '');
        $sheet->getStyle('S40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T40', '');
        $sheet->getStyle('T40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U40', '');
        $sheet->getStyle('U40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V40', '');
        $sheet->getStyle('V40')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A41', '');
        $sheet->getStyle('A41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B41', '5');
        $sheet->getStyle('B41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C41', 'Dokumentasi Training');
        $sheet->getStyle('C41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D41', '');
        $sheet->getStyle('D41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E41', '');
        $sheet->getStyle('E41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F41', '');
        $sheet->getStyle('F41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G41', '');
        $sheet->getStyle('G41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H41', '');
        $sheet->getStyle('H41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I41', '');
        $sheet->getStyle('I41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J41', '');
        $sheet->getStyle('J41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K41', '');
        $sheet->getStyle('K41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L41', '');
        $sheet->getStyle('L41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M41', '');
        $sheet->getStyle('M41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N41', '');
        $sheet->getStyle('N41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O41', '');
        $sheet->getStyle('O41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P41', '');
        $sheet->getStyle('P41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q41', '');
        $sheet->getStyle('Q41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R41', '');
        $sheet->getStyle('R41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S41', '');
        $sheet->getStyle('S41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T41', '');
        $sheet->getStyle('T41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U41', '');
        $sheet->getStyle('U41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V41', '');
        $sheet->getStyle('V41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A42', '');
        $sheet->getStyle('A42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B42', '');
        $sheet->getStyle('B42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C42', '');
        $sheet->getStyle('C42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D42', '');
        $sheet->getStyle('D42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E42', '');
        $sheet->getStyle('E42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F42', '');
        $sheet->getStyle('F42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G42', '');
        $sheet->getStyle('G42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H42', '');
        $sheet->getStyle('H42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I42', '');
        $sheet->getStyle('I42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J42', '');
        $sheet->getStyle('J42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K42', '');
        $sheet->getStyle('K42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L42', '                                                                                                                                                                                                                                                                                                                                                                                                    ');
        $sheet->getStyle('L42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M42', '');
        $sheet->getStyle('M42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N42', '');
        $sheet->getStyle('N42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O42', '');
        $sheet->getStyle('O42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P42', '');
        $sheet->getStyle('P42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q42', '');
        $sheet->getStyle('Q42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R42', '');
        $sheet->getStyle('R42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S42', '');
        $sheet->getStyle('S42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T42', '');
        $sheet->getStyle('T42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U42', '');
        $sheet->getStyle('U42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V42', '');
        $sheet->getStyle('V42')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A43', '');
        $sheet->getStyle('A43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B43', '');
        $sheet->getStyle('B43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C43', '');
        $sheet->getStyle('C43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D43', '');
        $sheet->getStyle('D43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E43', '');
        $sheet->getStyle('E43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F43', '');
        $sheet->getStyle('F43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G43', '');
        $sheet->getStyle('G43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H43', '');
        $sheet->getStyle('H43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I43', '');
        $sheet->getStyle('I43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J43', '');
        $sheet->getStyle('J43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K43', '');
        $sheet->getStyle('K43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L43', '');
        $sheet->getStyle('L43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M43', '');
        $sheet->getStyle('M43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N43', '');
        $sheet->getStyle('N43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O43', '');
        $sheet->getStyle('O43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P43', '');
        $sheet->getStyle('P43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q43', '');
        $sheet->getStyle('Q43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R43', '');
        $sheet->getStyle('R43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S43', '');
        $sheet->getStyle('S43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T43', '');
        $sheet->getStyle('T43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U43', '');
        $sheet->getStyle('U43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V43', '');
        $sheet->getStyle('V43')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A44', '');
        $sheet->getStyle('A44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B44', '');
        $sheet->getStyle('B44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C44', '');
        $sheet->getStyle('C44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D44', '');
        $sheet->getStyle('D44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E44', '');
        $sheet->getStyle('E44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F44', '');
        $sheet->getStyle('F44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G44', '');
        $sheet->getStyle('G44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H44', '');
        $sheet->getStyle('H44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I44', '');
        $sheet->getStyle('I44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J44', '');
        $sheet->getStyle('J44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K44', '');
        $sheet->getStyle('K44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L44', '');
        $sheet->getStyle('L44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M44', '');
        $sheet->getStyle('M44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N44', '');
        $sheet->getStyle('N44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O44', '');
        $sheet->getStyle('O44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P44', '');
        $sheet->getStyle('P44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q44', '');
        $sheet->getStyle('Q44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R44', '');
        $sheet->getStyle('R44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S44', '');
        $sheet->getStyle('S44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T44', '');
        $sheet->getStyle('T44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U44', '');
        $sheet->getStyle('U44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V44', '');
        $sheet->getStyle('V44')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A45', '');
        $sheet->getStyle('A45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B45', '');
        $sheet->getStyle('B45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C45', '');
        $sheet->getStyle('C45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D45', '');
        $sheet->getStyle('D45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E45', '');
        $sheet->getStyle('E45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F45', '');
        $sheet->getStyle('F45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G45', '');
        $sheet->getStyle('G45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H45', '');
        $sheet->getStyle('H45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I45', '');
        $sheet->getStyle('I45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J45', '');
        $sheet->getStyle('J45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K45', '');
        $sheet->getStyle('K45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L45', '');
        $sheet->getStyle('L45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M45', '');
        $sheet->getStyle('M45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N45', '');
        $sheet->getStyle('N45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O45', '');
        $sheet->getStyle('O45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P45', '');
        $sheet->getStyle('P45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q45', '');
        $sheet->getStyle('Q45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R45', '');
        $sheet->getStyle('R45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S45', '');
        $sheet->getStyle('S45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T45', '');
        $sheet->getStyle('T45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U45', '');
        $sheet->getStyle('U45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V45', '');
        $sheet->getStyle('V45')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A46', '');
        $sheet->getStyle('A46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B46', '');
        $sheet->getStyle('B46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C46', '');
        $sheet->getStyle('C46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D46', '');
        $sheet->getStyle('D46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E46', '');
        $sheet->getStyle('E46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F46', '');
        $sheet->getStyle('F46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G46', '');
        $sheet->getStyle('G46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H46', '');
        $sheet->getStyle('H46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I46', '');
        $sheet->getStyle('I46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J46', '');
        $sheet->getStyle('J46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K46', '');
        $sheet->getStyle('K46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L46', '');
        $sheet->getStyle('L46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M46', '');
        $sheet->getStyle('M46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N46', '');
        $sheet->getStyle('N46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O46', '');
        $sheet->getStyle('O46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P46', '');
        $sheet->getStyle('P46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q46', '');
        $sheet->getStyle('Q46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R46', '');
        $sheet->getStyle('R46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S46', '');
        $sheet->getStyle('S46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T46', '');
        $sheet->getStyle('T46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U46', '');
        $sheet->getStyle('U46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V46', '');
        $sheet->getStyle('V46')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A47', '');
        $sheet->getStyle('A47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B47', '');
        $sheet->getStyle('B47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C47', '');
        $sheet->getStyle('C47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D47', '');
        $sheet->getStyle('D47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E47', '');
        $sheet->getStyle('E47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F47', '');
        $sheet->getStyle('F47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G47', '');
        $sheet->getStyle('G47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H47', '');
        $sheet->getStyle('H47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I47', '');
        $sheet->getStyle('I47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J47', '');
        $sheet->getStyle('J47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K47', '');
        $sheet->getStyle('K47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L47', '');
        $sheet->getStyle('L47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M47', '');
        $sheet->getStyle('M47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N47', '');
        $sheet->getStyle('N47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O47', '');
        $sheet->getStyle('O47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P47', '');
        $sheet->getStyle('P47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q47', '');
        $sheet->getStyle('Q47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R47', '');
        $sheet->getStyle('R47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S47', '');
        $sheet->getStyle('S47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T47', '');
        $sheet->getStyle('T47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U47', '');
        $sheet->getStyle('U47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V47', '');
        $sheet->getStyle('V47')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A48', '');
        $sheet->getStyle('A48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B48', '');
        $sheet->getStyle('B48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C48', '');
        $sheet->getStyle('C48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D48', '');
        $sheet->getStyle('D48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E48', '');
        $sheet->getStyle('E48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F48', '');
        $sheet->getStyle('F48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G48', '');
        $sheet->getStyle('G48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H48', '');
        $sheet->getStyle('H48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I48', '');
        $sheet->getStyle('I48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J48', '');
        $sheet->getStyle('J48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K48', '');
        $sheet->getStyle('K48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L48', '');
        $sheet->getStyle('L48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M48', '');
        $sheet->getStyle('M48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N48', '');
        $sheet->getStyle('N48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O48', '');
        $sheet->getStyle('O48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P48', '');
        $sheet->getStyle('P48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q48', '');
        $sheet->getStyle('Q48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R48', '');
        $sheet->getStyle('R48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S48', '');
        $sheet->getStyle('S48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T48', '');
        $sheet->getStyle('T48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U48', '');
        $sheet->getStyle('U48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V48', '');
        $sheet->getStyle('V48')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A49', '');
        $sheet->getStyle('A49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B49', '');
        $sheet->getStyle('B49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C49', '');
        $sheet->getStyle('C49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D49', '');
        $sheet->getStyle('D49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E49', '');
        $sheet->getStyle('E49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F49', '');
        $sheet->getStyle('F49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G49', '');
        $sheet->getStyle('G49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H49', '');
        $sheet->getStyle('H49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I49', '');
        $sheet->getStyle('I49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J49', '');
        $sheet->getStyle('J49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K49', '');
        $sheet->getStyle('K49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L49', '');
        $sheet->getStyle('L49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M49', '');
        $sheet->getStyle('M49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N49', '');
        $sheet->getStyle('N49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O49', '');
        $sheet->getStyle('O49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P49', '');
        $sheet->getStyle('P49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q49', '');
        $sheet->getStyle('Q49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R49', '');
        $sheet->getStyle('R49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S49', '');
        $sheet->getStyle('S49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T49', '');
        $sheet->getStyle('T49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U49', '');
        $sheet->getStyle('U49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V49', '');
        $sheet->getStyle('V49')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A50', '');
        $sheet->getStyle('A50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B50', '');
        $sheet->getStyle('B50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C50', '');
        $sheet->getStyle('C50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D50', '');
        $sheet->getStyle('D50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E50', '');
        $sheet->getStyle('E50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F50', '');
        $sheet->getStyle('F50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G50', '');
        $sheet->getStyle('G50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H50', '');
        $sheet->getStyle('H50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I50', '');
        $sheet->getStyle('I50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J50', '');
        $sheet->getStyle('J50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K50', '');
        $sheet->getStyle('K50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L50', '');
        $sheet->getStyle('L50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M50', '');
        $sheet->getStyle('M50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N50', '');
        $sheet->getStyle('N50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('O50', '');
        $sheet->getStyle('O50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P50', '');
        $sheet->getStyle('P50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q50', '');
        $sheet->getStyle('Q50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R50', '');
        $sheet->getStyle('R50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S50', '');
        $sheet->getStyle('S50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T50', '');
        $sheet->getStyle('T50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U50', '');
        $sheet->getStyle('U50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V50', '');
        $sheet->getStyle('V50')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A51', '');
        $sheet->getStyle('A51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B51', '');
        $sheet->getStyle('B51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C51', '');
        $sheet->getStyle('C51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D51', '');
        $sheet->getStyle('D51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E51', '');
        $sheet->getStyle('E51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F51', '');
        $sheet->getStyle('F51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G51', '');
        $sheet->getStyle('G51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H51', '');
        $sheet->getStyle('H51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I51', 'Boyolali, 11 Desember 2023');
        $sheet->getStyle('I51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J51', '');
        $sheet->getStyle('J51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K51', '');
        $sheet->getStyle('K51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L51', '');
        $sheet->getStyle('L51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M51', '');
        $sheet->getStyle('M51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N51', '');
        $sheet->getStyle('N51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('O51', '');
        $sheet->getStyle('O51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P51', '');
        $sheet->getStyle('P51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q51', '');
        $sheet->getStyle('Q51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R51', '');
        $sheet->getStyle('R51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S51', '');
        $sheet->getStyle('S51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T51', '');
        $sheet->getStyle('T51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U51', '');
        $sheet->getStyle('U51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V51', '');
        $sheet->getStyle('V51')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A52', '');
        $sheet->getStyle('A52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B52', '');
        $sheet->getStyle('B52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C52', '');
        $sheet->getStyle('C52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D52', '');
        $sheet->getStyle('D52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E52', '');
        $sheet->getStyle('E52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F52', '');
        $sheet->getStyle('F52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G52', '');
        $sheet->getStyle('G52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H52', '');
        $sheet->getStyle('H52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I52', '');
        $sheet->getStyle('I52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J52', '');
        $sheet->getStyle('J52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K52', '');
        $sheet->getStyle('K52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L52', '');
        $sheet->getStyle('L52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('M52', '');
        $sheet->getStyle('M52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('N52', '');
        $sheet->getStyle('N52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O52', '');
        $sheet->getStyle('O52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P52', '');
        $sheet->getStyle('P52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q52', '');
        $sheet->getStyle('Q52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R52', '');
        $sheet->getStyle('R52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S52', '');
        $sheet->getStyle('S52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T52', '');
        $sheet->getStyle('T52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U52', '');
        $sheet->getStyle('U52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V52', '');
        $sheet->getStyle('V52')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A53', '');
        $sheet->getStyle('A53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B53', 'Dibuat oleh');
        $sheet->getStyle('B53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C53', '');
        $sheet->getStyle('C53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D53', '');
        $sheet->getStyle('D53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('E53', '');
        $sheet->getStyle('E53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F53', '');
        $sheet->getStyle('F53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G53', '');
        $sheet->getStyle('G53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H53', '');
        $sheet->getStyle('H53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('I53', 'Diperiksa');
        $sheet->getStyle('I53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J53', '');
        $sheet->getStyle('J53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K53', '');
        $sheet->getStyle('K53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L53', '');
        $sheet->getStyle('L53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M53', '');
        $sheet->getStyle('M53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N53', '');
        $sheet->getStyle('N53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O53', '');
        $sheet->getStyle('O53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P53', '');
        $sheet->getStyle('P53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q53', '');
        $sheet->getStyle('Q53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R53', '');
        $sheet->getStyle('R53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S53', '');
        $sheet->getStyle('S53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T53', '');
        $sheet->getStyle('T53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U53', '');
        $sheet->getStyle('U53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V53', '');
        $sheet->getStyle('V53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A54', '');
        $sheet->getStyle('A54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B54', '');
        $sheet->getStyle('B54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C54', '');
        $sheet->getStyle('C54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D54', '');
        $sheet->getStyle('D54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E54', '');
        $sheet->getStyle('E54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F54', '');
        $sheet->getStyle('F54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G54', '');
        $sheet->getStyle('G54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H54', '');
        $sheet->getStyle('H54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I54', '');
        $sheet->getStyle('I54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J54', '');
        $sheet->getStyle('J54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K54', '');
        $sheet->getStyle('K54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L54', '');
        $sheet->getStyle('L54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M54', '');
        $sheet->getStyle('M54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N54', '');
        $sheet->getStyle('N54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O54', '');
        $sheet->getStyle('O54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P54', '');
        $sheet->getStyle('P54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q54', '');
        $sheet->getStyle('Q54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R54', '');
        $sheet->getStyle('R54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S54', '');
        $sheet->getStyle('S54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T54', '');
        $sheet->getStyle('T54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U54', '');
        $sheet->getStyle('U54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V54', '');
        $sheet->getStyle('V54')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A55', '');
        $sheet->getStyle('A55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B55', '');
        $sheet->getStyle('B55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C55', '');
        $sheet->getStyle('C55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D55', '');
        $sheet->getStyle('D55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E55', '');
        $sheet->getStyle('E55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F55', '');
        $sheet->getStyle('F55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G55', '');
        $sheet->getStyle('G55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H55', '');
        $sheet->getStyle('H55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I55', '');
        $sheet->getStyle('I55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J55', '');
        $sheet->getStyle('J55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K55', '');
        $sheet->getStyle('K55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L55', '');
        $sheet->getStyle('L55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M55', '');
        $sheet->getStyle('M55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N55', '');
        $sheet->getStyle('N55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O55', '');
        $sheet->getStyle('O55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P55', '');
        $sheet->getStyle('P55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q55', '');
        $sheet->getStyle('Q55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R55', '');
        $sheet->getStyle('R55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S55', '');
        $sheet->getStyle('S55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T55', '');
        $sheet->getStyle('T55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U55', '');
        $sheet->getStyle('U55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V55', '');
        $sheet->getStyle('V55')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A56', '');
        $sheet->getStyle('A56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B56', '');
        $sheet->getStyle('B56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C56', '');
        $sheet->getStyle('C56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D56', '');
        $sheet->getStyle('D56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E56', '');
        $sheet->getStyle('E56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F56', '');
        $sheet->getStyle('F56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G56', '');
        $sheet->getStyle('G56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H56', '');
        $sheet->getStyle('H56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I56', '');
        $sheet->getStyle('I56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J56', '');
        $sheet->getStyle('J56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K56', '');
        $sheet->getStyle('K56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L56', '');
        $sheet->getStyle('L56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M56', '');
        $sheet->getStyle('M56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N56', '');
        $sheet->getStyle('N56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O56', '');
        $sheet->getStyle('O56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P56', '');
        $sheet->getStyle('P56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q56', '');
        $sheet->getStyle('Q56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R56', '');
        $sheet->getStyle('R56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S56', '');
        $sheet->getStyle('S56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T56', '');
        $sheet->getStyle('T56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U56', '');
        $sheet->getStyle('U56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V56', '');
        $sheet->getStyle('V56')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A57', '');
        $sheet->getStyle('A57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B57', 'Widiastuti');
        $sheet->getStyle('B57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C57', '');
        $sheet->getStyle('C57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('D57', '');
        $sheet->getStyle('D57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E57', '');
        $sheet->getStyle('E57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F57', '');
        $sheet->getStyle('F57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('G57', '');
        $sheet->getStyle('G57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('H57', '');
        $sheet->getStyle('H57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I57', 'Anik Kuswandari');
        $sheet->getStyle('I57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('J57', '');
        $sheet->getStyle('J57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('K57', '');
        $sheet->getStyle('K57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('L57', '');
        $sheet->getStyle('L57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M57', '');
        $sheet->getStyle('M57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N57', '');
        $sheet->getStyle('N57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O57', '');
        $sheet->getStyle('O57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P57', '');
        $sheet->getStyle('P57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q57', '');
        $sheet->getStyle('Q57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R57', '');
        $sheet->getStyle('R57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S57', '');
        $sheet->getStyle('S57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T57', '');
        $sheet->getStyle('T57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U57', '');
        $sheet->getStyle('U57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V57', '');
        $sheet->getStyle('V57')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A58', '');
        $sheet->getStyle('A58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B58', 'Staff T&D');
        $sheet->getStyle('B58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C58', '');
        $sheet->getStyle('C58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D58', '');
        $sheet->getStyle('D58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E58', '');
        $sheet->getStyle('E58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F58', '');
        $sheet->getStyle('F58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G58', '');
        $sheet->getStyle('G58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H58', '');
        $sheet->getStyle('H58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I58', 'HRM Factory Manager');
        $sheet->getStyle('I58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J58', '');
        $sheet->getStyle('J58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K58', '');
        $sheet->getStyle('K58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L58', '');
        $sheet->getStyle('L58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M58', '');
        $sheet->getStyle('M58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N58', '');
        $sheet->getStyle('N58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O58', '');
        $sheet->getStyle('O58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P58', '');
        $sheet->getStyle('P58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q58', '');
        $sheet->getStyle('Q58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R58', '');
        $sheet->getStyle('R58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S58', '');
        $sheet->getStyle('S58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T58', '');
        $sheet->getStyle('T58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U58', '');
        $sheet->getStyle('U58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V58', '');
        $sheet->getStyle('V58')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A59', '');
        $sheet->getStyle('A59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B59', '');
        $sheet->getStyle('B59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C59', '');
        $sheet->getStyle('C59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D59', '');
        $sheet->getStyle('D59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E59', '');
        $sheet->getStyle('E59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F59', '');
        $sheet->getStyle('F59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G59', '');
        $sheet->getStyle('G59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H59', '');
        $sheet->getStyle('H59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I59', '');
        $sheet->getStyle('I59')->getFont()->setSize(8)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J59', 'FM-HRD-34.R.02 #20-07-2023');
        $sheet->getStyle('J59')->getFont()->setSize(8)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K59', '');
        $sheet->getStyle('K59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L59', '');
        $sheet->getStyle('L59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M59', '');
        $sheet->getStyle('M59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N59', '');
        $sheet->getStyle('N59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O59', '');
        $sheet->getStyle('O59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P59', '');
        $sheet->getStyle('P59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q59', '');
        $sheet->getStyle('Q59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R59', '');
        $sheet->getStyle('R59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S59', '');
        $sheet->getStyle('S59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T59', '');
        $sheet->getStyle('T59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U59', '');
        $sheet->getStyle('U59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V59', '');
        $sheet->getStyle('V59')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A60', '');
        $sheet->getStyle('A60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B60', '');
        $sheet->getStyle('B60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C60', '');
        $sheet->getStyle('C60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D60', '');
        $sheet->getStyle('D60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E60', '');
        $sheet->getStyle('E60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F60', '');
        $sheet->getStyle('F60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G60', '');
        $sheet->getStyle('G60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H60', '');
        $sheet->getStyle('H60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I60', '');
        $sheet->getStyle('I60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J60', '');
        $sheet->getStyle('J60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K60', '');
        $sheet->getStyle('K60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L60', '');
        $sheet->getStyle('L60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M60', '');
        $sheet->getStyle('M60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N60', '');
        $sheet->getStyle('N60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O60', '');
        $sheet->getStyle('O60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P60', '');
        $sheet->getStyle('P60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q60', '');
        $sheet->getStyle('Q60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R60', '');
        $sheet->getStyle('R60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S60', '');
        $sheet->getStyle('S60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T60', '');
        $sheet->getStyle('T60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U60', '');
        $sheet->getStyle('U60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V60', '');
        $sheet->getStyle('V60')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A61', '');
        $sheet->getStyle('A61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B61', '');
        $sheet->getStyle('B61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C61', '');
        $sheet->getStyle('C61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D61', '');
        $sheet->getStyle('D61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E61', '');
        $sheet->getStyle('E61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F61', '');
        $sheet->getStyle('F61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G61', '');
        $sheet->getStyle('G61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H61', '');
        $sheet->getStyle('H61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I61', '');
        $sheet->getStyle('I61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J61', '');
        $sheet->getStyle('J61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K61', '');
        $sheet->getStyle('K61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L61', '');
        $sheet->getStyle('L61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M61', '');
        $sheet->getStyle('M61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N61', '');
        $sheet->getStyle('N61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O61', '');
        $sheet->getStyle('O61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P61', '');
        $sheet->getStyle('P61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q61', '');
        $sheet->getStyle('Q61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R61', '');
        $sheet->getStyle('R61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S61', '');
        $sheet->getStyle('S61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T61', '');
        $sheet->getStyle('T61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U61', '');
        $sheet->getStyle('U61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V61', '');
        $sheet->getStyle('V61')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A62', '');
        $sheet->getStyle('A62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B62', '');
        $sheet->getStyle('B62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C62', '');
        $sheet->getStyle('C62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D62', '');
        $sheet->getStyle('D62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E62', '');
        $sheet->getStyle('E62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F62', '');
        $sheet->getStyle('F62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G62', '');
        $sheet->getStyle('G62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H62', '');
        $sheet->getStyle('H62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I62', '');
        $sheet->getStyle('I62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J62', '');
        $sheet->getStyle('J62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K62', '');
        $sheet->getStyle('K62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L62', '');
        $sheet->getStyle('L62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M62', '');
        $sheet->getStyle('M62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N62', '');
        $sheet->getStyle('N62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O62', '');
        $sheet->getStyle('O62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P62', '');
        $sheet->getStyle('P62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q62', '');
        $sheet->getStyle('Q62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R62', '');
        $sheet->getStyle('R62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S62', '');
        $sheet->getStyle('S62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T62', '');
        $sheet->getStyle('T62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U62', '');
        $sheet->getStyle('U62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V62', '');
        $sheet->getStyle('V62')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A63', '');
        $sheet->getStyle('A63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B63', '');
        $sheet->getStyle('B63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C63', '');
        $sheet->getStyle('C63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D63', '');
        $sheet->getStyle('D63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E63', '');
        $sheet->getStyle('E63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F63', '');
        $sheet->getStyle('F63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G63', '');
        $sheet->getStyle('G63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H63', '');
        $sheet->getStyle('H63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I63', '');
        $sheet->getStyle('I63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J63', '');
        $sheet->getStyle('J63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K63', '');
        $sheet->getStyle('K63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L63', '');
        $sheet->getStyle('L63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M63', '');
        $sheet->getStyle('M63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N63', '');
        $sheet->getStyle('N63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O63', '');
        $sheet->getStyle('O63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P63', '');
        $sheet->getStyle('P63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q63', '');
        $sheet->getStyle('Q63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R63', '');
        $sheet->getStyle('R63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S63', '');
        $sheet->getStyle('S63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T63', '');
        $sheet->getStyle('T63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U63', '');
        $sheet->getStyle('U63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V63', '');
        $sheet->getStyle('V63')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A64', '');
        $sheet->getStyle('A64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B64', '');
        $sheet->getStyle('B64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C64', '');
        $sheet->getStyle('C64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D64', '');
        $sheet->getStyle('D64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E64', '');
        $sheet->getStyle('E64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F64', '');
        $sheet->getStyle('F64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G64', '');
        $sheet->getStyle('G64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H64', '');
        $sheet->getStyle('H64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I64', '');
        $sheet->getStyle('I64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J64', '');
        $sheet->getStyle('J64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K64', '');
        $sheet->getStyle('K64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L64', '');
        $sheet->getStyle('L64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M64', '');
        $sheet->getStyle('M64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N64', '');
        $sheet->getStyle('N64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O64', '');
        $sheet->getStyle('O64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P64', '');
        $sheet->getStyle('P64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q64', '');
        $sheet->getStyle('Q64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R64', '');
        $sheet->getStyle('R64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S64', '');
        $sheet->getStyle('S64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T64', '');
        $sheet->getStyle('T64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U64', '');
        $sheet->getStyle('U64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V64', '');
        $sheet->getStyle('V64')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('A65', '');
        $sheet->getStyle('A65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('B65', '');
        $sheet->getStyle('B65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('C65', '');
        $sheet->getStyle('C65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('D65', '');
        $sheet->getStyle('D65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('E65', '');
        $sheet->getStyle('E65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('F65', '');
        $sheet->getStyle('F65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('G65', '');
        $sheet->getStyle('G65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('H65', '');
        $sheet->getStyle('H65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I65', '');
        $sheet->getStyle('I65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('J65', '');
        $sheet->getStyle('J65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('K65', '');
        $sheet->getStyle('K65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('L65', '');
        $sheet->getStyle('L65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('M65', '');
        $sheet->getStyle('M65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('N65', '');
        $sheet->getStyle('N65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('O65', '');
        $sheet->getStyle('O65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('P65', '');
        $sheet->getStyle('P65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('Q65', '');
        $sheet->getStyle('Q65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('R65', '');
        $sheet->getStyle('R65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('S65', '');
        $sheet->getStyle('S65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('T65', '');
        $sheet->getStyle('T65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('U65', '');
        $sheet->getStyle('U65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('V65', '');
        $sheet->getStyle('V65')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');


        // Simpan ke file Excel
        $filename = 'export_data.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);


        // Mengirim file sebagai respons
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generatePDF(Request $request)
    {
        $id_training = $request->input('id_training');
        $reportData = Training::select(
            'training.materi_training',
            'training.waktu_mulai',
            'training.tanggal_training',
            'training.pic',
            'training.lokasi_training',
            'training.status_training',
            'users.nik',
            'users.name',
            'departement.nama as department_name',
            'absensi.status_absen',
            'test_pesertas.hasil_test'
        )
            ->join('detail_trainings', 'training.id', '=', 'detail_trainings.id_training')
            ->join('users', 'detail_trainings.id_user', '=', 'users.id')
            ->join('departement', 'detail_trainings.id_departement', '=', 'departement.id')
            ->leftJoin('absensi', 'detail_trainings.id_absen', '=', 'absensi.id')
            ->leftJoin('test_pesertas', 'detail_trainings.id_user', '=', 'test_pesertas.id_user')
            ->where('training.id', $id_training)
            ->distinct()
            ->get();

        $feedback = $request->input('feedback');

        // dd($feedback);
        if ($reportData->isEmpty()) {
            $materi_training = '';
            $waktu_mulai = '';
            $tanggal_training = '';
            $lokasi_training = '';
            $pic = '';
            $status_training = '';
            $pdf = PDF::loadView('pdf.report', compact(
                'reportData',
                'id_training',
                'materi_training',
                'waktu_mulai',
                'tanggal_training',
                'lokasi_training',
                'pic',
                'status_training',
                'feedback'
            ));
            return $pdf->download('training_report.pdf');
        }
        $materi_training = $reportData[0]->materi_training;
        $waktu_mulai = $reportData[0]->waktu_mulai;
        $tanggal_training = $reportData[0]->tanggal_training;
        $lokasi_training = $reportData[0]->lokasi_training;
        $pic = $reportData[0]->pic;
        $status_training = $reportData[0]->status_training;
        $pdf = PDF::loadView('pdf.report', compact(
            'reportData',
            'id_training',
            'materi_training',
            'waktu_mulai',
            'tanggal_training',
            'lokasi_training',
            'pic',
            'status_training',
            'feedback'
        ));
        return $pdf->download('training_report.pdf');
    }

    public function index(Request $request)
    {
        $id_training = $request->input('id_training');
        $reportData = Training::select(
            'training.materi_training',
            'training.waktu_mulai',
            'training.tanggal_training',
            'training.pic',
            'training.lokasi_training',
            'training.status_training',
            'users.nik',
            'users.name',
            'departement.nama as department_name',
            'absensi.status_absen',
            'test_pesertas.hasil_test'
        )
            ->join('detail_trainings', 'training.id', '=', 'detail_trainings.id_training')
            ->join('users', 'detail_trainings.id_user', '=', 'users.id')
            ->join('departement', 'detail_trainings.id_departement', '=', 'departement.id')
            ->leftJoin('absensi', 'detail_trainings.id_absen', '=', 'absensi.id')
            ->leftJoin('test_pesertas', 'detail_trainings.id_user', '=', 'test_pesertas.id_user')
            ->where('training.id', $id_training)
            ->distinct()
            ->get();

        if ($reportData->isEmpty()) {
            $materi_training = '';
            $waktu_mulai = '';
            $tanggal_training = '';
            $lokasi_training = '';
            $pic = '';
            $status_training = '';

            return view('panitia.training.tReport', compact(
                'reportData',
                'id_training',
                'materi_training',
                'waktu_mulai',
                'tanggal_training',
                'lokasi_training',
                'pic',
                'status_training'
            ));
        }
        $materi_training = $reportData[0]->materi_training;
        $waktu_mulai = $reportData[0]->waktu_mulai;
        $tanggal_training = $reportData[0]->tanggal_training;
        $lokasi_training = $reportData[0]->lokasi_training;
        $pic = $reportData[0]->pic;
        $status_training = $reportData[0]->status_training;

        return view('panitia.training.tReport', compact(
            'reportData',
            'id_training',
            'materi_training',
            'waktu_mulai',
            'tanggal_training',
            'lokasi_training',
            'pic',
            'status_training'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
