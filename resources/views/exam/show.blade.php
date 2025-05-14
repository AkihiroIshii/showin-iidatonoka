<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            試験の復習（管理者）
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <!-- テスト結果を表示 -->
        <div class="mb-6 mt-4">
            <p class="text-lg text-center">
                @if(Auth::user()->role == "admin")
                    ID:{{$exam->id}}　
                @endif
                {{$exam->year}}年度 {{$exam->grade}} {{$exam->exam_name}}
            </p>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">国語</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">社会</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">数学</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">理科</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">英語</td>
                </tr>
                <!-- 問題 -->
                <tr>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_jap_q.pdf']) }}">問題</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_soc_q.pdf']) }}">問題</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_math_q.pdf']) }}">問題</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_sci_q.pdf']) }}">問題</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_eng_q.pdf']) }}">問題</a></td>
                </tr>
                <!-- 解答 -->
                @if($folder == "schoolexam")
                    <tr>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_jap_a.pdf']) }}">解答</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_soc_a.pdf']) }}">解答</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_math_a.pdf']) }}">解答</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_sci_a.pdf']) }}">解答</a></td>
                        <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_eng_a.pdf']) }}">解答</a></td>
                    </tr>
                @endif
                <!-- 解説 -->
                <tr>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_jap_e.pdf']) }}">解説</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_soc_e.pdf']) }}">解説</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_math_e.pdf']) }}">解説</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_sci_e.pdf']) }}">解説</a></td>
                    <td class="border border-slate-300 px-4"><a class="font-semibold text-blue-600" target="_blank" href="{{ route('secure.file', ['folder' => $folder, 'filename' => 'exam_' . $exam->id . '_eng_e.pdf']) }}">解説</a></td>
                </tr>
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
        </div>
    </div>
</x-app-layout>