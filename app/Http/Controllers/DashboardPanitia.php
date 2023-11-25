<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class DashboardPanitia extends Controller
{
    public function index()
    {
        $trainings = Training::orderBy('tanggal_training', 'asc')->get();

        return view('panitia.mDashboard', compact('trainings'));
    }
}