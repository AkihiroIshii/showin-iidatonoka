<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\AdminController;

//管理者ページ
// Route::get('/admin', function() {
//     return view('admin');
// })->middleware(['auth', 'admin'])->name('admin');
Route::middleware(['auth', 'admin'])->group(function (){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::get('/admin/show/{user}', [AdminController::class, 'show'])->name('admin.show');

Route::get('/test', [TestController::class, 'test'])
->name('test');

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
    dd(Auth::user()->user_id,Auth::user()->name);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('record', [RecordController::class, 'index'])
->middleware(['auth', 'verified'])->name('record');
Route::get('record/spreadsheet', [RecordController::class, 'spreadsheet'])
->middleware(['auth', 'verified'])->name('spreadsheet');
Route::get('record/create', [RecordController::class, 'create'])
->name('record.create');
// Route::get('record/create', [RecordController::class, 'create'])
// ->middleware('admin');
Route::post('record', [RecordController::class, 'store'])
->name('record.store');
Route::get('record/show/{record}', [RecordController::class, 'show'])
->name('record.show');
Route::get('record/{record}/edit', [RecordController::class, 'edit'])
->name('record.edit');
Route::patch('record/{record}', [RecordController::class, 'update'])
->name('record.update');
Route::get('record/explanation', [RecordController::class, 'explanation'])
->name('record.explanation');


require __DIR__.'/auth.php';
