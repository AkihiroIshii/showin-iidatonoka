<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録一覧（管理者）＞{{ $user->name }}
        </h2>
    </x-slot>
    <div class="px-6 py-4 text-lg">
        <a href="{{route('admin.spreadsheet', $user)}}" class="text-blue-600 font-semibold">集計表</a>
    </div>
    <div class="mx-auto px-6">
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">解いた日</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">生徒名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">種類</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">得点/配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">得点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">解答時間(分)</td>
                </tr>
                @foreach($records as $record)
                <tr>
                    <th class="border border-slate-300 px-4 w-1/12"></td>
                    <td class="border border-slate-300 px-4">{{$record->date}}</td>
                    <td class="border border-slate-300 px-4">{{$record->user->name}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->type}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->year}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->no}}</td>
                    <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->question->point}}</td>
                    <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->target_score}}{{$record->target_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$record->minute}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>