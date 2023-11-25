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
    <h2 class="my-3 text-center">Absensi Pelatihan Sewing</h2>
    <div class="row justify-content-between g-2 my-3">
        <button type="button" class="btn btn-primary col-6 col-md-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Generate Barcode
        </button>
        <form action="{{ route('generate-pdf') }}" method="get" class="col-6 col-md-4">
            @csrf
            <input type="hidden" name="training_id" id="training_id" value="{{ $trainingId }}">
            <button type="submit" class="btn btn-danger w-100">Generate PDF</button>
        </form>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Barcode</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            @if ($qrCode)
                                <p class="p-5 text-center">{{ QrCode::size(300)->generate($nama_training) }}</p>
                            @else
                                <p class="text-center">Belum ada data untuk generate barcode.</p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row my-3">
        <table class="table-striped table-hover table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIK Peserta</th>
                    <th scope="col">Nama Peserta</th>
                    <th scope="col">Dept. Peserta</th>
                    <th scope="col">Status Absen</th>
                    @if ($ambilhasiltest)
                        <th scope="col" colspan="{{ count($ambilhasiltest) }}" class="text-center">Hasil Test</th>
                    @else
                        <th scope="col">Hasil Test</th>
                    @endif
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                    <tr>
                        {{-- @dump($trainingId) --}}
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $training->nik }}</td>
                        <td>{{ $training->name }}</td>
                        <td>{{ $training->nama }}</td>
                        <td>{{ $training->status_absen ? $training->status_absen : 'Belum Absen' }}</td>
                        @if ($ambilhasiltest)
                            @foreach ($ambilhasiltest as $item)
                                <td>{{ $item->jenis_test . ' : ' . $item->hasil_test }}</td>
                            @endforeach
                        @else
                            <td> belum ada test</td>
                        @endif
                        <td>
                            <div class="row">
                                <form action="{{ route('absen') }}" method="POST" class="col">
                                    @csrf
                                    <input type="hidden" name="id_user" value="{{ $training->id_user }}">
                                    <input type="hidden" name="id_department" value="{{ $training->id_department }}">
                                    <input type="hidden" name="id_training" value="{{ $training->id_training }}">
                                    <input type="hidden" name="id_absen" value="{{ $training->id_absen }}">
                                    <input type="hidden" name="nama_training" value="{{ $training->nama_training }}">
                                    <input type="hidden" name="waktu_mulai" value="{{ $training->waktu_mulai }}">
                                    <input type="hidden" name="tanggal_training"
                                        value="{{ $training->tanggal_training }}">
                                    <input type="hidden" name="lokasi_training" value="{{ $training->lokasi_training }}">
                                    <input type="hidden" name="pic" value="{{ $training->pic }}">
                                    <input type="hidden" name="status_training" value="{{ $training->status_training }}">
                                    <button type="submit" class="text-decoration-none btn btn-link w-100">Absen</button>
                                </form>
                                <form action="{{ route('tolak') }}" method="POST" class="col">
                                    @csrf
                                    <input type="hidden" name="id_user" value="{{ $training->id_user }}">
                                    <input type="hidden" name="id_department" value="{{ $training->id_department }}">
                                    <input type="hidden" name="id_training" value="{{ $training->id_training }}">
                                    <input type="hidden" name="id_absen" value="{{ $training->id_absen }}">
                                    <input type="hidden" name="nama_training" value="{{ $training->nama_training }}">
                                    <input type="hidden" name="waktu_mulai" value="{{ $training->waktu_mulai }}">
                                    <input type="hidden" name="tanggal_training"
                                        value="{{ $training->tanggal_training }}">
                                    <input type="hidden" name="lokasi_training"
                                        value="{{ $training->lokasi_training }}">
                                    <input type="hidden" name="pic" value="{{ $training->pic }}">
                                    <input type="hidden" name="status_training"
                                        value="{{ $training->status_training }}">
                                    <button type="submit" class="text-decoration-none btn btn-link w-100">Tolak</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="row justify-content-between g-2 my-3">
        <form action="{{ route('selesai.pelatihan') }}" method="POST" class="col-6 col-md-4">
            @csrf
            <input type="hidden" name="id_training" value="{{ $trainingId }}">
            <button type="submit" class="btn btn-success w-100">Selesai Pelatihan</button>
        </form>
        <form action="/panitia/training" class="col-6 col-md-4">
            <button type="submit" class="btn btn-secondary w-100">Kembali
            </button>
        </form>
    </div>
@endsection
