<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HospitalizationNoteController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/privacidad', 'pages.privacy')->name('privacy');
Route::view('/terminos', 'pages.terms')->name('terms');

Route::get('/centros', [CentroController::class, 'index'])->name('centros');
Route::get('/trabaja', [TrabajoController::class, 'create'])->name('trabaja');
Route::post('/trabaja', [TrabajoController::class, 'store'])->name('trabaja.submit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clients', ClientController::class);
    Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');
    Route::post('clients/{client}/assign', [ClientController::class, 'assignHospital'])->name('clients.assign');
});

Route::resource('pets', PetController::class);
Route::get('/pets/{pet}/history', [PetController::class, 'history'])->name('pets.history');

Route::get('/consultations/create/{pet}', [ConsultationController::class, 'create'])->name('consultations.create');
Route::post('/consultations/store/{pet}', [ConsultationController::class, 'store'])->name('consultations.store');
Route::post('/consultations/{pet}', [ConsultationController::class, 'store'])->name('consultations.store');


Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class)->except(['show']);
});

Route::post('/consultations/{id}/hospitalization', [HospitalizationNoteController::class, 'store'])->name('hospitalization.store');

Route::resource('appointments', AppointmentController::class);
Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::put('/appointments/{appointment}/mark-attended', [AppointmentController::class, 'markAttended'])->name('appointments.mark-attended');
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');




require __DIR__.'/auth.php';
