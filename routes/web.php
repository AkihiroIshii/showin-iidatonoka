<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AishowinController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WorkbookController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsualtargetController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamresultController;
use App\Http\Controllers\ExamratioController;
use App\Http\Controllers\WorkrecordController;
use App\Http\Controllers\TopChoiceController;
use App\Http\Controllers\KenteiController;

//管理者ページ
// Route::get('/admin', function() {
//     return view('admin');
// })->middleware(['auth', 'admin'])->name('admin');
Route::middleware(['auth', 'admin'])->group(function (){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::get('/admin/students', [AdminController::class, 'students'])
->middleware(['auth', 'verified'])->name('admin.students');
Route::get('/admin/setStudent/{user}', [AdminController::class, 'setStudent'])
->middleware(['auth', 'verified'])->name('admin.setStudent');
// Route::get('/admin/show/{user}', [AdminController::class, 'show'])
// ->middleware(['auth', 'verified'])->name('admin.show');
// Route::get('/admin/spreadsheet/{user}', [AdminController::class, 'spreadsheet'])
// ->middleware(['auth', 'verified'])->name('admin.spreadsheet');
// Route::get('/admin/spreadsheet3/{user}', [AdminController::class, 'spreadsheet3'])
// ->middleware(['auth', 'verified'])->name('admin.spreadsheet3');




/** 管理者＞過去問目標点数 */
// Route::get('/admin/target/{user}', [AdminController::class, 'target'])
// ->middleware(['auth', 'verified'])->name('admin.target');
// Route::get('admin/target/create/{user}', [AdminController::class, 'create_target'])
// ->middleware(['auth', 'verified'])->name('admin.target.create');
// Route::post('admin/target/store/{user}', [AdminController::class, 'store_target'])
// ->middleware(['auth', 'verified'])->name('admin.target.store');
// Route::get('admin/target/{target}/edit', [AdminController::class, 'edit_target'])
// ->middleware(['auth', 'verified'])->name('admin.target.edit');
// Route::patch('admin/target/{target}/update', [AdminController::class, 'update_target'])
// ->middleware(['auth', 'verified'])->name('admin.target.update');


/** 管理者＞日々の目標 */
// Route::get('/usualtarget/{user}', [AdminController::class, 'usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget');
// Route::get('admin/usualtarget/create/{user}', [AdminController::class, 'create_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.create');
// Route::post('admin/usualtarget/store/{user}', [AdminController::class, 'store_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.store');
// Route::get('admin/usualtarget/{usualtarget}/edit', [AdminController::class, 'edit_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.edit');
// Route::patch('admin/usualtarget/{usualtarget}/update', [AdminController::class, 'update_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.update');

/** 管理者＞テスト結果 */
// Route::get('/admin/exam/{user}', [AdminController::class, 'exam'])
// ->middleware(['auth', 'verified'])->name('admin.exam');
// Route::get('admin/usualtarget/create/{user}', [AdminController::class, 'create_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.create');
// Route::post('admin/usualtarget/store/{user}', [AdminController::class, 'store_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.store');
// Route::get('admin/usualtarget/{usualtarget}/edit', [AdminController::class, 'edit_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.edit');
// Route::patch('admin/usualtarget/{usualtarget}/update', [AdminController::class, 'update_usualtarget'])
// ->middleware(['auth', 'verified'])->name('admin.usualtarget.update');

/** 管理者＞ワーク演習 */
Route::get('admin/wordrecord/{user}', [AdminController::class, 'workrecord'])
->middleware(['auth', 'verified'])->name('admin.workrecord');
Route::get('admin/workrecord/create/{user}', [AdminController::class, 'create_workrecord'])
->middleware(['auth', 'verified'])->name('admin.workrecord.create');
Route::post('admin/workrecord/store/{user}', [AdminController::class, 'store_workrecord'])
->middleware(['auth', 'verified'])->name('admin.workrecord.store');
Route::get('admin/workrecord/{workrecord}/edit', [AdminController::class, 'edit_workrecord'])
->middleware(['auth', 'verified'])->name('admin.workrecord.edit');
Route::patch('admin/workrecord/{workrecord}/update', [AdminController::class, 'update_workrecord'])
->middleware(['auth', 'verified'])->name('admin.workrecord.update');


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
Route::get('record/spreadsheet/', [RecordController::class, 'spreadsheet'])
->middleware(['auth', 'verified'])->name('record.spreadsheet');
Route::get('record/spreadsheet3/', [RecordController::class, 'spreadsheet3'])
->middleware(['auth', 'verified'])->name('record.spreadsheet3');
Route::get('record/answersheet/', [RecordController::class, 'answersheet'])
->middleware(['auth', 'verified'])->name('record.answersheet');
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
Route::get('usualtarget/create/{user}', [UsualtargetController::class, 'create'])
->middleware(['auth', 'verified'])->name('usualtarget.create');
Route::post('usualtarget/store', [UsualtargetController::class, 'store'])
->middleware(['auth', 'verified'])->name('usualtarget.store');
Route::get('usualtarget/{usualtarget}/edit', [UsualtargetController::class, 'edit'])
->middleware(['auth', 'verified'])->name('usualtarget.edit');
Route::patch('usualtarget/{usualtarget}/update', [UsualtargetController::class, 'update'])
->middleware(['auth', 'verified'])->name('usualtarget.update');

/* 試験 */
// Route::get('exam', [ExamController::class, 'index'])
// ->middleware(['auth', 'verified'])->name('exam');
Route::get('/exam/list', [ExamController::class, 'getAllExams'])
->middleware(['auth', 'verified'])->name('exam.list');
Route::get('/exam/create', [ExamController::class, 'create'])
->middleware(['auth', 'verified'])->name('exam.create');
Route::post('/exam', [ExamController::class, 'store'])
->middleware(['auth', 'verified'])->name('exam.store');
Route::get('/exam/{exam}/edit', [ExamController::class, 'edit'])
->middleware(['auth', 'verified'])->name('exam.edit');
Route::patch('/exam/{exam}', [ExamController::class, 'update'])
->middleware(['auth', 'verified'])->name('exam.update');

/* 試験結果 */
Route::get('examresult', [ExamresultController::class, 'index'])
->middleware(['auth', 'verified'])->name('examresult');
Route::get('/examresult/create', [ExamresultController::class, 'create'])
->middleware(['auth', 'verified'])->name('examresult.create');
Route::post('/examresult', [ExamresultController::class, 'store'])
->middleware(['auth', 'verified'])->name('examresult.store');
Route::get('/examresult/{examresult}/edit', [ExamresultController::class, 'edit'])
->middleware(['auth', 'verified'])->name('examresult.edit');
Route::patch('/examresult/{examresult}', [ExamresultController::class, 'update'])
->middleware(['auth', 'verified'])->name('examresult.update');


/* 問題集 */
Route::get('workbook', [WorkbookController::class, 'index'])
->middleware(['auth', 'verified'])->name('workbook');
Route::get('workbook/reference', [WorkbookController::class, 'reference'])
->middleware(['auth', 'verified'])->name('workbook.reference');
Route::get('workbook/grammar', [WorkbookController::class, 'grammar'])
->middleware(['auth', 'verified'])->name('workbook.grammar');
Route::get('workbook/reading', [WorkbookController::class, 'reading'])
->middleware(['auth', 'verified'])->name('workbook.reading');

/* ワーク演習 */
Route::get('workrecord', [WorkrecordController::class, 'index'])
->middleware(['auth', 'verified'])->name('workrecord');
Route::get('workrecord/create', [WorkrecordController::class, 'create'])
->middleware(['auth', 'verified'])->name('workrecord.create');
Route::post('workrecord/store', [WorkrecordController::class, 'store'])
->middleware(['auth', 'verified'])->name('workrecord.store');
Route::get('workrecord/{workrecord}/edit', [WorkrecordController::class, 'edit'])
->middleware(['auth', 'verified'])->name('workrecord.edit');
Route::patch('workrecord/{workrecord}', [WorkrecordController::class, 'update'])
->middleware(['auth', 'verified'])->name('workrecord.update');

/* 志望校 */
Route::get('top_choice', [TopChoiceController::class, 'index'])
->middleware(['auth', 'verified'])->name('top_choice');
Route::get('/top_choice/create', [TopChoiceController::class, 'create'])
->middleware(['auth', 'verified'])->name('top_choice.create');
Route::post('/top_choice', [TopChoiceController::class, 'store'])
->middleware(['auth', 'verified'])->name('top_choice.store');
Route::get('/top_choice/{top_choice}/edit', [TopChoiceController::class, 'edit'])
->middleware(['auth', 'verified'])->name('top_choice.edit');
Route::patch('/top_choice/{top_choice}', [TopChoiceController::class, 'update'])
->middleware(['auth', 'verified'])->name('top_choice.update');

/* 検定試験 */
Route::get('kentei', [KenteiController::class, 'index'])
->middleware(['auth', 'verified'])->name('kentei');
Route::get('/kentei/create', [KenteiController::class, 'create'])
->middleware(['auth', 'verified'])->name('kentei.create');
Route::post('/kentei', [KenteiController::class, 'store'])
->middleware(['auth', 'verified'])->name('kentei.store');
Route::get('/kentei/{kentei}/edit', [KenteiController::class, 'edit'])
->middleware(['auth', 'verified'])->name('kentei.edit');
Route::patch('/kentei/{kentei}', [KenteiController::class, 'update'])
->middleware(['auth', 'verified'])->name('kentei.update');


/* AI-Showin */
Route::get('aishowin', [AishowinController::class, 'index'])
->middleware(['auth', 'verified'])->name('aishowin');


/* 高校入試倍率 */
Route::get('examratio', [ExamratioController::class, 'index'])
->middleware(['auth', 'verified'])->name('examratio');
Route::get('examratio/school', [ExamratioController::class, 'school'])
->middleware(['auth', 'verified'])->name('examratio.school');

/* その他（共通） */
Route::get('link', [CommonController::class, 'link'])
->middleware(['auth', 'verified'])->name('link');
Route::get('audiofile', [CommonController::class, 'audiofile'])
->middleware('auth', 'verified')->name('audiofile');
Route::get('info/plan', [CommonController::class, 'plan'])
->middleware(['auth', 'verified'])->name('plan');


require __DIR__.'/auth.php';
