<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 一次関数（交点の座標）
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
                <a href="{{route('workbook.unit.plot_linear_function2')}}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>

            <div class="text-center">
                問．次の２つの関数について、交点の座標を求めなさい。
                $$ y =
                @if ($a == 1)
                    x
                @elseif ($a == -1)
                    -x
                @else
                    {{ $a }}x
                @endif
                @if ($b >= 0)
                    +
                @endif
                {{ $b }}
                ,\,\,\,
                y =
                @if ($c == 1)
                    x
                @elseif ($c == -1)
                    -x
                @else
                    {{ $c }}x
                @endif
                @if ($d >= 0)
                    +
                @endif
                {{ $d }}
                $$
            </div>

                <details class="text-center">
                    <summary class="text-red-400 font-bold">答え</summary>
                    <div class="inline-block items-center text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200">
                        $$ ({{ $plots['p_x'] }}, {{ $plots['p_y'] }}) $$
                    </div>

                    <p>＜解説＞</p>
                    <div class="inline-block p-2 mb-2 text-left">
                        <p>２つの関数の交点では \( (x,y) \) がともに一致するので、連立方程式の解を求めればよい。</p>
                        <p>なお、グラフは下図のようになる。</p>
                    </div>

                    <div class="flex justify-center">
                        <svg width="{{ $plots['w_full'] }}" height="{{ $plots['w_full'] }}"
                            viewBox="-{{ $plots['w_half'] }} -{{ $plots['w_half'] }} {{ $plots['w_full'] }} {{ $plots['w_full'] }}"
                            class="border">

                            <!-- x軸 -->
                            <line x1="-{{ $plots['w_half'] }}" y1="0" x2="{{ $plots['w_half'] }}" y2="0"
                                stroke="black" />

                            <!-- y軸 -->
                            <line x1="0" y1="-{{$plots['w_half'] }}" x2="0" y2="{{ $plots['w_half'] }}"
                                stroke="black" />

                            <!-- y = ax + b -->
                            <line x1="{{ $plots['from_x'] }}" y1="{{ -$plots['from_y1'] }}"
                                x2="{{ $plots['to_x'] }}" y2="{{ -$plots['to_y1'] }}"
                                stroke="red"
                                stroke-width="2" />

                            <!-- y = cx + d -->
                            <line x1="{{ $plots['from_x'] }}" y1="{{ -$plots['from_y2'] }}"
                                x2="{{ $plots['to_x'] }}" y2="{{ -$plots['to_y2'] }}"
                                stroke="red"
                                stroke-width="2" />

                            <circle
                                cx="{{ $plots['p_x'] * $plots['scale'] }}"
                                cy="{{ -$plots['p_y'] * $plots['scale'] }}"
                                r="5"
                                fill="red"
                            />

                            <text
                                x="{{ $plots['p_x'] * $plots['scale'] + 10 }}"
                                y="{{ -$plots['p_y'] * $plots['scale'] }}"
                                font-size="16"
                            >
                                ({{ $plots['p_x'] }}, {{ $plots['p_y'] }})
                            </text>
                        </svg>
                    </div>
                </details>                    
        </div>
    </div>
</x-app-layout>