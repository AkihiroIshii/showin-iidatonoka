<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 音源
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            <!-- 英語リスニング音声 -->
            <x-h3>過去問　英語リスニング音声</x-h3>
            <table class="border-separate border border-slate-400 m-auto mb-6 table-fixed w-full">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">ファイル名</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">音声プレイヤー</th>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">公立高校入試過去問　2024年</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/02_公立高校入試過去問/公立高校入試過去問2024年.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">公立高校入試過去問　2023年</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/02_公立高校入試過去問/公立高校入試過去問2023年.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">公立高校入試過去問　2022年</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/02_公立高校入試過去問/公立高校入試過去問2022年.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">公立高校入試過去問　2021年</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/02_公立高校入試過去問/公立高校入試過去問2021年.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-300 px-4">公立高校入試過去問　2020年</td>
                    <td class="border border-slate-300 px-4">
                        <audio controls controlslist="nodownload" src="{{ asset('mp3/02_公立高校入試過去問/公立高校入試過去問2020年.mp3') }}" type="audio/mpeg"></audio>
                    </td>
                </tr>
            </table>

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