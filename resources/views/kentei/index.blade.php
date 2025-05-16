<x-app-layout>
    {{-- @if(Auth::user()->role == "admin" || Auth::user()->grade == "保護者") --}}

        <x-slot name="header">
            @if(Auth::user()->role == "admin")
                @include('layouts.adminmenu')
            @endif
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                検定
                @if(Auth::user()->role == "admin")
                    ：{{$user->name}}
                @endif
            </h2>
        </x-slot>

        <!-- スマホ表示用 -->
        <div class="sm:hidden">
            @if(Str::contains(Auth::user()->grade, ['中１','中２','高','保護者','管理者']))
            <div class="mb-6">
                @if(Auth::user()->grade != '保護者')
                    <p><a href="{{route('kentei.create', $user)}}" class="text-blue-600">新規作成</a></p>
                @endif
                @foreach($grouped_kenteis as $kenteis)
                    @if(Auth::user()->grade == "保護者")
                        <div class="mt-6">
                            <x-h4>{{$kenteis[0]->user_name}}</x-h4>
                        </div>
                    @endif
                    @foreach($kenteis as $kentei)
                        <div class="bg-sky-100 mb-4 p-2">
                            <p class="font-bold">
                                @if(Auth::user()->grade == '保護者')
                                    {{$kentei->user_name}}　 
                                @endif
                            </p>
                            <div class="ml-4">
                                <p>{{$kentei->name}}　{{$kentei->grade}}</p>
                                <p>一次試験：{{$kentei->first_date}}　{{$kentei->first_score}}点／{{$kentei->first_point}}点 ({{$kentei->first_rate}}%)</p>
                                <p>二次試験：{{$kentei->second_date}}　{{$kentei->second_score}}点／{{$kentei->second_point}}点 ({{$kentei->second_rate}}%)</p>
                                <p>結果：{{$kentei->result}}</p>
                                <p>メモ：{{$kentei->memo}}</p>
                                @if(Auth::user()->grade != '保護者')
                                    <x-primary-button class="mt-4">
                                        <a href="{{route('kentei.edit', $kentei)}}">編集</a>
                                    </x-primary-button>
                                @endif
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
                @if(Auth::user()->role == "admin")
                    <a href="{{route('kentei.create', $user)}}" class="text-blue-600">新規作成</a>
                @endif
                @foreach($grouped_kenteis as $kenteis)
                    @if(Auth::user()->grade == "保護者")
                        <div class="mt-6">
                            <x-h4>{{$kenteis[0]->user_name}}</x-h4>
                        </div>
                    @endif
                    <table class="border-separate border border-slate-400 m-auto table-fixed">
                        <tr class="bg-gray-300">
                            @if(Auth::user()->role == "admin")
                                <th class="bg-white border border-slate-300" colspan="3"></th>
                            @else
                                <th class="bg-white border border-slate-300" colspan="2"></th>
                            @endif
                            <th class="bg-white border border-slate-300" colspan="2">一次試験</th>
                            <th class="bg-white border border-slate-300" colspan="2">二次試験</th>
                            <th class="bg-white border border-slate-300" colspan="2"></th>
                        </tr>
                        <tr class="bg-gray-300">
                            @if(Auth::user()->role == "admin")
                                <x-th></x-th>
                            @endif
                            <x-th>検定名</x-th>
                            <x-th>級</x-th>
                            <x-th>日程</x-th>
                            <x-th>得点</x-th>
                            <x-th>日程</x-th>
                            <x-th>得点</x-th>
                            <x-th>結果</x-th>
                            <x-th>メモ</x-th>
                        </tr>
                        @foreach($kenteis as $kentei)
                            <tr>
                                @if(Auth::user()->role == "admin")
                                    <td class="border border-slate-300 px-4">
                                        <a href="{{route('kentei.edit', $kentei)}}" class="text-blue-600">編集</a>
                                    </td>
                                @endif
                                <td class="border border-slate-300 px-4">{{$kentei->name}}</td>
                                <td class="border border-slate-300 px-4">{{$kentei->grade}}</td>
                                <td class="border border-slate-300 px-4">{{$kentei->first_date}}</td>
                                <td class="border border-slate-300 px-4">{{$kentei->first_score}}／{{$kentei->first_point}} ({{$kentei->first_rate}}%)</td>
                                <td class="border border-slate-300 px-4">{{$kentei->second_date}}</td>
                                <td class="border border-slate-300 px-4">{{$kentei->second_score}}／{{$kentei->second_point}} ({{$kentei->second_rate}}%)</td>
                                <td class="border border-slate-300 px-4">{{$kentei->result}}</td>
                                <td class="border border-slate-300 px-4">{{$kentei->memo}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            </div>
        </div>
    {{-- @endif --}}
</x-app-layout>