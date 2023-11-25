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
    <div class="my-4">
        <h2 class="my-4 text-center">Test Pelatihan {{ $nama_training->nama_training }}</h2>

        <form method="POST" action="{{ route('simpan.jawaban') }}">
            @csrf
            <input type="hidden" name="id_test" value="{{ $test->id }}"> <!-- ID Test -->

            <div class="row my-3">
                <div class="col-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Nama Training</label>
                </div>
                <div class="col-9 col-md-3">
                    <input type="text" class="form-control" value="{{ $nama_training->nama_training }}" readonly>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Jenis Test.</label>
                </div>
                <div class="col-9 col-md-3">
                    <input type="text" class="form-control" value="{{ $test->jenis_test }}" readonly>
                </div>
            </div>
            @foreach ($soal as $s)
                <input type="hidden" name="id_soal[]" value="{{ $s->id }}">
                <div class="col-12 pt-1">
                    <div class="row">
                        <div class="col-2">
                            <label for="namaTraining" class="col-form-label col-auto pr-3">Soal
                                {{ $loop->iteration }}.</label>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label"
                                aria-placeholder="Isi Soal Anda ..."></label>
                            <textarea name="soalnomer" class="form-control" id="exampleFormControlTextarea1" rows="3" readonly required>{{ $s->soal }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="col-2">
                    <label class="col-form-label col-auto pr-3">Opsi Jawaban {{ $loop->iteration }}.</label>
                </div>
                @foreach ($s->jawaban as $jawaban)
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="radio" value="{{ $jawaban->jawaban }}"
                                            name="jawaban[{{ $s->id }}]" data-nomor="{{ $jawaban->nomor }}">
                                    </div>
                                    <input type="text" class="form-control" value="{{ $jawaban->jawaban }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
            <div class="row justify-content-end g-2 my-3">
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
        <div class="row justify-content-end g-2 my-3">
            <form action="{{ route('dashboard') }}" class="col-2">
                <button type="submit" class="btn btn-primary">Kembali</button>
            </form>
        </div>
    </div>
@endsection
