<?php

namespace App\Http\Controllers;

use App\Models\DetailTraining;
use App\Models\User;
use App\Models\Absensi;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\TestPeserta;
use App\Models\Training;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function absenBaru(Request $request)
    {
        $id_user = auth()->id();
        $id_training = $request->input('id_training');

        $existingAbsen = DB::table('absensi')
            ->where('id_user', $id_user)
            ->where('id_training', $id_training)
            ->first();

        if ($existingAbsen) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah absen.');
        }

        $user = User::find($id_user);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $id_departement = $user->id_departement;
        $status_absen = "Belum Absen";
        $tanggal_absen = now();

        DB::table('absensi')->insert([
            'id_department' => $id_departement,
            'id_training' => $id_training,
            'id_user' => $id_user,
            'status_absen' => $status_absen,
            'tanggal_absen' => $tanggal_absen,
        ]);

        return redirect()->route('dashboard')->with('success', 'Absen berhasil dicatat.');
    }


    public function scanBarcode(Request $request)
    {
        $nama_training = $request->input('result');
        $id_user = auth()->id();

        $dataTraining = DB::table('training')
            ->where('nama_training', $nama_training)
            ->get();

        if ($dataTraining->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Mengambil data ID dari tabel training
        $trainingId = $dataTraining[0]->id;


        // Pemrosesan data jika ditemukan
        $materi_training = $dataTraining[0]->materi_training;
        $waktu_mulai = $dataTraining[0]->waktu_mulai;
        $tanggal_training = $dataTraining[0]->tanggal_training;
        $lokasi_training = $dataTraining[0]->lokasi_training;
        $pic = $dataTraining[0]->pic;

        return view('peserta.absen', compact(
            'dataTraining',
            'nama_training',
            'materi_training',
            'waktu_mulai',
            'tanggal_training',
            'lokasi_training',
            'pic',
            'id_user',
            'trainingId'
        ));
    }

    public function index(Request $request)
    {
        $trainingId = $request->input('training_id');
        $currentDate = now()->toDateString();
        $query = "
        SELECT DISTINCT
            absensi.*,
            absensi.id as id_absen,
            departement.*,
            users.*,
            training.nama_training,
            training.pic as pic,
            training.lokasi_training as lokasi_training,
            training.waktu_mulai as waktu_mulai,
            training.tanggal_training as tanggal_training,
            training.status_training as status_training
        FROM
            absensi
        LEFT JOIN
            departement ON absensi.id_department = departement.id
        LEFT JOIN
            users ON absensi.id_user = users.id
        LEFT JOIN
            training ON absensi.id_training = training.id
        WHERE
            absensi.id_training = ?
            AND DATE(absensi.tanggal_absen) = ?
        ";
        $trainings = DB::select($query, [$trainingId, $currentDate]);

        $query2 = "
        SELECT test_pesertas.hasil_test, test.id_training,test.jenis_test, test_pesertas.id_user FROM test_pesertas
        JOIN test on test_pesertas.id_test = test.id
        WHERE test.id_training = ? && test_pesertas.id_user = ?
        ";

        if ($trainings) {
            foreach ($trainings as $key => $trai) {
                $ambilhasiltest = DB::select($query2, [$trainingId, $trai->id_user]);
            }
        } else {
            $ambilhasiltest = null;
        }

        if ($trainings) {
            $nama_training = isset($trainings[0]) ? $trainings[0]->nama_training : null; /* Ambil nilai nama_training */
        } else {
            $nama_training = Training::find($trainingId);
            $nama_training = $nama_training->nama_training;
        }
        $data = isset($trainings[0]) ? $trainings[0]->nik : 0;
        if (is_string($nama_training) && strlen($nama_training) > 0) {
            $qrCode = QrCode::size(200)->generate($nama_training);
        } else {
            $qrCode = null;
        }


        return view('panitia.training.tAbsensi', compact('trainings', 'data', 'qrCode', 'trainingId', 'nama_training', 'ambilhasiltest'));
    }



    public function updateStatus(Request $request)
    {
        try {
            $id_training = $request->input('id_training');
            DB::table('training')
                ->where('id', $id_training)
                ->update(['status_training' => 'selesai']);

            return redirect()->back()->with('success', 'Status pelatihan telah diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pelatihan: ' . $e->getMessage());
        }
    }
    public function absen(Request $request)
    {
        try {

            $id_training = $request->input('id_training');
            $id_department = $request->input('id_department');
            $id_user = $request->input('id_user');
            $status_absen = 'hadir';
            $tanggal_absen = now()->toDateString();
            $existingStatusTraining = Training::where('id', $id_training)
                ->first();

            if ($existingStatusTraining) {
                $existingStatusTraining->update(['status_training' => 'Sedang Dilaksanakan']);
            }

            $ambilstatusabsen = Absensi::where('id', $request->input('id_absen'))
                ->first();

            $existingAbsen = Absensi::where('id_training', $id_training)
                ->where('id_user', $id_user)
                ->whereDate('tanggal_absen', $tanggal_absen)
                ->first();

            $existingDetailTraining = DetailTraining::where('detail_trainings.id_training', $id_training)
                ->where('detail_trainings.id_user', $id_user)
                ->where('detail_trainings.id_absen', $request->input('id_absen'))
                ->first();
            if ($existingDetailTraining) {
                $existingDetailTraining->update(['status' => $status_absen]);
            }

            if ($existingAbsen) {
                $existingAbsen->update(['status_absen' => $status_absen]);
            } else {
                Absensi::create([
                    'id_department' => $id_department,
                    'id_training' => $id_training,
                    'id_user' => $id_user,
                    'status_absen' => $status_absen,
                    'tanggal_absen' => $tanggal_absen,
                ]);
            }

            $existingDetailTraining = DetailTraining::where('id_training', $id_training)
                ->where('id_user', $id_user)
                ->first();
            if (!$existingDetailTraining) {

                DetailTraining::create([
                    'id_user' => $request->input('id_user'),
                    'id_training' => $request->input('id_training'),
                    'id_departement' => $request->input('id_department'),
                    'id_absen' => $request->input('id_absen'),
                    'nama_training' => $request->input('nama_training'),
                    'waktu_mulai' => $request->input('waktu_mulai'),
                    'tanggal_training' => $request->input('tanggal_training'),
                    'lokasi_training' => $request->input('lokasi_training'),
                    'pic' => $request->input('pic'),
                    'status' => $ambilstatusabsen->status_absen,
                    'status_training' => $request->input('status_training'),
                ]);
            }

            return redirect('/panitia/training')->with('success', 'Absen berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect('/panitia/training')->with('error', 'Gagal mencatat absen: ' . $e->getMessage());
        }
    }


    public function tolak(Request $request)
    {
        try {

            $id_training = $request->input('id_training');
            $id_department = $request->input('id_department');
            $id_user = $request->input('id_user');
            $status_absen = 'tidak hadir';
            $tanggal_absen = now()->toDateString();
            $existingStatusTraining = Training::where('id', $id_training)
                ->first();

            if ($existingStatusTraining) {
                $existingStatusTraining->update(['status_training' => 'Sedang Dilaksanakan']);
            }

            $ambilstatusabsen = Absensi::where('id', $request->input('id_absen'))
                ->first();

            $existingAbsen = Absensi::where('id_training', $id_training)
                ->where('id_user', $id_user)
                ->first();

            $existingDetailTraining = DetailTraining::where('detail_trainings.id_training', $id_training)
                ->where('detail_trainings.id_user', $id_user)
                ->where('detail_trainings.id_absen', $request->input('id_absen'))
                ->first();
            if ($existingDetailTraining) {
                $existingDetailTraining->update(['status' => $status_absen]);
            }

            if ($existingAbsen) {
                $existingAbsen->update(['status_absen' => $status_absen]);
            } else {
                Absensi::create([
                    'id_department' => $id_department,
                    'id_training' => $id_training,
                    'id_user' => $id_user,
                    'status_absen' => $status_absen,
                    'tanggal_absen' => $tanggal_absen,
                ]);
            }

            $existingDetailTraining = DetailTraining::where('id_training', $id_training)
                ->where('id_user', $id_user)
                ->first();
            if (!$existingDetailTraining) {

                DetailTraining::create([
                    'id_user' => $request->input('id_user'),
                    'id_training' => $request->input('id_training'),
                    'id_departement' => $request->input('id_department'),
                    'id_absen' => $request->input('id_absen'),
                    'nama_training' => $request->input('nama_training'),
                    'waktu_mulai' => $request->input('waktu_mulai'),
                    'tanggal_training' => $request->input('tanggal_training'),
                    'lokasi_training' => $request->input('lokasi_training'),
                    'pic' => $request->input('pic'),
                    'status' => $ambilstatusabsen->status_absen,
                    'status_training' => $request->input('status_training'),
                ]);
            }

            return redirect('/panitia/training')->with('success', 'Absen berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect('/panitia/training')->with('error', 'Gagal mencatat absen: ' . $e->getMessage());
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
     * @param  \App\Http\Requests\StoreAbsensiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbsensiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbsensiRequest  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbsensiRequest $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
