@extends('index')

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
        <form action="{{ route('training.update', $training->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_training" class="mt-3">Nama Training</label>
                <input type="text" class="form-control mt-3" id="nama_training" name="nama_training"
                    value="{{ old('nama_training', $training->nama_training) }}">
            </div>
            <div class="form-group">
                <label for="waktu_mulai" class="mt-3">Waktu Mulai</label>
                <input type="time" class="form-control mt-3" id="waktu_mulai" name="waktu_mulai"
                    value="{{ old('waktu_mulai', $training->waktu_mulai) }}">
            </div>
            <div class="form-group">
                <label for="lokasi_training" class="mt-3">Lokasi Training</label>
                <input type="text" class="form-control mt-3" id="lokasi_training" name="lokasi_training"
                    value="{{ old('lokasi_training', $training->lokasi_training) }}">
            </div>
            <div class="form-group">
                <label for="pic" class="mt-3">PIC</label>
                <input type="text" class="form-control mt-3" id="pic" name="pic"
                    value="{{ old('pic', $training->pic) }}">
            </div>
            <div class="form-group">
                <label for="jadwal_training" class="mt-3">Tanggal Training</label>
                <input type="date" class="form-control mt-3" id="jadwal_training" name="jadwal_training"
                    value="{{ old('jadwal_training', $training->tanggal_training) }}">
            </div>
            <div class="form-group">
                <label for="status_training" class="mt-3">Status Training</label>
                <input type="text" class="form-control mt-3" id="status_training" name="status_training"
                    value="{{ old('status_training', $training->status_training) }}">
            </div>
            <div class="form-group">
                <label for="materi_training" class="mt-3">Materi Training</label>
                <input type="text" class="form-control mt-3" id="materi_training" name="materi_training"
                    value="{{ old('materi_training', $training->materi_training) }}">
            </div>

            <div class="pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/panitia/training" class="btn btn-primary">Back</a>
            </div>
        </form>
    @endsection
