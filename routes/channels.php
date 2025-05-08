<?php

// use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('chat-channel', function () {
//     return true; // 認証不要なパブリックチャンネルならtrue
// });

Broadcast::channel('chat-channel', function ($user) {
    return ['id' => $user->id];
});