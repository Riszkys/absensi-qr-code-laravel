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
    <div class="container">
        <form action="{{ route('updatetest', ['id' => $nama_training->id]) }}" method="POST">
            @csrf
            <h2 class="my-4 text-center">Update Test Pelatihan</h2>

            <div class="row my-3">
                <div class="col-4 col-md-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Nama Training</label>
                </div>
                <div class="col-8 col-md-3">
                    <input name="idtraining{{ $nama_training->id }}" type="text" class="form-control"
                        value="{{ $nama_training->nama_training }}" readonly>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-4 col-md-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Jenis
                        Test</label>
                </div>
                <div class="col-8 col-md-3">
                    <select class="form-select" name="jenistest">
                        <option value="{{ $test->jenis_test }}" selected>
                            {{ $test->jenis_test }}
                        </option>
                        @foreach (['Post Test', 'Pre Test', 'Evaluasi'] as $option)
                            @if ($option != $test->jenis_test)
                                <option value="{{ $option }}">
                                    {{ $option }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-4 col-md-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Jawaban Benar</label>
                </div>
                @foreach ($soal as $s)
                    @php
                        $selectedJawaban = $s->jawaban_benar ?? '';
                        // @dump($s->jawaban_benar);
                    @endphp
                    <div class="col-8 col-md-3">
                        <select name="jawabanbenar{{ $s->id }}" class="form-select">
                            @foreach (['A', 'B', 'C', 'D', 'E'] as $opsi)
                                <option value="{{ $opsi }}" {{ $selectedJawaban == $opsi ? 'selected' : '' }}>
                                    {{ $opsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
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
                                <textarea name="soalnomer{{ $s->id }}" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    required>{{ $s->soal }}</textarea>
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
                                    <input name="jawaban{{ $jawaban->id }}" type="text" class="form-control"
                                        value="{{ $jawaban->jawaban }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="row justify-content-end my-3">
                <button type="submit" class="btn btn-primary col-12 col-md-3">Save</button>
            </div>
        </form>
        <form action="{{ route('tampilkantest') }}" class="row justify-content-end my-3">
            <button type="submit" class="btn btn-secondary col-12 col-md-3">Kembali</button>
        </form>
    </div>
@endsection
