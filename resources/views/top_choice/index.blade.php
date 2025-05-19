<x-app-layout>
    {{-- @if(Auth::user()->role == "admin" || Auth::user()->grade == "保護者") --}}

        <x-slot name="header">
            @if(Auth::user()->role == "admin")
                @include('layouts.adminmenu')
            @endif
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                志望校
                @if(Auth::user()->role == "admin")
                    ：{{$user->name}}
                @endif
            </h2>
        </x-slot>

        <!-- スマホ表示用 -->
        <div class="sm:hidden">
            <!-- 志望校を表示 -->
            @if(Str::contains(Auth::user()->grade, ['中１','中２','高','保護者']))
            <x-h3>志望校</x-h3>
            <div class="mb-6">
                @if(Auth::user()->grade != '保護者')
                    <p><a href="{{route('top_choice.create', $user)}}" class="text-blue-600">新規作成</a></p>
                @endif
                @foreach($grouped_top_choices as $top_choices)
                    @if(Auth::user()->grade == "保護者")
                        <div class="mt-6">
                            <x-h4>{{$top_choices[0]["name"]}}</x-h4>
                        </div>
                    @endif
                    @foreach($top_choices as $choice)
                        <div class="bg-sky-100 mb-4 p-2">
                            <p class="font-bold">
                                第{{$choice->desired_ranking}}志望
                            </p>
                            <div class="ml-4">
                                <p>学校名：{{$choice->school_name}} </p>
                                <p>学部、学科：{{$choice->department}}</p>
                                <p>本試験日：{{$choice->exam_date}}</p>
                                <p>選抜方法：{{$choice->selection_method}}</p>
                                <p>募集定員：{{$choice->num_capacity}}</p>
                                <p>入試科目：{{$choice->subjects}}</p>
                                <p>模試：{{$choice->mock_date}}　{{$choice->mock_name}}　{{$choice->mock_judge}}</p>
                                <p>メモ：{{$choice->memo}}</p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            @endif
        </div>

        <!-- PC表示用 -->
        <div class="hidden sm:block mx-auto px-6 py-4">
            <div class="mb-6 mt-4">
                @if(Auth::user()->grade != "保護者")
                    <a href="{{route('top_choice.create', $user)}}" class="text-blue-600">新規作成</a>
                @endif
                @foreach($grouped_top_choices as $top_choices)
                    @if(Auth::user()->grade == "保護者")
                        <div class="mt-6">
                            <x-h4>{{$top_choices[0]["name"]}}</x-h4>
                        </div>
                    @endif
                    <table class="border-separate border border-slate-400 m-auto table-fixed">
                        <tr class="bg-gray-300">
                            @if(Auth::user()->grade !== "保護者")
                                <x-th></x-th>
                            @endif
                            <x-th>志望順位</x-th>
                            <x-th>学校名</x-th>
                            <x-th>学部、学科</x-th>
                            <x-th>選抜方法</x-th>
                            <x-th>定員</x-th>
                            <x-th>入試日</x-th>
                            <x-th>入試科目</x-th>
                            <x-th>模試日</x-th>
                            <x-th>模試名</x-th>
                            <x-th>模試判定</x-th>
                            <x-th>メモ</x-th>
                        </tr>
                        @foreach($top_choices as $choice)
                            <tr>
                                @if(Auth::user()->grade !== '保護者')
                                    <td class="border border-slate-300 px-4">
                                        <a href="{{route('top_choice.edit', $choice)}}" class="text-blue-600">編集</a>
                                    </td>
                                @endif
                                <td class="border border-slate-300 px-4">{{$choice->desired_ranking}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->school_name}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->department}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->selection_method}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->num_capacity}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->exam_date}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->subjects}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->mock_date}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->mock_name}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->mock_judge}}</td>
                                <td class="border border-slate-300 px-4">{{$choice->memo}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            </div>
        </div>
    {{-- @endif --}}
</x-app-layout>