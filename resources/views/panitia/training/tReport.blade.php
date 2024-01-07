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
        <h2 class="my-3 text-center">Report Training</h2>
        <div class="row justify-content-end g-2 my-3">
            <form action="{{ route('simpan.pdf') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 py-2">
                        <label for="namaTraining" class="col-form-label col-auto pr-3">Materi Training</label>
                        <input type="text" id="namaTraining" class="form-control col" aria-describedby="emailHelpInline"
                            value="{{ $materi_training }}" readonly>
                    </div>
                    <div class="col-12 py-2 pt-2">
                        <h5>Pelaksanaan Training</h5>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="feedback" class="col-form-label col-auto pr-3">Feedback</label>
                                <input type="hidden" value="{{ $id_training }}">
                            </div>
                            <div class="col">
                                <input name="feedback" type="text" id="feedback" class="form-control col">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="evaluasi" class="col-form-label col-auto pr-3">Evalusi</label>
                            </div>
                            <div class="col">
                                <textarea name="evaluasi" type="text" id="evaluasi" class="form-control col"> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2" id="gambar-container">
                        <div class="row">
                            <div class="col-3">
                                <label for="gambar" class="col-form-label col-auto pr-3">Gambar</label>
                            </div>
                            <div class="col">
                                <input name="gambar[]" type="file" id="gambar" class="form-control col">
                                <button class="btntambah btn btn-primary mt-3" id="btntambah">Tambah Gambar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">Waktu dan Tanggal</label>
                            </div>
                            <div class="col">
                                <p class="col">{{ $waktu_mulai }} {{ $tanggal_training }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">Lokasi</label>
                            </div>
                            <p class="col">{{ $lokasi_training }}</p>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">PIC</label>
                            </div>
                            <p class="col">{{ $pic }}</p>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">Status</label>
                            </div>
                            <p class="col">{{ $status_training }}</p>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <h5 class="my-2">Peserta Training</h5>
                    <table class="table-striped table-hover table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIK Peserta</th>
                                <th scope="col">Nama Peserta</th>
                                <th scope="col">Dept. Peserta</th>
                                <th scope="col">Status Absen</th>
                                <th scope="col">Hasil Test</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData as $index => $data)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $data->nik }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->department_name }}</td>
                                    <td>{{ $data->status_absen ?? 'Belum Absen' }}</td>
                                    <td>{{ $data->hasil_test ?? 'Belum Test' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row my-3">
                    <h5 class="my-2">Evaluasi Training</h5>
                    <table class="table-striped table-hover table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Bagian</th>
                                <th scope="col">Program</th>
                                <th scope="col">Pelatih</th>
                                <th scope="col">Metode Pelatihan</th>
                                <th scope="col">Kesan Umum</th>
                            </tr>
                        </thead>
                        @foreach ($reportData as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>Sangat Puas</td>
                                <td>{{ $data->hasil_test * 0.1 }}%</td>
                                <td>{{ $data->hasil_test * 0.15 }}%</td>
                                <td>{{ $data->hasil_test * 0.2 }}%</td>
                                <td>{{ $data->hasil_test * 0.25 }}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-start g-2 my-3">
                    <input type="hidden" name="id_training" value="{{ $id_training }}">
                    <button id="submitBtn" type="submit" class="btn btn-primary col-2 col-md-1 mx-2">Cetak PDF</button>
                </div>
            </form>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var tambahButton = document.getElementById('btntambah');
                var container = document.getElementById('gambar-container');

                tambahButton.addEventListener('click', function(event) {
                    event.preventDefault();

                    var newInput = document.createElement('input');
                    newInput.name = 'gambar[]';
                    newInput.type = 'file';
                    newInput.className = 'form-control col mt-2';

                    container.appendChild(newInput);
                });
            });
        </script>
    @endsection
