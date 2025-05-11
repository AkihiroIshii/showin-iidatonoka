<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                試験一覧（管理者）
            </h2>
        </x-slot>
        <div class="mx-auto px-6">
            <!-- 新規作成 -->
            <a href="{{route('exam.create')}}" class="text-blue-600">新規作成</a>

            <!-- テスト結果を表示 -->
            <div class="mb-6">
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th colspan="8"></th>
                        <th colspan="5">平均点</th>
                    </tr>
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">ID</th>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学校名</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">項番</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">試験日</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">試験名</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">国語</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">社会</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">数学</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">理科</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">英語</td>
                    </tr>
                    @foreach($exams as $exam)
                        @php
                            if ($exam->schoolName == "外部") { //なが模試の場合
                                $folder = 'moshi';
                                $tr_color = 'bg-green-100';
                            } else {
                                $folder = 'schoolexam';
                                if (strpos($exam->grade, '高') !== false) {
                                    $tr_color = 'bg-pink-100';
                                } elseif (strpos($exam->grade, '中３') !== false) {
                                    $tr_color = 'bg-sky-200';
                                } else {
                                    $tr_color = 'bg-sky-100';
                                }
                            }
                        @endphp
                        <tr class="{!!$tr_color!!}">
                            <th class="border border-slate-300 px-4 w-1/12">
                                <a href="{{route('exam.edit', $exam)}}" class="text-blue-600">編集</a>
                            </th>
                            <td class="border border-slate-300 px-4">
                                <a class="font-semibold text-blue-600" href="{{ route('exam.show', ['exam_id' => $exam->id, 'folder' => $folder]) }}">
                                    {{$exam->id}}
                                </a>
                            </td>
                            <td class="border border-slate-300 px-4">{{$exam->schoolName}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->year}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->grade}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->no}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->exam_date}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->exam_name}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->avg_japanese}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->avg_society}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->avg_math}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->avg_science}}</td>
                            <td class="border border-slate-300 px-4">{{$exam->avg_english}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</x-app-layout>