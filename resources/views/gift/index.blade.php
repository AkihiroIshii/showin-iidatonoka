<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 景品
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <div style="display:flex;">
            <div class="px-6 py-4 text-lg font-semibold">
                ＞ 景品一覧
            </div>
            <div class="px-6 py-4 text-lg">
                <a href="{{route('gift.howtoget')}}" class="text-blue-600 font-semibold">コイン取得方法</a>
            </div>
        </div>

        <!-- 景品表示 -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">カテゴリ</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">景品名</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">必要なコイン数</th>
                </tr>
                @foreach($gifts as $gift)
                    @php
                        if ($gift->category == "カード") {
                            $trClass = 'bg-green-100';
                        } elseif ($gift->category == "おもちゃ") {
                            $trClass = 'bg-yellow-100';
                        } else {
                            $trClass = 'bg-sky-100';
                        }
                    @endphp
                    <tr class="{!! $trClass !!}">
                        <td class="border border-slate-300 px-4">{{$gift->category}}</td>
                        <td class="border border-slate-300 px-4">{{$gift->name}}</td>
                        <td class="border border-slate-300 px-4">{{$gift->coin}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>