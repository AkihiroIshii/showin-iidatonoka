<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            目標設定　個別表示
        </h2>
    </x-slot>
    @if($target->user->id==Auth::id())
    <div class="py-6">
        <table class="border-separate border border-slate-400 m-auto table-fixed">
            <tr class="bg-gray-300">
                <th class="border border-slate-300 px-4"></td>
                <th class="border border-slate-300 px-4">科目</td>
                <th class="border border-slate-300 px-4">大問番号</td>
                <th class="border border-slate-300 px-4">目標点数</td>
                <th class="border border-slate-300 px-4">目標時間(分)</td>
            </tr>
            <tr>
                <th class="border border-slate-300 px-4">
                    <a href="{{route('target.edit', $target)}}" class="text-blue-600">編集</a>
                </td>
                <td class="border border-slate-300 px-4">{{$target->subject}}</td>
                <td class="border border-slate-300 px-4">{{$target->no}}</td>
                <td class="border border-slate-300 px-4">{{$target->target_score}}</td>
                <td class="border border-slate-300 px-4">{{$target->target_minute}}</td>
            </tr>
        </table>
    </div>
    @endif
</x-app-layout> -->