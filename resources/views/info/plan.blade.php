<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 通塾コースのご案内
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">

        <!-- おすすめのコース -->
        <x-h3>おすすめのコース</x-h3>
        <!-- スマホ、PC共通 -->
        <ul class="list-disc ml-4 mb-4">
            <li class="ml-4">コース変更のご相談は塾長まで。</li>
            <li class="ml-4">短期間で成績を上げるなら通い放題！</li>
        </ul>

        <!-- スマホ表示用のコード -->
        <div class="sm:hidden">
            <div class="bg-sky-100 mb-4 p-2">
                <p class="font-bold">通い放題コース</p>
                <ul class="list-disc ml-4">
                    <li class="ml-4">短期間で成績を上げたい</li>
                    <li class="ml-4">学校の授業についていけない</li>
                    <li class="ml-4">自宅では学習できない</li>
                </ul>
            </div>
            <div class="bg-sky-100 mb-4 p-2">
                <p class="font-bold">週３回コース</p>
                <ul class="list-disc ml-4">
                    <li class="ml-4">まず１教科の成績を上げたい</li>
                    <li class="ml-4">英作文などの記述問題も見てほしい</li>
                    <li class="ml-4">自宅であまり学習できない</li>
                </ul>
            </div>
            <div class="bg-sky-100 mb-4 p-2">
                <p class="font-bold">週２回コース</p>
                <ul class="list-disc ml-4">
                    <li class="ml-4">他にも習い事をしている</li>
                    <li class="ml-4">自宅でも学習を進められる</li>
                    <li class="ml-4">学校では先生に質問できない</li>
                </ul>
            </div>
            <div class="bg-sky-100 mb-4 p-2">
                <p class="font-bold">週１回コース(高校生のみ)</p>
                <ul class="list-disc ml-4">
                    <li class="ml-4">週１日しか予定が空かない</li>
                    <li class="ml-4">１教科だけ学習したい</li>
                    <li class="ml-4">自宅でも学習を進められる</li>
                </ul>
            </div>
        </div>

        <!-- PC表示用のコード -->
        <div class="hidden sm:block">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <x-th>コース</x-th>
                    <x-th>おすすめしたい生徒</x-th>
                </tr>
                <tr>
                    <x-td>通い放題</x-td>
                    <x-td>
                        <ul class="list-disc">
                            <li class="ml-4">短期間で成績を上げたい</li>
                            <li class="ml-4">学校の授業についていけない</li>
                            <li class="ml-4">自宅では学習できない</li>
                        </ul>
                    </x-td>
                </tr>
                <tr>
                    <x-td>週３回</x-td>
                    <x-td>
                        <ul class="list-disc">
                            <li class="ml-4">まず１教科の成績を上げたい</li>
                            <li class="ml-4">英作文などの記述問題も見てほしい</li>
                            <li class="ml-4">自宅であまり学習できない</li>
                        </ul>
                    </x-td>
                </tr>
                <tr>
                    <x-td>週２回</x-td>
                    <x-td>
                        <ul class="list-disc">
                            <li class="ml-4">他にも習い事をしている</li>
                            <li class="ml-4">自宅でも学習を進められる</li>
                            <li class="ml-4">学校では先生に質問できない</li>
                        </ul>
                    </x-td>
                </tr>
                <tr>
                    <x-td>
                        <p>週１回</p>
                        <p>(高校生のみ)</p>
                    </x-td>
                    <x-td>
                        <ul class="list-disc">
                            <li class="ml-4">週１日しか予定が空かない</li>
                            <li class="ml-4">１教科だけ学習したい</li>
                            <li class="ml-4">自宅でも学習を進められる</li>
                        </ul>
                    </x-td>
                </tr>
            </table>
        </div>

        <!-- 月謝表 -->
        <x-h3>月謝（小中学生）</x-h3>
        <ul class="text-xs">
            <li>・別途、教材費3,300円（税込）がかかります。</li>
            <li>・夏期講習費、冬期講習費、春期講習費は別料金です。</li>
            <li>・兄弟姉妹は金額が低い方が２割引きになります。</li>
            <li>・表の()内は税込みの金額です。</li>
        </ul>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-h4>小学生</x-h4>
                <img src="{{ route('secure.file', ['folder' => 'info', 'filename' => 'price_e.png']) }}">
            </div>
            <div>
                <x-h4>中１</x-h4>
                <img src="{{ route('secure.file', ['folder' => 'info', 'filename' => 'price_j1.png']) }}">
            </div>
            <div>
                <x-h4>中２</x-h4>
                <img src="{{ route('secure.file', ['folder' => 'info', 'filename' => 'price_j2.png']) }}">
            </div>
            <div>
                <x-h4>中３</x-h4>
                <img src="{{ route('secure.file', ['folder' => 'info', 'filename' => 'price_j3.png']) }}">
            </div>
        </div>


        <x-h3>月謝（高校生）</x-h3>
        <ul class="text-xs">
            <li>・ベリタスは教科ごとに教材費が別途かかる場合があります。</li>
            <li>・夏期講習費、冬期講習費、春期講習費は別料金です。</li>
            <li>・兄弟姉妹は金額が低い方が２割引きになります。</li>
        </ul>
        <div class="flex justify-center">
            <img src="{{ route('secure.file', ['folder' => 'info', 'filename' => 'price_h.png']) }}">
        </div>
    </div>
</x-app-layout>