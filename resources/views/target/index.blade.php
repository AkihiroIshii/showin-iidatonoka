<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @else
            @include('layouts.pastexam')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習＞目標点数
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        @if($targets->isEmpty())
            <p class="font-bold text-red-400">(※)何も表示されない人は、先生に登録してもらおう！</p>
        @else
            <p class="font-bold text-red-400">(※)目標点をクリックすると編集できます。</p>
        @endif

        @foreach($targets as $subject => $collection)
            <x-h3>{{$subject}}</x-h3>
            @if($allNoScores[$subject] != $totalScores[$subject])
                <p><b class="text-red-400">(※)全問の目標点（{{$allNoScores[$subject]}}点）が、各大問の目標点の合計（{{$totalScores[$subject]}}点）と一致していません。</b></p>
            @endif
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th class="border border-slate-300 px-4">大問番号</td>
                    <th class="border border-slate-300 px-4">目標点</td>
                    <th class="border border-slate-300 px-4">平均配点</td>
                    <th class="border border-slate-300 px-4">挑戦回数</td>
                    <th class="border border-slate-300 px-4">最高点</td>
                    <th class="border border-slate-300 px-4">平均点</td>
                    <th class="border border-slate-300 px-4">目標時間(分)</td>
                </tr>
                @foreach($collection as $target)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$target->no}}</td>
                        <th class="border border-slate-300 px-4">
                            <a href="{{route('target.edit', $target)}}" class="text-blue-600">{{$target->target_score}}</a>
                        </td>
                        <td class="border border-slate-300 px-4">/{{$target->avg_point}}</td>
                        <td class="border border-slate-300 px-4">{{$target->count}}</td>
                        <td class="border border-slate-300 px-4">{{$target->max_score}}{{$target->max_mark}}</td>
                        <td class="border border-slate-300 px-4">{{$target->avg_score}}{{$target->avg_mark}}</td>
                        <td class="border border-slate-300 px-4">{{$target->target_minute}}</td>
                    </tr>
                @endforeach
            </table>
        @endforeach
    </div>
</x-app-layout>