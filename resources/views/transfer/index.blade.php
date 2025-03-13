<x-app-layout>
    @if(Auth::user()->role == "admin" || Str::contains(Auth::user()->grade, ['高','保護者']))
        <x-slot name="header">
            @if(Auth::user()->role == "admin")
                @include('layouts.adminmenu')
            @endif
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                振替
                @if(Auth::user()->role == "admin")
                    ：{{$user->name}}
                @endif
            </h2>
        </x-slot>
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif

        <ul class="list-desc ml-4">
            <li>・申請中のものは編集できます。</li>
            <li>・承認済みのものは編集できません。</li>
        </ul>
        <!-- スマホ表示用 -->
        <div class="sm:hidden">
            <div class="mb-6">
                <p class="m-2"><a href="{{route('transfer.create', $user)}}" class="text-blue-600 font-bold">振替申請はこちら</a></p>
                @foreach($transfers as $transfer)
                    <div class="bg-sky-100 mb-4 p-2">
                        <p class="font-bold">
                            @if(Auth::user()->grade == '保護者')
                                {{$transfer->user_name}}（{{$transfer->status}}）　
                            @endif
                        </p>
                        <div class="ml-4">
                            <div class="mt-2">
                                <p>欠席した日（計{{$transfer->sum_t_abs}}分）</p>
                                <p>(1){{$transfer->day_of_absence_1}}　{{$transfer->formatted_time_from_absence_1}}～{{$transfer->formatted_time_to_absence_1}}</p>
                                <p>(2){{$transfer->day_of_absence_2}}　{{$transfer->formatted_time_from_absence_2}}～{{$transfer->formatted_time_to_absence_2}}</p>
                                <p>(3){{$transfer->day_of_absence_3}}　{{$transfer->formatted_time_from_absence_3}}～{{$transfer->formatted_time_to_absence_3}}</p>
                            </div>
                            <div class="mt-2">
                                <p>振替希望日（計{{$transfer->sum_t_alt}}分）</p>
                                <p>(1){{$transfer->alternative_day_1}}　{{$transfer->formatted_time_from_alternative_1}}～{{$transfer->formatted_time_to_alternative_1}}</p>
                                <p>(2){{$transfer->alternative_day_2}}　{{$transfer->formatted_time_from_alternative_2}}～{{$transfer->formatted_time_to_alternative_2}}</p>
                                <p>(3){{$transfer->alternative_day_3}}　{{$transfer->formatted_time_from_alternative_3}}～{{$transfer->formatted_time_to_alternative_3}}</p>
                            </div>
                            @if(Auth::user()->role == "admin" || $transfer->status == "申請中")
                                <x-primary-button class="mt-4">
                                    <a href="{{route('transfer.edit', $transfer)}}">編集</a>
                                </x-primary-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- PC表示用 -->
        <div class="hidden sm:block mx-auto px-6 py-4">
            <div class="mb-6 mt-4">
                <p class="m-2"><a href="{{route('transfer.create', $user)}}" class="text-blue-600 font-bold">振替申請はこちら</a></p>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th class="bg-white border border-slate-300" colspan="2"></th>
                        <th class="bg-white border border-slate-300" colspan="4">欠席した日</th>
                        <th class="bg-white border border-slate-300" colspan="3">振替希望日</th>
                        <th class="bg-white border border-slate-300" colspan="1"></th>
                    </tr>
                    <tr class="bg-gray-300">
                        <x-th></x-th>
                        <x-th>生徒名</x-th>
                        <x-th>日付</x-th>
                        <x-th>時間</x-th>
                        <x-th>計</x-th>
                        <x-th>理由</x-th>
                        <x-th>日付</x-th>
                        <x-th>時間</x-th>
                        <x-th>計</x-th>
                        <x-th>状態</x-th>
                    </tr>
                    @foreach($transfers as $transfer)
                        <tr>
                            <td class="border border-slate-300 px-4">
                                @if(Auth::user()->role == "admin" || $transfer->status == "申請中")
                                    <a href="{{route('transfer.edit', $transfer)}}" class="text-blue-600 font-bold">編集</a>
                                @endif
                            </td>
                            <td class="border border-slate-300 px-4">{{$transfer->user_name}}</td>
                            <td class="border border-slate-300 px-4">
                                <ul class="ml-2 list-decimal text-center">
                                    <li>{{$transfer->day_of_absence_1}}</li>
                                    <li>{{$transfer->day_of_absence_2}}</li>
                                    <li>{{$transfer->day_of_absence_3}}</li>
                                </ul>                                
                            </td>
                            <td class="border border-slate-300 px-4">
                                <ul class="ml-2 list-decimal text-center">
                                    <li>{{$transfer->formatted_time_from_absence_1}}～{{$transfer->formatted_time_to_absence_1}}</li>
                                    <li>{{$transfer->formatted_time_from_absence_2}}～{{$transfer->formatted_time_to_absence_2}}</li>
                                    <li>{{$transfer->formatted_time_from_absence_3}}～{{$transfer->formatted_time_to_absence_3}}</li>
                                </ul>
                            </td>
                            <td class="border border-slate-300 px-4">{{$transfer->sum_t_abs}}分</td>
                            <td class="border border-slate-300 px-4">
                                <ul class="ml-2 list-decimal text-center">
                                    <li>{{$transfer->reason_of_absence_1}}</li>
                                    <li>{{$transfer->reason_of_absence_2}}</li>
                                    <li>{{$transfer->reason_of_absence_3}}</li>
                                </ul>                                
                            </td>
                            <td class="border border-slate-300 px-4">
                                <ul class="ml-2 list-decimal text-center">
                                    <li>{{$transfer->alternative_day_1}}</li>
                                    <li>{{$transfer->alternative_day_2}}</li>
                                    <li>{{$transfer->alternative_day_3}}</li>
                                </ul>                                
                            </td>
                            <td class="border border-slate-300 px-4">
                                <ul class="ml-2 list-decimal text-center">
                                    <li>{{$transfer->formatted_time_from_alternative_1}}～{{$transfer->formatted_time_to_alternative_1}}</li>
                                    <li>{{$transfer->formatted_time_from_alternative_2}}～{{$transfer->formatted_time_to_alternative_2}}</li>
                                    <li>{{$transfer->formatted_time_from_alternative_3}}～{{$transfer->formatted_time_to_alternative_3}}</li>
                                </ul>                                
                            </td>
                            <td class="border border-slate-300 px-4">{{$transfer->sum_t_alt}}分</td>
                            <td class="border border-slate-300 px-4">{{$transfer->status}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</x-app-layout>