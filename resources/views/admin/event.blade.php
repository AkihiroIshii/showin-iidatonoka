<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント一覧
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">日付</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">関連校</td>
                </tr>
                @foreach($events as $event)
                <tr>
                    @if($event->test_flg == true)
                        <td class="border border-slate-300 px-4 font-bold">{{$event->formatted_date}}</td>
                        <td class="border border-slate-300 px-4 font-bold">{{$event->content}}</td>
                        <td class="border border-slate-300 px-4 font-bold">{{$event->name}}</td>
                    @else
                        <td class="border border-slate-300 px-4">{{$event->formatted_date}}</td>
                        <td class="border border-slate-300 px-4">{{$event->content}}</td>
                        <td class="border border-slate-300 px-4">{{$event->name}}</td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>