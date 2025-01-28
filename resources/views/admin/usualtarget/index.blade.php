<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            @include('layouts.adminmenu')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                日々の目標（管理者）＞{{ $user->name }}
            </h2>
        </x-slot>
        <div class="mx-auto px-6">
            <!-- 新規作成 -->
            <a href="{{route('admin.usualtarget.create', $user)}}" class="text-blue-600">新規作成</a>

            <!-- 普段の目標を表示 -->
            <div class="mb-6">
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <th></th>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">設定日</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標期限</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">状況</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">振り返り</td>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">獲得コイン数</td>
                    </tr>
                    @foreach($usualtargets as $usualtarget)
                        <tr>
                            <th class="border border-slate-300 px-4 w-1/12">
                                <a href="{{route('admin.usualtarget.edit', $usualtarget)}}" class="text-blue-600">編集</a>
                            </td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->formatted_set_date}}</td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->content}}</td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->formatted_due_date}}</td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->achieve_mark}}</td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->comment}}</td>
                            <td class="border border-slate-300 px-4">{{$usualtarget->coin}}</td>
                            </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</x-app-layout>