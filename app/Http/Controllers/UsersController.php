<?php

namespace App\Http\Controllers;

use App\Models\absensi;
use App\Models\User;
use App\Models\Training;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Models\DetailTraining;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $trainingOptions = Training::pluck('nama_training', 'id');
        $departementOptions = Departement::pluck('nama', 'id');
        return view('register', compact('trainingOptions', 'departementOptions'));
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
            } elseif ($user->role === 'user') {
                $detailTrainings = DetailTraining::where('id_user', $user->id)->get();
                $currentDate = now()->toDateString();

                $absensiHariIni = Absensi::where('id_user', $user->id)->first();
                if ($absensiHariIni) {
                    $absensiHariIni2 = Absensi::where('id_user', $user->id)
                        ->whereDate('tanggal_absen', $currentDate)
                        ->first();
                    if (!$absensiHariIni2) {
                        $absensiTerakhir = Absensi::where('id_user', $user->id)
                            ->orderBy('tanggal_absen', 'desc')
                            ->first();
                        $absensiHariIni2 = new Absensi();
                        $absensiHariIni2->id_user = $user->id;
                        $absensiHariIni2->id_training = $absensiTerakhir->id_training;
                        $absensiHariIni2->id_department = $absensiTerakhir->id_department;
                        $absensiHariIni2->status_absen = "belum absen";
                        $absensiHariIni2->tanggal_absen = $currentDate;
                        $absensiHariIni2->save();
                        foreach ($detailTrainings as $detailTraining) {
                            $detailTraining->id_absen = $absensiHariIni2->id;
                            $detailTraining->save();
                        }
                    }
                }
                return redirect()->route('dashboard')->with('success', 'Selamat datang, User!');
            }
        }

        return redirect()->route('login')->with('error', 'Email atau password salah.');
    }

    public function showLoginForm()
    {
        return view('login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function logoutPeserta()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'id_departement' => 'required',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User([
            'id_departement' => $request->input('id_departement'),
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'nik' => $request->input('nik'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($user->save()) {
            return redirect()->back()->with('success', 'Data user berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data user.');
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show()
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
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
