<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest();

        return view('units.index', [
            'units' => $units->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::latest();
        return view('units.create', [
            'faculties' => $faculties->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:units'],
            'code' => ['required', 'string', 'max:10', 'unique:units'],
            'faculty' => [],
        ]);

        $units = Unit::create([
            'name' => $request->name,
            'code' => $request->code,
            'faculty_id' => $request->faculty,
        ]);

        return redirect('/units')
            ->with("status", "$units->name added successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $units = Unit::all();
        $faculties = Faculty::all();
        return view('units.edit', compact('unit', 'units',  'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'faculty' => 'nullable|exists:faculties,id', // Faculty tidak wajib, hanya jika diisi
        ]);

        // Update 'code' secara langsung
        $unit->name = $validatedData['name'];
        $unit->code = $validatedData['code'];

        // Cek apakah 'code' dimulai dengan angka, jika ya, update 'faculty'
        if (preg_match('/^\d/', $validatedData['code'])) {
            // Jika 'code' dimulai dengan angka dan 'faculty' dipilih, update faculty
            if (!empty($validatedData['faculty'])) {
                $unit->faculty_id = $validatedData['faculty'];
            }
        } else {
            // Jika 'code' tidak dimulai dengan angka, pastikan 'faculty_id' diset ke null
            $unit->faculty_id = null;
        }

        // Simpan perubahan ke database
        $unit->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('units.index')
            ->with('success', "Data $unit->name berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        Unit::destroy($unit->id);

        return redirect('/units')->with('status', 'Delete successfully');
    }
}
