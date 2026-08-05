<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PatientController;
use App\Models\Medicine;
use App\Models\Patient;

Route::get('/kasir-pintar', function () {
    return view('apotek', [
        'medicines' => Medicine::orderBy('name')->get(),
        'patients' => Patient::orderBy('name')->get(),
    ]);
});

Route::post('/proses-sales/check-safety', [SalesController::class, 'checkItemSafety']);
Route::post('/proses-sales/store', [SalesController::class, 'store']);
Route::post('/proses-patients', [PatientController::class, 'store']);
