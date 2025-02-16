<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            @include('layouts.adminmenu') <!-- 過去問演習　共通メニュー -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                過去問演習目標点数（管理者）＞{{ $user->name }}
            </h2>
        </x-slot>
        <div class="mx-auto px-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th class="border border-slate-300 px-4">科目</td>
                    <th class="border border-slate-300 px-4">大問番号</td>
                    <th class="border border-slate-300 px-4">目標点</td>
                    <th class="border border-slate-300 px-4">平均配点</td>
                    <th class="border border-slate-300 px-4">挑戦回数</td>
                    <th class="border border-slate-300 px-4">最高点</td>
                    <th class="border border-slate-300 px-4">平均点</td>
                    <th class="border border-slate-300 px-4">目標時間(分)</td>
                </tr>
                @foreach($targets as $target)
                <tr>
                    <td class="border border-slate-300 px-4">{{$target->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$target->no}}</td>
                    <th class="border border-slate-300 px-4">{{$target->target_score}}</td>
                    <td class="border border-slate-300 px-4">/{{$target->avg_point}}</td>
                    <td class="border border-slate-300 px-4">{{$target->count}}</td>
                    <td class="border border-slate-300 px-4">{{$target->max_score}}{{$target->max_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$target->avg_score}}{{$target->avg_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$target->target_minute}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    @endif
</x-app-layout>