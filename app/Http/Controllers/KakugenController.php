<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Kakugen;
use App\Traits\KakugenTrait;

class KakugenController extends Controller
{
    use KakugenTrait;
    
    public function show(Kakugen $kakugen) {
        return view('kakugen.show', compact('kakugen'));
    }

    public function reshow() {
        // 格言を取得
        $kakugen = $this->getKakugen();
        return view('kakugen.show', compact('kakugen'));
    }

    public function create() {
        //ログインユーザ
        return view('kakugen.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'sentence' => 'required',
            'person' => 'required',
            'reference' => 'nullable',
            'comment' => 'nullable',
        ]);
        $request = Kakugen::create($validated);
        // $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Kakugen $kakugen) {
        //ログインユーザ
        // $user = User::where('id', $this->user->id)->first();
        return view('kakugen.edit', compact('kakugen'));
    }

    public function update(Request $request, Kakugen $kakugen) {

        try {
            $validated = $request->validate([
                'sentence' => 'required',
                'person' => 'required',
                'reference' => 'nullable',
                'comment' => 'nullable',
            ]);
        
            // バリデーション成功時にここに到達する
            // dd($validated);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // バリデーションエラーの内容を確認
            dd($e->errors());
        }
        
        $kakugen->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }
}
