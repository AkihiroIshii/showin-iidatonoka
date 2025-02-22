<x-app-layout>
    <x-slot name="header">
        @include('layouts.pastexam') <!-- 過去問演習　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習＞記録一覧
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <x-h3>これまでの演習量</x-h3>
        <div style="padding-left:4px;display:flex;justify-content:center;">
            <div style="margin-right:80px;">
                <h3 style="text-align:center;">{{$user->name}}</h3>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問数</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">時間</td>
                    </tr>
                    @isset($records_sum_this_user)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$records_sum_this_user->count}}問</td>
                        <td class="border border-slate-300 px-4">{{$records_sum_this_user->sum_hour}}時間</td>
                    </tr>
                    @else
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </table>
            </div>
            <div>
                <h3 style="text-align:center;">塾内トップ</h3>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問数</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">時間</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 px-4">{{$records_sum_top_user->count}}問</td>
                        <td class="border border-slate-300 px-4">{{$records_sum_top_user->sum_hour}}時間</td>
                    </tr>
                </table>
            </div>
        </div>

        <x-h3>演習記録一覧</x-h3>
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">解いた日</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">初回</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">得点/配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">得点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">解答時間(分)</td>
                </tr>
                @foreach($records as $record)
                <tr>
                    <th class="border border-slate-300 px-4 w-1/12">
                        <a href="{{route('record.edit', $record)}}" class="text-blue-600">編集</a>
                    </td>
                    <td class="border border-slate-300 px-4">{{$record->date}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->year}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->no}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->content}}</td>
                    <td class="border border-slate-300 px-4">{{$record->first_charange}}</td>
                    <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->question->point}}</td>
                    <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->target_score}}{{$record->target_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$record->minute}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>