<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @include('layouts.pastexam') <!-- 過去問演習　共通メニュー -->
            過去問演習＞集計表２（年度区別なし）
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <div>
            @php
                // $questionsを6レコードずつ分割
                $chunkedQuestions = $questions->chunk(6);
            @endphp
            @foreach($groupedQuestions as $subject => $chunks)
                <h3>科目：{{$subject}}</h3>
                <table class="border-separate border border-slate-400 m-auto table-fixed whitespace-nowrap">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最新年度の内容</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">挑戦回数</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均配点</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最高点/目標点</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均点/目標点</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均(分)</td>
                    </tr>
                    @foreach($chunks as $chunk)
                        @foreach($chunk as $question)
                            <tr>
                                <td class="border border-slate-300 px-4">{{$question->subject}}</td>
                                <td class="border border-slate-300 px-4">{{$question->no}}</td>
                                <td class="border border-slate-300 px-4">{{$question->content}}</td>
                                <td class="border border-slate-300 px-4">{{$question->count}}</td>
                                <td class="border border-slate-300 px-4">{{$question->avg_point}}</td>
                                <td class="border border-slate-300 px-4">{{$question->max_score}}/{{$question->target_score}}{{$question->max_mark}}</td>
                                <td class="border border-slate-300 px-4">{{$question->avg_score}}/{{$question->target_score}}{{$question->avg_mark}}</td>
                                <td class="border border-slate-300 px-4">{{$question->avg_minute}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            @endforeach
        </div>
    </div>
</x-app-layout>