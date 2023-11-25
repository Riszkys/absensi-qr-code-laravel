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
    <div class="container">
        <h2 class="text-center">Daftar Pelatihan</h2>
        <div class="row justify-content-between my-3 gap-2">
            <button type="button" class="btn btn-primary col-12 col-md-3" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Buka Kamera
            </button>
            <form action="{{ route('logout.peserta') }}" method="GET" class="col-12 col-md-3">
                @csrf
                <button type="submit" class="btn btn-secondary w-100">Logout</button>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="reader-modal" style="width: 250px;"></div>
                            <!-- Letakkan pemindai kamera di dalam modal-body -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3 overflow-scroll">
            <table class="table-striped table-hover table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Training</th>
                        <th scope="col">Waktu Mulai</th>
                        <th scope="col">Tanggal Training</th>
                        <th scope="col">Lokasi Training</th>
                        <th scope="col">PIC</th>
                        <th scope="col">Status Training</th>
                        <th scope="col">Status Absen</th>
                        <th scope="col" colspan="3">Status Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainingData as $data)
                        {{-- idtraining --}}
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $data->nama_training }}</td>
                            <td>{{ $data->waktu_mulai }}</td>
                            <td>{{ $data->tanggal_training }}</td>
                            <td>{{ $data->lokasi_training }}</td>
                            <td>{{ $data->pic }}</td>
                            <td>{{ $data->status_training }}</td>
                            <td>{{ $data->status_absen }}</td>
                            <td>
                                @if (
                                    $testStatus[$loop->index]['userHasPreTest'] &&
                                        $testStatus[$loop->index]['userHasPostTest'] &&
                                        $testStatus[$loop->index]['userHasEvaluasi']
                                )
                                    {{-- kondisi true --}}
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Pre Test Tidak Tersedia</button>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Post Test Tidak
                                        Tersedia</button>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Evaluasi Tidak Tersedia</button>
                                @else
                                    @if (isset($testStatus[$loop->index]))
                                        @if (isset($testStatus[$loop->index]['userHasPreTest']) && $testStatus[$loop->index]['userHasPreTest'])
                                            @if (isset($testData[$data->id_training]))
                                                <form action="{{ route('mulaitest') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $data->id_training }}"
                                                        name="id_training">
                                                    <input type="hidden" value="Pre Test" name="jenistest">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">Ikuti Pre
                                                        Test</button>
                                                </form>
                                            @else
                                                @if (isset($testData[$data->id_training]))
                                                    @foreach ($testData[$data->id_training] as $test)
                                                        <!-- Tombol Pre Test -->
                                                        <form action="{{ route('mulaitest') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" value="{{ $test->id_training }}"
                                                                name="id_training">
                                                            <input type="hidden" value="Pre Test" name="jenistest">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm w-100">Ikuti Pre Test</button>
                                                        </form>
                                                    @endforeach
                                                @endif
                                            @endif
                                        @else
                                            <!-- Tombol Pre Test non-aktif -->
                                            <button class="btn btn-secondary btn-sm w-100" disabled>Pre Test Tidak
                                                Tersedia</button>
                                        @endif

                                        @if (isset($testStatus[$loop->index]['userHasPostTest']) && $testStatus[$loop->index]['userHasPostTest'])
                                            @if (isset($testData[$data->id_training]))
                                                @foreach ($testData[$data->id_training] as $test)
                                                    <!-- Tombol Post Test -->
                                                    <form action="{{ route('mulaitest') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $test->id_training }}"
                                                            name="id_training">
                                                        <input type="hidden" value="Post Test" name="jenistest">
                                                        <button type="submit" class="btn btn-primary btn-sm w-100">Ikuti
                                                            Post Test</button>
                                                    </form>
                                                @endforeach
                                            @endif
                                        @else
                                            <!-- Tombol Post Test non-aktif -->
                                            <button class="btn btn-secondary btn-sm w-100" disabled>Post Test Tidak
                                                Tersedia</button>
                                        @endif

                                        @if (isset($testStatus[$loop->index]['userHasEvaluasi']) && $testStatus[$loop->index]['userHasEvaluasi'])
                                            @foreach ($testData[$data->id_training] as $test)
                                                <form action="{{ route('mulaitest') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $test->id_training }}"
                                                        name="id_training">
                                                    <input type="hidden" value="Evaluasi" name="jenistest">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">Ikuti
                                                        Evaluasi</button>
                                                </form>
                                            @break
                                        @endforeach
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>Evaluasi Tidak
                                            Tersedia</button>
                                    @endif
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        $('#result').val(decodedText);
        alert('Data berhasil di-scan');

        // Arahkan ke rute /absen dengan parameter result
        window.location.href = '/absen?result=' + decodedText;
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    $('#exampleModal').on('show.bs.modal', function() {
        let html5QrcodeScannerModal = new Html5QrcodeScanner(
            "reader-modal", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            false
        );
        html5QrcodeScannerModal.render(onScanSuccess, onScanFailure);
    });
</script>
@endsection
