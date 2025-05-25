<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ 高校入試倍率
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <div style="display:flex;">
            <div class="px-6 py-4 text-lg font-semibold">
                ＞ 年度別
            </div>
            <div class="px-6 py-4 text-lg">
                <a href="{{route('entrance_exam_data_highschool.schools')}}" class="text-blue-600 font-semibold">学校別</a>
            </div>
        </div>

        <!-- 入試倍率表示 -->
        <ul style="list-style:circle;" class="px-6">
            <li>倍率が<span class="bg-yellow-100">1.0を超える場合は黄色</span>に、<span class="bg-red-100">2.0以上の場合は赤</span>になっています。</li>
            <li>前期の「入学予定者数」は、飯田女子および公立（2024年度まで）は「合格者」の数を表示しています。</li>
            <li>後期の「志願数」は、志願変更受付後のデータを表示しています。</li>
            <li>飯田女子は、推薦入試のデータを「前期」に、一般入試のデータを「後期」に表示しています。</li>
        </ul>

        <!-- スマホ表示 -->
        <div class="sm:hidden">
            <div class="mb-6">
                @foreach($grouped_entrance_exam_data_highschools as $entrance_exam_data_highschools)
                    <div class="mt-6">
                        <x-h3>{{$entrance_exam_data_highschools[0]->year}}年度</x-h3>
                    </div>

                    <table class="border-separate border border-slate-400 m-auto table-fixed">
                        <tr class="bg-gray-300">
                            <th colspan="1" class="w-1/3"></th>
                            <th colspan="2" class="w-2/3">志願数/募集人員（倍率）</th>
                        </tr>
                        <tr class="bg-gray-300">
                            @if(Auth::user()->role == "admin")
                                <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                            @endif
                            <x-th>
                                <ul>
                                    <li>高校</li>
                                    <li class="text-sm">（学科）</li>
                                </ul>
                            </x-th>
                            <x-th>前期</x-th>
                            <x-th>後期</x-th>
                        </tr>
                        @foreach($entrance_exam_data_highschools as $entrance_exam_data_highschool)
                            @php
                                // 前期倍率
                                if($entrance_exam_data_highschool->early_ratio >= 2.0) {
                                    $early_bg_color = "bg-pink-100";
                                } elseif($entrance_exam_data_highschool->early_ratio > 1.0) {
                                    $early_bg_color = "bg-yellow-100";
                                } else {
                                    $early_bg_color = "bg-white-100";
                                }
                                // 後期倍率
                                if($entrance_exam_data_highschool->late_ratio >= 2.0) {
                                    $late_bg_color = "bg-pink-100";
                                } elseif($entrance_exam_data_highschool->late_ratio > 1.0) {
                                    $late_bg_color = "bg-yellow-100";
                                } else {
                                    $late_bg_color = "bg-white-100";
                                }
                            @endphp
                            <tr class="text-center">
                                {{-- @if(Auth::user()->role == "admin")
                                    <x-td>
                                        <a href="{{route('completedunit.edit', $completed_unit_kawaijukuone->id)}}" class="text-blue-600">編集</a>
                                    </x-td>
                                @endif --}}
                                <x-td>
                                    <ul>
                                        <li>{{$entrance_exam_data_highschool->schoolNameShort}}</li>
                                        <li class="text-sm">({{$entrance_exam_data_highschool->department_short}})</li>
                                    </ul>
                                </x-td>
                                <x-td>
                                    @if($entrance_exam_data_highschool->early_capacity == 0)
                                        募集なし
                                    @else
                                        <ul>
                                            <li>
                                                {{$entrance_exam_data_highschool->early_applicants}}
                                                /{{$entrance_exam_data_highschool->early_capacity}}
                                            </li>
                                            <li class="text-sm"><span class="{!!$early_bg_color!!}">（{{$entrance_exam_data_highschool->early_ratio}}倍）</span></li>
                                        </ul>
                                    @endif
                                </x-td>
                                <x-td>
                                    <ul>
                                        <li>
                                            {{$entrance_exam_data_highschool->late_post_applicants}}
                                            /{{$entrance_exam_data_highschool->late_capacity}}
                                        </li>
                                        <li class="text-sm"><span class="{!!$late_bg_color!!}">（{{$entrance_exam_data_highschool->late_ratio}}倍）</span></li>
                                    </ul>
                                </x-td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            </div>
        </div>

        <!-- PC表示 -->
        <div class="hidden sm:block mx-auto px-6 py-4">
            <div class="mb-6 mt-4">
                @foreach($grouped_entrance_exam_data_highschools as $entrance_exam_data_highschools)
                    <x-h3>{{$entrance_exam_data_highschools[0]->year}}年度</x-h3>

                    <table class="border-separate border border-slate-400 m-auto table-fixed">
                        <tr class="bg-gray-300">
                            <th colspan="1"></th>
                            <th colspan="3">前期</th>
                            <th colspan="3">後期</th>
                            <th colspan="1">再募集</th>
                        </tr>
                        <tr class="bg-gray-300">
                            @if(Auth::user()->role == "admin")
                                <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                            @endif
                            <x-th>高校（学科）</x-th>
                            <x-th>募集人員</x-th>
                            <x-th>
                                <ul>
                                    <li>志願数⇒</li>
                                    <li>入学予定者数</li>
                                </ul>
                            </x-th>
                            <x-th>倍率</x-th>
                            <x-th>募集人員</x-th>
                            <x-th>
                                <ul>
                                    <li>志願数⇒</li>
                                    <li>入学予定者数</li>
                                </ul>
                            </x-th>
                            <x-th>倍率</x-th>
                            <x-th>募集人員</x-th>
                        </tr>
                        @foreach($entrance_exam_data_highschools as $entrance_exam_data_highschool)
                            @php
                                // 前期倍率
                                if($entrance_exam_data_highschool->early_ratio >= 2.0) {
                                    $early_bg_color = "bg-pink-100";
                                } elseif($entrance_exam_data_highschool->early_ratio > 1.0) {
                                    $early_bg_color = "bg-yellow-100";
                                } else {
                                    $early_bg_color = "bg-white-100";
                                }
                                // 後期倍率
                                if($entrance_exam_data_highschool->late_ratio >= 2.0) {
                                    $late_bg_color = "bg-pink-100";
                                } elseif($entrance_exam_data_highschool->late_ratio > 1.0) {
                                    $late_bg_color = "bg-yellow-100";
                                } else {
                                    $late_bg_color = "bg-white-100";
                                }
                            @endphp
                            <tr class="text-center">
                                {{-- @if(Auth::user()->role == "admin")
                                    <x-td>
                                        <a href="{{route('completedunit.edit', $completed_unit_kawaijukuone->id)}}" class="text-blue-600">編集</a>
                                    </x-td>
                                @endif --}}
                                <x-td>
                                    <ul>
                                        <li>{{$entrance_exam_data_highschool->schoolName}}</li>
                                        <li>（{{$entrance_exam_data_highschool->department}}）</li>
                                    </ul>
                                </x-td>
                                @if($entrance_exam_data_highschool->early_capacity == 0)
                                    <x-td>募集なし</x-td>
                                    <x-td></x-td>
                                @else
                                    <x-td>{{$entrance_exam_data_highschool->early_capacity}}人</x-td>
                                    <x-td>{{$entrance_exam_data_highschool->early_applicants}}人 ⇒ {{$entrance_exam_data_highschool->early_admission}}人</x-td>
                                @endif
                                <x-td class="{!!$early_bg_color!!}">{{$entrance_exam_data_highschool->early_ratio}}</x-td>
                                <x-td>{{$entrance_exam_data_highschool->late_capacity}}人</x-td>
                                <x-td>
                                    @if($entrance_exam_data_highschool->late_admission == 0)
                                        {{$entrance_exam_data_highschool->late_post_applicants}}人 ⇒ 不明
                                    @else
                                        {{$entrance_exam_data_highschool->late_post_applicants}}人 ⇒ {{$entrance_exam_data_highschool->late_admission}}人
                                    @endif
                                </x-td>
                                <x-td class="{!!$late_bg_color!!}">{{$entrance_exam_data_highschool->late_ratio}}</x-td>
                                <x-td>
                                    @if($entrance_exam_data_highschool->rerecruitment == 0)
                                        募集なし
                                    @elseif($entrance_exam_data_highschool->rerecruitment == -1)
                                        若干名
                                    @else
                                        {{$entrance_exam_data_highschool->formatted_rerecruitment}}人
                                    @endif
                                </x-td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>