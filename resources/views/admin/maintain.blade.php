<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                管理者専用ページ（メンテナンス）
            </h2>
        </x-slot>
        <div class="mx-auto px-6 py-10">
            <div class="mx-auto px-6">
                <!-- 門配 -->
                <x-h3>門配開始時刻</x-h3>
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <tr>
                                <x-th>学校名</x-th>
                                <x-th>５時間授業</x-th>
                                <x-th>６時間授業</x-th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <x-td>伊賀良小</x-td>
                                <x-td>14:40?</x-td>
                                <x-td>15:50</x-td>
                            </tr>
                            <tr>
                                <x-td>旭中</x-td>
                                <x-td>14:55</x-td>
                                <x-td>-</x-td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- 経理 -->
                <x-h3>経理</x-h3>
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <tr>
                                <x-th>用途</x-th>
                                <x-th>勘定科目</x-th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <x-td>政策公庫への返済（元本）（37,000円）</x-td>
                                <x-td>長期借入金</x-td>
                            </tr>
                            <tr>
                                <x-td>飯田信金への返済（元本）（48,000円）</x-td>
                                <x-td>長期借入金</x-td>
                            </tr>
                            <tr>
                                <x-td>切手、はがき</x-td>
                                <x-td>通信費</x-td>
                            </tr>
                            <tr>
                                <x-td>なが模試</x-td>
                                <x-td>新聞図書費</x-td>
                            </tr>
                            <tr>
                                <x-td>ダスト　ゴミ収集</x-td>
                                <x-td>支払手数料</x-td>
                            </tr>
                            <tr>
                                <x-td>エアコン掃除</x-td>
                                <x-td>修繕費</x-td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Laravel -->
                <x-h3>Laravel</x-h3>
                <div class="mb-4">
                    <h3>コントローラの作成</h3>
                    <p>1. $ sail artisan make:controller HelloController</p>
                </div>
                <div class="mb-4">
                    <h3>テーブル作成</h3>
                    <p>1. $ sail artisan make:model TopChoice -m (※)テーブル名はキャメルケースで単数形。</p>
                    <p>2. モデルと同時に作成されたマイグレーションファイルを編集。</p>
                    <p>3. $ sail artisan migrate（本番環境では $php artisan migrate）</p>
                </div>
                <div class="mb-4">
                    <h3>テーブルにカラムを追加</h3>
                    <p>1. $ sail artisan make:migration マイグレーションファイル名 --table=編集するテーブル名</p>
                    <p>2. 作成されたマイグレーションファイルを編集。</p>
                    <p>3. $ sail artisan migrate　(※)さくらレンタルサーバでは、sshログイン後に $php artisan migrate</p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>