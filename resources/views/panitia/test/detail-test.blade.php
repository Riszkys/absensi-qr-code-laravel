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
    </div>
    <div class="conntainer">
        <div class="my-4">
            <h2 class="my-4 text-center">Detail Test Pelatihan</h2>

            <div class="row my-3">
                <div class="col-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Nama Training</label>
                </div>
                <div class="col-9 col-md-3">
                    <input type="text" class="form-control" value=" {{ $nama_training->nama_training }}" readonly>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Jenis
                        Test</label>
                </div>
                <div class="col-9 col-md-3">
                    <input type="text" class="form-control" value="{{ $test->jenis_test }}" readonly>
                </div>
            </div>

            <div class="row">
                @foreach ($soal as $s)
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
                                    <input type="text" class="form-control" value="{{ $jawaban->jawaban }}" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            <form action="{{ route('tampilkantest') }}" class="row justify-content-end g-2 my-3 mb-3">
                <button type="submit" class="btn btn-primary col-12 col-md-3">Kembali</button>
            </form>
        </div>
    </div>
@endsection
