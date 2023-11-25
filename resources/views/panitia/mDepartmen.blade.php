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
        <h2 class="my-3 text-center">Departemen Manajemen</h2>
        <div class="row justify-content-end my-3">
            <button type="button"class="btn btn-success col-5 col-md-3" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Tambah
                Departemen</button>
            <!-- Modal -->
            <form action="{{ route('departement.create') }}" method="POST">
                @csrf
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Departemen</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mx-1">
                                    <label for="textinput" class="col-form-label col-auto pr-3">Nama Departemen</label>
                                    <input type="text" id="nama_departement" name="nama_departement"
                                        class="form-control col" aria-describedby="emailHelpInline">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="row my-3 overflow-scroll">
            <table class="table-striped table-hover table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Departemen</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departements as $key => $departement)
                        <tr>

                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $departement->nama }}</td>
                            <td>
                                <div class="row">
                                    <form class="col" action="{{ route('departement.edit', $departement->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </form>
                                    <form class="col" action="{{ route('departement.destroy', $departement->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
