<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestPeserta;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTestPesertaRequest;
use App\Http\Requests\UpdateTestPesertaRequest;

class TestPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_training = $request->input('idtraining'); // Ubah ini

        $testkus = Test::select('test.id as id', 'training.nama_training', 'training.tanggal_training', 'training.status_training')
            ->leftJoin('training', 'test.id_training', '=', 'training.id') // Ubah ini
            ->where('test.id_training', '=', $id_training) // Ubah ini
            ->get();

        return view('peserta.pilihtest', compact('testkus'));
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
     * @param  \App\Http\Requests\StoreTestPesertaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestPesertaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestPeserta  $testPeserta
     * @return \Illuminate\Http\Response
     */
    public function show(TestPeserta $testPeserta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestPeserta  $testPeserta
     * @return \Illuminate\Http\Response
     */
    public function edit(TestPeserta $testPeserta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTestPesertaRequest  $request
     * @param  \App\Models\TestPeserta  $testPeserta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestPesertaRequest $request, TestPeserta $testPeserta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestPeserta  $testPeserta
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestPeserta $testPeserta)
    {
        //
    }
}