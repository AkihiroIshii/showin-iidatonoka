<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                管理者専用ページ（生徒一覧）
            </h2>
        </x-slot>
        <div class="mx-auto px-6">

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
                            <td class="border border-slate-300 px-4">{{$usualtarget->content}}</td>
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
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">挑戦中の目標</td>
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
                            </th>
                            <td class="border border-slate-300 px-4">{{$user->user_name}}</td>
                            <td class="border border-slate-300 px-4">{{$user->grade}}</td>
                            <td class="border border-slate-300 px-4">
                                @if(isset($user->content))
                                    {{$user->due_date}}：{{$user->content}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</x-app-layout>