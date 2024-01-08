<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Report;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateReportRequest;
use App\Models\GambarTraining;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
        $report = new Report();
        $report->id_training = $request->input('id_training');
        $report->feedback = $request->input('feedback');
        $report->evaluasi = $request->input('evaluasi');
        $report->save();

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $image) {
                $gambarTraining = new GambarTraining();
                $gambarTraining->id_report = $request->input('id_training');
                $gambarTraining->gambar = $image->store('gambar_training', 'public');
                $gambarTraining->save();
            }
        }
        return redirect()->route('report.index')->with('success', 'Data berhasil disimpan.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    }

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
            'users.jenis_kelamin',
            'departement.nama as department_name',
            'absensi.status_absen',
            'test_pesertas.hasil_test',
            'test_pesertas.id_test',
            'test.jenis_test',
            'report.*',
            'gambar_training.gambar'
        )
        ->join('detail_trainings', 'training.id', '=', 'detail_trainings.id_training')
        ->join('users', 'detail_trainings.id_user', '=', 'users.id')
        ->join('departement', 'detail_trainings.id_departement', '=', 'departement.id')
        ->leftJoin('absensi', 'detail_trainings.id_absen', '=', 'absensi.id')
        ->leftJoin('test_pesertas', 'detail_trainings.id_user', '=', 'test_pesertas.id_user')
        ->leftJoin('report', 'training.id', '=', 'report.id_training')
        ->leftJoin('gambar_training', 'report.id_training', '=', 'gambar_training.id_report')
        ->leftJoin('test', 'test_pesertas.id_test', '=', 'test.id')
        ->where('training.id', $id_training)
        ->distinct()
        ->get();

        $genderCount = $reportData->groupBy('jenis_kelamin')->map(function ($item, $key) {
            return count($item);
        });
        $lakiCount = $genderCount['laki'] ?? 0;
        $perempuanCount = $genderCount['perempuan'] ?? 0;
        $totalAttendance = $reportData->count();
        $hadirCount = $reportData->where('status_absen', 'hadir')->count();
        $preTestResults = $reportData->where('id_test', 1)->pluck('hasil_test');
        $postTestResults = $reportData->where('id_test', 2)->pluck('hasil_test');
        $averagePreTest = $preTestResults->avg();
        $averagePostTest = $postTestResults->avg();
        if ($reportData->isEmpty()) {
            $materi_training = '';
            $waktu_mulai = '';
            $tanggal_training = '';
            $lokasi_training = '';
            $pic = '';
            $status_training = '';
            $gambarTraining= '';
            return view('panitia.training.tReport', compact(
                'reportData',
                'id_training',
                'materi_training',
                'waktu_mulai',
                'tanggal_training',
                'lokasi_training',
                'pic',
                'gambarTraining',
                'status_training',
                'genderCount',
                'averagePreTest',
                'averagePostTest',
                'totalAttendance',
                'hadirCount',
                'lakiCount',
                'perempuanCount'
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
            'status_training',
            'genderCount',
            'averagePreTest',
            'averagePostTest',
            'totalAttendance',
            'hadirCount',
            'lakiCount',
            'perempuanCount'
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
