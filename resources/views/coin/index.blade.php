<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            コイン（AI-Showin以外）
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp
        
        <!-- コイン合計 -->
        <div class="text-center">
            <p class="text-xl">合計：<span>{{$allCoins}}コイン</span></p>
            <p class="text-sm">AI-Showinのコインと合算して使えます(^^)/</p>
        </div>

        <!-- 新規作成 -->
        @if(Auth::user()->role == "admin")
            <a href="{{route('coin.create', $user)}}" class="text-blue-600">新規作成</a>
        @endif

        <!-- スマホ表示用 -->
        <div class="sm:hidden">
            <!-- 普段の目標を表示 -->
            @foreach($coins as $coin)
                <div class="bg-sky-100 mb-4 p-2">
                    <p>{{$coin->change_date}}</p>
                    <p>{{$coin->memo}}</p>
                    <p>{{$coin->coin}}コイン</p>
                </div>
            @endforeach
        </div>

        <!-- PC表示用 -->
        <div class="hidden sm:block mb-6 max-w-full">

            <table class="border-separate border border-slate-400 m-auto table-fixed mt-2">
                <tr class="bg-gray-300">
                    @if(Auth::user()->role == "admin")
                        <th></th>
                    @endif
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">日付</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">コイン数</td>
                </tr>
                @foreach($coins as $coin)
                    <tr>
                        @if(Auth::user()->role == "admin")
                            <th class="border border-slate-300 px-4 w-1/12">
                                <a href="{{route('coin.edit', $coin)}}" class="text-blue-600">編集</a>
                            </th>
                        @endif
                        <td class="border border-slate-300 px-4">{{$coin->change_date}}</td>
                        <td class="border border-slate-300 px-4">{{$coin->memo}}</td>
                        <td class="border border-slate-300 px-4">{{$coin->coin}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        
    </div>
</x-app-layout>