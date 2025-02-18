<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 目的別対策
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <ul style="list-style:circle;" class="ml-8">
            <li>AI-Showinでおすすめの単元を、目的別に一覧表示しています。</li>
            <li>自宅学習でやるべき単元に迷ったら参考にしてください。</li>
            <li>リターン問題を増やしたくない人は、どこでもモードで学習しましょう。</li>
        </ul>

        <!-- 中学社会 -->
        <x-h3>中学社会の計算問題を解きたい</x-h3>
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">AI-Showin単元名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">レベル数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                </tr>
                @foreach($societyUnits as $unit)
                <tr>
                    <td class="border border-slate-300 px-4">{{$unit->grade}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->unit}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->num_level}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->explanation}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <!-- 中学理科 -->
        <x-h3>中学理科の計算問題を解きたい</x-h3>
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">AI-Showin単元名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">レベル数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                </tr>
                @foreach($scienceUnits as $unit)
                <tr>
                    <td class="border border-slate-300 px-4">{{$unit->grade}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->unit}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->num_level}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->explanation}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <!-- 中学数学：応用問題 -->
        <x-h3>応用問題を解きたい</x-h3>
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">AI-Showin単元名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">レベル数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                </tr>
                @foreach($appliedUnits as $unit)
                <tr>
                    <td class="border border-slate-300 px-4">{{$unit->grade}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->unit}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->num_level}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->explanation}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <!-- 計算力を鍛える単元 -->
        <x-h3>計算力を鍛えたい</x-h3>
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">AI-Showin単元名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">レベル数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                </tr>
                @foreach($trainUnits as $unit)
                <tr>
                    <td class="border border-slate-300 px-4">{{$unit->grade}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->unit}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->num_level}}</td>
                    <td class="border border-slate-300 px-4">{{$unit->explanation}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>