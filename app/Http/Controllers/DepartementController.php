<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Departement;
use App\Http\Requests\StoreDepartementRequest;
use App\Http\Requests\UpdateDepartementRequest;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departements = Departement::all();

        return view('panitia.mDepartmen', compact('departements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'nama_departement' => 'required|string|max:255',
        ]);

        $departement = new Departement([
            'nama' => $request->input('nama_departement'),
        ]);

        if ($departement->save()) {
            return redirect()->back()->with('success', 'Data departemen berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data departemen.');
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departement  $departement
     * @return \Illuminate\Http\Response
     */
    public function show(Departement $departement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departement  $departement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        return view('panitia.editDepartemen', compact('departement'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartementRequest  $request
     * @param  \App\Models\Departement  $departement
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        try {
            $departement = Departement::findOrFail($id);

            $request->validate([
                'nama_departement' => 'required|string|max:255',
            ]);

            $departement->update([
                'nama' => $request->input('nama_departement'),
            ]);

            return redirect()->route('departement.index')->with('success', 'Data departemen berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('departement.index')->with('error', 'Gagal memperbarui departemen: ' . $e->getMessage());
        }
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departement  $departement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return redirect()->back()->with('error', 'Departemen tidak ditemukan.');
        }

        $departement->delete();

        return redirect()->back()->with('success', 'Departemen berhasil dihapus.');
    }
}
