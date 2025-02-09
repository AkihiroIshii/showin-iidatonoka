<x-app-layout>
    <x-slot name="header">
        @include('layouts.pastexam') <!-- 過去問演習　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            解答用紙(配点記入済)
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            @php
                $years = [2024, 2023, 2022, 2021, 2020];
                $subjects = ['jap', 'math', 'soc', 'sci', 'eng'];
                $avg_score = [
                    2024 => ['jap' => 54.9, 'math' => 49.0, 'soc' => 61.7, 'sci' => 49.2, 'eng' => 59.1],
                    2023 => ['jap' => 55.7, 'math' => 51.1, 'soc' => 56.9, 'sci' => 54.3, 'eng' => 45.0],
                    2022 => ['jap' => 47.8, 'math' => 46.5, 'soc' => 52.5, 'sci' => 39.0, 'eng' => 51.3],
                    2021 => ['jap' => 57.6, 'math' => 51.9, 'soc' => 63.5, 'sci' => 56.8, 'eng' => 59.9],
                    2020 => ['jap' => 72.7, 'math' => 55.9, 'soc' => 68.1, 'sci' => 53.2, 'eng' => 53.6]
                ] //本試験の平均点
            @endphp
            <x-h3>解答用紙</x-h3>
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
                @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="border border-slate-300 px-4">{!! $years[$i] !!}</td>
                        @for($j = 0; $j < 5; $j++)
                            <td class="border border-slate-300 px-8 py-2">
                                <a class="font-semibold text-blue-600" href="{{ asset('pdf/' . $years[$i] . $subjects[$j] . '.pdf') }}">○</a>
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
                @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="border border-slate-300 px-4 text-center">{!! $years[$i] !!}</td>
                        @for($j = 0; $j < 5; $j++)
                            <td class="border border-slate-300 px-8 py-2 text-center">
                                {{ $avg_score[$years[$i]][$subjects[$j]] }}
                            </td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
</x-app-layout>