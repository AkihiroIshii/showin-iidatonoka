<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 音源
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            <!-- なが模試 英語リスニング音声 -->
            <x-h3>なが模試　英語リスニング音声</x-h3>
            <details class="mt-2 border border-gray-300 p-2 rounded-lg">
                <summary class="cursor-pointer text-blue-500 font-semibold">一覧</summary>
                <table class="border-separate border border-slate-400 m-auto mb-6 table-fixed w-full">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">ファイル名</th>
                    </tr>
                    @php
                        $numbers = ['1'];
                    @endphp
                    @foreach($numbers as $number)
                        <tr>
                            <td class="border border-slate-300 px-4 cursor-pointer text-blue-500 font-semibold">
                                <a href="{{ route('secure.file', ['folder' => 'mp3/nagamoshi_listening', 'filename' => '2025_' . $number . '.mp3']) }}">なが模試2025年度　第{{$number}}回</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </details>

            <!-- 英語リスニング音声 -->
            <x-h3>公立高校過去問　英語リスニング音声</x-h3>
            <details class="mt-2 border border-gray-300 p-2 rounded-lg">
                <summary class="cursor-pointer text-blue-500 font-semibold">一覧</summary>
                <table class="border-separate border border-slate-400 m-auto mb-6 table-fixed w-full">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">ファイル名</th>
                    </tr>
                    @php
                        $years = ['2025','2024','2023','2022','2021','2020','2019','H30'];
                    @endphp
                    @foreach($years as $year)
                        <tr>
                            <td class="border border-slate-300 px-4 cursor-pointer text-blue-500 font-semibold">
                                <a href="{{ route('secure.file', ['folder' => 'mp3/pastexam_listening', 'filename' => 'listening_' . $year . '.mp3']) }}">公立高校入試過去問　{{$year}}年</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </details>

            <!-- 古典朗読 -->
            <x-h3>古典朗読</x-h3>
            <p>書籍は塾にあります（貸出可）。</p>
            <table class="border-separate border border-slate-400 m-auto mb-6 table-fixed w-full">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">題材</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">音声プレイヤー</th>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">平家物語　巻第一【1】　祇園精舎 ～ 殿上闇討</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/05_古典_朗読音声/平家物語（日本の古典をよむ13）原文編/002 巻第一【1】祇園精舎～殿上闇討.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">平家物語　巻第十一【2】　那須与一 ～ 鶏合 壇浦合戦</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/05_古典_朗読音声/平家物語（日本の古典をよむ13）原文編/022 巻第十一【2】那須与一～鶏合壇浦合戦.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
            </table>                

            <!-- 英語朗読 -->
            <x-h3>英語朗読</x-h3>
            <p>書籍は塾にあります（貸出可）。</p>
            <table class="border-separate border border-slate-400 m-auto mb-6 table-fixed w-full">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">題材</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">音声プレイヤー</th>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">STEP Ladder　リトル・マーメイド（ステップ１）　Chapter1</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/04_ラダーシリーズ_英語朗読音声/011_リトル・マーメイド（ステップ１）/01.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">STEP Ladder　アインシュタイン物語（ステップ１）　Chapter1</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/04_ラダーシリーズ_英語朗読音声/012_アインシュタイン物語（ステップ１）/0614_the_albert_einstein_story_01.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">STEP Ladder　赤毛のアン（ステップ２）　Chapter1</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/04_ラダーシリーズ_英語朗読音声/021_赤毛のアン（ステップ２）/0628_anne_of_green_gables_01.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">STEP Ladder　オズの魔法使い（ステップ２）　Chapter1</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/04_ラダーシリーズ_英語朗読音声/022_オズの魔法使い（ステップ２）/01.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">ラダーシリーズ　美女と野獣（レベル1）　Chapter1</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/04_ラダーシリーズ_英語朗読音声/111_美女と野獣（レベル1）/001 分割版1.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">ラダーシリーズ　日本昔話1　桃太郎ほか（レベル1）　Chapter1</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/04_ラダーシリーズ_英語朗読音声/112_日本昔話1　桃太郎ほか（レベル1）/001 分割版1.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
            </table>                
        </div>
</x-app-layout>
