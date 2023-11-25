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
        <h2 class="my-3 text-center">Daftar Test</h2>


        <div class="row my-3">
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
                                <form action="{{ route('mulaitest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="idtest" value="{{ $testku->id }}">
                                    <button type="submit" class="btn btn-primary">Ikuti Test</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row justify-content-end g-2 my-3">
            <button type="button" class="btn btn-primary col-2"> <a href="/dashboard"
                    style="font-style: none; color: white">Kembali</a>
            </button>
        </div>
    @endsection
