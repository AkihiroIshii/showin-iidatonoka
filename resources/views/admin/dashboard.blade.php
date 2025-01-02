<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者専用ページ
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            生徒一覧
        </h2>
        <div style="height:300px;grid-area:content;overflow:scroll;">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/12"></td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4 w-1/12">生徒名</td>
                </tr>
                @foreach($users as $user)
                <tr>
                    <th class="border border-slate-300 px-4 w-1/12">
                        <a href="{{route('admin.show', $user)}}" class="text-blue-600">編集</a>
                    </td>
                    <td class="border border-slate-300 px-4">{{$user->name}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>