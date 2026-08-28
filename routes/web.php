<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Events\ChatEvent;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AishowinController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\CompletedUnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntranceExamDataHighschoolController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamresultController;
// use App\Http\Controllers\ExamratioController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\KenteiController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TopChoiceController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UsualtargetController;
use App\Http\Controllers\WorkbookController;
use App\Http\Controllers\WorkrecordController;

/* ログイン */
Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
/* はじめに */
Route::get('readme', function() {
    return view('readme');
})->name('readme');

// ファイルへのアクセス
Route::get('/secure-file/{folder}/{filename}', function ($folder, $filename) {
    // URL デコード
    $decodedFolder = urldecode($folder);

    // スラッシュを区切り文字に変換（必要な場合）
    $folderPath = str_replace('/', DIRECTORY_SEPARATOR, $decodedFolder);

    // ファイルパスを組み立て
    $filePath = "{$folderPath}/{$filename}";
    // $filePath = "private/{$folderPath}/{$filename}";
// dd($filePath);
    if (!Storage::disk('local')->exists($filePath)) {
        session()->flash('error_type', 'pdf_not_found');
        abort(404); // ファイルが存在しない場合は 404 エラー
    }

    return Response::make(Storage::get($filePath), 200, [
        'Content-Type' => Storage::mimeType($filePath),
        'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
    ]);
})->middleware('auth')->where('filename', '.*')->name('secure.file');

// jitsiのビデオ通話
Route::get('/meeting/video', [RoomController::class, 'video'])
->middleware(['auth', 'verified'])->name('meeting.video');

//チャット
// Route::get('/message/test', [MessageController::class, 'test']);
// Route::get('/message', [MessageController::class, 'index'])
// ->middleware(['auth', 'verified'])->name('message');
// Route::post('/messages', [MessageController::class, 'store']);
// Route::post('/message/send', [MessageController::class, 'sendMessage'])
// ->middleware(['auth', 'verified'])->name('message.send');
// Route::post('/message/send', function (Request $request) {
//     return response()->json(['message' => 'Received: ' . $request->message]);
// });

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

/* リンク */
Route::get('link', [LinkController::class, 'index'])
->middleware(['auth', 'verified'])->name('link');

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

/* クリアした単元 */
Route::get('completedunit', [CompletedUnitController::class, 'index'])
->middleware(['auth', 'verified'])->name('completedunit');
Route::get('completedunit/create', [CompletedUnitController::class, 'create'])
->middleware(['auth', 'verified'])->name('completedunit.create');
Route::post('completedunit/store', [CompletedUnitController::class, 'store'])
->middleware(['auth', 'verified'])->name('completedunit.store');
Route::get('completedunit/{completedunit}/edit', [CompletedUnitController::class, 'edit'])
->middleware(['auth', 'verified'])->name('completedunit.edit');
Route::patch('completedunit/{completedunit}/update', [CompletedUnitController::class, 'update'])
->middleware(['auth', 'verified'])->name('completedunit.update');

