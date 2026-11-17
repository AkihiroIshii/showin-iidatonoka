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
                <a href="{{route('workbook.unit.linear_equation4')}}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>

            <div class="text-center">
                問．次の方程式を解きなさい。
                $$ \frac{ {{ $c }} }{ \,{{ $a }}x + {{ $b}}\, } = {{ $d }} $$
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
                        与式の両辺に \( ({{ $a }}x + {{ $b}}) \) をかけて、
                        $$ {{ $c }} = {{ $d }}({{ $a }}x + {{ $b}}) $$
                        右辺を分配法則で整理して、
                        $$
                        {{ $c }} = {{ $a * $d }}x
                        @if ( $b * $d > 0 )
                            + {{ $b * $d }}
                        @else
                            {{ $b * $d }}
                        @endif
                        $$
                        \(x\)の項を左辺に、\({{ $c }}\)は右辺に移項してまとめると、
                        $$ {{ -1 * $a * $d }}x =  {{ $b * $d - $c }} $$
                        両辺に \({{ -1 * $a * $d }}\) の逆数をかけて、
                        $$
                        x = {{ $b * $d - $c }} \times \frac{ 1 }{ {{ -1 * $a * $d }} }
                        = {{ $ans_sign }}
                        @if ($denominator == 1)
                            {{ $numerator }}
                        @else
                            \frac{ {{ $numerator }} }{ \,{{ $denominator }}\, }
                        @endif
                        $$
                        (※)\(\displaystyle \frac{c}{\,ax+b\,}=d\) の方程式は \(adx = c-bd\) と変形できるので、一次方程式に分類した。
                    </div>
                </details>                    
            </p>
        </div>
    </div>
</x-app-layout>