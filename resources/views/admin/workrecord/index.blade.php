<x-app-layout>
    @if(Auth::user()->role == "admin")
    <x-slot name="header">
            @include('layouts.adminmenu')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ワーク演習（管理者）＞{{ $user->name }}
            </h2>
        </x-slot>
        <div class="mx-auto px-6">
            <a href="{{route('admin.workrecord.create', $user)}}" :active="request()->routeIs('admin.workrecord.create')" class="text-blue-600">新規登録</a>
            <x-h3>演習記録一覧</x-h3>
            <div>
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
                            <a href="{{route('admin.workrecord.edit', $workrecord)}}" class="text-blue-600">編集</a>
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
    @endif
</x-app-layout>