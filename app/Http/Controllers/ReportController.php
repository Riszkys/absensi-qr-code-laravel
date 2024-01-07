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

        $sheet->mergeCells('C20:K20');
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



        $sheet->mergeCells('B24:E24');
        $sheet->setCellValue('B24', 'Sindi Senora');
        $sheet->getStyle('B24:E24')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B24:E24')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B24:E24')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('F24:G24');
        $sheet->setCellValue('F24', '092100483');
        $sheet->getStyle('F24:G24')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F24:G24')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F24:G24')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('H24:I24');
        $sheet->setCellValue('H24', '6');
        $sheet->getStyle('H24:I24')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('H24:I24')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H24:I24')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('J24:K24');
        $sheet->setCellValue('J24', '10');
        $sheet->getStyle('J24:K24')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('J24:K24')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J24:K24')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('B25:E25');
        $sheet->setCellValue('B25', 'Sindi Senora');
        $sheet->getStyle('B25:E25')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B25:E25')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B25:E25')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('F25:G25');
        $sheet->setCellValue('F25', '092100483');
        $sheet->getStyle('F25:G25')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F25:G25')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F25:G25')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('H25:I25');
        $sheet->setCellValue('H25', '6');
        $sheet->getStyle('H25:I25')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('H25:I25')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H25:I25')->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('J25:K25');
        $sheet->setCellValue('J25', '10');
        $sheet->getStyle('J25:K25')->getFont()->setSize(12)->setName('Arial')->setBold(false);
        $sheet->getStyle('J25:K25')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('J25:K25')->getBorders()->getAllBorders()->setBorderStyle('thin');



        $sheet->setCellValue('B27', '4');
        $sheet->getStyle('B27')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B27')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');


        $sheet->mergeCells('C27:K27');
        $sheet->setCellValue('C27', 'Evaluasi Training');
        $sheet->getStyle('C27')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->mergeCells('B29:C29');
        $sheet->setCellValue('B29', 'Kehadiran');
        $sheet->getStyle('B29:C29')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B29:C29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B29:C29')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('D29:E29');
        $sheet->setCellValue('D29', 'Test');
        $sheet->getStyle('D29:E29')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D29:E29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('D29:E29')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('F29:G29');
        $sheet->setCellValue('F29', 'Peserta');
        $sheet->getStyle('F29:G29')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F29:G29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('F29:G29')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('H29:K29');
        $sheet->setCellValue('H29', 'Evaluasi');
        $sheet->getStyle('F29:K29')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F29:K29')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('F29:K29')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('F29')->getAlignment()->setWrapText(true);

        $sheet->setCellValue('B30', 'Plan');
        $sheet->getStyle('B30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('C30', 'Actual');
        $sheet->getStyle('C30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('C30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('D30', 'Ave Pre');
        $sheet->getStyle('D30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('D30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('E30', 'Ave Post');
        $sheet->getStyle('E30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('E30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('E30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('F30', 'Male');
        $sheet->getStyle('F30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('G30', 'Female');
        $sheet->getStyle('G30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('G30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('H30:K32');
        $sheet->setCellValue('H30', 'Berdasarkan hasil perhitungan rata-rata, terdapat peningkatan nilai dari pre-test ke post-test sebesar 3.7 poin. Maka dapat disimpulkan bahwa secara keseluruhan, peserta mengalami peningkatan pengetahuan mengenai materi yang ditrainingkan. Namun pelatihan ini tetap harus rutin dilakukan agar pemahaman dan kesadaran karyawan dapat terus meningkat');
        $sheet->getStyle('H30:K32')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');
        $sheet->getStyle('H30:K32')->getBorders()->getAllBorders()->setBorderStyle('medium');
        $sheet->getStyle('H30:K32')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('H30:K32')->getAlignment()->setWrapText(true);

        $sheet->setCellValue('B30', 'Plan');
        $sheet->getStyle('B30')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B30')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B30')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('B31', '6');
        $sheet->getStyle('B31')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B31')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B31')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('C31', '6');
        $sheet->getStyle('C31')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('C31')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('C31')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('D31', '6,3');
        $sheet->getStyle('D31')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('D31')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D31')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('E31', '10');
        $sheet->getStyle('E31')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('E31')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('E31')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('F31', '4');
        $sheet->getStyle('F31')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F31')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F31')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('G31', '2');
        $sheet->getStyle('G31')->getFont()->setSize(12)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('G31')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G31')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('B32:C32');
        $sheet->setCellValue('B32', '100%');
        $sheet->getStyle('B32:C32')->getFont()->setSize(26)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('B32:C32')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B32:C32')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->mergeCells('D32:E32');
        $sheet->setCellValue('D32', '3,7');
        $sheet->getStyle('D32:E32')->getFont()->setSize(26)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('D32:E32')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D32:E32')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('F32', '67%');
        $sheet->getStyle('F32')->getFont()->setSize(18)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('F32')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F32')->getBorders()->getAllBorders()->setBorderStyle('medium');

        $sheet->setCellValue('G32', '33%');
        $sheet->getStyle('G32')->getFont()->setSize(18)->setName('Times New Roman')->setBold(false);
        $sheet->getStyle('G32')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('G32')->getBorders()->getAllBorders()->setBorderStyle('medium');


        $sheet->setCellValue('B33', 'Evaluasi Training');
        $sheet->getStyle('B33')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');
        $sheet->getStyle('B33')->getBorders()->getTop()->setBorderStyle('medium');

        $sheet->setCellValue('B34', 'Bagian');
        $sheet->getStyle('B34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');


        $sheet->setCellValue('D34', 'Program');
        $sheet->getStyle('D34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('F34', 'Pelatih');
        $sheet->getStyle('F34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('H34', 'Metode Pelatihan');
        $sheet->getStyle('H34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('J34', 'Kesan Umum');
        $sheet->getStyle('J34')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('B35', 'Sangat Tidak Puas');
        $sheet->getStyle('B35')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

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

        $sheet->setCellValue('B36', 'Tidak Puas');
        $sheet->getStyle('B36')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

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

        $sheet->setCellValue('B37', 'Netral');
        $sheet->getStyle('B37')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

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

        $sheet->setCellValue('B38', 'Puas');
        $sheet->getStyle('B38')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

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

        $sheet->setCellValue('B39', 'Sangat Puas');
        $sheet->getStyle('B39')->getFont()->setSize(11)->setName('Calibri')->setBold('normal');

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

        $sheet->setCellValue('B41', '5');
        $sheet->getStyle('B41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('C41', 'Dokumentasi Training');
        $sheet->getStyle('C41')->getFont()->setSize(12)->setName('Times New Roman')->setBold('bold');

        $sheet->setCellValue('B53', 'Dibuat oleh');
        $sheet->getStyle('B53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

        $sheet->setCellValue('I53', 'Diperiksa');
        $sheet->getStyle('I53')->getFont()->setSize(12)->setName('Times New Roman')->setBold('normal');

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
