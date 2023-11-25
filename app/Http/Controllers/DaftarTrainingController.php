<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\DetailTraining;
use App\Models\absensi;

class DaftarTrainingController extends Controller
{
    public function index()
    {
        $training = training::all();

        return view('peserta.DaftarTraining', compact('training'));
    }

    public function join(Request $request, $trainingItem)
    {
        $user = auth()->user();
        $training = Training::where('id', $trainingItem)->first();

        if ($user && $training) {
            $idDepartement = $user->id_departement;
            $existingDetailTraining = DetailTraining::where('id_user', $user->id)
                ->where('id_training', $training->id)
                ->first();
            if ($existingDetailTraining) {
                return redirect()->back()->with('error', 'Anda sudah terdaftar dalam pelatihan ini.');
            }
            $absensi = Absensi::where('id_user', $user->id)
                ->where('id_training', $training->id)
                ->first();

            if (!$absensi) {
                $absensi = new Absensi();
                $absensi->id_user = $user->id;
                $absensi->id_training = $training->id;
                $absensi->id_department = $idDepartement;
                $absensi->status_absen = "belum absen";
                $absensi->tanggal_absen = now();
                $absensi->save();
            }
            $detailTraining = new DetailTraining();
            $detailTraining->id_user = $user->id;
            $detailTraining->id_departement = $idDepartement;
            $detailTraining->id_training = $training->id;
            $detailTraining->nama_training = $training->nama_training;
            $detailTraining->waktu_mulai = $training->waktu_mulai;
            $detailTraining->tanggal_training = $training->tanggal_training;
            $detailTraining->lokasi_training = $training->lokasi_training;
            $detailTraining->pic = $training->pic;
            $detailTraining->status = "telah diikuti";
            $detailTraining->status_training = "belum selesai";
            $detailTraining->id_absen = $absensi->id;
            $detailTraining->save();

            return redirect('/dashboard')->with('success', 'Anda berhasil bergabung dalam pelatihan ini.');
        } else {
            return redirect()->back()->with('error', 'Gagal bergabung dalam pelatihan ini.');
        }
    }


    public function isFollowedByUser($user_id, $training)
    {
        return DetailTraining::where('id_user', $user_id)
            ->where('id_training', $training->id)
            ->exists();
    }
}