/* 試験 */
// Route::get('exam', [ExamController::class, 'index'])
// ->middleware(['auth', 'verified'])->name('exam');
Route::get('/exam/list', [ExamController::class, 'getAllExams'])
->middleware(['auth', 'verified'])->name('exam.list');
// Route::get('/exam/show/{exam_id}', [ExamController::class, 'show'])
// ->middleware(['auth', 'verified'])->name('exam.show');
Route::get('/exam/show/{exam_id}/{folder}', [ExamController::class, 'show'])
->middleware(['auth', 'verified'])->name('exam.show');
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
// Route::get('examresult/show/{exam_id}', [ExamresultController::class, 'show'])
// ->middleware(['auth', 'verified'])->name('examresult.show');
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
Route::get('workbook/randomsetting', [WorkbookController::class, 'randomsetting'])
->middleware(['auth', 'verified'])->name('workbook.randomsetting');
Route::get('workbook/unitbasedlist', [WorkbookController::class, 'unitbasedlist'])
->middleware(['auth', 'verified'])->name('workbook.unitbasedlist');
/*************** 単元別学習　ここから *************************/
//小学生国語
Route::get('workbook/kanjiP2', [WorkbookController::class, 'kanjiP2'])
->middleware(['auth', 'verified'])->name('workbook.unit.kanjiP2');
Route::get('workbook/kanjiP3', [WorkbookController::class, 'kanjiP3'])
->middleware(['auth', 'verified'])->name('workbook.unit.kanjiP3');
Route::get('workbook/kanjiP4', [WorkbookController::class, 'kanjiP4'])
->middleware(['auth', 'verified'])->name('workbook.unit.kanjiP4');
//算数
Route::get('workbook/mul100', [WorkbookController::class, 'mul100'])
->middleware(['auth', 'verified'])->name('workbook.unit.mul100');
Route::get('workbook/ratio1', [WorkbookController::class, 'ratio1'])
->middleware(['auth', 'verified'])->name('workbook.unit.ratio1');
Route::get('workbook/ratio2', [WorkbookController::class, 'ratio2'])
->middleware(['auth', 'verified'])->name('workbook.unit.ratio2');
Route::get('workbook/velocity', [WorkbookController::class, 'velocity1'])
->middleware(['auth', 'verified'])->name('workbook.unit.velocity1');
Route::get('workbook/velocity2', [WorkbookController::class, 'velocity2'])
->middleware(['auth', 'verified'])->name('workbook.unit.velocity2');
Route::get('workbook/fraction_muldiv', [WorkbookController::class, 'fraction_muldiv'])
->middleware(['auth', 'verified'])->name('workbook.unit.fraction_muldiv');
//数学
Route::get('workbook/distributive_law1', [WorkbookController::class, 'distributive_law1'])
->middleware(['auth', 'verified'])->name('workbook.unit.distributive_law1');
Route::get('workbook/distributive_law2', [WorkbookController::class, 'distributive_law2'])
->middleware(['auth', 'verified'])->name('workbook.unit.distributive_law2');
Route::get('workbook/fractional_expression', [WorkbookController::class, 'fractional_expression'])
->middleware(['auth', 'verified'])->name('workbook.unit.fractional_expression');
Route::get('workbook/linear_equation1', [WorkbookController::class, 'linear_equation1'])
->middleware(['auth', 'verified'])->name('workbook.unit.linear_equation1');
Route::get('workbook/linear_equation2', [WorkbookController::class, 'linear_equation2'])
->middleware(['auth', 'verified'])->name('workbook.unit.linear_equation2');
Route::get('workbook/linear_equation3', [WorkbookController::class, 'linear_equation3'])
->middleware(['auth', 'verified'])->name('workbook.unit.linear_equation3');
Route::get('workbook/linear_equation4', [WorkbookController::class, 'linear_equation4'])
->middleware(['auth', 'verified'])->name('workbook.unit.linear_equation4');
Route::get('workbook/plot_proportional_function', [WorkbookController::class, 'plot_proportional_function'])
->middleware(['auth', 'verified'])->name('workbook.unit.plot_proportional_function');
Route::get('workbook/plane_figure', [WorkbookController::class, 'plane_figure'])
->middleware(['auth', 'verified'])->name('workbook.unit.plane_figure');
Route::get('workbook/spacial_figure', [WorkbookController::class, 'spacial_figure'])
->middleware(['auth', 'verified'])->name('workbook.unit.spacial_figure');
// 数学（中2）
Route::get('workbook/plot_linear_function', [WorkbookController::class, 'plot_linear_function'])
->middleware(['auth', 'verified'])->name('workbook.unit.plot_linear_function');
Route::get('workbook/plot_linear_function2', [WorkbookController::class, 'plot_linear_function2'])
->middleware(['auth', 'verified'])->name('workbook.unit.plot_linear_function2');
Route::get('workbook/linear_function3', [WorkbookController::class, 'linear_function3'])
->middleware(['auth', 'verified'])->name('workbook.unit.linear_function3');
Route::get('workbook/find_angle', [WorkbookController::class, 'find_angle'])
->middleware(['auth', 'verified'])->name('workbook.find_angle');
Route::get('workbook/regular_polygon', [WorkbookController::class, 'regular_polygon'])
->middleware(['auth', 'verified'])->name('workbook.unit.regular_polygon');
Route::get('workbook/proof_congruence1', [WorkbookController::class, 'proof_congruence1'])
->middleware(['auth', 'verified'])->name('workbook.proof_congruence1');
// 数学（中3）
Route::get('workbook/expansion', [WorkbookController::class, 'expansion'])
->middleware(['auth', 'verified'])->name('workbook.expansion');
Route::get('workbook/factorization', [WorkbookController::class, 'factorization'])
->middleware(['auth', 'verified'])->name('workbook.factorization');
Route::get('workbook/sqrt_calc', [WorkbookController::class, 'sqrt_calc'])
->middleware(['auth', 'verified'])->name('workbook.unit.sqrt_calc');
Route::get('workbook/sqrt_natural', [WorkbookController::class, 'sqrt_natural'])
->middleware(['auth', 'verified'])->name('workbook.unit.sqrt_natural');
Route::get('workbook/expansion', [WorkbookController::class, 'expansion'])
->middleware(['auth', 'verified'])->name('workbook.expansion');
// 英語
Route::get('workbook/be_verb', [WorkbookController::class, 'be_verb'])
->middleware(['auth', 'verified'])->name('workbook.be_verb');
Route::get('workbook/general_verb', [WorkbookController::class, 'general_verb'])
->middleware(['auth', 'verified'])->name('workbook.general_verb');
Route::get('workbook/interrogative', [WorkbookController::class, 'interrogative'])
->middleware(['auth', 'verified'])->name('workbook.interrogative');
Route::get('workbook/past_verb', [WorkbookController::class, 'past_verb'])
->middleware(['auth', 'verified'])->name('workbook.past_verb');

