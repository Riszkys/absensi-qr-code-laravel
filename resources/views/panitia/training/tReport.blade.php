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
        <form id="formEvaluasi" action="{{ route('simpan.report') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="row justify-content-end g-2 my-3">

            <form action="{{ route('simpan.excel') }}" method="POST">
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
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col" class="text-center">Feedback</th>
                                <th scope="col">Tanggal & Tempat</th>
                                <th scope="col" class="text-center">Fasilitator / Trainer</th>
                                <th scope="col">Durasi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td rowspan="4">
                                    <input type="hidden" value="{{ $id_training }}" name="id_training" id="id_training">
                                    <input name="feedback" type="text" id="feedback" class="form-control col">
                                </td>
                                <td>{{ $tanggal_training }}</td>
                                <td class="text-center">{{ $pic }}</td>
                                <td><input type="text" class="form-control"></td>
                              </tr>
                              <tr>
                                <td>{{ $lokasi_training }}</td>
                                <td colspan="2" class="text-center">Alat</td>
                              </tr>
                              <tr>
                                <td >Larry the Bird</td>
                                <td colspan="2" class="text-center"><input type="text" class="form-control"></td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                    <div class="col-12 py-2" id="gambar-container">
                        <div class="row">
                            <div class="col-3">
                                <label for="gambar" class="col-form-label col-auto pr-3">Gambar</label>
                            </div>
                            <div class="col">
                                {{-- <input type="text" name="id_training" id="id_training_input" value="{{ $id_training }}"> --}}
                                <input name="gambar[]" type="file" id="gambar" class="form-control col">
                                <button type="button" class="btntambah btn btn-primary mt-3" id="btntambah">Tambah Gambar</button>
                            </div>
                        </div>
                    </div>
                <div class="row my-3">
                    <h5 class="my-2">Peserta Training</h5>
                    <table class="table-striped table-hover table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Peserta</th>
                                <th scope="col">NiK</th>
                                <th scope="col">Pre </th>
                                <th scope="col">Post</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData->unique('name') as $data)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->nik }}</td>
                                <td>{{ $data->hasil_test ?? 'Belum Test' }}</td>
                                <td>{{ $data->hasil_test ?? 'Belum Test' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row my-3">
                    <h5 class="my-2" class="text-center">Evaluasi Training</h5>
                    <table class="table-responsive table table-bordered" border="2">
                        <thead>
                          <tr>
                            <th scope="col" colspan="2" class="text-center">Kehadiran</th>
                            <th scope="col" colspan="2" class="text-center">Test</th>
                            <th scope="col" colspan="2" class="text-center">Test</th>
                            <th scope="col" class="text-center" >Evaluasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th >Plan</th>
                            <td>Actual</td>
                            <td>Ave Pre</td>
                            <td>Ave Pos</td>
                            <td>Male</td>
                            <td>Female</td>
                            <td rowspan="4"><textarea name="evaluasi" type="text" id="evaluasi" class="form-control col"> </textarea></td>
                          </tr>
                          <tr>
                            <th>{{ $totalAttendance }}</th>
                            <td>{{ $hadirCount }}</td>
                            <td>{{ $averagePreTest }}</td>
                            <td>{{ $averagePostTest }}</td>
                            <td>{{ $lakiCount ?? 0 }}</td>
                            <td>{{ $perempuanCount ?? 0 }}</td>
                          </tr>
                          <tr>
                            <th colspan="2" rowspan="3" class="text-center">
                                @if ($hadirCount != 0)
                                    {{ number_format(($totalAttendance / $hadirCount) * 100, 2) }}%
                                @else
                                    N/A
                                @endif
                            </th>
                            <td rowspan="3" colspan="2" class="text-center">{{ ($averagePreTest + $averagePostTest) / 2 }}</td>
                            <td colspan="2" rowspan="3" class="text-center">{{ ($lakiCount + $perempuanCount) / 2 }}</td>
                          </tr>
                          <tr>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table table-bordered" border="2">
                        <thead>
                          <tr>
                            <th colspan="9" class="text-center">evaluasi training</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(count($reportData) > 0)
                          <tr>
                            <th>Bagian</th>
                            <td colspan="2" class="text-center">Program</td>
                            <td colspan="2" class="text-center">pelatih</td>
                            <td colspan="2" class="text-center">metode pelatihan</td>
                            <td colspan="2" class="text-center">kesan umum</td>
                          </tr>
                          <tr>
                            <th>Sangat Tidak Puas</th>
                            <td>Jumlah</td>
                            <td>Precentage</td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                          </tr>
                          <tr>
                            <th>Tidak Puas</th>
                            <td>{{ $data->hasil_test * 0.1}}</td>
                            <td>{{ $data->hasil_test * 0.2}}</td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td ><input type="number" class="form-control"></td>
                            <td ><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                          </tr>
                          <tr>
                            <th>Netral</th>
                            <td>{{ $data->hasil_test * 0.3}}</td>
                            <td >{{ $data->hasil_test * 0.4}}</td>
                            <td><input type="number" class="form-control"></td>
                            <td ><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                          </tr>
                          <tr>
                            <th>Puas</th>
                            <td >{{ $data->hasil_test * 0.5}}</td>
                            <td >{{ $data->hasil_test * 0.6}}</td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                          </tr>
                          <tr>
                            <th>Sangat Puas</th>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td ><input type="number" class="form-control"></td>
                            <td ><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                            <td><input type="number" class="form-control"></td>
                          </tr>
                      @endif
                        </tbody>
                      </table>
                </div>
                <div class="row my-3 text-center">
                    <h5 class="my-2">Gambar Training</h5>

                    @if(count($reportData) > 0)
                    <div class="col-md-4 mb-3">
                      @if ($reportData[0]->gambar)
                        <img src="{{ asset('storage/' . $reportData[0]->gambar) }}" alt="Gambar Training" class="img-fluid" style="max-width: 250px;">
                      @else
                        <p>Tidak ada gambar</p>
                      @endif
                    </div>
                  @endif

                </div>
                <div class="row justify-content-start g-2 my-3">
                    <input type="hidden" name="id_training" value="{{ $id_training }}">

                    <button id="submitBtn" type="submit" class="btn btn-success col-2 col-md-1 mx-2">Cetak Excel</button>

                    {{-- <button id="submitBtn" type="submit" class="btn btn-primary col-2 col-md-1 mx-2">Cetak PDF</button> --}}
                    <button id="btnsimpanreport" type="submit" class="btn btn-primary col-2 col-md-1 mx-2">Simpan Data</button>
                </div>
                </div>
        </div>
        </form>
         <script>
            document.addEventListener('DOMContentLoaded', function() {
    var tambahButton = document.getElementById('btntambah');
    var container = document.getElementById('gambar-container');
    var formEvaluasi = document.getElementById('formEvaluasi');
    var btnSimpanReport = document.getElementById('btnsimpanreport');

    tambahButton.addEventListener('click', function(event) {
        event.preventDefault();

        var newInput = document.createElement('input');
        newInput.name = 'gambar[]';
        newInput.type = 'file';
        newInput.className = 'form-control col mt-2';

        container.appendChild(newInput);
    });

//     btnSimpanReport.addEventListener('click', function(event) {
//         event.preventDefault();
//         var idTraining = document.getElementById('id_training').value;
//         var feedback = document.getElementById('feedback').value;
//         var evaluasi = document.getElementById('evaluasi').value;
//         var formData = new FormData(formEvaluasi);

//         formData.append('id_training', idTraining);
//         formData.append('feedback', feedback);
//         formData.append('evaluasi', evaluasi);

//         var gambarInputs = document.querySelectorAll('[name="gambar[]"]');
//             gambarInputs.forEach(function(input, index) {
//                 formData.append('gambar[]', input.files[0]);
//             });
//         var xhr = new XMLHttpRequest();
//         xhr.open('POST', '{{ route("simpan.report") }}', true);

//         xhr.onreadystatechange = function() {
//             if (xhr.readyState === XMLHttpRequest.DONE) {
//                 if (xhr.status === 200) {
//                     console.log(xhr.responseText);
//                     window.location.href = '{{ route("report.index") }}';
//                 } else {
//                     console.error('Error:', xhr.statusText);
//                 }
//             }
//         };

//         xhr.send(formData);
//     });
});

        </script>
    @endsection
