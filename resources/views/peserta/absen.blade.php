@extends('indexPeserta')

@section('container')
    <div class="row my-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <h2 class="text-center">Daftar Pelatihan {{ $nama_training }}</h2>
    <div class="row">
        <div class="col-12 py-2">
            {{-- @foreach ($dataTraining as $training) --}}
            <div class="row">
                <div class="col-3">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Materi Training</label>
                </div>
                <p class="col">{{ $materi_training }}</p>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Waktu Mulai</label>
                </div>
                <p class="col">{{ $waktu_mulai }}</p>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Jadwal Training</label>
                </div>
                <p class="col">{{ $tanggal_training }}</p>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Lokasi Training</label>
                </div>
                <p class="col">{{ $lokasi_training }}</p>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">PIC</label>
                </div>
                <p class="col">{{ $pic }}</p>
            </div>
            <div class="row justify-content-between my-3">
                <form action="{{ route('absen.baru') }}" class="col-12 col-md-5" method="POST">
                    @csrf
                    <input type="hidden" name="id_training" id="id_training" value="{{ $trainingId }}">
                    <button type="submit" class="btn btn-primary w-100">Absen</button>
                </form>
                <form action="/dashboard" class="col-12 col-md-5">
                    <button type="submit" class="btn btn-secondary w-100">Kembali</button>
                </form>
            </div>
            {{-- @endforeach --}}
        </div>
    </div>
    {{-- <h2 class="text-center">Nama Training: {{ $nama_training }}</h2> --}}
    </div>
@endsection