Route::get('workbook/e_word_verb1', [WorkbookController::class, 'e_word_verb1'])
->middleware(['auth', 'verified'])->name('workbook.unit.e_word_verb1');
Route::get('workbook/be_verb1', [WorkbookController::class, 'be_verb1'])
->middleware(['auth', 'verified'])->name('workbook.unit.be_verb1');
Route::get('workbook/be_verb2', [WorkbookController::class, 'be_verb2'])
->middleware(['auth', 'verified'])->name('workbook.unit.be_verb2');
Route::get('workbook/be_verb3', [WorkbookController::class, 'be_verb3'])
->middleware(['auth', 'verified'])->name('workbook.unit.be_verb3');
Route::get('workbook/general_verb1', [WorkbookController::class, 'general_verb1'])
->middleware(['auth', 'verified'])->name('workbook.unit.general_verb1');
Route::get('workbook/general_verb2', [WorkbookController::class, 'general_verb2'])
->middleware(['auth', 'verified'])->name('workbook.unit.general_verb2');
Route::get('workbook/general_verb3', [WorkbookController::class, 'general_verb3'])
->middleware(['auth', 'verified'])->name('workbook.unit.general_verb3');
Route::get('workbook/general_verb4', [WorkbookController::class, 'general_verb4'])
->middleware(['auth', 'verified'])->name('workbook.unit.general_verb4');
Route::get('workbook/pronoun', [WorkbookController::class, 'pronoun'])
->middleware(['auth', 'verified'])->name('workbook.unit.pronoun');
Route::get('workbook/preposition', [WorkbookController::class, 'preposition'])
->middleware(['auth', 'verified'])->name('workbook.unit.preposition');
Route::get('workbook/sentence_structure1', [WorkbookController::class, 'sentence_structure1'])
->middleware(['auth', 'verified'])->name('workbook.sentence_structure1');
// 社会
Route::get('workbook/map_scale', [WorkbookController::class, 'map_scale'])
->middleware(['auth', 'verified'])->name('workbook.unit.map_scale');
// 理科
Route::get('workbook/density', [WorkbookController::class, 'density'])
->middleware(['auth', 'verified'])->name('workbook.unit.density');
Route::get('workbook/aqueous1', [WorkbookController::class, 'aqueous1'])
->middleware(['auth', 'verified'])->name('workbook.unit.aqueous1');
Route::get('workbook/humidity', [WorkbookController::class, 'humidity'])
->middleware(['auth', 'verified'])->name('workbook.unit.humidity');
Route::get('workbook/electromagnetism', [WorkbookController::class, 'electromagnetism'])
->middleware(['auth', 'verified'])->name('workbook.unit.electromagnetism');
/*************** 単元別学習　ここまで *************************/



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

