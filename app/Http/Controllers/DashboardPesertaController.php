<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailTraining;
use App\Models\Test;
use App\Models\TestPeserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardPesertaController extends Controller
{
    public function showTrainingData()
    {
        $userId = Auth::id();
        $name = Auth::user()->name;

        $trainingData = DB::table('detail_trainings')
            ->select('id', 'id_user', 'id_training', 'nama_training', 'waktu_mulai', 'tanggal_training', 'pic', 'status as status_absen', 'status_training', 'lokasi_training')
            ->where('id_user', $userId)
            ->get();
        $testData = [];

        foreach ($trainingData as $data) {
            $id_training = $data->id_training;

            // Menggunakan Eloquent untuk mengambil data dari tabel test_pesertas dan melakukan join dengan tabel test
            $tests = TestPeserta::where('id_training', $id_training)
                ->join('test', 'test_pesertas.id_test', '=', 'test.id')
                ->select('test.jenis_test', 'test.id_training', 'test_pesertas.*')
                ->orderByRaw("FIELD(test.jenis_test, 'Pre Test', 'Post Test', 'Evaluasi')")
                ->get();

            $testData[$id_training] = $tests;
        }


        $testStatus = [];

        foreach ($trainingData as $data) {
            $id_training = $data->id_training;
            $kondisiaktiv = [
                'id_training' => $id_training,
                'userHasPreTest' => false, // Inisialisasi dengan false
                'userHasPostTest' => false, // Inisialisasi dengan false
                'userHasEvaluasi' => false, // Inisialisasi dengan false
            ];


            $kondisiaktiv['userHasPreTest'] = true;
            $kondisiaktiv['userHasPostTest'] = false;
            $kondisiaktiv['userHasEvaluasi'] = false;
            foreach ($testData as $tests) {
                foreach ($tests as $hasil) {
                    if ($hasil->jenis_test === 'Pre Test' && $data->id_training === $hasil->id_training) {
                        $kondisiaktiv['id_training'] = $hasil->id_training;
                        $kondisiaktiv['userHasPreTest'] = false;
                        $kondisiaktiv['userHasPostTest'] = true;
                        $kondisiaktiv['userHasEvaluasi'] = false;
                    } elseif ($hasil->jenis_test === 'Post Test' && $data->id_training === $hasil->id_training) {
                        $kondisiaktiv['id_training'] = $hasil->id_training;
                        $kondisiaktiv['userHasPreTest'] = false;
                        $kondisiaktiv['userHasPostTest'] = false;
                        $kondisiaktiv['userHasEvaluasi'] = true;
                    } elseif ($hasil->jenis_test === 'Evaluasi' && $data->id_training === $hasil->id_training) {
                        $kondisiaktiv['userHasPreTest'] = true;
                        $kondisiaktiv['userHasPostTest'] = true;
                        $kondisiaktiv['userHasEvaluasi'] = true;
                    }
                }
            }
            $testStatus[] = $kondisiaktiv;
        }

        return view('peserta.dashboard', compact('trainingData', 'name', 'testData', 'testStatus'));
    }
}
