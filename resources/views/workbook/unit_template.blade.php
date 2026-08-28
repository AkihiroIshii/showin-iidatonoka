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
                {{-- <a href="{{route('workbook.unit.regular_polygon')}}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a> --}}
                <a href="{{ url()->current() }}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>

            {{-- <div class="text-center leading-[8]">
                <p class="text-lg m-4">{{ $question['q'] }}</p>
            </div> --}}
            {{-- q_type : 1:短文（数式なし）、2:短文（数式あり）、3:複数行（htmlタグあり）、4:2行（変数あり） --}}
            <div class="text-center mb-4">
                <div class="text-center leading-[3] font-klee text-lg">
                    @if ($question['q_type'] == 1)
                        <p class="m-4">{{ $question['q'] }}</p>
                    @elseif ($question['q_type'] == 2)
                        \(\displaystyle {{ $question['q'] }} \)
                    @elseif ($question['q_type'] == 3)
                        {!! $question['q'] !!}
                    @elseif ($question['q_type'] == 4)
                        <div class="text-center leading-[8]">
                            <p class="text-lg m-4">{{ $question['q1'] }}</p>
                            <p class="text-3xl m-4">{{ $question['q2'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <details class="text-center">
                    <summary class="text-red-400 font-bold">答え</summary>
                    <div class="inline-block items-center text-center m-4 p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200 font-klee text-lg">
                        @if ($question['a_type'] == 1)
                            <p class="text-3xl m-4">{{ $question['a'] }}</p>
                        @elseif ($question['a_type'] == 2)
                            \(\displaystyle {{ $question['a'] }} \)
                        @elseif ($question['a_type'] == 3)
                            <div class="pl-5 text-left">
                                {!! $question['a'] !!}
                            </div>
                        @endif
                    </div>
                    <p class="text-lg">＜解説＞</p>
                    <div class="inline-block leading-[3] font-klee text-lg">
                        @if ($question['e_type'] == 1)
                            <p class="m-4">{{ $question['e'] }}</p>
                        @elseif ($question['e_type'] == 2)
                            \(\displaystyle {{ $question['e'] }} \)
                        @elseif ($question['e_type'] == 3)
                            <div class="pl-5 text-left">
                                {!! $question['e'] !!}
                            </div>
                        @endif
                    </div>

                </details>                    
            </div>
        </div>
    </div>
</x-app-layout>