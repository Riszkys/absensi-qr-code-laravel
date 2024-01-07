<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Test;
use App\Models\Jawaban;
use App\Models\Training;
use App\Models\TestPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTestRequest;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $testkus = Test::select('test.id', 'training.nama_training', 'training.tanggal_training', 'training.status_training')
            ->leftJoin('training', 'id_training', '=', 'training.id')
            ->get();

        return view('panitia.mTest', compact('testkus'));
    }

    public function showtraining()
    {
        $trainings = Training::select('id', 'nama_training')->get();
        return view('panitia.test.tambah', compact('trainings'));
    }

    public function showpilihsoal(Request $request)
    {
        $id_training = $request->input('idtraining');

        $testkus = Test::select('test.id as id', 'training.nama_training', 'training.tanggal_training', 'training.status_training')
            ->leftJoin('training', 'test.id_training', '=', 'training.id')
            ->where('test.id_training', '=', $id_training)
            ->get();
        return view('peserta.pilihtest', compact('testkus'));
    }

    public function mulaitest(Request $request)
    {
        // Menggunakan first() untuk mendapatkan satu baris hasil query
        $test = Test::where('id_training', $request->input('id_training'))
            ->where('jenis_test', $request->input('jenistest'))
            ->first();
        if (!$test) {
            $test = Test::where('id_training', $request->input('id_training'))
                ->first();
            $jenistest = $test->jenis_test;
            if ($jenistest === 'Pre Test') {
                return redirect()->route('dashboard')->with('error', 'Post Test Belum Dibuat Panitia');
            } elseif ($jenistest === 'Post Test') {
                return redirect()->route('dashboard')->with('error', 'Evaluasi Belum Dibuat Panitia');
            } elseif ($jenistest) {
                return redirect()->route('dashboard')->with('error', 'Pre Test Belum Dibuat Panitia');
            } else {
                return redirect()->route('dashboard')->with('error', 'Tes tidak ditemukan / Belum Dibuat');
            }
        }

        $soal = Soal::where('id_test', $test->id)->get();
        $nama_training = Training::find($test->id_training);
        return view('peserta.test', compact('test', 'soal', 'nama_training'));
    }


    public function simpanjawaban(Request $request)
    {
        $id_test = $request->input('id_test');
        $id_user = Auth::user()->id;
        $id_soal = $request->input('id_soal');
        $jawaban = $request->input('jawaban');
        $nilaiJawaban = [];
        $totalJawabanBenar = 0;

        foreach ($id_soal as $id) {
            $jawabanSamaIdSoal = Jawaban::where('id_soal', $id)->get();

            if ($jawabanSamaIdSoal->count() > 0) {
                $soal = Soal::find($id);
                $indeksJawabanBenar = $soal->jawaban_benar;

                $jawabanBenar = $jawabanSamaIdSoal[$indeksJawabanBenar - 1];

                $nilaiJawaban[] = ($jawaban[$id] == $jawabanBenar->jawaban) ? '1' : '0';
            }
        }
        $totalJawabanBenar = array_sum($nilaiJawaban);
        $totalSoal = count($nilaiJawaban);
        $persentaseBenar = ($totalJawabanBenar / $totalSoal) * 100;
        $nilaiAkhir = round($persentaseBenar);

        $testPeserta = TestPeserta::where('id_test', $id_test)
            ->where('id_user', $id_user)
            ->first();

        if ($testPeserta) {
            $testPeserta->hasil_test = $nilaiAkhir;
            if ($testPeserta->save()) {
                return redirect()->route('dashboard')->with('success', 'Nilai berhasil disimpan.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Gagal menyimpan nilai.');
            }
        } else {
            $testPeserta = new TestPeserta();
            $testPeserta->id_test = $id_test;
            $testPeserta->id_user = $id_user;
            $testPeserta->hasil_test = $nilaiAkhir;

            if ($testPeserta->save()) {
                return redirect()->route('dashboard')->with('success', 'Nilai berhasil disimpan.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Gagal menyimpan nilai.');
            }
        }
    }









    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTestRequest  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
