<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\VotingEventController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\VoterController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\ResultController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('results', [ResultController::class, 'index'])->name('results.index');
        Route::get('results/{event}/export', [ResultController::class, 'exportPdf'])->name('results.export.pdf');
        Route::resource('events', VotingEventController::class);
        Route::patch('events/{event}/status', [VotingEventController::class, 'updateStatus'])->name('events.status.update');
        Route::prefix('events/{event}/candidates')->name('events.candidates.')->group(function () {
            Route::get('/', [CandidateController::class, 'index'])->name('index');
            Route::post('/', [CandidateController::class, 'store'])->name('store');
            Route::delete('/{candidate}', [CandidateController::class, 'destroy'])->name('destroy');
        });
        Route::get('voters', [VoterController::class, 'index'])->name('voters.index');
        Route::post('voters/generate', [VoterController::class, 'generate'])->name('voters.generate');
        Route::post('voters/export', [VoterController::class, 'export'])->name('voters.export');
    });
});
