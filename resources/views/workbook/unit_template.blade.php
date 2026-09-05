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
    <div class="mx-auto p-6">
        <div class="mx-auto px-6">

            <div class="relative">
                <!-- 単元一覧画面へ -->
                <a href="{{route('workbook.unitbasedlist')}}" class="text-blue-600 font-bold">単元一覧画面へ</a>

                <form method="GET" action="{{ url()->current() }}" class="inline-block">
                    <!-- 和訳のみなど絞る場合はチェックボックスを表示 -->
                    @isset($subject)
                        <div class="flex gap-4">
                        @if ($subject == "eng")
                            <label class="px-6">
                                <input type="checkbox" name="ja" value="1"
                                    {{ request('ja') ? 'checked' : '' }}>
                                和訳
                            </label>

                            <label>
                                <input type="checkbox" name="en" value="1"
                                    {{ request('en') ? 'checked' : '' }}>
                                英訳
                            </label>
                        @elseif ($subject == "kanji")
                            <label class="px-6">
                                <input type="checkbox" name="r" value="1"
                                    {{ request('r') ? 'checked' : '' }}>
                                読み
                            </label>

                            <label>
                                <input type="checkbox" name="w" value="1"
                                    {{ request('w') ? 'checked' : '' }}>
                                書き
                            </label>
                        @elseif ($subject == "science")
                            <label class="px-6">
                                <input type="checkbox" name="term" value="1"
                                    {{ request('term') ? 'checked' : '' }}>
                                用語
                            </label>

                            <label>
                                <input type="checkbox" name="calc" value="1"
                                    {{ request('calc') ? 'checked' : '' }}>
                                計算
                            </label>
                        @endif
                        </div>
                    @endisset

                    <button type="submit" class="absolute left-1/2 -translate-x-1/2 top-0 inline-block p-2 rounded shadow bg-blue-200 font-bold">
                        次の問題
                    </button>
                </form>
            </div>
            {{-- <div class="py-4 text-center">
                <a href="{{ url()->current() }}?type=1" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div> --}}

            {{-- <div class="text-center leading-[8]">
                <p class="text-lg m-4">{{ $question['q'] }}</p>
            </div> --}}
            {{-- q_type : 1:短文（数式なし）、2:短文（数式あり）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ(旧)、6:グラフ(新) --}}
            {{-- 5:グラフ(旧)はq,a,eいずれかにしか$plotsを渡せなかったため、それぞれ渡せるように6:グラフ(新)を追加した。--}}
            <div class="text-center mt-4 mb-4">
                <div class="inline-block text-center leading-[3] font-klee text-lg">
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
                    @elseif ($question['q_type'] == 5)
                        <p class="text-lg m-4">{!! $question['q'] !!}</p>
                        <div class="flex justify-center">
                            <svg width="{{ $plot_para['w_full'] }}" height="{{ $plot_para['w_full'] }}"
                                viewBox="-{{ $plot_para['w_half'] }} -{{ $plot_para['w_half'] }} {{ $plot_para['w_full'] }} {{ $plot_para['w_full'] }}"
                                class="border">
                                {!! $plot_contents !!}
                            </svg>
                        </div>
                    @elseif ($question['q_type'] == 6)
                        <p class="text-lg m-4">{!! $question['q'] !!}</p>
                        <div class="flex justify-center">
                            <svg width="{{ $plot_par_q['w_full'] }}" height="{{ $plot_par_q['w_full'] }}"
                                viewBox="-{{ $plot_par_q['w_half'] }} -{{ $plot_par_q['w_half'] }} {{ $plot_par_q['w_full'] }} {{ $plot_par_q['w_full'] }}"
                                class="border">
                                {!! $plot_con_q !!}
                            </svg>
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
                            {{-- <div class="pl-5 text-left"> --}}
                            {{-- <div> --}}
                                {!! $question['a'] !!}
                            {{-- </div> --}}
                        @elseif ($question['a_type'] == 5)
                            <div class="flex justify-center">
                                <svg width="{{ $plot_para['w_full'] }}" height="{{ $plot_para['w_full'] }}"
                                    viewBox="-{{ $plot_para['w_half'] }} -{{ $plot_para['w_half'] }} {{ $plot_para['w_full'] }} {{ $plot_para['w_full'] }}"
                                    class="border">
                                    {!! $plot_contents !!}
                                </svg>
                            </div>
                        @elseif ($question['a_type'] == 6)
                            <p class="text-lg m-4">{!! $question['a'] !!}</p>
                            <div class="flex justify-center">
                                <svg width="{{ $plot_par_a['w_full'] }}" height="{{ $plot_par_a['w_full'] }}"
                                    viewBox="-{{ $plot_par_a['w_half'] }} -{{ $plot_par_a['w_half'] }} {{ $plot_par_a['w_full'] }} {{ $plot_par_a['w_full'] }}"
                                    class="border">
                                    {!! $plot_con_a !!}
                                </svg>
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
                            {{-- <div class="pl-5 text-left"> --}}
                            {{-- <div> --}}
                                {!! $question['e'] !!}
                            {{-- </div> --}}
                        @elseif ($question['e_type'] == 6)
                            <p class="text-lg m-4">{!! $question['e'] !!}</p>
                            <div class="flex justify-center">
                                <svg width="{{ $plot_par_e['w_full'] }}" height="{{ $plot_par_e['w_full'] }}"
                                    viewBox="-{{ $plot_par_e['w_half'] }} -{{ $plot_par_e['w_half'] }} {{ $plot_par_e['w_full'] }} {{ $plot_par_e['w_full'] }}"
                                    class="border">
                                    {!! $plot_con_e !!}
                                </svg>
                            </div>
                        @endif
                    </div>

                </details>                    
            </div>
        </div>
    </div>
</x-app-layout>