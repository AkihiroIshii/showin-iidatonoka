<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問の目標点数
        </h2>
    </x-slot>
    @if($user->id==Auth::id())
    <div class="px-20 py-2 font-bold text-red-400">
        目標点をクリックすると編集できます。
    </div>
    <div class="py-6">
        <table class="border-separate border border-slate-400 m-auto table-fixed">
            <tr class="bg-gray-300">
                <th class="border border-slate-300 px-4">科目</td>
                <th class="border border-slate-300 px-4">大問番号</td>
                <th class="border border-slate-300 px-4">目標点</td>
                <th class="border border-slate-300 px-4">平均配点</td>
                <th class="border border-slate-300 px-4">挑戦回数</td>
                <th class="border border-slate-300 px-4">最高点</td>
                <th class="border border-slate-300 px-4">平均点</td>
                <th class="border border-slate-300 px-4">目標時間(分)</td>
            </tr>
            @foreach($targets as $target)
            <tr>
                <td class="border border-slate-300 px-4">{{$target->subject}}</td>
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
    </div>
    @endif
</x-app-layout>