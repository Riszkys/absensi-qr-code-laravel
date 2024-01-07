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
        <form action="{{ route('simpansoal') }}" method="post">
            @csrf
            <h2 class="my-4 text-center">Form Tambah Test</h2>
            <div class="row my-3">
                <div class="col-4 col-md-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Nama
                        Training</label>
                </div>
                <div class="col-8 col-md-3">
                    <select class="form-select" id="inputGroupSelect01" name="training">
                        @foreach ($trainings as $training)
                            <option value="{{ $training->id }}">{{ $training->id }}. {{ $training->nama_training }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-4 col-md-2">
                    <label for="namaTraining" class="col-form-label col-auto pr-3">Jenis
                        Test .</label>
                </div>
                <div class="col-8 col-md-3">
                    <select class="form-select" id="inputGroupSelect01" name="jenistest" required>
                        <option value="Post Test" id="post_test">Post Test</option>
                        <option value="Pre Test" id="pre_test">Pre Test</option>
                        <option value="Evaluasi" id="evaluasi">Evaluasi</option>
                    </select>
                </div>
            </div>

            <div id="loopsoal">

            </div>

            <div class="row justify-content-evenly gap-md-5 my-3 gap-2">
                <button id="tambahSoalBtn" type="button" class="btn btn-secondary col">Tambah Soal</button>
                <button id="hapusSoalBtn" type="button" class="btn btn-danger col">Hapus Soal</button>
                <button id="tambahSoalBtn" type="submit" class="btn btn-success col">Simpan Soal</button>
            </div>
        </form>

        <form action="/panitia/test" class="row justify-content-end my-3">
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Kembali
            </button>
        </form>
    </div>




    <script>
        let soalCounter = 0;
        let jawabanCounter = 1;

        function tambahSoal() {
            soalCounter++;
            const newSoalId = `soal${soalCounter}`;
            const newSoalDiv = document.createElement("div");
            newSoalDiv.className = "row";
            newSoalDiv.id = newSoalId;
            newSoalDiv.innerHTML = `
                        <div class="col-12 py-2">
                            <div class="row">
                                <div class="col-4 col-md-2">
                                    <label for="namaTraining" class="col-form-label col-auto pr-3">Soal ${soalCounter}.</label>
                                </div>
                                <div class="col-8 col-md-10">
                                    <label for="exampleFormControlTextarea1" class="form-label"
                                        aria-placeholder="Isi Soal Anda ..."></label>
                                    <textarea name="soalnomer${soalCounter}" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    `;

            // Cek jenis tes yang dipilih
            const jenisTest = document.querySelector('[name="jenistest"]').value;

            if (jenisTest !== "Evaluasi") {
                // Jika bukan Evaluasi, tambahkan input jawaban
                newSoalDiv.innerHTML += `
                    <div class="row py-2 px-0 m-0">
                        <div class="col-4 col-md-2">
                            <label for="namaTraining" class="col-form-label col-auto pr-3">Jawaban</label>
                        </div>
                        <div class="col p-0 m-0">
                            <div class="row p-0 m-0">
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <p class="col-1">A</p>
                                        <div class="input-group col">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="radio${soalCounter}" value="1"
                                                        aria-label="Radio button for following text input" required>
                                            </div>
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <p class="col-1">B</p>
                                        <div class="input-group col">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="radio${soalCounter}" value="2"
                                                        aria-label="Radio button for following text input" required>
                                            </div>
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <p class="col-1">C</p>
                                        <div class="input-group col">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="radio${soalCounter}" value="3"
                                                        aria-label="Radio button for following text input" required>
                                            </div>
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <p class="col-1">D</p>
                                        <div class="input-group col">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="radio${soalCounter}" value="4"
                                                        aria-label="Radio button for following text input" required>
                                            </div>
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <p class="col-1">E</p>
                                        <div class="input-group col">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="radio${soalCounter}" value="5"
                                                        aria-label="Radio button for following text input" required>
                                            </div>
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                newSoalDiv.innerHTML += `
                    <div class="row py-2 px-0 m-0">
                        <div class="col-4 col-md-2">
                            <label for="namaTraining" class="col-form-label col-auto pr-3">Jawaban</label>
                        </div>
                        <div class="col p-0 m-0">
                            <div class="row p-0 m-0">
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="input-group col">
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="input-group col">
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="input-group col">
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="input-group col">
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="input-group col">
                                            <input name="nilaiopsi${jawabanCounter++}" type="text" class="form-control"
                                                aria-label="Text input with radio button" required >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

            }
            // Sisipkan elemen div soal baru ke dalam elemen dengan ID "loopsoal"
            document.getElementById("loopsoal").appendChild(newSoalDiv);
        }

        // Menambahkan event listener untuk tombol "Tambah Soal"
        document.getElementById("tambahSoalBtn").addEventListener("click", tambahSoal);

        function hapusSoal() {
            const loopSoalDiv = document.getElementById("loopsoal");
            const lastSoal = loopSoalDiv.lastChild;

            if (lastSoal) {
                loopSoalDiv.removeChild(lastSoal);
                soalCounter--;
            } else {
                alert("Tidak ada soal yang bisa dihapus.");
            }
        }

        // Menambahkan event listener untuk tombol "Hapus Soal"
        document.getElementById("hapusSoalBtn").addEventListener("click", hapusSoal);
    </script>
@endsection
