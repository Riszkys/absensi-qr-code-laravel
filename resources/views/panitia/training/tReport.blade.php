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
        <h2 class="my-3 text-center">Report Training</h2>
        <div class="row justify-content-end g-2 my-3">

                <div class="row">
                    <div class="col-12 py-2">
                        <label for="namaTraining" class="col-form-label col-auto pr-3">Materi Training</label>
                        <input type="text" id="namaTraining" class="form-control col" aria-describedby="emailHelpInline"
                            value="{{ $materi_training }}" readonly>
                    </div>
                    <div class="col-12 py-2 pt-2">
                        <h5>Pelaksanaan Training</h5>
                    </div>
                    <form action="{{ route('simpan.report') }}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="col-12 py-2">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col" class="text-center">Feedback</th>
                                <th scope="col">Tanggal & Tempat</th>
                                <th scope="col" class="text-center">Fasilitator / Trainer</th>
                                <th scope="col">Durasi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td rowspan="4"></td>
                                <td>11 January 2023</td>
                                <td class="text-center">Widiasuty</td>
                                <td >1 Jam</td>
                              </tr>
                              <tr>
                                <td>Ruang Training</td>
                                <td colspan="2" class="text-center">Alat</td>
                              </tr>
                              <tr>
                                <td >Larry the Bird</td>
                                <td colspan="2" class="text-center">cok</td>

                              </tr>
                            </tbody>
                          </table>
                        <div class="row">
                            <div class="col-3">
                                <label for="feedback" class="col-form-label col-auto pr-3">Feedback</label>
                                <input type="hidden" value="{{ $id_training }}" name="id_training" id="id_training">
                            </div>
                            <div class="col">
                                <input name="feedback" type="text" id="feedback" class="form-control col">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="evaluasi" class="col-form-label col-auto pr-3">Evalusi</label>
                            </div>
                            <div class="col">
                                <textarea name="evaluasi" type="text" id="evaluasi" class="form-control col"> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2" id="gambar-container">
                        <div class="row">
                            <div class="col-3">
                                <label for="gambar" class="col-form-label col-auto pr-3">Gambar</label>
                            </div>
                            <div class="col">
                                <input name="gambar[]" type="file" id="gambar" class="form-control col">
                                <button type="button" class="btntambah btn btn-primary mt-3" id="btntambah">Tambah Gambar</button>
                                <button type="submit" class="btn btn-primary mt-3" >simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
                    <form action="{{ route('simpan.pdf') }}" method="POST">
                        @csrf
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">Waktu dan Tanggal</label>
                            </div>
                            <div class="col">
                                <p class="col">{{ $waktu_mulai }} {{ $tanggal_training }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">Lokasi</label>
                            </div>
                            <p class="col">{{ $lokasi_training }}</p>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">PIC</label>
                            </div>
                            <p class="col">{{ $pic }}</p>
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="waktuTanggal" class="col-form-label col-auto pr-3">Status</label>
                            </div>
                            <p class="col">{{ $status_training }}</p>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <h5 class="my-2">Peserta Training</h5>
                    <table class="table-striped table-hover table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Peserta</th>
                                <th scope="col">NiK</th>
                                <th scope="col">Pre </th>
                                <th scope="col">Post</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData as $index => $data)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->nik }}</td>
                                    <td>{{ $data->hasil_test ?? 'Belum Test' }}</td>
                                    <td>{{ $data->hasil_test ?? 'Belum Test' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row my-3">
                    <h5 class="my-2">Evaluasi Training</h5>
                    <table class="table-responsive table table-bordered" border="2">
                        <thead>
                          <tr>
                            <th scope="col" colspan="2" class="text-center">Kehadiran</th>
                            <th scope="col" colspan="2" class="text-center">Test</th>
                            <th scope="col" colspan="2" class="text-center">Test</th>
                            <th scope="col" class="text-center" >Evaluasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th >Plan</th>
                            <td>Actual</td>
                            <td>Ave Pre</td>
                            <td>Ave Pos</td>
                            <td>Male</td>
                            <td>Female</td>
                            <td rowspan="4"></td>
                          </tr>
                          <tr>
                            <th>90</th>
                            <th>90</th>
                            <td>90</td>
                            <td>90</td>
                            <td>90</td>
                            <td>9</td>

                            {{-- <td>Female</td> --}}
                          </tr>
                          <tr>
                            <th colspan="2" rowspan="3">80</th>
                            <td rowspan="3" colspan="2">70</td>
                            <td colspan="2" rowspan="3">90</td>
                            {{-- <td>9g</td> --}}
                          </tr>
                          <tr>
                            {{-- <td>00p</td> --}}

                            {{-- <td>10</td> --}}
                          </tr>
                        </tbody>
                      </table>
                      <table class="table table-bordered" border="2">
                        <thead>
                          <tr>
                            <th colspan="9" class="text-center">evaluasi training</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th>Bagian</th>
                            <td colspan="2" class="text-center">Program</td>
                            <td colspan="2" class="text-center">pelatih</td>
                            <td colspan="2" class="text-center">metode pelatihan</td>
                            <td colspan="2" class="text-center">kesan umum</td>
                          </tr>
                          <tr>
                            <th>Sangat Tidak Puas</th>
                            <td>Jacob</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>Thornton</td>
                            <td>@twitter</td>
                            <td>@fat</td>
                            <td>@fat</td>
                          </tr>
                          <tr>
                            <th>Tidak Puas</th>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td >Larry the Bird</td>
                            <td >Larry the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                          </tr>
                          <tr>
                            <th>Netral</th>
                            <td>@twitter</td>
                            <td >Larry the Bird</td>
                            <td>@twitter</td>
                            <td >Larry the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                          </tr>
                          <tr>
                            <th>Puas</th>
                            <td >Larry the Bird</td>
                            <td >Larry the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                          </tr>
                          <tr>
                            <th>Sangat Puas</th>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td >Larry the Bird</td>
                            <td >Larry the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                          </tr>
                        </tbody>
                      </table>
                    <table class="table-striped table-hover table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Bagian</th>
                                <th scope="col">Program</th>
                                <th scope="col">Pelatih</th>
                                <th scope="col">Metode Pelatihan</th>
                                <th scope="col">Kesan Umum</th>
                            </tr>
                        </thead>
                        @foreach ($reportData as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>Sangat Puas</td>
                                <td>{{ $data->hasil_test * 0.1 }}%</td>
                                <td>{{ $data->hasil_test * 0.15 }}%</td>
                                <td>{{ $data->hasil_test * 0.2 }}%</td>
                                <td>{{ $data->hasil_test * 0.25 }}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row my-3 text-center">
                    <h5 class="my-2">Gambar Training</h5>

                    @foreach ($reportData as $data)
                        <div class="col-md-4 mb-3">
                            @if ($data->gambar)
                                <img src="{{ asset('storage/' . $data->gambar) }}" alt="Gambar Training" class="img-fluid" style="max-width: 250px;">
                            @else
                                <p>Tidak ada gambar</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="row justify-content-start g-2 my-3">
                    <input type="hidden" name="id_training" value="{{ $id_training }}">
                    <button id="submitBtn" type="submit" class="btn btn-primary col-2 col-md-1 mx-2">Cetak PDF</button>
                </div>
            </form>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var tambahButton = document.getElementById('btntambah');
                var container = document.getElementById('gambar-container');

                tambahButton.addEventListener('click', function(event) {
                    event.preventDefault();

                    var newInput = document.createElement('input');
                    newInput.name = 'gambar[]';
                    newInput.type = 'file';
                    newInput.className = 'form-control col mt-2';

                    container.appendChild(newInput);
                });
            });
        </script>
    @endsection
