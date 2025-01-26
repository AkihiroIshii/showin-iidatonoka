<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            コイン取得方法
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
    <div style="display:flex;">
        <div class="px-6 py-4 text-lg font-semibold">
            <a href="{{route('gift')}}" class="text-blue-600 font-semibold">景品一覧</a>
        </div>
        <div class="px-6 py-4 text-lg font-semibold">
            ＞ コイン取得方法
        </div>
    </div>

    <div>
        <!-- コイン取得方法表示 -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">取得方法</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">獲得コイン数</th>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">備考</th>
                </tr>
                @foreach($howtogetcoins as $howtogetcoin)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$howtogetcoin->howtoget}}</td>
                        <td class="border border-slate-300 px-4">{{$howtogetcoin->coin}}</td>
                        <td class="border border-slate-300 px-4">{{$howtogetcoin->memo}}</td>
                    </tr>
                @endforeach
            </table>
        </div>



    </div>
</x-app-layout>