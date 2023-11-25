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
    <form action="{{ route('panitia.updateDepartemen', $departement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_departement" class="mt-3">Nama Departemen</label>
            <input type="text" class="form-control mt-3" id="nama_departement" name="nama_departement"
                value="{{ old('nama_departement', $departement->nama) }}">
        </div>
        <div class="pt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/panitia/department" class="btn btn-primary">Back</a>
        </div>

    </form>
@endsection
