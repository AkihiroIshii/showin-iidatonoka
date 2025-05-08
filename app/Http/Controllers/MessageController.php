<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Message;
use App\Events\ChatEvent;

class MessageController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    // public function sendMessage(Request $request)
    // {
    //     $message = $request->input('message');
    //     return response()->json(['message' => $message]);
    // }

    public function index() {
        $user = $this->user;
        // $messages = Message::where('user_id', $this->user->id)->get();
        $messages = Message::where('user_id', $user->id)->latest()->take(20)->get()->reverse();
        // dd($messages);
        return view('message.index', compact('messages','user'));
    }

    public function store(Request $request)
    {
        \Log::info('store 呼び出し'); // 追加してログで確認
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = $this->user;
        $message = Message::create([
            'user_id' => $user->id, //認証が必要
            // 'user_id' => 20,
            'message' => $request->input('message'),
        ]);

        // イベントをブロードキャスト
        \Log::info('ブロードキャストします：' . $message);
        broadcast(new ChatEvent($message));
        // broadcast(new \App\Events\ChatEvent('テストメッセージ'));
        \Log::info('ブロードキャスト直後：' . $message);

        return response()->json(['status' => 'Message sent']);
        // return response()->json(['message' => 'index 動いてます！']);
    }

    // public function sendMessage(Request $request)
    // {
    //     \Log::info('sendMessage 呼び出し'); // 追加してログで確認
    //     $message = $request->input('message');

    //     // イベントをブロードキャスト
    //     \Log::info('ブロードキャストします：' . $message);
    //     // broadcast(new ChatEvent($message));
    //     broadcast(new \App\Events\ChatEvent('テストメッセージ'));
    //     \Log::info('ブロードキャスト直後：' . $message);

    //     return response()->json(['message' => $message]);
    //     // return response()->json(['message' => 'index 動いてます！']);
    // }

    public function test()
    {
        return response()->json(['message' => 'index 動いてます！']);
    }
    
}
