<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transfer;
use App\Http\Requests\TransferRequest;

class TransferController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得（対象がひとりのとき）
        $this->user = User::where('id', Session::get('target_students'))->first();

        // セッション情報から対象生徒を取得（対象が複数のとき）
        $user_ids = Session::get('target_students', null); //セッションから対象の生徒を取得。
        $this->user_ids = Arr::wrap($user_ids); //配列に統一
    }

    public function index() {
        $user = $this->user;
        $user_ids = Session::get('target_students', null); //セッションから対象の生徒を取得。
        $user_ids = Arr::wrap($user_ids); //配列に統一
        $transfers = Transfer::from('transfers as t')
            ->whereIn('t.user_id', $user_ids)
            ->LeftJoin('users', 'users.id', '=', 't.user_id')
            ->selectRaw('
                t.*,
                ROUND(
                    (TIME_TO_SEC(COALESCE(t.time_to_absence_1, 0)) - TIME_TO_SEC(COALESCE(t.time_from_absence_1, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_absence_2, 0)) - TIME_TO_SEC(COALESCE(t.time_from_absence_2, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_absence_3, 0)) - TIME_TO_SEC(COALESCE(t.time_from_absence_3, 0))) / 60
                , 0) as sum_t_abs,
                ROUND(
                    (TIME_TO_SEC(COALESCE(t.time_to_alternative_1, 0)) - TIME_TO_SEC(COALESCE(t.time_from_alternative_1, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_alternative_2, 0)) - TIME_TO_SEC(COALESCE(t.time_from_alternative_2, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_alternative_3, 0)) - TIME_TO_SEC(COALESCE(t.time_from_alternative_3, 0))) / 60
                , 0) as sum_t_alt,
                users.name as user_name
            ')
            ->orderBy('t.alternative_day_1','asc')
            ->orderBy('t.user_id','asc')
            ->get();

        return view('transfer.index',compact('user','transfers'));
    }

    public function create() {
        $user = $this->user;
        $user_ids = $this->user_ids;
        $users = User::whereIn('id', $user_ids)->get();
        return view('transfer.create',compact('user','users'));
    }

    public function store(TransferRequest $request) {
        $request['status'] = "申請中";
        $transfer = Transfer::create($request->all());
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Transfer $transfer) {
        $user = $this->user;
        $user_ids = $this->user_ids;
        $users = User::whereIn('id', $user_ids)->get();
        return view('transfer.edit', compact('transfer','user','users'));
    }

    public function update(TransferRequest $request, Transfer $transfer) {    
        $transfer->update($request->all());
        // $validated = $request->validated();
        $request->session()->flash('message', '更新しました');
        return back();
    }
}
