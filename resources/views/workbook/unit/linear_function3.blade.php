<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 {{ $unitname }}
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
                <a href="{{ url()->current() }}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>

            <div class="text-center leading-[3]">
                {!! $question['q'] !!}
            </div>

            <p>
                <details class="text-center">
                    <summary class="text-red-400 font-bold">答え</summary>
                    <div class="inline-block items-center text-center m-4 p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200">
                        \(\displaystyle {{ $question['a'] }}\)
                    </div>
                    <p class="text-lg">＜解説＞</p>
                    <div class="leading-[3]">
                        {!! $question['e'] !!}
                        <div class="flex justify-center">
                            <svg width="{{ $plots['w_full'] }}" height="{{ $plots['w_full'] }}"
                                viewBox="-{{ $plots['w_half'] }} -{{ $plots['w_half'] }} {{ $plots['w_full'] }} {{ $plots['w_full'] }}"
                                class="border bg-pink-200">

                                <!-- x軸 -->
                                <line x1="-{{ $plots['w_half'] }}" y1="0" x2="{{ $plots['w_half'] }}" y2="0"
                                    stroke="black" />

                                <!-- y軸 -->
                                <line x1="0" y1="-{{$plots['w_half'] }}" x2="0" y2="{{ $plots['w_half'] }}"
                                    stroke="black" />

                                <!-- y = ax -->
                                <line x1="{{ $plots['from_x'] }}" y1="{{ -$plots['from_y'] }}"
                                    x2="{{ $plots['to_x'] }}" y2="{{ -$plots['to_y'] }}"
                                    stroke="red"
                                    stroke-width="2" />

                                <circle
                                    cx="0"
                                    cy="{{ -$plots['b'] * $plots['scale'] }}"
                                    r="5"
                                    fill="red"
                                />

                                <text
                                    x="10"
                                    y="{{ -$plots['b'] * $plots['scale'] }}"
                                    font-size="16"
                                >
                                    (0, {{ $plots['b'] }})
                                </text>

                                <circle
                                    cx="{{ $plots['p_x'] * $plots['scale'] }}"
                                    cy="{{ -$plots['p_y'] * $plots['scale'] }}"
                                    r="5"
                                    fill="red"
                                />

                                <text
                                    x="{{ $plots['p_x'] * $plots['scale'] + 10 }}"
                                    y="{{ -$plots['p_y'] * $plots['scale'] + 10 }}"
                                    font-size="16"
                                >
                                    P(
                                        {{ $plots['p_x'] }},
                                        {{ $plots['p_y'] }}
                                    )                                        
                                </text>

                                <circle
                                    cx="{{ $plots['q_x'] * $plots['scale'] }}"
                                    cy="{{ -$plots['q_y'] * $plots['scale'] }}"
                                    r="5"
                                    fill="red"
                                />

                                <text
                                    x="{{ $plots['q_x'] * $plots['scale'] + 10 }}"
                                    y="{{ -$plots['q_y'] * $plots['scale'] + 10 }}"
                                    font-size="16"
                                >
                                    Q(
                                        {{ $plots['q_x'] }},
                                        {{ $plots['q_y'] }}
                                    )                                        
                                </text>
                            </svg>
                        </div>
                    </div>

                </details>                    
            </p>
        </div>
    </div>
</x-app-layout>