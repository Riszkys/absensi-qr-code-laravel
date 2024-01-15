<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Training;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\GambarTraining;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreReportRequest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Requests\UpdateReportRequest;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function exportDataToExcel(Request $request)
    {
        // Mengambil semua data dari formulir
        $sangatTidakPuasProgram1 = $request->input("sangat_tidak_puas_program1");
        $sangatTidakPuasProgram2 = $request->input("sangat_tidak_puas_program2");
        $sangatTidakPuasPelatih1 = $request->input("sangat_tidak_puas_pelatih1");
        $sangatTidakPuasPelatih2 = $request->input("sangat_tidak_puas_pelatih2");
        $sangatTidakPuasMetode1 = $request->input("sangat_tidak_puas_metode1");
        $sangatTidakPuasMetode2 = $request->input("sangat_tidak_puas_metode2");
        $sangatTidakPuasKesan1 = $request->input("sangat_tidak_puas_kesan1");
        $sangatTidakPuasKesan2 = $request->input("sangat_tidak_puas_kesan2");

        $tidakPuasProgram1 = $request->input("tidak_puas_program1");
        $tidakPuasProgram2 = $request->input("tidak_puas_program2");
        $tidakPuasPelatih1 = $request->input("tidak_puas_pelatih1");
        $tidakPuasPelatih2 = $request->input("tidak_puas_pelatih2");
        $tidakPuasMetode1 = $request->input("tidak_puas_metode1");
        $tidakPuasMetode2 = $request->input("tidak_puas_metode2");
        $tidakPuasKesan1 = $request->input("tidak_puas_kesan1");
        $tidakPuasKesan2 = $request->input("tidak_puas_kesan2");

        $netralProgram1 = $request->input("netral_program1");
        $netralProgram2 = $request->input("netral_program2");
        $netralPelatih1 = $request->input("netral_pelatih1");
        $netralPelatih2 = $request->input("netral_pelatih2");
        $netralMetode1 = $request->input("netral_metode1");
        $netralMetode2 = $request->input("netral_metode2");
        $netralKesan1 = $request->input("netral_kesan1");
        $netralKesan2 = $request->input("netral_kesan2");

        $puasProgram1 = $request->input("puas_program1");
        $puasProgram2 = $request->input("puas_program2");
        $puasPelatih1 = $request->input("puas_pelatih1");
        $puasPelatih2 = $request->input("puas_pelatih2");
        $puasMetode1 = $request->input("puas_metode1");
        $puasMetode2 = $request->input("puas_metode2");
        $puasKesan1 = $request->input("puas_kesan1");
        $puasKesan2 = $request->input("puas_kesan2");

        $sangatPuasProgram1 = $request->input("sangat_puas_program1");
        $sangatPuasProgram2 = $request->input("sangat_puas_program2");
        $sangatPuasPelatih1 = $request->input("sangat_puas_pelatih1");
        $sangatPuasPelatih2 = $request->input("sangat_puas_pelatih2");
        $sangatPuasMetode1 = $request->input("sangat_puas_metode1");
        $sangatPuasMetode2 = $request->input("sangat_puas_metode2");
        $sangatPuasKesan1 = $request->input("sangat_puas_kesan1");
        $sangatPuasKesan2 = $request->input("sangat_puas_kesan2");

        // Ambil data yang ingin diekspor (contoh: data dari model User)
        $datauser = DB::table('test_pesertas')
            ->join('users', 'test_pesertas.id_user', '=', 'users.id')
            ->select(
                'users.name',
                'users.nik',
                DB::raw('MAX(CASE WHEN test_pesertas.id_test = 1 THEN test_pesertas.hasil_test END) AS pre'),
                DB::raw('MAX(CASE WHEN test_pesertas.id_test = 2 THEN test_pesertas.hasil_test END) AS post')
            )
            ->groupBy('users.name', 'users.nik')
            ->get();

        $gambarTraining = GambarTraining::join('report', 'gambar_training.id_report', '=', 'report.id')
            ->where('report.id_training', '=', 1) // Ganti 1 dengan nilai yang sesuai
            ->select('gambar_training.gambar')
            ->get();


        $id_training = $request->input("id_training");
        $alat = $request->input("alat");
        $durasi = $request->input("durasi");
        $evaluasi = $request->input("evaluasi");
        $feedback = $request->input("feedback");
        $sangat_tidak_puas1 = $request->input("sangat_tidak_puas1");
        $sangat_tidak_puas2 = $request->input("sangat_tidak_puas2");
        $sangat_tidak_puas3 = $request->input("sangat_puas3");
        $sangat_tidak_puas4 = $request->input("sangat_tidak_puas4");
        $sangat_tidak_puas5 = $request->input("sangat_tidak_puas5");
        $sangat_tidak_puas6 = $request->input("sangat_tidak_puas6");
        $hasil_tes1 = $request->input("hasil_tes1");
        $hasil_tes2 = $request->input("hasil_tes2");
        $hasil_tes3 = $request->input("hasil_tes3");
        $hasil_tes4 = $request->input("hasil_tes4");
        $hasil_tes5 = $request->input("hasil_tes5");
        $hasil_tes6 = $request->input("hasil_tes6");
        $hasil_tes7 = $request->input("hasil_tes7");
        $hasil_tes8 = $request->input("hasil_tes8");
        $netral1 = $request->input("netral1");
        $netral2 = $request->input("netral2");
        $netral3 = $request->input("netral3");
        $netral4 = $request->input("netral4");
        $netral5 = $request->input("netral5");
        $netral6 = $request->input("netral6");
        $netral7 = $request->input("netral7");
        $netral8 = $request->input("netral8");
        $puas1 = $request->input("puas1");
        $puas2 = $request->input("puas2");
        $puas3 = $request->input("puas3");
        $puas4 = $request->input("puas4");
        $puas5 = $request->input("puas5");
        $puas6 = $request->input("puas6");
        $puas7 = $request->input("puas7");
        $puas8 = $request->input("puas8");
        $sangat_puas1 = $request->input("sangat_puas1");
        $sangat_puas2 = $request->input("sangat_puas2");
        $sangat_puas3 = $request->input("sangat_puas3");
        $sangat_puas4 = $request->input("sangat_puas4");
        $sangat_puas5 = $request->input("sangat_puas5");
        $sangat_puas6 = $request->input("sangat_puas6");
        $sangat_puas7 = $request->input("sangat_puas7");
        $sangat_puas8 = $request->input("sangat_puas8");
        $totalKehadiran = $request->input("totalKehadiran");
        $index = 23;
        $indexluar = 0;
        $date = date("d-m-Y");


        $reportData = Training::select(
            "training.nama_training",
            "training.materi_training",
            "training.waktu_mulai",
            "training.tanggal_training",
            "training.pic",
            "training.lokasi_training",
            "training.status_training",
            "users.nik",
            "users.name",
            "users.jenis_kelamin",
            "departement.nama as department_name",
            "absensi.status_absen",
            "test_pesertas.hasil_test",
            "test_pesertas.id_test",
            "test.jenis_test",
            "report.*",
            "gambar_training.gambar"
        )
            ->join("detail_trainings", "training.id", "=", "detail_trainings.id_training")
            ->join("users", "detail_trainings.id_user", "=", "users.id")
            ->join("departement", "detail_trainings.id_departement", "=", "departement.id")
            ->leftJoin("absensi", "detail_trainings.id_absen", "=", "absensi.id")
            ->leftJoin("test_pesertas", "detail_trainings.id_user", "=", "test_pesertas.id_user")
            ->leftJoin("report", "training.id", "=", "report.id_training")
            ->leftJoin("gambar_training", "report.id_training", "=", "gambar_training.id_report")
            ->leftJoin("test", "test_pesertas.id_test", "=", "test.id")
            ->where("training.id", $id_training)
            ->distinct()
            ->get();
        // dd($reportData);

        $genderCount = $reportData->groupBy("jenis_kelamin")->map(function ($item, $key) {
            return count($item);
        });
        $namaTraining = $reportData[0]->nama_training;
        $lakiCount = $genderCount["laki"] ?? 0;
        $perempuanCount = $genderCount["perempuan"] ?? 0;
        $totalAttendance = $reportData->count();
        $hadirCount = $reportData->where("status_absen", "hadir")->count();
        $preTestResults = $reportData->where("id_test", 1)->pluck("hasil_test");
        $postTestResults = $reportData->where("id_test", 2)->pluck("hasil_test");
        $averagePreTest = $preTestResults->avg();
        $averagePostTest = $postTestResults->avg();

        $materi_training = $reportData[0]->materi_training;
        $waktu_mulai = $reportData[0]->waktu_mulai;
        $tanggal_training = $reportData[0]->tanggal_training;
        $nama_training = $reportData[0]->nama_training;
        $lokasi_training = $reportData[0]->lokasi_training;
        $pic = $reportData[0]->pic;
        $status_training = $reportData[0]->status_training;
        $rata_rata = ($averagePostTest + $averagePreTest) / 2;

        $totalCounts = $lakiCount + $perempuanCount; // Add more counts here if needed
        $numberOfGenders = count(array_filter([$lakiCount, $perempuanCount])); // Count the number of non-zero counts

        $averageCount = $numberOfGenders > 0 ? $totalCounts / $numberOfGenders : 0;
        // Inisialisasi PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Path ke file gambar di storage Laravel
        $imagePath = storage_path("app/public/header1.jpg");

        // Menyisipkan gambar ke dalam sel B2:C4
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($imagePath);
        $drawing->setCoordinates("B2");
        $drawing->setHeight(100); // Sesuaikan dengan ukuran yang diinginkan
        $drawing->setWidth(100);  // Sesuaikan dengan ukuran yang diinginkan

        // Menyisipkan gambar ke dalam worksheet
        $sheet->mergeCells("B2:C4");
        $sheet->getStyle("B2:C4")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("B2:C4")->getBorders()->getAllBorders()->setBorderStyle("medium");

        // Menambahkan gambar ke worksheet menggunakan addDrawing (alternatif dari addImage)
        // Menambahkan gambar ke collection
        $drawings = $sheet->getDrawingCollection();
        $drawings[] = $drawing;

        $sheet->mergeCells("D2:I3");
        $sheet->getStyle("D2:I3")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("D2:I3")->getFont()->setSize(26)->setName("Times New Roman")->setBold("bold");
        $sheet->setCellValue("D2", " TRAINING REPORT");
        $sheet->getStyle("D2:I3")->getBorders()->getAllBorders()->setBorderStyle("medium");

        // Path ke file gambar di storage Laravel
        $imagePath = storage_path("app/public/header2.jpg");

        // Menyisipkan gambar ke dalam sel B2:C4
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($imagePath);
        $drawing->setCoordinates("J2");
        $drawing->setHeight(100); // Sesuaikan dengan ukuran yang diinginkan
        $drawing->setWidth(100);  // Sesuaikan dengan ukuran yang diinginkan

        // Menyisipkan gambar ke dalam worksheet
        $sheet->mergeCells("J2:k4");
        $sheet->getStyle("J2:k4")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("J2:k4")->getBorders()->getAllBorders()->setBorderStyle("medium");

        // Menambahkan gambar ke collection
        $drawings = $sheet->getDrawingCollection();
        $drawings[] = $drawing;

        $sheet->mergeCells("D4:I4");
        $sheet->getStyle("D4:I4")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("D4:I4")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->setCellValue("D4", "PT PAN BROTHERS TBK");
        $sheet->getStyle("D4:I4")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("B7:K7");
        $sheet->getStyle("B7:K7")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("B7:K7")->getFont()->setSize(20)->setName("Times New Roman")->setBold("bold");
        $sheet->setCellValue("B7", "TRAINING BPJS");
        $sheet->getStyle("B7:K7")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("B8", "1");
        $sheet->getStyle("B8")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("B8")->getAlignment()->setHorizontal("center");

        $sheet->mergeCells("C8:K8");
        $sheet->setCellValue("C8", "Materi Training ");
        $sheet->getStyle("C8")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("C9:K9");
        $sheet->setCellValue("C9", $materi_training);
        $sheet->getStyle("C9")->getFont()->setSize(12)->setName("Times New Roman");

        $sheet->setCellValue("B11", "2");
        $sheet->getStyle("B11")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("B11")->getAlignment()->setHorizontal("center");

        $sheet->mergeCells("C11:K11");
        $sheet->setCellValue("C11", "Pelaksanaan Training");
        $sheet->getStyle("C11")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("B13:F13");
        $sheet->setCellValue("B13", "Feedback");
        $sheet->getStyle("B13")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("B13:F13")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("B13:F13")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98");
        $sheet->getStyle("B13")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("B14:F18");
        $sheet->getStyle("B14")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B14")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("B14", $feedback);
        $sheet->getStyle("B14")->getFont()->setSize(12)->setName("Times New Roman");
        $sheet->getStyle("B14:F18")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("G13:H13");
        $sheet->setCellValue("G13", "Tanggal & Tempat");
        $sheet->getStyle("G13")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G13:H13")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("G13:H13")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98");
        $sheet->getStyle("G13")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("G14:H14");
        $sheet->setCellValue("G14", $tanggal_training);
        $sheet->getStyle("G14")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G14:H14")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("G14")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("G15:H15");
        $sheet->setCellValue("G15", $lokasi_training);
        $sheet->getStyle("G15")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G15")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("G14:H14")->getBorders()->getAllBorders()->setBorderStyle("thin");

        $sheet->mergeCells("I13:J13");
        $sheet->setCellValue("I13", "Fasilitator / Trainer");
        $sheet->getStyle("I13")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("I13:J13")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("I13:J13")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98");
        $sheet->getStyle("I13")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("I14:J15");
        $sheet->setCellValue("I14", $pic);
        $sheet->getStyle("I14")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("I14")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("I14:J15")->getBorders()->getAllBorders()->setBorderStyle("thin");

        $sheet->setCellValue("K13", "Durasi");
        $sheet->getStyle("K13")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("K13")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98");
        $sheet->getStyle("K13")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("K13")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("K14:K15");
        $sheet->setCellValue("K14", $durasi);
        $sheet->getStyle("K14")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("K14")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("K14:K15")->getBorders()->getAllBorders()->setBorderStyle("thin");

        $sheet->mergeCells("G16:K16");
        $sheet->setCellValue("G16", "Alat");
        $sheet->getStyle("G16")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("G16:K16")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("G16:K16")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98");
        $sheet->getStyle("G16")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("G17:K18");
        $sheet->setCellValue("G17", $alat);
        $sheet->getStyle("G17")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G17")->getFont()->setSize(12)->setName("Times New Roman");
        $sheet->getStyle("G17:K18")->getBorders()->getAllBorders()->setBorderStyle("medium");




        $sheet->setCellValue("B20", "3");
        $sheet->getStyle("B20")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("B20")->getAlignment()->setHorizontal("center");

        $sheet->mergeCells("C20:K20");
        $sheet->setCellValue("C20", "Peserta");
        $sheet->getStyle("C20")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");


        $sheet->mergeCells("B22:E22");
        $sheet->setCellValue("B22", "Nama");
        $sheet->getStyle("B22")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("B22")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B22:E22")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("B22:E22")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98"); // Hijau Muda

        $sheet->mergeCells("F22:G22");
        $sheet->setCellValue("F22", "NIK");
        $sheet->getStyle("F22:G22")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("F22:G22")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("F22:G22")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("F22:G22")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98"); // Hijau Muda

        $sheet->mergeCells("H22:I22");
        $sheet->setCellValue("H22", "PRE");
        $sheet->getStyle("H22:I22")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("H22:I22")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("H22:I22")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("H22:I22")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98"); // Hijau Muda

        $sheet->mergeCells("J22:K22");
        $sheet->setCellValue("J22", "POST");
        $sheet->getStyle("J22:K22")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("J22:K22")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("J22:K22")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("J22:K22")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98"); // Hijau Muda


        foreach ($datauser as $user) {
            // Merge cells and set value for column B to E
            $sheet->mergeCells("B$index:E$index");
            $sheet->setCellValue("B$index", $user->name); // Assuming User model has 'name' property
            $sheet->getStyle("B$index:E$index")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
            $sheet->getStyle("B$index:E$index")->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("B$index:E$index")->getBorders()->getAllBorders()->setBorderStyle("thin");

            // Merge cells and set value for column F to G
            $sheet->mergeCells("F$index:G$index");
            $sheet->setCellValue("F$index", $user->nik); // Assuming User model has 'id' property
            $sheet->getStyle("F$index:G$index")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
            $sheet->getStyle("F$index:G$index")->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("F$index:G$index")->getBorders()->getAllBorders()->setBorderStyle("thin");

            // Merge cells and set value for column H to I
            $sheet->mergeCells("H$index:I$index");
            $sheet->setCellValue("H$index", $user->pre); // Replace 'custom_field' with the actual property in your User model
            $sheet->getStyle("H$index:I$index")->getFont()->setSize(12)->setName("Arial")->setBold(false);
            $sheet->getStyle("H$index:I$index")->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("H$index:I$index")->getBorders()->getAllBorders()->setBorderStyle("thin");

            // Merge cells and set value for column J to K
            $sheet->mergeCells("J$index:K$index");
            $sheet->setCellValue("J$index", $user->post); // Replace 'another_field' with the actual property in your User model
            $sheet->getStyle("J$index:K$index")->getFont()->setSize(12)->setName("Arial")->setBold(false);
            $sheet->getStyle("J$index:K$index")->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("J$index:K$index")->getBorders()->getAllBorders()->setBorderStyle("thin");

            $index++;
            $indexluar = $index;
        }

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "4");
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("C$indexluar:K$indexluar");
        $sheet->setCellValue("C$indexluar", "Evaluasi Training");
        $sheet->getStyle("C$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $indexluar++;
        $indexluar++;

        $sheet->getStyle("B$indexluar:K$indexluar")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98"); // Hijau Muda

        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->setCellValue("B$indexluar", "Kehadiran");
        $sheet->getStyle("B$indexluar:C$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar:C$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("D$indexluar:E$indexluar");
        $sheet->setCellValue("D$indexluar", "Test");
        $sheet->getStyle("D$indexluar:E$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("D$indexluar:E$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("D$indexluar:E$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("F$indexluar:G$indexluar");
        $sheet->setCellValue("F$indexluar", "Peserta");
        $sheet->getStyle("F$indexluar:G$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("F$indexluar:G$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("F$indexluar:G$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("H$indexluar:K$indexluar");
        $sheet->setCellValue("H$indexluar", "Evaluasi");
        $sheet->getStyle("F$indexluar:K$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("F$indexluar:K$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("F$indexluar:K$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("F$indexluar")->getAlignment()->setWrapText(true);

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Plan");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("C$indexluar", "Actual");
        $sheet->getStyle("C$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("C$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", "Ave Pre");
        $sheet->getStyle("D$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("D$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("D$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("E$indexluar", "Ave Post");
        $sheet->getStyle("E$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("E$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("E$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("F$indexluar", "Male");
        $sheet->getStyle("F$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("F$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("F$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("G$indexluar", "Female");
        $sheet->getStyle("G$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("G$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("H$indexluar:K" . ($indexluar + 2));
        $sheet->setCellValue("H$indexluar", $evaluasi);
        $sheet->getStyle("H$indexluar:K" . ($indexluar + 2))->getFont()->setSize(12)->setName("Times New Roman")->setBold("normal");
        $sheet->getStyle("H$indexluar:K" . ($indexluar + 2))->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("H$indexluar:K" . ($indexluar + 2))->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("H$indexluar:K" . ($indexluar + 2))->getAlignment()->setWrapText(true);

        $sheet->setCellValue("B$indexluar", "Plan");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $indexluar++;

        $sheet->setCellValue("B$indexluar", $totalAttendance);
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("C$indexluar", $hadirCount);
        $sheet->getStyle("C$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("C$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", $averagePreTest);
        $sheet->getStyle("D$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("D$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("D$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("E$indexluar", $averagePostTest);
        $sheet->getStyle("E$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("E$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("E$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("F$indexluar", $lakiCount);
        $sheet->getStyle("F$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("F$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("F$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("G$indexluar", $perempuanCount);
        $sheet->getStyle("G$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("G$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $indexluar++;

        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->setCellValue("B$indexluar", $totalKehadiran);
        $sheet->getStyle("B$indexluar:C$indexluar")->getFont()->setSize(26)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("B$indexluar:C$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->mergeCells("D$indexluar:E$indexluar");
        $sheet->setCellValue("D$indexluar", $rata_rata);
        $sheet->getStyle("D$indexluar:E$indexluar")->getFont()->setSize(26)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("D$indexluar:E$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("D$indexluar:E$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("F$indexluar", $averageCount);
        $sheet->getStyle("F$indexluar")->getFont()->setSize(18)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("F$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("F$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("G$indexluar", $averageCount);
        $sheet->getStyle("G$indexluar")->getFont()->setSize(18)->setName("Times New Roman")->setBold(false);
        $sheet->getStyle("G$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("G$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $indexluar++;

        $sheet->mergeCells("B$indexluar:K$indexluar");
        $sheet->setCellValue("B$indexluar", "Evaluasi Training");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->getStyle("B$indexluar:K$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");
        $sheet->getStyle("B$indexluar:K$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar:K$indexluar")->getFill()->setFillType("solid")->getStartColor()->setRGB("98FB98");

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Bagian");
        $sheet->getStyle("B$indexluar:C$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");


        $sheet->setCellValue("D$indexluar", "Program");
        $sheet->getStyle("D$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->mergeCells("D$indexluar:E$indexluar");
        $sheet->getStyle("D$indexluar:E$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("F$indexluar", "Pelatih");
        $sheet->getStyle("F$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->mergeCells("F$indexluar:G$indexluar");
        $sheet->getStyle("F$indexluar:G$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("H$indexluar", "Metode Pelatihan");
        $sheet->getStyle("H$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->mergeCells("H$indexluar:I$indexluar");
        $sheet->getStyle("H$indexluar:I$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("J$indexluar", "Kesan Umum");
        $sheet->getStyle("J$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");
        $sheet->mergeCells("J$indexluar:K$indexluar");
        $sheet->getStyle("J$indexluar:K$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $indexluar++;

        $rangeD35toK39 = "D$indexluar:K" . ($indexluar + 4);

        $sheet->getStyle($rangeD35toK39)->getFont()->setSize(12)->setName("Times New Roman")->setBold("normal");
        $sheet->getStyle($rangeD35toK39)->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("B$indexluar", "Sangat Tidak Puas");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(11)->setName("Calibri")->setBold("normal");
        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", "Jumlah");

        $sheet->setCellValue("E$indexluar", "Percentage");

        $sheet->setCellValue("F$indexluar", $sangat_tidak_puas1);

        $sheet->setCellValue("G$indexluar", $sangat_tidak_puas2);

        $sheet->setCellValue("H$indexluar", $sangat_tidak_puas3);

        $sheet->setCellValue("I$indexluar", $sangat_tidak_puas4);

        $sheet->setCellValue("J$indexluar", $sangat_tidak_puas5);

        $sheet->setCellValue("K$indexluar", $sangat_tidak_puas6);

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Tidak Puas");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(11)->setName("Calibri")->setBold("normal");
        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", $hasil_tes1);

        $sheet->setCellValue("E$indexluar", $hasil_tes2);

        $sheet->setCellValue("F$indexluar", $hasil_tes3);

        $sheet->setCellValue("G$indexluar", $hasil_tes4);

        $sheet->setCellValue("H$indexluar", $hasil_tes5);

        $sheet->setCellValue("I$indexluar", $hasil_tes6);

        $sheet->setCellValue("J$indexluar", $hasil_tes7);

        $sheet->setCellValue("K$indexluar", $hasil_tes8);

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Netral");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(11)->setName("Calibri")->setBold("normal");
        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", $netral1);

        $sheet->setCellValue("E$indexluar", $netral2);

        $sheet->setCellValue("F$indexluar", $netral3);

        $sheet->setCellValue("G$indexluar", $netral4);

        $sheet->setCellValue("H$indexluar", $netral5);

        $sheet->setCellValue("I$indexluar", $netral6);

        $sheet->setCellValue("J$indexluar", $netral7);

        $sheet->setCellValue("K$indexluar", $netral8);

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Puas");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(11)->setName("Calibri")->setBold("normal");
        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", $puas1);

        $sheet->setCellValue("E$indexluar", $puas2);

        $sheet->setCellValue("F$indexluar", $puas3);

        $sheet->setCellValue("G$indexluar", $puas4);

        $sheet->setCellValue("H$indexluar", $puas5);

        $sheet->setCellValue("I$indexluar", $puas6);

        $sheet->setCellValue("J$indexluar", $puas7);

        $sheet->setCellValue("K$indexluar", $puas8);

        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Sangat Puas");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(11)->setName("Calibri")->setBold("normal");
        $sheet->mergeCells("B$indexluar:C$indexluar");
        $sheet->getStyle("B$indexluar:C$indexluar")->getBorders()->getAllBorders()->setBorderStyle("medium");

        $sheet->setCellValue("D$indexluar", $sangat_puas1);

        $sheet->setCellValue("E$indexluar", $sangat_puas2);

        $sheet->setCellValue("F$indexluar", $sangat_puas3);

        $sheet->setCellValue("G$indexluar", $sangat_puas4);

        $sheet->setCellValue("H$indexluar", $sangat_puas5);

        $sheet->setCellValue("I$indexluar", $sangat_puas6);

        $sheet->setCellValue("j$indexluar", $sangat_puas7);

        $sheet->setCellValue("k$indexluar", $sangat_puas8);

        $indexluar++;
        $indexluar++;

        $sheet->setCellValue("B$indexluar", "5");
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->mergeCells("C$indexluar:K$indexluar");
        $sheet->setCellValue("C$indexluar", "Gambar Training");
        $sheet->getStyle("C$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $indexluar++;


        foreach ($gambarTraining as $gambar) {
            $indexluar++;
            // Path ke file gambar di storage Laravel
            $imagePath = storage_path("app/public/{$gambar->gambar}");

            // Menyisipkan gambar ke dalam sel
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath($imagePath);
            $drawing->setCoordinates("B$indexluar");
            $drawing->setHeight(100); // Sesuaikan dengan ukuran yang diinginkan
            $drawing->setWidth(100);  // Sesuaikan dengan ukuran yang diinginkan

            // Menyisipkan gambar ke dalam worksheet
            $sheet->mergeCells("B$indexluar:K" . ($indexluar + 6));
            $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("B$indexluar:K" . ($indexluar + 6))->getBorders()->getAllBorders()->setBorderStyle("medium");

            $drawings = $sheet->getDrawingCollection();
            $drawings[] = $drawing;

            $indexluar += 7; // Sesuaikan dengan kebutuhan Anda

        }

        $indexluar++;
        $indexluar++;
        $indexluar++;

        $sheet->setCellValue("B$indexluar", "Dibuat oleh");
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->mergeCells("B$indexluar:D$indexluar");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("normal");

        $sheet->mergeCells("I$indexluar:K$indexluar");
        $sheet->getStyle("I$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->setCellValue("I$indexluar", "Diperiksa");
        $sheet->getStyle("I$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("normal");

        $indexluar++;

        $sheet->mergeCells("B$indexluar:D" . ($indexluar + 2));
        $sheet->mergeCells("I$indexluar:K" . ($indexluar + 2));

        $indexluar++;
        $indexluar++;
        $indexluar++;

        $sheet->mergeCells("B$indexluar:D$indexluar");
        $sheet->mergeCells("I$indexluar:K$indexluar");


        $sheet->setCellValue("B$indexluar", "Widiastuti");
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $sheet->setCellValue("I$indexluar", "Anik Kuswandari");
        $sheet->getStyle("I$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("I$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("bold");

        $indexluar++;

        $sheet->mergeCells("B$indexluar:D$indexluar");
        $sheet->mergeCells("I$indexluar:K$indexluar");
        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("I$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");


        $sheet->setCellValue("B$indexluar", "Staff T&D");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("normal");

        $sheet->setCellValue("I$indexluar", "HRM Factory Manager");
        $sheet->getStyle("I$indexluar")->getFont()->setSize(12)->setName("Times New Roman")->setBold("normal");

        $indexluar++;
        $indexluar++;
        $indexluar++;

        $sheet->getStyle("B$indexluar")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->mergeCells("B$indexluar:K$indexluar");
        $sheet->setCellValue("B$indexluar", "FM-HRD-34.R.02 #$date");
        $sheet->getStyle("B$indexluar")->getFont()->setSize(8)->setName("Times New Roman")->setBold("normal");


        // Simpan ke file Excel
        $filename = "export_data.xlsx";
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);


        // Mengirim file sebagai respons
        return response()->download($filename)->deleteFileAfterSend(true);
    }
    public function store(Request $request)
    {
        try {
            $report = new Report();
            $report->id_training = $request->input("id_training");
            $report->feedback = $request->input("feedback");
            $report->evaluasi = $request->input("evaluasi");
            $report->save();

            if ($request->hasFile("gambar")) {
                foreach ($request->file("gambar") as $image) {
                    $gambarTraining = new GambarTraining();
                    $gambarTraining->id_report = $report->id_training;
                    $gambarTraining->gambar = $image->store("gambar_training", "public");
                    $gambarTraining->save();
                }
            }

            return redirect()->back()->with("success", "Data berhasil disimpan.");
        } catch (\Exception $e) {
            return back()->with("error", "Terjadi kesalahan: " . $e->getMessage());
        }
    }

    public function generatePDF(Request $request)
    {
        $id_training = $request->input("id_training");
        $alat = $request->input("alat");
        $durasi = $request->input("durasi");
        $evaluasi = $request->input("evaluasi");
        $feedback = $request->input("feedback");
        $sangat_tidak_puas1 = $request->input("sangat_tidak_puas1");
        $sangat_tidak_puas2 = $request->input("sangat_tidak_puas2");
        $sangat_tidak_puas3 = $request->input("sangat_puas3");
        $sangat_tidak_puas4 = $request->input("sangat_tidak_puas4");
        $sangat_tidak_puas5 = $request->input("sangat_tidak_puas5");
        $sangat_tidak_puas6 = $request->input("sangat_tidak_puas6");
        $hasil_tes1 = $request->input("hasil_tes1");
        $hasil_tes2 = $request->input("hasil_tes2");
        $hasil_tes3 = $request->input("hasil_tes3");
        $hasil_tes4 = $request->input("hasil_tes4");
        $hasil_tes5 = $request->input("hasil_tes5");
        $hasil_tes6 = $request->input("hasil_tes6");
        $hasil_tes7 = $request->input("hasil_tes7");
        $hasil_tes8 = $request->input("hasil_tes8");
        $netral1 = $request->input("netral1");
        $netral2 = $request->input("netral2");
        $netral3 = $request->input("netral3");
        $netral4 = $request->input("netral4");
        $netral5 = $request->input("netral5");
        $netral6 = $request->input("netral6");
        $netral7 = $request->input("netral7");
        $netral8 = $request->input("netral8");
        $puas1 = $request->input("puas1");
        $puas2 = $request->input("puas2");
        $puas3 = $request->input("puas3");
        $puas4 = $request->input("puas4");
        $puas5 = $request->input("puas5");
        $puas6 = $request->input("puas6");
        $puas7 = $request->input("puas7");
        $puas8 = $request->input("puas8");
        $sangat_puas1 = $request->input("sangat_puas1");
        $sangat_puas2 = $request->input("sangat_puas2");
        $sangat_puas3 = $request->input("sangat_puas3");
        $sangat_puas4 = $request->input("sangat_puas4");
        $sangat_puas5 = $request->input("sangat_puas5");
        $sangat_puas6 = $request->input("sangat_puas6");
        $sangat_puas7 = $request->input("sangat_puas7");
        $sangat_puas8 = $request->input("sangat_puas8");

        $reportData = Training::select(
            "training.nama_training",
            "training.materi_training",
            "training.waktu_mulai",
            "training.tanggal_training",
            "training.pic",
            "training.lokasi_training",
            "training.status_training",
            "users.nik",
            "users.name",
            "users.jenis_kelamin",
            "departement.nama as department_name",
            "absensi.status_absen",
            "test_pesertas.hasil_test",
            "test_pesertas.id_test",
            "test.jenis_test",
            "report.*",
            "gambar_training.gambar"
        )
            ->join("detail_trainings", "training.id", "=", "detail_trainings.id_training")
            ->join("users", "detail_trainings.id_user", "=", "users.id")
            ->join("departement", "detail_trainings.id_departement", "=", "departement.id")
            ->leftJoin("absensi", "detail_trainings.id_absen", "=", "absensi.id")
            ->leftJoin("test_pesertas", "detail_trainings.id_user", "=", "test_pesertas.id_user")
            ->leftJoin("report", "training.id", "=", "report.id_training")
            ->leftJoin("gambar_training", "report.id_training", "=", "gambar_training.id_report")
            ->leftJoin("test", "test_pesertas.id_test", "=", "test.id")
            ->where("training.id", $id_training)
            ->distinct()
            ->get();
        // dd($reportData);

        $genderCount = $reportData->groupBy("jenis_kelamin")->map(function ($item, $key) {
            return count($item);
        });
        $lakiCount = $genderCount["laki"] ?? 0;
        $perempuanCount = $genderCount["perempuan"] ?? 0;
        $totalAttendance = $reportData->count();
        $hadirCount = $reportData->where("status_absen", "hadir")->count();
        $preTestResults = $reportData->where("id_test", 1)->pluck("hasil_test");
        $postTestResults = $reportData->where("id_test", 2)->pluck("hasil_test");
        $averagePreTest = $preTestResults->avg();
        $averagePostTest = $postTestResults->avg();
        if ($reportData->isEmpty()) {
            $materi_training = "";
            $waktu_mulai = "";
            $tanggal_training = "";
            $lokasi_training = "";
            $nama_training = "";
            $pic = "";
            $status_training = "";
            $gambarTraining = "";
            $html = view("pdf.report", compact(
                "reportData",
                "id_training",
                "materi_training",
                "waktu_mulai",
                "nama_training",
                "tanggal_training",
                "lokasi_training",
                "pic",
                "gambarTraining",
                "status_training",
                "genderCount",
                "averagePreTest",
                "averagePostTest",
                "totalAttendance",
                "hadirCount",
                "lakiCount",
                "perempuanCount",
                "sangat_tidak_puas1",
                "sangat_tidak_puas2",
                "sangat_tidak_puas3",
                "sangat_tidak_puas4",
                "sangat_tidak_puas5",
                "sangat_tidak_puas6",
                "hasil_tes1",
                "hasil_tes2",
                "hasil_tes3",
                "hasil_tes4",
                "hasil_tes5",
                "hasil_tes6",
                "hasil_tes7",
                "hasil_tes8",
                "netral1",
                "netral2",
                "netral3",
                "netral4",
                "netral5",
                "netral6",
                "netral7",
                "netral8",
                "puas1",
                "puas2",
                "puas3",
                "puas4",
                "puas5",
                "puas6",
                "puas7",
                "puas8",
                "sangat_puas1",
                "sangat_puas2",
                "sangat_puas3",
                "sangat_puas4",
                "sangat_puas5",
                "sangat_puas6",
                "sangat_puas7",
                "sangat_puas8",
                "alat",
                "durasi",
                "feedback",
                "alat"
            ))->render();
            $pdf = app("dompdf.wrapper");
            $pdf->loadHTML($html);
            $pdf->setPaper("landscape");

            return $pdf->download("training_report.pdf");
        }

        $materi_training = $reportData[0]->materi_training;
        $waktu_mulai = $reportData[0]->waktu_mulai;
        $tanggal_training = $reportData[0]->tanggal_training;
        $nama_training = $reportData[0]->nama_training;
        $lokasi_training = $reportData[0]->lokasi_training;
        $pic = $reportData[0]->pic;
        $status_training = $reportData[0]->status_training;

        $html = view("pdf.report", compact(
            "reportData",
            "id_training",
            "materi_training",
            "waktu_mulai",
            "nama_training",
            "tanggal_training",
            "lokasi_training",
            "pic",
            "status_training",
            "genderCount",
            "averagePreTest",
            "averagePostTest",
            "totalAttendance",
            "hadirCount",
            "lakiCount",
            "perempuanCount",
            "sangat_tidak_puas1",
            "sangat_tidak_puas2",
            "sangat_tidak_puas3",
            "sangat_tidak_puas4",
            "sangat_tidak_puas5",
            "sangat_tidak_puas6",
            "hasil_tes1",
            "hasil_tes2",
            "hasil_tes3",
            "hasil_tes4",
            "hasil_tes5",
            "hasil_tes6",
            "hasil_tes7",
            "hasil_tes8",
            "netral1",
            "netral2",
            "netral3",
            "netral4",
            "netral5",
            "netral6",
            "netral7",
            "netral8",
            "puas1",
            "puas2",
            "puas3",
            "puas4",
            "puas5",
            "puas6",
            "puas7",
            "puas8",
            "sangat_puas1",
            "sangat_puas2",
            "sangat_puas3",
            "sangat_puas4",
            "sangat_puas5",
            "sangat_puas6",
            "sangat_puas7",
            "sangat_puas8",
            "alat",
            "durasi",
            "feedback",
            "alat"
        ))->render();
        $pdf = app("dompdf.wrapper");
        $pdf->loadHTML($html);
        $pdf->setPaper("landscape");

        return $pdf->download("training_report.pdf");
    }

    public function index(Request $request)
    {
        $id_training = $request->input("id_training");
        $reportData = Training::select(
            "training.nama_training",
            "training.materi_training",
            "training.waktu_mulai",
            "training.tanggal_training",
            "training.pic",
            "training.lokasi_training",
            "training.status_training",
            "users.nik",
            "users.name",
            "users.jenis_kelamin",
            "departement.nama as department_name",
            "absensi.status_absen",
            "test_pesertas.hasil_test",
            "test_pesertas.id_test",
            "test.jenis_test",
            "report.*",
            "gambar_training.gambar"
        )
            ->join("detail_trainings", "training.id", "=", "detail_trainings.id_training")
            ->join("users", "detail_trainings.id_user", "=", "users.id")
            ->join("departement", "detail_trainings.id_departement", "=", "departement.id")
            ->leftJoin("absensi", "detail_trainings.id_absen", "=", "absensi.id")
            ->leftJoin("test_pesertas", "detail_trainings.id_user", "=", "test_pesertas.id_user")
            ->leftJoin("report", "training.id", "=", "report.id_training")
            ->leftJoin("gambar_training", "report.id_training", "=", "gambar_training.id_report")
            ->leftJoin("test", "test_pesertas.id_test", "=", "test.id")
            ->where("training.id", $id_training)
            ->distinct()
            ->get();
        // dd($reportData);
        $genderCount = $reportData->groupBy("jenis_kelamin")->map(function ($item, $key) {
            return count($item);
        });
        $lakiCount = $genderCount["laki"] ?? 0;
        $perempuanCount = $genderCount["perempuan"] ?? 0;
        $totalAttendance = $reportData->count();
        $hadirCount = $reportData->where("status_absen", "hadir")->count();
        $preTestResults = $reportData->where("id_test", 1)->pluck("hasil_test");
        $postTestResults = $reportData->where("id_test", 2)->pluck("hasil_test");
        $averagePreTest = $preTestResults->avg();
        $averagePostTest = $postTestResults->avg();
        if ($reportData->isEmpty()) {
            $materi_training = "";
            $waktu_mulai = "";
            $tanggal_training = "";
            $lokasi_training = "";
            $pic = "";
            $nama_training = "";
            $status_training = "";
            $gambar_training = "";
            return view("panitia.training.tReport", compact(
                "reportData",
                "id_training",
                "nama_training",
                "materi_training",
                "waktu_mulai",
                "tanggal_training",
                "lokasi_training",
                "pic",
                "gambar_training",
                "status_training",
                "genderCount",
                "averagePreTest",
                "averagePostTest",
                "totalAttendance",
                "hadirCount",
                "lakiCount",
                "perempuanCount"
            ));
        }

        $materi_training = $reportData[0]->materi_training;
        $nama_training = $reportData[0]->nama_training;
        $waktu_mulai = $reportData[0]->waktu_mulai;
        $tanggal_training = $reportData[0]->tanggal_training;
        $lokasi_training = $reportData[0]->lokasi_training;
        $pic = $reportData[0]->pic;
        $status_training = $reportData[0]->status_training;
        $gambar_training = $reportData[0]->gambar;

        return view("panitia.training.tReport", compact(
            "reportData",
            "id_training",
            "nama_training",
            "materi_training",
            "waktu_mulai",
            "tanggal_training",
            "lokasi_training",
            "pic",
            "status_training",
            "genderCount",
            "averagePreTest",
            "averagePostTest",
            "totalAttendance",
            "hadirCount",
            "lakiCount",
            "gambar_training",
            "perempuanCount"
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