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


        <div class="row my-3">
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
                                <form action="{{ route('training.join', $trainingItem->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Ikuti</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @endsection
