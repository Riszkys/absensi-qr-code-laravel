@extends('index')

@section('container')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/events',
                editable: false,
            });
            calendar.render();
        });
    </script>
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
        <div class="row mt-4">
            <div class="col-12 col-md-9 border-end">
                <div id='calendar'></div>
            </div>
            <div class="col">
                <h5 class="my-3">Agenda : </h5>
                @foreach ($trainings as $training)
                    <p class="m-1 my-1">
                        {{ $training->nama_training }} -
                        {{ \Carbon\Carbon::parse($training->tanggal_training)->format('l, j F Y') }}
                    </p>
                @endforeach
            </div>
        </div>
    @endsection
