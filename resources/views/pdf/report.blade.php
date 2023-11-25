@extends('indexPeserta')

@section('container')
    <h2 class="my-3 text-center">Report Training</h2>
    <div class="row justify-content-end g-2 my-3">
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
                    </div>
                    <div class="col">
                        <input name="feedback" type="text" id="feedback" class="form-control col"
                            value="{{ $feedback }}">
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
    </div>
@endsection
