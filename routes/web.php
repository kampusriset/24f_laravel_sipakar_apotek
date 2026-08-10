<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SaleExportController; 
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\User;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin');
        }
        return redirect('/kasir-pintar');
    }
    return view('login-pilihan');
});

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect('/admin');
        }
        return redirect('/kasir-pintar');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    Auth::login($user);

    if ($user->role === 'admin') {
        return redirect('/admin');
    }
    return redirect('/kasir-pintar');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/kasir-pintar', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('kasir.dashboard');
})->name('kasir.dashboard');

Route::get('/pos', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('kasir.pos', [
        'medicines' => Medicine::orderBy('nama_obat')->get(),
        'patients' => Patient::orderBy('name')->get(),
    ]);
})->name('kasir.pos');

Route::get('/rekam-medis', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('patients.create', [
        'patients' => Patient::orderBy('name')->get(),
    ]);
})->name('kasir.rekam_medis');
Route::post('/proses-sales/check-safety', [SalesController::class, 'checkItemSafety'])->name('sales.check_safety');
Route::post('/proses-sales/store', [SalesController::class, 'store'])->name('sales.store');
Route::get('/sales/pdf/{invoice}', [SalesController::class, 'downloadPdf'])->name('sales.pdf');
Route::get('/admin/sales/pdf/invoice/{invoice}', [SalesController::class, 'downloadPdf'])->name('sales.pdf.invoice');
Route::get('/admin/export-sales', [SaleExportController::class, 'export'])->name('sales.export');
Route::post('/proses-patients', [PatientController::class, 'store']);
Route::get('/dashboard-user', [UserDashboardController::class, 'index'])->name('user.dashboard');
Route::post('/cart/add', [UserDashboardController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{id}', [UserDashboardController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [UserDashboardController::class, 'checkout'])->name('checkout');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);