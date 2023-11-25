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
        <h2 class="my-3 text-center">Training Manajemen</h2>
        <div class="row justify-content-end my-3">
            <button type="button"class="btn btn-success col-5 col-md-3" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Tambah
                Training</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('training.create') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Training</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="namaTraining" class="col-form-label col-auto pr-3">Nama
                                                    Training</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" id="namaTraining" name="nama_training"
                                                    class="form-control col" aria-describedby="emailHelpInline">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="waktu_mulai" class="col-form-label col-auto pr-3">Waktu
                                                    Mulai</label>
                                            </div>
                                            <div class="col">
                                                <input type="time" id="waktu_mulai" name="waktu_mulai"
                                                    class="form-control col" aria-describedby="emailHelpInline">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="lokasiTraining" class="col-form-label col-auto pr-3">Lokasi
                                                    Training</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" id="lokasiTraining" name="lokasi_training"
                                                    class="form-control col">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="pic" class="col-form-label col-auto pr-3">PIC</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" id="pic" name="pic"
                                                    class="form-control col">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="jadwaltraining" class="col-form-label col-auto pr-3">Jadwal
                                                    Training</label>
                                            </div>
                                            <div class="col">
                                                <input type="date" id="jadwal_training" name="jadwal_training"
                                                    class="form-control col">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="status_training" class="col-form-label col-auto pr-3">status
                                                    training
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="text" id="status_training" name="status_training"
                                                    class="form-control col">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="materiTraining" class="col-form-label col-auto pr-3">Materi
                                                    Training</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" id="materiTraining" name="materi_training"
                                                    class="form-control col">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
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
                        <th scope="col">Tanggal</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">PIC</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($training as $key => $trainingItem)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $trainingItem->nama_training }}</td>
                            <td>{{ $trainingItem->waktu_mulai }}</td>
                            <td>{{ $trainingItem->tanggal_training }}</td>
                            <td>{{ $trainingItem->lokasi_training }}</td>
                            <td>{{ $trainingItem->pic }}</td>
                            <td>{{ $trainingItem->status_training }}</td>

                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('training.absensi') }}" method="GET">
                                        @csrf @method('GET')
                                        <input type="hidden" name="training_id" value="{{ $trainingItem->id }}">
                                        <button type="submit" class="btn btn-link text-decoration-none">Absensi</button>
                                    </form>
                                    <span class="my-auto">|</span>
                                    <form action="{{ route('report.index') }}" method="GET">
                                        <input type="hidden" name="id_training" id="id_training"
                                            value="{{ $trainingItem->id }}">
                                        <button type="submit" class="btn btn-link text-decoration-none">Report</button>
                                    </form>
                                    <span class="my-auto">|</span>
                                    <form action="{{ route('training.edit', $trainingItem->id) }}" method="GET">
                                        <button type="submit" class="btn btn-link text-decoration-none">Update</button>
                                    </form>
                                    <span class="my-auto">|</span>
                                    <form action="{{ route('training.destroy', $trainingItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-decoration-none">Delete</button>
                                    </form>
                                </div>
                            </td>




                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
