<?php

namespace App\Services;

use Firebase\JWT\JWT;

class JaasTokenService
{
    /**
     * JaaS用のJWTを生成
     */
    public static function generateToken($roomName, $user)
    {
        // $apiKey = env('JAAS_APP_ID');
        $apiKey = env('JAAS_API_KEY');
        $appSecret = env('JAAS_APP_SECRET');
        $subDomain = env('JAAS_SUBDOMAIN');

        $payload = [
            // "aud" => "jitsi",
            "aud" => $apiKey,
            "iss" => $apiKey, 
            "sub" => $subDomain,
            // "sub" => $user->id,
            "exp" => time() + 3600, // 1時間の有効期限
            "room" => $roomName,
            "context" => [
                "user" => [
                    "avatar" => "",
                    "name" => "ishii.akihiro",
                    "email" => "ishii.akihiro@gmail.com",
                    // "id" => "google-oauth2|107814237471728419284",
                    "moderator" => true // ここをfalseにすると一般ユーザー
                ]
                // "user" => [
                //     "avatar" => $user->avatar ?? "",
                //     "name" => $user->name,
                //     "email" => $user->email ?? "",
                //     "id" => (string) $user->id,
                //     "moderator" => true // ここをfalseにすると一般ユーザー
                // ]
            ]
        ];

        return JWT::encode($payload, $appSecret, 'HS256');
    }
}
