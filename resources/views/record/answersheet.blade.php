<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @else
            @include('layouts.pastexam')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            正答・配点
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            <!-- データセット -->
            @php
                $folder = 'pastexam';
                $years = [2025, 2024, 2023, 2022, 2021, 2020];
                $subjects = ['jap', 'math', 'soc', 'sci', 'eng'];
                $avg_score = [
                    2025 => ['jap' => 59.5, 'math' => 58.5, 'soc' => 70.0, 'sci' => 54.4, 'eng' => 59.2],
                    2024 => ['jap' => 54.9, 'math' => 49.0, 'soc' => 61.7, 'sci' => 49.2, 'eng' => 59.1],
                    2023 => ['jap' => 55.7, 'math' => 51.1, 'soc' => 56.9, 'sci' => 54.3, 'eng' => 45.0],
                    2022 => ['jap' => 47.8, 'math' => 46.5, 'soc' => 52.5, 'sci' => 39.0, 'eng' => 51.3],
                    2021 => ['jap' => 57.6, 'math' => 51.9, 'soc' => 63.5, 'sci' => 56.8, 'eng' => 59.9],
                    2020 => ['jap' => 72.7, 'math' => 55.9, 'soc' => 68.1, 'sci' => 53.2, 'eng' => 53.6]
                ] //本試験の平均点
            @endphp

            <!-- 表示部分 -->
            <p class="text-center">平均は、年度ごとの受験者の平均点です。</p>
            @for($i=0; $i<count($years); $i++)
                <!-- テスト結果を表示 -->
                <x-h3>{{$years[$i]}}年度</x-h3>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">国語</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">社会</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">数学</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">理科</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">英語</td>
                    </tr>
                    <!-- 平均点 -->
                    <tr>
                        <td class="border border-slate-300 px-4">平均：{{ $avg_score[$years[$i]]['jap'] }}</td>
                        <td class="border border-slate-300 px-4">平均：{{ $avg_score[$years[$i]]['soc'] }}</td>
                        <td class="border border-slate-300 px-4">平均：{{ $avg_score[$years[$i]]['math'] }}</td>
                        <td class="border border-slate-300 px-4">平均：{{ $avg_score[$years[$i]]['sci'] }}</td>
                        <td class="border border-slate-300 px-4">平均：{{ $avg_score[$years[$i]]['eng'] }}</td>
                    </tr>
                    {{-- <!-- 問題 -->
                    <tr>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'jap_q.pdf']) }}">問題</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'soc_q.pdf']) }}">問題</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'math_q.pdf']) }}">問題</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'sci_q.pdf']) }}">問題</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'eng_q.pdf']) }}">問題</a></td>
                    </tr>
                    <!-- 解答用紙 -->
                    <tr>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'jap_a.pdf']) }}">解答用紙</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'soc_a.pdf']) }}">解答用紙</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'math_a.pdf']) }}">解答用紙</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'sci_a.pdf']) }}">解答用紙</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'eng_a.pdf']) }}">解答用紙</a></td>
                    </tr> --}}
                    <!-- 正答・配点 -->
                    <tr>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'jap_e.pdf']) }}">正答・配点</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'soc_e.pdf']) }}">正答・配点</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'math_e.pdf']) }}">正答・配点</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'sci_e.pdf']) }}">正答・配点</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'eng_e.pdf']) }}">正答・配点</a></td>
                    </tr>
                    {{-- <!-- 石井コメント -->
                    <tr>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'jap_comment.pdf']) }}">補足解説</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'soc_comment.pdf']) }}">補足解説</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'math_comment.pdf']) }}">補足解説</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'sci_comment.pdf']) }}">補足解説</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => $years[$i] . 'eng_comment.pdf']) }}">補足解説</a></td>
                    </tr> --}}
                </table>
                
                <!-- 学校の試験の場合 -->
                @if($folder == "schoolexam")
                    <p class="text-center">(※)別タブで開きます。解説はない場合もあります。</p>
                <!-- 模試の場合 -->
                @elseif($folder == "moshi")
                    <div class="mt-6 text-center">
                        <ul>
                            <li><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_answersheet.pdf']) }}">解答用紙</a></li>
                            <li><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_kaito_kaisetsu.pdf']) }}">解答と解説</a></li>
                        </ul>
                    </div>
                @endif
            @endfor


            {{-- <x-h3>解答用紙</x-h3>                    
            <p>○をクリックするとPDFが開きます。</p>
            <table class="border-separate border border-slate-400 m-auto mb-4 table-fixed w-auto">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">国語</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">数学</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">社会</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">理科</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">英語</th>
                </tr>
                @for($i = 0; $i < count($years); $i++)
                    <tr>
                        <td class="border border-slate-300 px-4">{!! $years[$i] !!}</td>
                        @for($j = 0; $j < count($subjects); $j++)
                            <td class="border border-slate-300 px-8 py-2">
                                <a class="font-semibold text-blue-600" href="{{ route('secure.file', ['folder' => 'pastexam', 'filename' => $years[$i] . $subjects[$j] . '_a.pdf']) }}">○</a>
                            </td>
                        @endfor
                    </tr>
                @endfor
            </table>

            <x-h3>本試験の平均点</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed w-auto">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">国語</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">数学</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">社会</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">理科</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">英語</th>
                </tr>
                @for($i = 0; $i < count($years); $i++)
                    <tr>
                        <td class="border border-slate-300 px-4 text-center">{!! $years[$i] !!}</td>
                        @for($j = 0; $j < count($subjects); $j++)
                            <td class="border border-slate-300 px-8 py-2 text-center">
                                {{ $avg_score[$years[$i]][$subjects[$j]] }}
                            </td>
                        @endfor
                    </tr>
                @endfor
            </table> --}}
        </div>
</x-app-layout>