/* 振替 */
Route::get('transfer', [TransferController::class, 'index'])
->middleware(['auth', 'verified'])->name('transfer');
Route::get('/transfer/create', [TransferController::class, 'create'])
->middleware(['auth', 'verified'])->name('transfer.create');
Route::post('/transfer', [TransferController::class, 'store'])
->middleware(['auth', 'verified'])->name('transfer.store');
Route::get('/transfer/{transfer}/edit', [TransferController::class, 'edit'])
->middleware(['auth', 'verified'])->name('transfer.edit');
Route::patch('/transfer/{transfer}', [TransferController::class, 'update'])
->middleware(['auth', 'verified'])->name('transfer.update');

/* コイン */
Route::get('coin', [CoinController::class, 'index'])
->middleware(['auth', 'verified'])->name('coin');
Route::get('/coin/create', [CoinController::class, 'create'])
->middleware(['auth', 'verified'])->name('coin.create');
Route::post('/coin', [CoinController::class, 'store'])
->middleware(['auth', 'verified'])->name('coin.store');
Route::get('/coin/{coin}/edit', [CoinController::class, 'edit'])
->middleware(['auth', 'verified'])->name('coin.edit');
Route::patch('/coin/{coin}', [CoinController::class, 'update'])
->middleware(['auth', 'verified'])->name('coin.update');

/* お知らせ */
Route::get('information', [InformationController::class, 'index'])
->middleware(['auth', 'verified'])->name('information');
Route::get('/information/create', [InformationController::class, 'create'])
->middleware(['auth', 'verified'])->name('information.create');
Route::post('/information', [InformationController::class, 'store'])
->middleware(['auth', 'verified'])->name('information.store');
Route::get('/information/{information}/edit', [InformationController::class, 'edit'])
->middleware(['auth', 'verified'])->name('information.edit');
Route::patch('/information/{information}', [InformationController::class, 'update'])
->middleware(['auth', 'verified'])->name('information.update');

/* AI-Showin */
Route::get('aishowin', [AishowinController::class, 'index'])
->middleware(['auth', 'verified'])->name('aishowin');


/* 高校入試倍率 */
// Route::get('examratio', [ExamratioController::class, 'index'])
// ->middleware(['auth', 'verified'])->name('examratio');
// Route::get('examratio/school', [ExamratioController::class, 'school'])
// ->middleware(['auth', 'verified'])->name('examratio.school');
Route::get('entrance_exam_data_highschool/years', [EntranceExamDataHighschoolController::class, 'years'])
->middleware(['auth', 'verified'])->name('entrance_exam_data_highschool.years');
Route::get('entrance_exam_data_highschool/schools', [EntranceExamDataHighschoolController::class, 'schools'])
->middleware(['auth', 'verified'])->name('entrance_exam_data_highschool.schools');

/* その他（共通） */
// Route::get('link', [CommonController::class, 'link'])
// ->middleware(['auth', 'verified'])->name('link');
Route::get('audiofile', [CommonController::class, 'audiofile'])
->middleware('auth', 'verified')->name('audiofile');
Route::get('info/plan', [CommonController::class, 'plan'])
->middleware(['auth', 'verified'])->name('plan');

require __DIR__.'/auth.php';
