<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                管理者専用ページ（メンテナンス）
            </h2>
        </x-slot>
        <div class="mx-auto px-6 py-10">
            <div class="mx-auto px-6">
                <div>
                    <h3>コントローラの作成</h3>
                    <p>1. $ sail artisan make:controller HelloController</p>

                    <h3>テーブルにカラムを追加</h3>
                    <p>1. $ sail artisan make:migration マイグレーションファイル名 --table=編集するテーブル名</p>
                    <p>2. 作成されたマイグレーションファイルを編集。</p>
                    <p>3. $ sail artisan migrate　(※)さくらレンタルサーバでは、sshログイン後に $php artisan migrate</p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>