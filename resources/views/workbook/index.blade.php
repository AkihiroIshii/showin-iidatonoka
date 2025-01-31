<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            練習問題
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp

        <!-- 問題表示 -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">分野</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">対象学年</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">問題</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">答え</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">参考</td>
                </tr>
                @foreach($workbooks as $workbook)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$workbook->subject}}</td>
                        <td class="border border-slate-300 px-4">{{$workbook->field}}</td>
                        <td class="border border-slate-300 px-4">{{$workbook->grade}}</td>
                        <td class="border border-slate-300 px-4">{{$workbook->question}}</td>
                        <td class="border border-slate-300 px-4">
                            <details>
                                <summary>答え</summary>
                                <p>{!! $workbook->answer !!}</p>
                            </details>    
                        </td>
                        <td class="border border-slate-300 px-4">
                            <details>
                                <summary>参考</summary>
                                <p>{!! $workbook->reference !!}</p>
                            </details>    
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>