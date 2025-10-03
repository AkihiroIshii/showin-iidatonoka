<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クリアした単元
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <!-- 新規作成 -->
        @if(Auth::user()->role == "admin")
        <a href="{{route('completedunit.create')}}" class="text-blue-600">新規作成</a>
        @endif

        <!-- スマホ表示用のコード -->
        <div class="sm:hidden mb-8">
            <x-h3>河合塾One</x-h3>
            <p>最終更新日：{{$latest_date_updated_kawaijukuones}}</p>
            @foreach($grouped_completed_unit_kawaijukuones as $completed_unit_kawaijukuones)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$completed_unit_kawaijukuones[0]["name"]}}</x-h4>
                    </div>
                @endif
                @foreach($completed_unit_kawaijukuones as $completed_unit_kawaijukuone)
                    @php
                        if(isset($completed_unit_kawaijukuone->completed_date)) {
                            $bg_color = "bg-pink-300";
                        } else {
                            $bg_color = "bg-pink-100";
                        }
                    @endphp
                    <div class="mb-4 p-2 {!!$bg_color!!}">
                        <p class="font-bold">目標日：{{$completed_unit_kawaijukuone->target_date}}</p>
                        <p class="font-bold">完了日：{{$completed_unit_kawaijukuone->completed_date}}</p>
                        <p class="font-bold">単元名：{{$completed_unit_kawaijukuone->subject_1}} - {{$completed_unit_kawaijukuone->subject_2}} - {{$completed_unit_kawaijukuone->section}}<p>
                        <div class="ml-4">
                            <p>トピック数：{{$completed_unit_kawaijukuone->num_topic}}</p>
                        </div>
                    </div>
                @endforeach
            @endforeach

            <x-h3>AI-Showin</x-h3>
            <p>最終更新日：{{$latest_date_updated_aishowins}}</p>
            @foreach($grouped_completed_unit_aishowins as $completed_unit_aishowins)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$completed_unit_aishowins[0]["name"]}}</x-h4>
                    </div>
                @endif
                @foreach($completed_unit_aishowins as $completed_unit_aishowin)
                        @php
                            if(strpos($completed_unit_aishowin->grade, "小") !== false) {
                                if(isset($completed_unit_aishowin->completed_date)) {
                                    $bg_color = "bg-yellow-300";
                                } else {
                                    $bg_color = "bg-yellow-100";
                                }
                            } else {
                                if(isset($completed_unit_aishowin->completed_date)) {
                                    $bg_color = "bg-sky-300";
                                } else {
                                    $bg_color = "bg-sky-100";
                                }
                            }
                        @endphp
                    <div class="mb-4 p-2 {!!$bg_color!!}">
                        <p class="font-bold">目標日：{{$completed_unit_aishowin->target_date}}</p>
                        <p class="font-bold">完了日：{{$completed_unit_aishowin->completed_date}}</p>
                        <p class="font-bold">単元名：{{$completed_unit_aishowin->unit}} ({{$completed_unit_aishowin->grade}})<p>
                        <div class="ml-4">
                            <ul>
                                <li>内容：{{$completed_unit_aishowin->explanation}}</li>
                                <li>レベル数：{{$completed_unit_aishowin->num_level}}　周回数：{{$completed_unit_aishowin->num_loop}}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endforeach

            <x-h3>moji蔵</x-h3>
            <p>最終更新日：{{$latest_date_updated_mojizous}}</p>
            @foreach($grouped_completed_unit_mojizous as $completed_unit_mojizous)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$completed_unit_mojizous[0]["name"]}}</x-h4>
                    </div>
                @endif
                @foreach($completed_unit_mojizous as $completed_unit_mojizou)
                    @php
                        if(strpos($completed_unit_mojizou->grade, "１") !== false || strpos($completed_unit_mojizou->grade, "２") !== false) {
                            if(isset($completed_unit_mojizou->completed_date)) {
                                $bg_color = "bg-sky-300";
                            } else {
                                $bg_color = "bg-sky-100";
                            }
                        } else {
                            if(isset($completed_unit_mojizou->completed_date)) {
                                $bg_color = "bg-yellow-300";
                            } else {
                                $bg_color = "bg-yellow-100";
                            }
                        }
                    @endphp
                    <div class="mb-4 p-2 {!!$bg_color!!}">
                        <p class="font-bold">目標日：{{$completed_unit_mojizou->target_date}}</p>
                        <p class="font-bold">完了日：{{$completed_unit_mojizou->completed_date}}</p>
                        <p class="font-bold">
                            項目：{{$completed_unit_mojizou->grade}} - {{$completed_unit_mojizou->category}} - {{$completed_unit_mojizou->topic}}
                            ({{$completed_unit_mojizou->num_question}}問)
                        </p>
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- PC表示用のコード -->
        <div class="hidden sm:block">
            <x-h3>河合塾One</x-h3>
            <p>最終更新日：{{$latest_date_updated_kawaijukuones}}</p>
            @foreach($grouped_completed_unit_kawaijukuones as $completed_unit_kawaijukuones)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$completed_unit_kawaijukuones[0]["name"]}}</x-h4>
                    </div>
                @endif
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        @if(Auth::user()->role == "admin")
                            <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                        @endif
                        <x-th>教科</x-th>
                        <x-th>科目</x-th>
                        <x-th>分野</x-th>
                        <x-th>トピック数</x-th>
                        <x-th>クリア目標日</x-th>
                        <x-th>クリアした日</x-th>
                    </tr>
                    @foreach($completed_unit_kawaijukuones as $completed_unit_kawaijukuone)
                        @php
                            if(isset($completed_unit_kawaijukuone->completed_date)) {
                                $bg_color = "bg-pink-300";
                            } else {
                                $bg_color = "bg-pink-100";
                            }
                        @endphp
                        <tr class="{!!$bg_color!!}">
                            @if(Auth::user()->role == "admin")
                                <x-td>
                                    <a href="{{route('completedunit.edit', $completed_unit_kawaijukuone->id)}}" class="text-blue-600">編集</a>
                                </x-td>
                            @endif
                            <x-td>{{$completed_unit_kawaijukuone->subject_1}}</x-td>
                            <x-td>{{$completed_unit_kawaijukuone->subject_2}}</x-td>
                            <x-td>{{$completed_unit_kawaijukuone->section}}</x-td>
                            <x-td>{{$completed_unit_kawaijukuone->num_topic}}</x-td>
                            <x-td>{{$completed_unit_kawaijukuone->target_date}}</x-td>
                            <x-td>{{$completed_unit_kawaijukuone->completed_date}}</x-td>
                        </tr>
                    @endforeach
                </table>
            @endforeach

            <x-h3>AI-Showin</x-h3>
            <p>最終更新日：{{$latest_date_updated_aishowins}}</p>
            <p class="text-center">(※)周回数は、学習モードの周回数です。学習モードで80点未満だと、その単元をもう１周学習します。</p>
            @foreach($grouped_completed_unit_aishowins as $completed_unit_aishowins)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$completed_unit_aishowins[0]["name"]}}</x-h4>
                    </div>
                @endif
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        @if(Auth::user()->role == "admin")
                            <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                        @endif
                        <x-th>単元名 (学年)</x-th>
                        <x-th>レベル数</x-th>
                        <x-th>周回数</x-th>
                        <x-th>クリア目標日</x-th>
                        <x-th>クリアした日</x-th>
                        <x-th>内容</x-th>
                    </tr>
                    @foreach($completed_unit_aishowins as $completed_unit_aishowin)
                        @php
                            if(strpos($completed_unit_aishowin->grade, "小") !== false) {
                                if(isset($completed_unit_aishowin->completed_date)) {
                                    $bg_color = "bg-yellow-300";
                                } else {
                                    $bg_color = "bg-yellow-100";
                                }
                            } else {
                                if(isset($completed_unit_aishowin->completed_date)) {
                                    $bg_color = "bg-sky-300";
                                } else {
                                    $bg_color = "bg-sky-100";
                                }
                            }
                        @endphp
                        <tr class="{!! $bg_color !!}">
                            @if(Auth::user()->role == "admin")
                                <x-td>
                                    <a href="{{route('completedunit.edit', $completed_unit_aishowin->id)}}" class="text-blue-600">編集</a>
                                </x-td>
                            @endif
                            <x-td>{{$completed_unit_aishowin->unit}} ({{$completed_unit_aishowin->grade}})</x-td>
                            <x-td>{{$completed_unit_aishowin->num_level}}</x-td>
                            <x-td>{{$completed_unit_aishowin->num_loop}}</x-td>
                            <x-td>{{$completed_unit_aishowin->target_date}}</x-td>
                            <x-td>{{$completed_unit_aishowin->completed_date}}</x-td>
                            <x-td>{{$completed_unit_aishowin->explanation}}</x-td>
                        </tr>
                    @endforeach
                </table>
            @endforeach

            <x-h3>moji蔵</x-h3>
            <p>最終更新日：{{$latest_date_updated_mojizous}}</p>
            @foreach($grouped_completed_unit_mojizous as $completed_unit_mojizous)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$completed_unit_mojizous[0]["name"]}}</x-h4>
                    </div>
                @endif
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        @if(Auth::user()->role == "admin")
                            <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></th>
                        @endif
                        <x-th>級</x-th>
                        <x-th>分野</x-th>
                        <x-th>項目</x-th>
                        <x-th>問題数</x-th>
                        <x-th>クリア目標日</x-th>
                        <x-th>クリアした日</x-th>
                    </tr>
                    @foreach($completed_unit_mojizous as $completed_unit_mojizou)
                        @php
                            if(strpos($completed_unit_mojizou->grade, "１") !== false || strpos($completed_unit_mojizou->grade, "２") !== false) {
                                if(isset($completed_unit_mojizou->completed_date)) {
                                    $bg_color = "bg-sky-300";
                                } else {
                                    $bg_color = "bg-sky-100";
                                }
                            } else {
                                if(isset($completed_unit_mojizou->completed_date)) {
                                    $bg_color = "bg-yellow-300";
                                } else {
                                    $bg_color = "bg-yellow-100";
                                }
                            }
                        @endphp
                        <tr class="{!!$bg_color!!}">
                            @if(Auth::user()->role == "admin")
                                <x-td>
                                    <a href="{{route('completedunit.edit', $completed_unit_mojizou->id)}}" class="text-blue-600">編集</a>
                                </x-td>
                            @endif
                            <x-td>{{$completed_unit_mojizou->grade}}</x-td>
                            <x-td>{{$completed_unit_mojizou->category}}</x-td>
                            <x-td>{{$completed_unit_mojizou->topic}}</x-td>
                            <x-td>{{$completed_unit_mojizou->num_question}}</x-td>
                            <x-td>{{$completed_unit_mojizou->target_date}}</x-td>
                            <x-td>{{$completed_unit_mojizou->completed_date}}</x-td>
                        </tr>
                    @endforeach
                </table>
            @endforeach
            
        </div>
    </div>
</x-app-layout>