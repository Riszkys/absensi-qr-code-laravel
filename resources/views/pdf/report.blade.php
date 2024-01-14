@extends('indexreport')
@section('kontainer')
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
                                        <p>{{ $feedback }}</p>
                                    </td>
                                    <td>{{ $tanggal_training }}</td>
                                    <td class="text-center">{{ $pic }}</td>
                                    <td>
                                        <p>{{ $durasi }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ $lokasi_training }}</td>
                                    <td colspan="2" class="text-center">Alat</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2" class="text-center">
                                        <p>{{ $alat }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                        <p>Evaluasi</p>
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
                                        <td>
                                            <p>{{ $sangat_tidak_puas1 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_tidak_puas2 }} </p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_tidak_puas3 }} </p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_tidak_puas4 }} </p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_tidak_puas5 }} </p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_tidak_puas6 }} </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tidak Puas</th>
                                        <td>
                                            <p>{{ $hasil_tes1 }}</p>
                                        </td>
                                        <td>
                                            <p> {{ $hasil_tes2 }}</p>
                                        </td>
                                        <td>
                                            <p> {{ $hasil_tes3 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $hasil_tes4 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $hasil_tes5 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $hasil_tes6 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $hasil_tes7 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $hasil_tes8 }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Netral</th>
                                        <td>
                                            <p>{{ $netral1 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral2 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral3 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral4 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral5 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral6 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral7 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $netral8 }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Puas</th>
                                        <td>
                                            <p>{{ $puas1 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas2 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas3 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas4 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas5 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas6 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas7 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $puas8 }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sangat Puas</th>
                                        <td>
                                            <p>{{ $sangat_puas1 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas2 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas3 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas4 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas5 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas6 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas7 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sangat_puas8 }}</p>
                                        </td>
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
                </div>
            </div>
        </form>

    @endsection
