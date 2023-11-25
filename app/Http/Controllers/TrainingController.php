<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\DetailTraining;
use App\Http\Requests\StoreTrainingRequest;
use App\Models\absensi;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $training = training::all();
        return view('panitia.mTraining', compact('training'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'nama_training' => 'required|string|max:255',
            'waktu_mulai' => 'required|string|max:255',
            'jadwal_training' => 'required|date',
            'lokasi_training' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'materi_training' => 'required|string|max:255',
        ]);

        $training = new Training([
            'nama_training' => $request->input('nama_training'),
            'waktu_mulai' => $request->input('waktu_mulai'),
            'lokasi_training' => $request->input('lokasi_training'),
            'pic' => $request->input('pic'),
            'tanggal_training' => $request->input('jadwal_training'),
            'status_training' => 'belum dimulai',
            'materi_training' => $request->input('materi_training'),
        ]);
        if ($training->save()) {
            return redirect()->back()->with('success', 'Data departemen berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data departemen.');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $training = training::findOrFail($id);
        return view('panitia.editTraining', compact('training'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingRequest  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $training = Training::findOrFail($id);

        $request->validate([
            'nama_training' => 'required|string|max:255',
            // 'waktu_mulai' => 'required|string|max:255',
            'jadwal_training' => 'required|date',
            'lokasi_training' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'status_training' => 'required|string|max:255',
            'materi_training' => 'required|string|max:255',
        ]);

        if ($training->update([
            'nama_training' => $request->input('nama_training'),
            'waktu_mulai' => $request->input('waktu_mulai'),
            'lokasi_training' => $request->input('lokasi_training'),
            'pic' => $request->input('pic'),
            'tanggal_training' => $request->input('jadwal_training'),
            'status_training' => $request->input('status_training'),
            'materi_training' => $request->input('materi_training'),
        ])) {
            return redirect()->back()->with('success', 'Data training berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data training.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training = Training::find($id);

        if (!$training) {
            return redirect()->back()->with('error', 'Training tidak ditemukan.');
        }

        DetailTraining::where('id_training', $id)->delete();
        Absensi::where('id_training', $id)->delete();
        Test::where('id_training', $id)->delete();

        if ($training->delete()) {
            return redirect()->back()->with('success', 'Training berhasil dihapus beserta data terkait.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus training dan data terkait.');
        }
    }
}