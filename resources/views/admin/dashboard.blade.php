<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                管理者専用ページ（生徒一覧）
            </h2>
        </x-slot>
        <div class="mx-auto px-6">
            <div>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">生徒名</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学年</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">学校</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">通塾頻度</td>
                    </tr>
                    @foreach($users as $user)
                    <tr>
                        <th class="border border-slate-300 px-4">
                            @if($user->grade =='中３')
                                <a href="{{route('admin.show', $user)}}" class="text-blue-600">過去問</a>
                            @endif
                        </td>
                        <td class="border border-slate-300 px-4">{{$user->user_name}}</td>
                        <td class="border border-slate-300 px-4">{{$user->grade}}</td>
                        <td class="border border-slate-300 px-4">{{$user->school_name}}</td>
                        <td class="border border-slate-300 px-4">{{$user->plan}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</x-app-layout>