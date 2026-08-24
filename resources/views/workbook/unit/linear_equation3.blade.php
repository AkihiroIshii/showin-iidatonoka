<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 一次方程式(3)
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
                <a href="{{route('workbook.unit.linear_equation3')}}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>

            <div class="text-center">
                問．次の方程式を解きなさい。
                $$ \frac{ {{ $a }} }{\,x\,} = {{ $b }} $$
            </div>

            <p>
                <details class="text-center">
                    <summary class="text-red-400 font-bold">答え</summary>
                    <div class="inline-block items-center text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200">
                        $$
                        x = {{ $ans_sign }}
                        @if ($denominator == 1)
                            {{ $numerator }}
                        @else
                            \frac{ {{ $numerator }} }{ \,{{ $denominator }}\, }
                        @endif
                        $$
                    </div>
                    <p>＜解説＞</p>
                    <div>
                        与式の両辺を \(x\) 倍して、
                        $$ {{ $a }} = {{ $b }}x $$
                        両辺を入れ替えて、
                        $$ {{ $b }}x = {{ $a }} $$
                        両辺に \({{ $b }}\) の逆数をかけて、
                        $$
                        x = {{ $a }} \times \frac{ 1 }{ {{ $b }} }
                        = {{ $ans_sign }}
                        @if ($denominator == 1)
                            {{ $numerator }}
                        @else
                            \frac{ {{ $numerator }} }{ \,{{ $denominator }}\, }
                        @endif
                        $$
                        (※)\(\displaystyle \frac{a}{\,x\,}=b\) の方程式は \(bx = a\) と変形できるので、一次方程式に分類した。
                    </div>
                </details>                    
            </p>
        </div>
    </div>
</x-app-layout>