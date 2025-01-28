<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            普段の目標一覧
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp

        <!-- 普段の目標を表示 -->
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">設定日</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標期限</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">状況</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">振り返り</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">獲得コイン数</td>
                </tr>
                @foreach($usualtargets as $usualtarget)
                    <tr>
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
</x-app-layout>