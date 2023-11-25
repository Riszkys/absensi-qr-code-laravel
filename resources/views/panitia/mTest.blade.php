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
        <h2 class="my-3 text-center">Daftar Test</h2>
        <form action="{{ route('tambahtest') }}">
            <div class="row justify-content-end my-3">
                <button type="submit" class="btn btn-primary col-4 col-md-2">Tambah Test
                </button>
            </div>
        </form>

        <div class="row my-3 overflow-scroll">
            <table class="table-striped table-hover table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Training</th>
                        <th scope="col">Tanggal Training</th>
                        <th scope="col">Status Training</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testkus as $testku)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $testku->nama_training }}</td>
                            <td>{{ $testku->tanggal_training }}</td>
                            <td>{{ $testku->status_training }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a class="text-decoration-none"
                                        href="{{ route('detailtest', ['id' => $testku->id]) }}">Detail</a>
                                    <span class="mx-2">|</span>
                                    <form method="GET" action="{{ route('showupdatesoal', ['id' => $testku->id]) }}">
                                        @csrf
                                        @method('GET')
                                        <!-- Masukkan input atau elemen lain yang diperlukan untuk pembaruan -->
                                        <button type="submit" class="btn btn-link text-decoration-none">Update</button>
                                    </form>
                                    <span class="mx-2">|</span>
                                    <a class="text-decoration-none" href="#"
                                        onclick="event.preventDefault();
                                            if(confirm('Apakah Anda yakin ingin menghapus test ini?')) {
                                                document.getElementById('delete-form-{{ $testku->id }}').submit();
                                            }">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                    <form id="delete-form-{{ $testku->id }}"
                                        action="{{ route('deletetest', $testku->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
