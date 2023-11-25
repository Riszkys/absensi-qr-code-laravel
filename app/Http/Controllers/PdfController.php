<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $trainingId = $request->input('training_id');
        $currentDate = now()->toDateString();
        $query = "
             SELECT DISTINCT users.nik, users.name, departement.nama, absensi.status_absen, test_pesertas.hasil_test, departement.id AS iddepart, test_pesertas.id AS idtest, users.id AS idusers
             FROM detail_trainings
             LEFT JOIN departement ON detail_trainings.id_departement = departement.id
             LEFT JOIN absensi ON detail_trainings.id_absen = absensi.id
             LEFT JOIN test_pesertas ON detail_trainings.id_user = test_pesertas.id_user
             LEFT JOIN users ON detail_trainings.id_user = users.id
             WHERE detail_trainings.id_training = ? AND DATE(absensi.tanggal_absen) = ?
         ";
        $trainings = DB::select($query, [$trainingId, $currentDate]);
        // Load view 'pdf.trainings' yang berisi tabel
        $data = isset($trainings[0]) ? $trainings[0]->nik : 0;
        $pdf = PDF::loadView('pdf.trainings', compact('trainings', 'data', 'trainingId'));
        // Simpan PDF ke dalam file atau kirim sebagai respons
        return $pdf->download('training_report.pdf');
    }
}
