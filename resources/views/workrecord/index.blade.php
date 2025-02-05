<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ワーク演習＞記録一覧
        </h2>
    </x-slot>
    <div class="ml-4 mt-2 mb-2">
        <a href="{{route('workrecord.create')}}" :active="request()->routeIs('workrecord.create')" class="text-blue-600 font-bold">新規登録</a>
    </div>
    <div class="mx-auto px-6">
        <x-h3>演習記録一覧</x-h3>
        <div>
            <p class="ml-8 mt-4 mb-4">１週するごとに先生に報告してください。</p>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th colspan="7"></th>
                    <th colspan="3">学習完了日</th>
                </tr>
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">試験日</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">試験名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">ワーク名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">範囲</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">メモ</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">１周目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">２周目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">３周目</td>
                </tr>
                @foreach($workrecords as $workrecord)
                    <tr>
                        <th class="border border-slate-300 px-4 w-1/12">
                            <a href="{{route('workrecord.edit', $workrecord)}}" class="text-blue-600">編集</a>
                        </th>
                        <td class="border border-slate-300 px-4">{{$workrecord->exam_date}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->exam_name}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->subject}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->work_name}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->work_range}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->memo}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->date_1st}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->date_2nd}}</td>
                        <td class="border border-slate-300 px-4">{{$workrecord->date_3rd}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>