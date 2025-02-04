<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WorkbookController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsualtargetController;

//管理者ページ
// Route::get('/admin', function() {
//     return view('admin');
// })->middleware(['auth', 'admin'])->name('admin');
Route::middleware(['auth', 'admin'])->group(function (){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::get('/admin/show/{user}', [AdminController::class, 'show'])
->middleware(['auth', 'verified'])->name('admin.show');
Route::get('/admin/spreadsheet/{user}', [AdminController::class, 'spreadsheet'])
->middleware(['auth', 'verified'])->name('admin.spreadsheet');
Route::get('/admin/spreadsheet3/{user}', [AdminController::class, 'spreadsheet3'])
->middleware(['auth', 'verified'])->name('admin.spreadsheet3');

/** 管理者＞日々の目標 */
Route::get('/admin/usualtarget/{user}', [AdminController::class, 'usualtarget'])
->middleware(['auth', 'verified'])->name('admin.usualtarget');
Route::get('admin/usualtarget/create/{user}', [AdminController::class, 'create_usualtarget'])
->middleware(['auth', 'verified'])->name('admin.usualtarget.create');
Route::post('admin/usualtarget/store/{user}', [AdminController::class, 'store_usualtarget'])
->middleware(['auth', 'verified'])->name('admin.usualtarget.store');
Route::get('admin/usualtarget/{usualtarget}/edit', [AdminController::class, 'edit_usualtarget'])
->middleware(['auth', 'verified'])->name('admin.usualtarget.edit');
Route::patch('admin/usualtarget/{usualtarget}/update', [AdminController::class, 'update_usualtarget'])
->middleware(['auth', 'verified'])->name('admin.usualtarget.update');

/** 管理者＞テスト結果 */
Route::get('/admin/exam/{user}', [AdminController::class, 'exam'])
->middleware(['auth', 'verified'])->name('admin.exam');
// Route::get('admin/usualtarget/create/{user}', [AdminController::class, 'create_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.create');
// Route::post('admin/usualtarget/store/{user}', [AdminController::class, 'store_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.store');
// Route::get('admin/usualtarget/{usualtarget}/edit', [AdminController::class, 'edit_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.edit');
// Route::patch('admin/usualtarget/{usualtarget}/update', [AdminController::class, 'update_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.update');

Route::get('/admin/link', [AdminController::class, 'link'])
->middleware(['auth', 'verified'])->name('admin.link');
Route::get('/admin/event', [AdminController::class, 'event'])
->middleware(['auth', 'verified'])->name('admin.event');
Route::get('/admin/maintain', [AdminController::class, 'maintain'])
->middleware(['auth', 'verified'])->name('admin.maintain');

/** 管理者＞問題集 */
Route::get('/admin/workbook', [AdminController::class, 'workbook'])
->middleware(['auth', 'verified'])->name('admin.workbook');
Route::get('/admin/workbook/create', [AdminController::class, 'create_workbook'])
->middleware(['auth', 'verified'])->name('admin.workbook.create');
Route::post('/admin/workbook/store', [AdminController::class, 'store_workbook'])
->middleware(['auth', 'verified'])->name('admin.workbook.store');
Route::get('/admin/workbook/{workbook}/edit', [AdminController::class, 'edit_workbook'])
->middleware(['auth', 'verified'])->name('admin.workbook.edit');
Route::patch('workbook/{workbook}', [AdminController::class, 'update_workbook'])
->middleware(['auth', 'verified'])->name('admin.workbook.update');

/* 管理者＞ユーザ */
Route::get('/admin/user/create', [AdminController::class, 'create_user'])
->middleware(['auth', 'verified'])->name('admin.user.create');
Route::post('/admin/user/store', [AdminController::class, 'store_user'])
->middleware(['auth', 'verified'])->name('admin.user.store');
Route::get('/admin/user/{user}/edit', [AdminController::class, 'edit_user'])
->middleware(['auth', 'verified'])->name('admin.user.edit');
Route::patch('user/{user}', [AdminController::class, 'update_user'])
->middleware(['auth', 'verified'])->name('admin.user.update');


/* ログイン */
Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

/* ダッシュボード */
Route::get('dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
//     dd(Auth::user()->user_id,Auth::user()->name);
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* レコード管理 */
Route::get('record', [RecordController::class, 'index'])
->middleware(['auth', 'verified'])->name('record');
Route::get('record/spreadsheet/{user}', [RecordController::class, 'spreadsheet'])
->middleware(['auth', 'verified'])->name('record.spreadsheet');
Route::get('record/spreadsheet2/{user}', [RecordController::class, 'spreadsheet2'])
->middleware(['auth', 'verified'])->name('record.spreadsheet2');
Route::get('record/spreadsheet3/{user}', [RecordController::class, 'spreadsheet3'])
->middleware(['auth', 'verified'])->name('record.spreadsheet3');
Route::get('record/create', [RecordController::class, 'create'])
->middleware(['auth', 'verified'])->name('record.create');
// Route::get('record/create', [RecordController::class, 'create'])
// ->middleware('admin');
Route::post('record', [RecordController::class, 'store'])
->middleware(['auth', 'verified'])->name('record.store');
// Route::get('record/show/{record}', [RecordController::class, 'show'])
// ->name('record.show');
Route::get('record/{record}/edit', [RecordController::class, 'edit'])
->middleware(['auth', 'verified'])->name('record.edit');
Route::patch('record/{record}', [RecordController::class, 'update'])
->middleware(['auth', 'verified'])->name('record.update');

/* 目標管理 */
Route::get('target', [TargetController::class, 'index'])
->middleware(['auth', 'verified'])->name('target');
// Route::get('target/show/{target}', [TargetController::class, 'show'])
// ->name('target.show');
Route::get('target/{target}/edit', [TargetController::class, 'edit'])
->middleware(['auth', 'verified'])->name('target.edit');
Route::patch('target/{target}', [TargetController::class, 'update'])
->middleware(['auth', 'verified'])->name('target.update');

/* イベント */
Route::get('event', [EventController::class, 'index'])
->middleware(['auth', 'verified'])->name('event');

/* 景品 */
Route::get('gift', [GiftController::class, 'index'])
->middleware(['auth', 'verified'])->name('gift');
Route::get('gift/howtoget', [GiftController::class, 'howtoget'])
->middleware(['auth', 'verified'])->name('gift.howtoget');

/* 普段の目標 */
Route::get('usualtarget', [UsualtargetController::class, 'index'])
->middleware(['auth', 'verified'])->name('usualtarget');

/* 問題集 */
Route::get('workbook', [WorkbookController::class, 'index'])
->middleware(['auth', 'verified'])->name('workbook');
Route::get('workbook/reference', [WorkbookController::class, 'reference'])
->middleware(['auth', 'verified'])->name('workbook.reference');
Route::get('workbook/grammar', [WorkbookController::class, 'grammar'])
->middleware(['auth', 'verified'])->name('workbook.grammar');
Route::get('workbook/answersheet', [WorkbookController::class, 'answersheet'])
->middleware(['auth', 'verified'])->name('workbook.answersheet');
Route::get('workbook/reading', [WorkbookController::class, 'reading'])
->middleware(['auth', 'verified'])->name('workbook.reading');


require __DIR__.'/auth.php';
