<x-app-layout>
    <x-slot name="header">
        @include('layouts.workbook_submenu') <!-- 問題集　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            練習問題
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
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
                    @if(Auth::user()->role == "admin")
                        <th class="px-8">編集</th>
                    @endif
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">対象学年</td>
                    <div class="w-5/6">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/2">問題</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/4">答え</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/4">解説</td>
                    </div>
                </tr>
                @foreach($workbooks as $i => $workbook)
                    {{-- @dd($workbooks)             --}}
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
                        @if(Auth::user()->role == "admin")
                            <td>
                                <a href="{{route('workbook.edit', $workbook)}}" class="text-blue-600">●</a>
                            </td>
                        @endif
                        <td class="border border-slate-300 text-center">{{$workbook->subject}}</td>
                        <td class="border border-slate-300 text-center">{{$workbook->grade}}</td>
                        <td class="border border-slate-300 px-4">{!! $workbook->question !!}</td>
                        <td class="border border-slate-300 px-4">
                            <details>
                                <summary>答えを見る
                                </summary>
                                <p>{!! $workbook->answer !!}</p>
                            </details>    
                        </td>
                        <td class="border border-slate-300 px-4">
                            <button type="button"
                                    onclick="showExplanation({{ $i }})"
                                    class="text-blue-600 underline">
                                解説
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <!-- モーダル -->
    <div id="explanationModal"
        class="hidden fixed inset-0 z-50 bg-black/50
                flex items-center justify-center p-4"
        onclick="if (event.target === this) closeExplanation()">

        <div class="bg-white rounded-lg shadow-lg
                    w-full max-w-2xl max-h-[80vh] overflow-y-auto">

            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-lg font-bold">
                    解説
                </h2>

                <button type="button"
                        onclick="closeExplanation()"
                        class="text-gray-500 text-2xl">
                    ×
                </button>
            </div>

            <div id="explanationContent" class="p-6">
            </div>

        </div>
    </div>

    <script>
        const questions = @json(
            collect($workbooks)->pluck('question')->values()
        );
        const answers = @json(
            collect($workbooks)->pluck('answer')->values()
        );
        const explanations = @json(
            collect($workbooks)->pluck('explanation')->values()
        );

        function showExplanation(index) {
            document.getElementById('explanationContent').innerHTML =
                "<p>問題：　" + questions[index]
                    + "</p><p>答え：　" + answers[index]
                    + "</p><p>解説：　" + explanations[index] + "</p>";

            document.getElementById('explanationModal')
                .classList.remove('hidden');
        }

        function closeExplanation() {
            document.getElementById('explanationModal')
                .classList.add('hidden');
        }
    </script>
</x-app-layout>