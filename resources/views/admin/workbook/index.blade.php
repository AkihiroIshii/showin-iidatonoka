<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            練習問題
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <a href="{{route('admin.workbook.create')}}" :active="request()->routeIs('admin.workbook.create')" class="text-blue-600">新規登録</a>

        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp

        <!-- 問題表示 -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th class="px-8">編集</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">分野</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">対象学年</td>
                    <div class="w-5/6">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">問題</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/4">答え</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/4">参考</td>
                    </div>
                </tr>
                @foreach($workbooks as $workbook)
                    @php
                        if($workbook->subject == '国語') {
                            $trClass = 'bg-pink-100';
                        } elseif($workbook->subject == '数学' | $workbook->subject == '算数') {
                            $trClass = 'bg-sky-100';
                        } elseif($workbook->subject == '社会') {
                            $trClass = 'bg-yellow-100';
                        } elseif($workbook->subject == '理科') {
                            $trClass = 'bg-green-100';
                        } elseif($workbook->subject == '英語') {
                            $trClass = 'bg-purple-100';
                        }
                    @endphp
                    <tr class={!! $trClass !!}>
                        <td>
                            <a href="{{route('admin.workbook.edit', $workbook)}}" class="text-blue-600">●</a>
                        </td>
                        <td class="border border-slate-300 text-center">{{$workbook->subject}}</td>
                        <td class="border border-slate-300 text-center">{{$workbook->field}}</td>
                        <td class="border border-slate-300 text-center">{{$workbook->grade}}</td>
                        <td class="border border-slate-300 px-4">{!! $workbook->question !!}</td>
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