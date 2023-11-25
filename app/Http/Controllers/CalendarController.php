<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function events()
    {
        $events = Training::all();
        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'title' => $event->nama_training,
                'start' => $event->tanggal_training,
            ];
        }

        return response()->json($formattedEvents);
    }
}
