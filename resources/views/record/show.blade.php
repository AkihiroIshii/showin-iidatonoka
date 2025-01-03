<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録　個別表示
        </h2>
    </x-slot>
    ログインユーザID:{{ Auth::id() }}
    @if($record->user->id==Auth::id())
        <table class="border-separate border border-slate-400 m-auto table-fixed">
            <tr class="bg-gray-300">
                <th class="border border-slate-300 px-4 w-1/12"></td>
                <th class="border border-slate-300 px-4 w-1/12">解いた日</td>
                <th class="border border-slate-300 px-4 w-1/12">生徒名</td>
                <th class="border border-slate-300 px-4 w-1/12">問題の種類</td>
                <th class="border border-slate-300 px-4">年度</td>
                <th class="border border-slate-300 px-4">科目</td>
                <th class="border border-slate-300 px-4">大問番号</td>
                <th class="border border-slate-300 px-4 w-1/2">得点/配点</td>
                <th class="border border-slate-300 px-4 w-1/2">解答時間(分)</td>
            </tr>
            <tr>
                <th class="border border-slate-300 px-4 w-1/12">
                    <a href="{{route('record.edit', $record)}}" class="text-blue-600">編集</a>
                </td>
                <td class="border border-slate-300 px-4">{{$record->date}}</td>
                <td class="border border-slate-300 px-4">{{$record->user->name}}</td>
                <td class="border border-slate-300 px-4">{{$record->question->type}}</td>
                <td class="border border-slate-300 px-4">{{$record->question->year}}</td>
                <td class="border border-slate-300 px-4">{{$record->question->subject}}</td>
                <td class="border border-slate-300 px-4">{{$record->question->no}}</td>
                <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->question->point}}</td>
                <td class="border border-slate-300 px-4">{{$record->minute}}</td>
            </tr>
        </table>
    @endif
</x-app-layout>


<th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">得点/配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">得点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">解答時間(分)</td>
