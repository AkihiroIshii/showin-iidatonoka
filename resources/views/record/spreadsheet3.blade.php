<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @include('layouts.pastexam') <!-- 過去問演習　共通メニュー -->
            過去問演習＞集計表３
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        @php
            $maxNos = ['国語' => 6, '数学' => 5, '社会' => 4, '理科' => 5, '英語' => 5];
            $questionsSet = $questionsSet->groupBy('subject')->map(fn($group) => $group->groupBy('year'));
        @endphp
        <div>
            <div>
                <span class="bg-sky-200 font-semibold">(※)平均点が目標点以上であれば、水色になります。水色のマスを増やしましょう(^^)/</span>
            </div>
            @foreach($questionsSet as $subject => $years)
                <x-h3 class="text-xl font-bold mt-4">{{ $subject }}</x-h3>
                
                <table class="border-collapse border border-gray-400 w-full">
                    <thead>
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">年度</th>
                            @for($i = 1; $i <= 5; $i++)
                                <th class="border border-gray-400 px-4 py-2">問 {{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($years as $year => $questionsByYear)
                            <tr>
                                <td class="border border-gray-400 px-4 py-2">{{ $year }}</td>
                                
                                @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $question = $questionsByYear->firstWhere('no', $i);
                                    @endphp
                                    <td class="border border-gray-400 px-4 py-2">
                                        @if($question)
                                            @php
                                                if($question->avg_score >= $question->target_score) {
                                                    $ulClass = 'bg-sky-200';
                                                } else {
                                                    $ulClass = '';
                                                }
                                            @endphp
                                            <ul class="{!! $ulClass !!}">
                                                <li>挑戦回数：{{ $question->count }}回</li>
                                                <li>
                                                    平均：{{ $question->avg_score }}点
                                                    ／目標：{{ $question->target_score }}点
                                                    @if($question->avg_score > $question->target_score)
                                                        (^^)/◎
                                                    @endif
                                                </li>
                                            </ul>
                                        @else
                                            &nbsp; {{-- 空白セル --}}
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
</x-app-layout>