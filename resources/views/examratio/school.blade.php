<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            高校入試倍率（学校別）
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <!-- @extends('layouts.app') -->

        <!-- @section('content') -->
            @php
                // school, department, period でグループ化する
                $grouped = $examratios->groupBy('school')->map(function ($schoolGroup) {
                    return $schoolGroup->groupBy('department')->map(function ($deptGroup) {
                        return $deptGroup->groupBy('period');
                    });
                });
            @endphp

            @foreach ($grouped as $school => $departments)
                <h2>{{ $school }}</h2>
                @foreach ($departments as $department => $periods)
                    <h3>{{ $department }}</h3>
                    @foreach ($periods as $period => $records)
                        <h4>{{ $period }}</h4>

                        @php
                            // 各グループから、縦軸に使う year と横軸に使う type の一覧を取得
                            $years = $records->pluck('year')->unique()->sort();
                            $types = $records->pluck('type')->unique()->sort();
                        @endphp

                        <table border="1" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <th>Year \ Type</th>
                                    @foreach ($types as $type)
                                        <th>{{ $type }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($years as $year)
                                    <tr>
                                        <x-td>{{ $year }}</x-td>
                                        @foreach ($types as $type)
                                            @php
                                                // 条件に一致するレコードを検索（複数ある場合は最初の1件）
                                                $record = $records->firstWhere(function ($record) use ($year, $type) {
                                                    return $record->year == $year && $record->type == $type;
                                                });
                                            @endphp
                                            <x-td>{{ $record ? $record->num : '-' }}</x-td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                    @endforeach
                @endforeach
            @endforeach
        <!-- @endsection -->
    </div>
</x-app-layout>