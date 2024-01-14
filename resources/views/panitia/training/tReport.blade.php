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
        <table class="table" border="1">
            <th class="text-center">
                <img src="{{ asset('storage/header1.jpg') }}" alt="" style="max-width: 100px">
            </th>
            <th>
                <h1 class="text-center">Training Report</h1>
                <p class="text-center">PT Prima Sejati Sejahtera</p>
            </th>
            <th class="text-center">
                <img src="{{ asset('storage/header2.jpg') }}" alt="" style="max-width: 100px">
            </th>
        </table>

        <table class="table" border="1">
            <th>
                <h1 class="text-center">{{ $nama_training }}</h1>
            </th>
        </table>

        <form id="formEvaluasi" action="{{ route('simpan.report') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row justify-content-end g-2 my-3">
                <input type="hidden" value="{{ $id_training }}" name="id_training" id="id_training">
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
                                        <input type="hidden" value="{{ $id_training }}" name="id_training"
                                            id="id_training">
                                        <input name="feedback" type="text" id="feedback" class="form-control col"
                                            required>
                                    </td>
                                    <td>{{ $tanggal_training }}</td>
                                    <td class="text-center">{{ $pic }}</td>
                                    <td><input type="text" class="form-control" name="durasi" id="durasi" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ $lokasi_training }}</td>
                                    <td colspan="2" class="text-center">Alat</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2" class="text-center"><input type="text" name="alat"
                                            id="alat" class="form-control" required></td>
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
                                <button type="button" class="btntambah btn btn-primary mt-3" id="btntambah">Tambah
                                    Gambar</button>
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
                                    <th scope="col" class="text-center">Evaluasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Plan</th>
                                    <td>Actual</td>
                                    <td>Ave Pre</td>
                                    <td>Ave Pos</td>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td rowspan="4">
                                        <textarea name="evaluasi" type="text" id="evaluasi" class="form-control col" required> </textarea>
                                    </td>
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
                                    <td rowspan="3" colspan="2" class="text-center">
                                        {{ ($averagePreTest + $averagePostTest) / 2 }}</td>
                                    <td colspan="2" rowspan="3" class="text-center">
                                        {{ ($lakiCount + $perempuanCount) / 2 }}</td>
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
                                @if (count($reportData) > 0)
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
                                        <td><input type="number" name="sangat_tidak_puas1" id="sangat_tidak_puas1"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_tidak_puas2" id="sangat_tidak_puas2"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_tidak_puas3" id="sangat_tidak_puas3"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_tidak_puas4" id="sangat_tidak_puas4"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_tidak_puas5" id="sangat_tidak_puas5"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_tidak_puas6" id="sangat_tidak_puas6"
                                                class="form-control" required></td>
                                    </tr>
                                    <tr>
                                        <th>Tidak Puas</th>
                                        {{-- <td>{{ $data->hasil_test * 0.1 }}</td>
                                        <td>{{ $data->hasil_test * 0.2 }}</td> --}}
                                        <td><input type="number" name="hasil_tes1" id="hasil_tes1" class="form-control"
                                                required></td>
                                        <td><input type="number" name="hasil_tes2" id="hasil_tes2" class="form-control"
                                                required></td>
                                        <td><input type="number" name="hasil_tes3" id="hasil_tes3" class="form-control"
                                                required></td>
                                        <td><input type="number" name="hasil_tes4" id="hasil_tes4" class="form-control"
                                                required></td>
                                        <td><input type="number" name="hasil_tes5" id="hasil_tes5" class="form-control"
                                                required></td>
                                        <td><input type="number" name="hasil_tes6" id="hasil_tes6" class="form-control"
                                                required></td>
                                        <td><input type="number" name="hasil_tes7" id="hasil_tes7" class="form-control"
                                                required></td>
                                        <td><input type="number" id="hasil_tes8" name="hasil_tes8" class="form-control"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <th>Netral</th>
                                        {{-- <td>{{ $data->hasil_test * 0.3 }}</td>
                                        <td>{{ $data->hasil_test * 0.4 }}</td> --}}
                                        <td><input type="number" name="netral1" id="netral1" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral2" id="netral2" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral3" id="netral3" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral4" id="netral4" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral5" id="netral5" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral6" id="netral6" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral7" id="netral7" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="netral8" id="netral8" class="form-control"
                                                required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Puas</th>
                                        {{-- <td>{{ $data->hasil_test * 0.5 }}</td>
                                        <td>{{ $data->hasil_test * 0.6 }}</td> --}}
                                        <td><input type="number" name="puas1" id="puas1"
                                                class="form-control"required>
                                        </td>
                                        <td><input type="number" name="puas2" id="puas2"
                                                class="form-control"required>
                                        </td>
                                        <td><input type="number" name="puas3" id="puas3"
                                                class="form-control"required>
                                        </td>
                                        <td><input type="number" name="puas4" id="puas4"
                                                class="form-control"required>
                                        </td>
                                        <td><input type="number" name="puas5" id="puas5"
                                                class="form-control"required>
                                        </td>
                                        <td><input type="number" name="puas6" id="puas6"
                                                class="form-control"required>
                                        </td>
                                        <td><input type="number" name="puas7" id="puas7" class="form-control"
                                                required>
                                        </td>
                                        <td><input type="number" name="puas8" id="puas8" class="form-control"
                                                required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sangat Puas</th>
                                        <td><input type="number" name="sangat_puas1" id="sangat_puas1"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_puas2" id="sangat_puas2"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_puas3" id="sangat_puas3"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_puas4" id="sangat_puas4"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_puas5" id="sangat_puas5"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_puas6" id="sangat_puas6"
                                                class="form-control" required></td>
                                        <td><input type="number" name="sangat_puas7" id="sangat_puas7"
                                                class="form-control"required></td>
                                        <td><input type="number" name="sangat_puas8" id="sangat_puas8"
                                                class="form-control" required></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row my-3 text-center">
                        <h5 class="my-2">Gambar Training</h5>
                        @if (count($reportData) > 0)
                            <div class="col-md-4 mb-3">
                                @if ($reportData[0]->gambar)
                                    <img src="{{ asset('storage/' . $reportData[0]->gambar) }}" alt="Gambar Training"
                                        class="img-fluid" style="max-width: 250px;">
                                @else
                                    <p>Tidak ada gambar</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="row justify-content-start g-2 my-3">
                        <input type="hidden" name="id_training" value="{{ $id_training }}">
                        <a href="#" id="downloadExcel" class="btn btn-success col-2 col-md-1 mx-2">Cetak Excel</a>
                        <a href="#" id="cetakPdfLink" class="btn btn-primary col-2 col-md-1 mx-2">Cetak PDF</a>
                        <button id="btnsimpanreport" type="submit" class="btn btn-primary col-2 col-md-1 mx-2">Simpan
                            Data</button>
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
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Include jsPDF library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

        <script>
            $(document).on('click', '#cetakPdfLink', function(e) {
                e.preventDefault();
                var idTrainingValue = $('#id_training').val();
                var inputData = {
                    id_training: $('#id_training').val(),
                    feedback: $('#feedback').val(),
                    durasi: $('#durasi').val(),
                    alat: $('#alat').val(),
                    evaluasi: $('#evaluasi').val(),
                    sangat_tidak_puas1: $('#sangat_tidak_puas1').val(),
                    sangat_tidak_puas2: $('#sangat_tidak_puas2').val(),
                    sangat_tidak_puas3: $('#sangat_tidak_puas3').val(),
                    sangat_tidak_puas4: $('#sangat_tidak_puas4').val(),
                    sangat_tidak_puas5: $('#sangat_tidak_puas5').val(),
                    sangat_tidak_puas6: $('#sangat_tidak_puas6').val(),
                    hasil_tes1: $('#hasil_tes1').val(),
                    hasil_tes2: $('#hasil_tes2').val(),
                    hasil_tes3: $('#hasil_tes3').val(),
                    hasil_tes4: $('#hasil_tes4').val(),
                    hasil_tes5: $('#hasil_tes5').val(),
                    hasil_tes6: $('#hasil_tes6').val(),
                    hasil_tes7: $('#hasil_tes7').val(),
                    hasil_tes8: $('#hasil_tes8').val(),
                    netral1: $('#netral1').val(),
                    netral2: $('#netral2').val(),
                    netral3: $('#netral3').val(),
                    netral4: $('#netral4').val(),
                    netral5: $('#netral5').val(),
                    netral6: $('#netral6').val(),
                    netral7: $('#netral7').val(),
                    netral8: $('#netral8').val(),
                    puas1: $('#puas1').val(),
                    puas2: $('#puas2').val(),
                    puas3: $('#puas3').val(),
                    puas4: $('#puas4').val(),
                    puas5: $('#puas5').val(),
                    puas6: $('#puas6').val(),
                    puas7: $('#puas7').val(),
                    puas8: $('#puas8').val(),
                    sangat_puas1: $('#sangat_puas1').val(),
                    sangat_puas2: $('#sangat_puas2').val(),
                    sangat_puas3: $('#sangat_puas3').val(),
                    sangat_puas4: $('#sangat_puas4').val(),
                    sangat_puas5: $('#sangat_puas5').val(),
                    sangat_puas6: $('#sangat_puas6').val(),
                    sangat_puas7: $('#sangat_puas7').val(),
                    sangat_puas8: $('#sangat_puas8').val(),
                };
                console.log(inputData);

                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('simpan.pdf') }}',
                    'target': '_blank',
                    'style': 'display:none;'

                });
                form.append('{{ csrf_field() }}');
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'id_training',
                    'value': idTrainingValue
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'feedback',
                    'value': inputData.feedback
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'durasi',
                    'value': inputData.durasi
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'alat',
                    'value': inputData.alat
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'evaluasi',
                    'value': inputData.evaluasi
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_tidak_puas1',
                    'value': inputData.sangat_tidak_puas1
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_tidak_puas2',
                    'value': inputData.sangat_tidak_puas2
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_tidak_puas3',
                    'value': inputData.sangat_tidak_puas3
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_tidak_puas4',
                    'value': inputData.sangat_tidak_puas4
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_tidak_puas5',
                    'value': inputData.sangat_tidak_puas5
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_tidak_puas6',
                    'value': inputData.sangat_tidak_puas6
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes1',
                    'value': inputData.hasil_tes1
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes2',
                    'value': inputData.hasil_tes2
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes3',
                    'value': inputData.hasil_tes3
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes4',
                    'value': inputData.hasil_tes4
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes5',
                    'value': inputData.hasil_tes5
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes6',
                    'value': inputData.hasil_tes6
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes7',
                    'value': inputData.hasil_tes7
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'hasil_tes8',
                    'value': inputData.hasil_tes8
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral1',
                    'value': inputData.netral1
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral2',
                    'value': inputData.netral2
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral3',
                    'value': inputData.netral3
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral4',
                    'value': inputData.netral4
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral5',
                    'value': inputData.netral5
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral6',
                    'value': inputData.netral6
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral7',
                    'value': inputData.netral7
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'netral8',
                    'value': inputData.netral8
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas1',
                    'value': inputData.puas1
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas2',
                    'value': inputData.puas2
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas3',
                    'value': inputData.puas3
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas4',
                    'value': inputData.puas4
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas5',
                    'value': inputData.puas5
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas6',
                    'value': inputData.puas6
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas7',
                    'value': inputData.puas7
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'puas8',
                    'value': inputData.puas8
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas1',
                    'value': inputData.sangat_puas1
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas2',
                    'value': inputData.sangat_puas2
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas3',
                    'value': inputData.sangat_puas3
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas4',
                    'value': inputData.sangat_puas4
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas5',
                    'value': inputData.sangat_puas5
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas6',
                    'value': inputData.sangat_puas6
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas7',
                    'value': inputData.sangat_puas7
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sangat_puas8',
                    'value': inputData.sangat_puas8
                }));
                $('body').append(form);
                console.log('form:', form);
                form.submit();
            });
        </script>


        <script>
            $(document).on('click', '#downloadExcel', function(e) {
                e.preventDefault();
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('simpan.excel') }}',
                    'target': '_blank',
                    'style': 'display:none;'
                });

                form.append('{{ csrf_field() }}');
                $('body').append(form);
                form.submit();
            });
        </script>
    @endsection
