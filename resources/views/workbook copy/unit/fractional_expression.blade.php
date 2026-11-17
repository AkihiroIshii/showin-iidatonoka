<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 分数の文字式
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            <!-- 単元一覧画面へ -->
            <a href="{{route('workbook.unitbasedlist')}}" class="text-blue-600 font-bold">単元一覧画面へ</a>
            <div class="py-4 text-center">
                <a href="{{route('workbook.unit.fractional_expression')}}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>
            <div class="text-center">
                問．次の計算をしなさい。
                $$
                \frac{ \,a\, }{ {{ $p }} }
                @if ($q >= 0)
                    + {{ $q }}a
                @else
                    {{ $q }}a
                @endif
                $$
            </div>

            <details class="text-center">
                <summary class="text-red-400 font-bold">答え</summary>
                <div class="inline-block items-center text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200">
                    $$
                    {{ 1 + $p * $q < 0 ? "-" : "" }}
                    \frac{ \,{{ abs(1 + $p * $q) }}\, }{ {{ $p }} }a 
                    $$
                </div>
                <p>＜解説＞</p>
                <div>
                    $$
                    与式 = \frac{ a 
                        @if ($p * $q >= 0)
                            + {{ $p * $q }}a
                        @else
                            {{ $p * $q }}a
                        @endif
                        }{ {{ $p }} }
                    = \frac{ (1
                        @if ($p * $q >= 0)
                            + {{ $p * $q }}
                        @else
                            {{ $p * $q }}
                        @endif
                        )a}{ {{ $p }} }
                    =
                        {{ 1 + $p * $q < 0 ? "-" : "" }}
                        \frac{ \,{{ abs(1 + $p * $q) }}\, }{ {{ $p }} }a 
                    $$
                </div>
            </details>                    
        </div>
    </div>
</x-app-layout>