<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 高校入試倍率
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- 入試倍率表示 -->
        <ul style="list-style:circle;" class="px-6">
            <li>倍率が<span class="bg-yellow-100">1.0を超える場合は黄色</span>に、<span class="bg-red-100">2.0以上の場合は赤</span>になっています。</li>
            <li>後期本試験の志願者数は、志願変更前のデータを表示しています。</li>
        </ul>

        @php
            // schoolName, department, period でグループ化する
            $grouped = $examratios->groupBy('schoolName')->map(function ($schoolGroup) {
                return $schoolGroup->groupBy('department')->map(function ($deptGroup) {
                    return $deptGroup->groupBy('period');
                });
            });
        @endphp

        @foreach ($grouped as $schoolName => $departments)
            <x-h3>{{ $schoolName }}</x-h3>
            @foreach ($departments as $department => $periods)
                <x-h4 class="font-bold">{{ $department }}科</x-h4>
                <div class="flex justfy-end">
                    @foreach ($periods as $period => $records)
                        <div class="w-1/2">
                            <h4 class="text-center font-semibold text-l mb-2">{{ $period }}</h4>

                            @php
                                // 各グループから、縦軸に使う year と横軸に使う type の一覧を取得
                                $years = $records->pluck('year')->unique()->sortDesc();
                                $types = ['第１回調査','第２回調査','本試験'];
                            @endphp

                            <table class="border-separate border border-slate-400 m-auto table-fixed">
                                <thead>
                                    <tr>
                                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4" colspan="2"></th>
                                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4" colspan="3">志願者数（倍率）</th>
                                    </tr>
                                    <tr>
                                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</th>
                                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">定員</th>
                                        @foreach ($types as $type)
                                            <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">{{ $type }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($years as $year)
                                        <tr>
                                            <td class="border border-slate-300 px-4">{{ $year }}</td>
                                            @php
                                                // 条件に一致するレコードを検索（複数ある場合は最初の1件）
                                                $record = $records->firstWhere(function ($record) use ($year) {
                                                    return $record->year == $year;
                                                });
                                            @endphp
                                            <td class="border border-slate-300 px-4">{{ $record ? $record->num_capacity : '-' }}人</td>
                                            @foreach ($types as $type)
                                                @php
                                                    // 条件に一致するレコードを検索（複数ある場合は最初の1件）
                                                    $record = $records->firstWhere(function ($record) use ($year, $type) {
                                                        return $record->year == $year && $record->type == $type;
                                                    });
                                                    // 倍率によって背景色を変更
                                                    $bgColor = '';
                                                    if (isset($record->examRatio)) {
                                                        if ($record->examRatio >= 2.0) {
                                                            $bgColor = 'bg-red-100';
                                                        } elseif ($record->examRatio > 1.0) {
                                                            $bgColor = 'bg-yellow-100';
                                                        }
                                                    }
                                                @endphp
                                                <td class="border border-slate-300 px-4 {!! $bgColor !!}">
                                                    <ul class="text-center">
                                                        @if(isset($record->num_capacity) && $record->num_capacity == 0)
                                                            <li>-</li>
                                                            <li>（-倍）</li>
                                                        @else
                                                            <li>{{ $record ? $record->num_applicants : '-' }}人</li>
                                                            <li>（{{ $record ? $record->examRatio : '-' }}倍）</li>
                                                        @endif
                                                    </ul>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endforeach
    </div>
</x-app-layout>