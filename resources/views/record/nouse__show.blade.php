<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録　個別表示
        </h2>
    </x-slot>
    @if($record->user->id==Auth::id())
    <div>
        <table class="border-separate border border-slate-400 m-auto table-fixed">
            <tr class="bg-gray-300">
                <th class="border border-slate-300 px-4"></td>
                <th class="border border-slate-300 px-4">解いた日</td>
                <th class="border border-slate-300 px-4">生徒名</td>
                <th class="border border-slate-300 px-4">問題の種類</td>
                <th class="border border-slate-300 px-4">年度</td>
                <th class="border border-slate-300 px-4">科目</td>
                <th class="border border-slate-300 px-4">大問番号</td>
                <th class="border border-slate-300 px-4">得点/配点</td>
                <th class="border border-slate-300 px-4">解答時間(分)</td>
            </tr>
            <tr>
                <th class="border border-slate-300 px-4">
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
    </div>
    @endif
</x-app-layout> -->