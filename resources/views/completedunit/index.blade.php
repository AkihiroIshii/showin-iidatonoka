<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クリアした単元
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <!-- 新規作成 -->
        @if(Auth::user()->role == "admin")
        <a href="{{route('completedunit.create')}}" class="text-blue-600">新規作成</a>
        @endif

        <!-- スマホ表示用のコード -->
        {{-- <div class="sm:hidden">
            <x-h3>学校の試験</x-h3>
            @foreach($examresults as $examresult)
                <div class="bg-sky-100 mb-4 p-2">
                    <p class="font-bold">{{$examresult->exam_date}}：{{$examresult->exam_name}}（{{$examresult->name}}）<p>
                    <div class="ml-4">
                        国語　{{$examresult->score_japanese}}
                        （平均 {{$examresult->avg_diff_japanese}}　前回 {{$examresult->prev_diff_japanese}}）
                    </div>
                    <div class="ml-4">
                        社会　{{$examresult->score_society}}
                        （平均 {{$examresult->avg_diff_society}}　前回 {{$examresult->prev_diff_society}}）
                    </div>
                    <div class="ml-4">
                        数学　{{$examresult->score_math}}
                        （平均 {{$examresult->avg_diff_math}}　前回 {{$examresult->prev_diff_math}}）
                    </div>
                    <div class="ml-4">
                        理科　{{$examresult->score_science}}
                        （平均 {{$examresult->avg_diff_science}}　前回 {{$examresult->prev_diff_science}}）
                    </div>
                    <div class="ml-4">
                        英語　{{$examresult->score_english}}
                        （平均 {{$examresult->avg_diff_english}}　前回 {{$examresult->prev_diff_english}}）
                    </div>
                    <hr class="border-gray-400">
                    <div class="">
                        ５教科　{{$examresult->sum_score}}
                        （平均 {{$examresult->avg_diff_all}}　前回 {{$examresult->prev_diff_all}}）
                    </div>
                </div>
            @endforeach

            <x-h3>模試</x-h3>
            @foreach($moshiresults as $moshiresult)
                <div class="bg-sky-100 mb-4 p-2">
                    <p class="font-bold">{{$moshiresult->exam_date}}：{{$moshiresult->exam_name}}（{{$moshiresult->name}}）<p>
                    <div class="ml-4">
                        国語　{{$moshiresult->score_japanese}}
                        （平均 {{$moshiresult->avg_diff_japanese}}　前回 {{$moshiresult->prev_diff_japanese}}）
                    </div>
                    <div class="ml-4">
                        社会　{{$moshiresult->score_society}}
                        （平均 {{$moshiresult->avg_diff_society}}　前回 {{$moshiresult->prev_diff_society}}）
                    </div>
                    <div class="ml-4">
                        数学　{{$moshiresult->score_math}}
                        （平均 {{$moshiresult->avg_diff_math}}　前回 {{$moshiresult->prev_diff_math}}）
                    </div>
                    <div class="ml-4">
                        理科　{{$moshiresult->score_science}}
                        （平均 {{$moshiresult->avg_diff_science}}　前回 {{$moshiresult->prev_diff_science}}）
                    </div>
                    <div class="ml-4">
                        英語　{{$moshiresult->score_english}}
                        （平均 {{$moshiresult->avg_diff_english}}　前回 {{$moshiresult->prev_diff_english}}）
                    </div>
                    <hr class="border-gray-400">
                    <div class="">
                        ５教科　{{$moshiresult->sum_score}}
                        （平均 {{$moshiresult->avg_diff_all}}　前回 {{$moshiresult->prev_diff_all}}）
                    </div>
                </div>
            @endforeach
        </div> --}}

        <!-- PC表示用のコード -->
        <div class="hidden sm:block">
            <x-h3>AI-Showin</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    @if(Auth::user()->role == "admin")
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                    @endif
                    <x-th>単元名</x-th>
                    <x-th>レベル数</x-th>
                    <x-th>学習モード周回数</x-th>
                    <x-th>クリアした日</x-th>
                    <x-th>内容</x-th>
                </tr>
                @foreach($completed_unit_aishowins as $completed_unit_aishowin)
                    <tr>
                        @if(Auth::user()->role == "admin")
                            <x-td>
                                <a href="{{route('completedunit.edit', $completed_unit_aishowin->id)}}" class="text-blue-600">編集</a>
                            </x-td>
                        @endif
                        <x-td>{{$completed_unit_aishowin->unit}}</x-td>
                        <x-td>{{$completed_unit_aishowin->num_level}}</x-td>
                        <x-td>{{$completed_unit_aishowin->num_loop}}</x-td>
                        <x-td>{{$completed_unit_aishowin->completed_date}}</x-td>
                        <x-td>{{$completed_unit_aishowin->explanation}}</x-td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
</x-app-layout>