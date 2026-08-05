<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    // 1. Tampilkan semua daftar pasien
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // 2. Simpan pasien baru beserta riwayat medisnya
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:120',
            'allergies' => 'nullable|array', // Diinput dalam bentuk array dari front-end
            'medical_conditions' => 'nullable|array',
            'is_pregnant' => 'nullable|boolean',
            'is_breastfeeding' => 'nullable|boolean',
        ]);

        $patient = Patient::create([
            'name' => $request->name,
            'age' => $request->age,
            'allergies' => $request->allergies ?? [],
            'medical_conditions' => $request->medical_conditions ?? [],
            'is_pregnant' => $request->boolean('is_pregnant'),
            'is_breastfeeding' => $request->boolean('is_breastfeeding'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data pasien dan riwayat medis berhasil didaftarkan!',
            'data' => $patient
        ], 201);
    }

    // 3. Tampilkan detail satu pasien tertentu
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    // 4. Update riwayat alergi atau penyakit pasien jika ada perubahan
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:120',
            'allergies' => 'nullable|array',
            'medical_conditions' => 'nullable|array',
            'is_pregnant' => 'nullable|boolean',
            'is_breastfeeding' => 'nullable|boolean',
        ]);

        $patient->update([
            'name' => $request->name,
            'age' => $request->age,
            'allergies' => $request->allergies ?? [],
            'medical_conditions' => $request->medical_conditions ?? [],
            'is_pregnant' => $request->boolean('is_pregnant'),
            'is_breastfeeding' => $request->boolean('is_breastfeeding'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data riwayat medis pasien berhasil diperbarui!',
            'data' => $patient
        ]);
    }

    // 5. Hapus data pasien
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pasien berhasil dihapus dari sistem.'
        ]);
    }
}
