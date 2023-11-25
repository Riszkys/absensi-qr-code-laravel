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
    <form method="POST" action="{{ route('login.submit') }}" class="">
        @csrf
        <div class="container">
            <div class="row mt-3">
                {{-- atur lebar --}}
                <div class="col-12 col-md-6 col-lg-4 m-auto">
                    <h2 class="text-center">Login Form</h2>
                    {{-- atur lebar maxx --}}
                    <div class="row mt-3">
                        <div class="col-12 py-2">
                            <div class="row">
                                <div class="col-3">
                                    <label for="inputemail6" class="col-form-label col-auto pr-3">Email</label>
                                </div>
                                <div class="col">
                                    <input type="email" id="email" name="email" class="form-control col"
                                        aria-describedby="emailHelpInline">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-2">
                            <div class="row">
                                <div class="col-3">
                                    <label for="inputPassword6" class="col-form-label col-auto pr-3">Password</label>
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
                                    <button type="submit" class="btn btn-primary h-100 w-100 m-auto">Login</button>
                                </div>
                                <a href="/register" class="col-12 col-md-4 m-auto">
                                    <button class="btn btn-secondary h-100 w-100 m-auto" type="button">Register
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
