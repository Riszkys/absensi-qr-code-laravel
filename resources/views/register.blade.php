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
    <form method="POST" action="{{ route('user.create') }}" class="container">
        @csrf
        <div class="row mt-3">
            {{-- atur lebar --}}
            <div class="col-12 col-md-6 col-lg-4 m-auto">
                <h2 class="text-center">Registration Form</h2>
                {{-- atur lebar maxx --}}
                <div class="col-12 mt-3 py-2">
                    <div class="row">
                        <div class="col-3">
                            <label for="id_departement" class="col-form-label col-auto pr-3">Pilih Departement</label>
                        </div>
                        <div class="col">
                            <select id="id_departement" name="id_departement" class="form-control col">
                                <option value="">Pilih Departement</option>
                                @foreach ($departementOptions as $departementId => $departementName)
                                    <option value="{{ $departementId }}"
                                        {{ old('id_departement') == $departementId ? 'selected' : '' }}>
                                        {{ $departementName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-12 py-2">
                    <div class="row">
                        <div class="col-3">
                            <label for="name" class="col-form-label col-auto pr-3">Nama</label>
                        </div>
                        <div class="col">
                            <input type="text" id="name" name="name" class="form-control col"
                                aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-12 py-2">
                    <div class="row">
                        <div class="col-3">
                            <label for="number" class="col-form-label col-auto pr-3">NIK</label>
                        </div>
                        <div class="col">
                            <input type="number" id="nik" name="nik" class="form-control col"
                                aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-12 py-2">
                    <div class="row">
                        <div class="col-3">
                            <label for="email" class="col-form-label col-auto pr-3">Email</label>
                        </div>
                        <div class="col">
                            <input type="email" id="email" name="email" class="form-control col"
                                aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-12 py-2">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" id="role" name="role" class="form-control col"
                                aria-describedby="passwordHelpInline" value="user">
                        </div>
                    </div>
                </div>
                <div class="col-12 py-2">
                    <div class="row">
                        <div class="col-3">
                            <label for="password" class="col-form-label col-auto pr-3">Password</label>
                        </div>
                        <div class="col">
                            <input type="password" id="password" name="password" class="form-control col"
                                aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="col-12 py-2">
                    <div class="row gap-2">
                        <div class="col-12 col-md-4 m-auto">
                            <button type="submit" class="btn btn-primary h-100 w-100 m-auto">Register</button>
                        </div>
                        <a href="/login" class="col-12 col-md-4 m-auto">
                            <button class="btn btn-secondary h-100 w-100 m-auto" type="button">Login
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
