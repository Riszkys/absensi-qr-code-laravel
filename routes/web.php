<?php


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\detailTest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardPanitia;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DaftarTrainingController;
use App\Http\Controllers\DashboardPesertaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/absen', [AbsensiController::class, 'scanBarcode'])->name('absen.index');
Route::post('/absen/peserta/baru', [AbsensiController::class, 'absenBaru'])->name('absen.baru');

Route::post('/test/mulai', [TestController::class, 'mulaitest'])->name('mulaitest');


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/absensi', function () {
    return view('peserta.absen');
});

// user login register crud start
Route::post('/user/create', [UsersController::class, 'create'])->name('user.create');
Route::get('/register', [UsersController::class, 'index']);
Route::get('/login', [UsersController::class, 'showLoginForm'])->name('login');
Route::post('/login/redirect', [UsersController::class, 'login'])->name('login.submit');
Route::get('/logout', [UsersController::class, 'logout'])->name('logout');
Route::get('/logout/peserta', [UsersController::class, 'logoutPeserta'])->name('logout.peserta');

// route admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/panitia/dashboard', [DashboardPanitia::class, 'index'])->name('admin.dashboard');
    Route::get('/panitia/dashboard', [DashboardPanitia::class, 'index'])->name('admin.dashboard');
    Route::get('/panitia/department', function () {
        return view('panitia.mDepartmen');
    });
    Route::get('/panitia/training', [TrainingController::class, 'index']);
    Route::get('/panitia/test', function () {
        return view('panitia.mTest');
    });
    Route::get('/panitia/test/detail', function () {
        return view('panitia.test.detail');
    });
    Route::get('/calendar', [CalendarController::class, 'index']);
    Route::get('/events', [CalendarController::class, 'events']);
    Route::get('/panitia', [DashboardPanitia::class, 'index']);
    Route::get('/panitia/training/absensi', [AbsensiController::class, 'index'])->name('training.absensi');
    Route::post('/selesai-pelatihan', [AbsensiController::class, 'updateStatus'])->name('selesai.pelatihan');
    Route::get('/panitia/training/report', [ReportController::class, 'index'])->name('report.index');
    Route::post('/generate-pdf', [ReportController::class, 'generatePDF'])->name('simpan.pdf');
    Route::post('/generate-excel', [ReportController::class, 'exportDataToExcel'])->name('simpan.excel');
    Route::get('/panitia/test/detail-test/{id}', [detailTest::class, 'detail'])->name('detailtest');
    Route::get('/panitia/test/showupdate/{id}', [detailTest::class, 'tampilupdate'])->name('showupdatesoal');
    Route::post('/panitia/test/update/{id}', [detailTest::class, 'updatetest'])->name('updatetest');
    Route::post('/panitia/text/detail/simpan', [detailTest::class, 'simpan'])->name('simpansoal');
    Route::delete('/panitia/test/delete/{id}', [detailTest::class, 'delete'])->name('deletetest');
    Route::get('/panitia/test', [TestController::class, 'index'])->name('tampilkantest');
    Route::get('/panitia/test/tambah', [TestController::class, 'showtraining'])->name('tambahtest');
    Route::post('/department', [DepartementController::class, 'create'])->name('departement.create');
    Route::get('/panitia/department', [DepartementController::class, 'index'])->name('departement.index');
    Route::delete('/department/{id}', [DepartementController::class, 'destroy'])->name('departement.destroy');
    Route::put('/department/{id}', [DepartementController::class, 'edit'])->name('departement.edit');
    Route::put('/departemen/{id}', [DepartementController::class, 'update'])->name('panitia.updateDepartemen');
    Route::post('/training/create', [TrainingController::class, 'create'])->name('training.create');
    Route::get('/panitia/training', [TrainingController::class, 'index'])->name('training.index');
    Route::delete('/training/{id}', [TrainingController::class, 'destroy'])->name('training.destroy');
    Route::get('/training/{id}/edit', [TrainingController::class, 'edit'])->name('training.edit');
    Route::put('/training/{id}', [TrainingController::class, 'update'])->name('training.update');
    Route::get('/generate-pdf/get', [PDFController::class, 'generatePDF'])->name('generate-pdf');
    Route::post('/panitia/training/absen', [AbsensiController::class, 'absen'])->name('absen');
    Route::post('/panitia/training/tolak', [AbsensiController::class, 'tolak'])->name('tolak');
});


// routes peserta
Route::middleware(['auth', 'peserta'])->group(function () {
    Route::get('/dashboard', [DashboardPesertaController::class, 'showTrainingData'])->name('dashboard');
    Route::get('/soal', function () {
        return view('peserta.soal');
    });
    Route::get('/absensi', function () {
        return view('peserta.absen');
    });
    Route::get('/daftarTraining', [DaftarTrainingController::class, 'index'])->name('training.index');
    Route::post('/training/join/{trainingItem}', [DaftarTrainingController::class, 'join'])->name('training.join');
    Route::post('/test', [TestController::class, 'showpilihsoal'])->name('ikutitest');
    // Route::post('/test/mulai', [TestController::class, 'mulaitest'])->name('mulaitest');
    Route::post('/simpan-jawaban', [TestController::class, 'simpanjawaban'])->name('simpan.jawaban');
    Route::get('/absensi', function () {
        return view('peserta.absen');
    });
});
