<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Test;
use App\Models\Jawaban;
use App\Models\TestPeserta;
use App\Models\Training;
use Illuminate\Http\Request;

class detailTest extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function simpan(Request $request)
    {
        $test = new Test();
        $test->id_training = $request->input('training');
        $test->jenis_test = $request->input('jenistest');
        $test->save();
        $id_test_baru = $test->id;
        $inputData = $request->except('_token', 'training', 'jenistest');

        $nomorSoal = null;
        $soalData = [];

        foreach ($inputData as $key => $value) {
            if (strpos($key, 'soalnomer') === 0) {
                $nomorSoal = substr($key, 9);
                $soalData[$nomorSoal]['soal'] = $value;
            } elseif (strpos($key, 'radio') === 0) {
                $soalData[$nomorSoal]['jawaban_benar'] = $value;
            } elseif (strpos($key, 'nilaiopsi') === 0) {
                $jawabanCounter = (int) substr($key, 9);
                $soalData[$nomorSoal]['opsi'][$jawabanCounter] = $value;
            }
        }

        if (empty($soalData)) {
            return redirect()->route('tampilkantest')->with('error', 'Tambahkan Soal Minimal 1.');
        }

        foreach ($soalData as $data) {
            $soal = new Soal();
            $soal->id_test = $id_test_baru;
            $soal->soal = $data['soal'];
            $soal->jawaban_benar = $data['jawaban_benar'];
            $soal->save();
            $id_soal_baru = $soal->id;
            foreach ($data['opsi'] as $nomorOpsi => $nilaiOpsi) {
                $jawaban = new Jawaban();
                $jawaban->id_soal = $id_soal_baru;
                $jawaban->jawaban = $nilaiOpsi;
                $jawaban->save();
            }
        }
        return redirect()->route('tampilkantest')->with('success', 'Test berhasil disimpan.');
    }
    // public function simpan(Request $request)
    // {
    //     // try {
    //     //     $existingTest = Test::where('id_training', $request->input('training'))
    //     //         ->where('jenis_test', $request->input('jenistest'))
    //     //         ->first();
    //     //     if ($existingTest) {
    //     //         return redirect()->route('tampilkantest')->with('error', 'jenis test yang sama sudah ada pada training tersebut.');
    //     //     }

    //     $test = new Test();
    //     $test->id_training = $request->input('training');
    //     $test->jenis_test = $request->input('jenistest');
    //     $test->save();
    //     $id_test_baru = $test->id;
    //     $inputData = $request->except('_token', 'training', 'jenistest');

    //     $nomorSoal = null;
    //     $soalData = [];

    //     foreach ($inputData as $key => $value) {
    //         if (strpos($key, 'soalnomer') === 0) {
    //             $nomorSoal = substr($key, 9);
    //             $soalData[$nomorSoal]['soal'] = $value;
    //         } elseif (strpos($key, 'radio') === 0) {
    //             $soalData[$nomorSoal]['jawaban_benar'] = $value;
    //         } elseif (strpos($key, 'nilaiopsi') === 0) {
    //             $jawabanCounter = (int) substr($key, 9);
    //             $soalData[$nomorSoal]['opsi'][$jawabanCounter] = $value;
    //         }
    //     }

    //     if (empty($soalData)) {
    //         return redirect()->route('tampilkantest')->with('error', 'Tambahkan Soal Minimal 1.');
    //     }

    //     foreach ($soalData as $data) {
    //         $soal = new Soal();
    //         $soal->id_test = $id_test_baru;
    //         $soal->soal = $data['soal'];
    //         $soal->jawaban_benar = $data['jawaban_benar'];
    //         $soal->save();
    //         $id_soal_baru = $soal->id;
    //         foreach ($data['opsi'] as $nomorOpsi => $nilaiOpsi) {
    //             $jawaban = new Jawaban();
    //             $jawaban->id_soal = $id_soal_baru;
    //             $jawaban->jawaban = $nilaiOpsi;
    //             $jawaban->save();
    //         }
    //     }
    //     return redirect()->route('tampilkantest')->with('success', 'Test berhasil disimpan.');

    //     return redirect()->route('tampilkantest')->with('error', 'Gagal menyimpan test: ' . $e->getMessage());
    // }



    public function detail($id)
    {
        $test = Test::find($id);

        if (!$test) {
            return redirect()->route('tampilkantest')->with('error', 'Tes tidak ditemukan');
        }
        $soal = Soal::where('id_test', $id)->get();
        $nama_training = Training::find($test->id_training);
        return view('panitia.test.detail-test', compact('test', 'soal', 'nama_training'));
    }


    public function tampilupdate($id)
    {
        $test = Test::find($id);

        if (!$test) {
            return redirect()->route('tampilkantest')->with('error', 'Tes tidak ditemukan');
        }
        $soal = Soal::where('id_test', $id)->get();
        $nama_training = Training::find($test->id_training);
        return view('panitia.test.update-soal', compact('test', 'soal', 'nama_training'));
    }


    public function delete($id)
    {
        try {
            $test = Test::findOrFail($id);
            $test->soal->each(function ($soal) {
                $soal->jawaban()->delete();
            });
            $test->soal()->delete();
            TestPeserta::where('id_test', $id)->delete();
            $test->delete();

            return redirect()->route('tampilkantest')->with('success', 'Test berhasil dihapus beserta data terkait.');
        } catch (\Exception $e) {
            return redirect()->route('tampilkantest')->with('error', 'Gagal menghapus test: ' . $e->getMessage());
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTest(Request $request, $id)
    {
        try {
            $jenisTest = $request->input('jenistest');
            Test::where('id', $id)->update([
                'jenis_test' => $jenisTest,
            ]);

            $requestData = $request->except('_token', 'idtraining1', 'jenistest2'); // Mengabaikan token dan kunci yang tidak diperlukan

            foreach ($requestData as $key => $value) {
                if (strpos($key, 'soalnomer') === 0) {
                    $soalId = substr($key, 9); // Mendapatkan ID soal dari nama kunci
                    Soal::where('id', $soalId)->update([
                        'soal' => $value,
                    ]);
                } elseif (strpos($key, 'jawaban') === 0) {
                    $jawabanId = substr($key, 7); // Mendapatkan ID jawaban dari nama kunci
                    Jawaban::where('id', $jawabanId)->update([
                        'jawaban' => $value,
                    ]);
                }
            }

            return redirect()->route('tampilkantest')->with('success', 'Test berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('tampilkantest')->with('error', 'Gagal memperbarui test: ' . $e->getMessage());
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
