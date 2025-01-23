<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の集計表（年度区別なし）
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <div style="display:flex;">
            <div class="px-6 py-4 text-lg">
                <a href="{{route('record.spreadsheet', $user)}}" class="text-blue-600 font-semibold">年度-科目-大問ごと</a>
            </div>
            <div class="px-6 py-4 text-lg font-semibold">
                ＞ 年度区別なし
            </div>
        </div>
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed whitespace-nowrap">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最新年度の内容</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">挑戦回数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最高点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均(分)</td>
                </tr>
                @foreach($questions as $question)
                <tr>
                    <td class="border border-slate-300 px-4">{{$question->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$question->no}}</td>
                    <td class="border border-slate-300 px-4">{{$question->content}}</td>
                    <td class="border border-slate-300 px-4">{{$question->count}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_point}}</td>
                    <td class="border border-slate-300 px-4">{{$question->max_score}}/{{$question->target_score}}{{$question->max_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_score}}/{{$question->target_score}}{{$question->avg_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_minute}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>