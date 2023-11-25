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
        <h2 class="my-3 text-center">Pre test Pelatihan</h2>
        <div class="row mt-4">
            <div class="col-12 col-md-10">
                <h4>Soal</h4>
                <div class="soal d-flex mt-4">
                    <b class="mx-2">1.</b>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eveniet facere provident ipsum
                        debitis
                        dolores sunt, fugiat at esse accusamus?</p>
                </div>
                <div class="jawaban">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerA" value="A">
                        <label class="form-check-label" for="answerA">
                            A. Lorem, ipsum.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerB" value="B">
                        <label class="form-check-label" for="answerB">
                            B. Lorem, ipsum dolor.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerC" value="C">
                        <label class="form-check-label" for="answerC">
                            C. Lorem ipsum dolor sit amet.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerD" value="D">
                        <label class="form-check-label" for="answerD">
                            D. lorem
                        </label>
                    </div>
                </div>
                <div class="soal d-flex mt-4">
                    <b class="mx-2">1.</b>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eveniet facere provident ipsum
                        debitis
                        dolores sunt, fugiat at esse accusamus?</p>
                </div>
                <div class="jawaban">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerA" value="A">
                        <label class="form-check-label" for="answerA">
                            A. Lorem, ipsum.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerB" value="B">
                        <label class="form-check-label" for="answerB">
                            B. Lorem, ipsum dolor.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerC" value="C">
                        <label class="form-check-label" for="answerC">
                            C. Lorem ipsum dolor sit amet.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerD" value="D">
                        <label class="form-check-label" for="answerD">
                            D. lorem
                        </label>
                    </div>
                </div>
                <div class="soal d-flex mt-4">
                    <b class="mx-2">1.</b>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eveniet facere provident ipsum
                        debitis
                        dolores sunt, fugiat at esse accusamus?</p>
                </div>
                <div class="jawaban">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerA" value="A">
                        <label class="form-check-label" for="answerA">
                            A. Lorem, ipsum.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerB" value="B">
                        <label class="form-check-label" for="answerB">
                            B. Lorem, ipsum dolor.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerC" value="C">
                        <label class="form-check-label" for="answerC">
                            C. Lorem ipsum dolor sit amet.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer" id="answerD" value="D">
                        <label class="form-check-label" for="answerD">
                            D. lorem
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <button type="submit" class="btn btn-primary col-1">Submit</button>
        </div>
    @endsection
