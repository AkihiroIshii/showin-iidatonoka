<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                管理者専用ページ（生徒一覧）
            </h2>
        </x-slot>
        <div class="mx-auto px-6">
            <!-- お知らせ -->
            <x-h3>お知らせ</x-h3>
            <div class="mb-6 mt-4">
                @foreach($informations as $info)
                    <ul class="list-disc px-8">
                        <li>{{$info->content}}</li>
                    </ul>
                @endforeach
            </div>

            <!-- 振替申請中 -->
            <x-h3>振替申請中</x-h3>
            <div class="mb-6 mt-4">
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th class="bg-white border border-slate-300" colspan="1"></th>
                        <th class="bg-white border border-slate-300" colspan="4">欠席した日</th>
                        <th class="bg-white border border-slate-300" colspan="3">振替希望日</th>
                        <th class="bg-white border border-slate-300" colspan="1"></th>
                    </tr>
                    <tr class="bg-gray-300">
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

            <x-h3>本日が期限の目標</x-h3>
            <div class="mb-6">
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">生徒名</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">挑戦中の目標</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標期限</td>
                    </tr>
                    @foreach($usualtargets as $usualtarget)
                        <tr>
                            <td class="border border-slate-300 px-4">{{$usualtarget->name}}</td>
                            <td class="border border-slate-300 px-4"><pre>{{$usualtarget->content}}</pre></td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->due_date}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <x-h3>生徒一覧</x-h3>
            <!-- 新規作成 -->
            <a href="{{route('admin.user.create')}}" class="text-blue-600">新規ユーザ作成</a>           
            <div>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">生徒名</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">通塾頻度</td>
                    </tr>
                    @foreach($users as $user)
                    @php
                        if(isset($user->expiration_date)) {
                            $trClass = 'bg-gray-300';
                        } elseif(strpos($user->grade, '中３') !== false) {
                            $trClass = 'bg-sky-200';
                        } elseif(strpos($user->grade, '中') !== false) {
                            $trClass = 'bg-sky-100';
                        } elseif(strpos($user->grade, '小') !== false) {
                            $trClass = 'bg-yellow-100';
                        } elseif(strpos($user->grade, '高') !== false)  {
                            $trClass = 'bg-pink-100';
                        }
                    @endphp
                    <tr class="{!! $trClass !!}">
                        <th class="border border-slate-300 px-4">
                            <a href="{{route('admin.setStudent', $user)}}" class="text-blue-600">詳細</a>
                        </td>
                        <td class="border border-slate-300 px-4">{{$user->user_name}}</td>
                        <td class="border border-slate-300 px-4">{{$user->grade}}</td>
                        <td class="border border-slate-300 px-4">{{$user->plan}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</x-app-layout>