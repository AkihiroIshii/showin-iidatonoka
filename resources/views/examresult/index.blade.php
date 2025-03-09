<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            試験結果
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <!-- 新規作成 -->
        @if(Auth::user()->role == "admin")
        <a href="{{route('examresult.create')}}" class="text-blue-600">新規作成</a>
        @endif
        <div class="ml-4 mt-4 mb-4 pl-4">
            <ul style="list-style:circle;">
                <li>５教科とも先生に答案を提出した回のみ表示されます。</li>
                <li>平均点が表示されない場合は、テスト成績表などを提出してください。</li>
            </ul>
        </div>

        <!-- スマホ表示用のコード -->
        <div class="sm:hidden">
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
        </div>

        <!-- PC表示用のコード -->
        <div class="hidden sm:block">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    @if(Auth::user()->role == "admin")
                        <th colspan="5"></th>
                    @else
                        <th colspan="4"></th>
                    @endif
                    <th colspan="6">得点／平均点</th>
                </tr>
                <tr class="bg-gray-300">
                    @if(Auth::user()->role == "admin")
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                    @endif
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">生徒</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">試験日</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">試験名</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">国語</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">社会</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">数学</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">理科</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">英語</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">５教科</td>
                </tr>
                @foreach($examresults as $examresult)
                    <tr>
                        @if(Auth::user()->role == "admin")
                            <th class="border border-slate-300 px-4 w-1/12">
                                <a href="{{route('examresult.edit', $examresult->id)}}" class="text-blue-600">編集</a>
                            </td>
                        @endif
                        <td class="border border-slate-300 px-4">{{$examresult->name}}</td>
                        <td class="border border-slate-300 px-4">{{$examresult->grade}}</td>
                        <td class="border border-slate-300 px-4">{{$examresult->exam_date}}</td>
                        <td class="border border-slate-300 px-4">{{$examresult->exam_name}}</td>
                        <td class="border border-slate-300 px-4">
                            <p>{{$examresult->score_japanese}}／{{$examresult->avg_japanese}}</p>
                            <p>平均 {{$examresult->avg_diff_japanese}}</p>
                            <p>前回 {{$examresult->prev_diff_japanese}}</p>
                        </td>
                        <td class="border border-slate-300 px-4">
                            <p>{{$examresult->score_society}}／{{$examresult->avg_society}}</p>
                            <p>平均 {{$examresult->avg_diff_society}}</p>
                            <p>前回 {{$examresult->prev_diff_society}}</p>
                        </td>
                        <td class="border border-slate-300 px-4">
                            <p>{{$examresult->score_math}}／{{$examresult->avg_math}}</p>
                            <p>平均 {{$examresult->avg_diff_math}}</p>
                            <p>前回 {{$examresult->prev_diff_math}}</p>
                        </td>
                        <td class="border border-slate-300 px-4">
                            <p>{{$examresult->score_science}}／{{$examresult->avg_science}}</p>
                            <p>平均 {{$examresult->avg_diff_science}}</p>
                            <p>前回 {{$examresult->prev_diff_science}}</p>
                        </td>
                        <td class="border border-slate-300 px-4">
                            <p>{{$examresult->score_english}}／{{$examresult->avg_english}}</p>
                            <p>平均 {{$examresult->avg_diff_english}}</p>
                            <p>前回 {{$examresult->prev_diff_english}}</p>
                        </td>
                        <td class="border border-slate-300 px-4">
                            <p>{{$examresult->sum_score}}／{{$examresult->sum_avg}}</p>
                            <p>平均 {{$examresult->avg_diff_all}}</p>
                            <p>前回 {{$examresult->prev_diff_all}}</p>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>