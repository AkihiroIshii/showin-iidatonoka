<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @else
            @include('layouts.pastexam')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習＞集計表(一覧形式)
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed whitespace-nowrap">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                    <!-- <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">配点</td> -->
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">挑戦回数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最後に解いた日</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最高点/配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">８割正解</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最高点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均(分)</td>
                    <!-- <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">メモ</td> -->
                </tr>
                @foreach($questions as $question)
                <tr>
                    <td class="border border-slate-300 px-4">{{$question->year}}</td>
                    <td class="border border-slate-300 px-4">{{$question->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$question->no}}</td>
                    <td class="border border-slate-300 px-4">{{$question->content}}</td>
                    <!-- <td class="border border-slate-300 px-4">{{$question->point}}</td> -->
                    <td class="border border-slate-300 px-4">{{$question->count}}</td>
                    <td class="border border-slate-300 px-4">{{$question->latest_date}}</td>
                    <td class="border border-slate-300 px-4">{{$question->max_score}}/{{$question->point}}({{$question->score_rate}}%)</td>
                    <td class="border border-slate-300 px-4">{{$question->max_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$question->max_score}}/{{$question->target_score}}{{$question->target_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_score}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_minute}}</td>
                    <!-- <td class="border border-slate-300 px-4">{{$question->memo}}</td> -->
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>