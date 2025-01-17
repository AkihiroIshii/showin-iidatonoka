<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録一覧
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        @auth
            @foreach($user as $u)
                {{$u->name}}さんログイン中
            @endforeach
        @else
            ログインできていません
        @endauth
        
        <!-- @php
            $pass="karina27";
            echo(bcrypt($pass));
        @endphp -->
        <p><b style="color:red;">(※)新規登録は上のメニューから↑</b></p>
        <!-- <x-primary-button class="mt-4">
            <a href="{{route('record.create')}}" class="text-blue-600">新規登録</a>
        </x-primary-button> -->
        <!-- <x-primary-button class="mt-4">
            <a href="{{route('record.explanation')}}" class="text-blue-600">過去問解説（作成中）</a>
        </x-primary-button> -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録　一覧
        </h2>
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4"></td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">解いた日</td>
                    <!-- <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">生徒名</td> -->
                    <!-- <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">種類</td> -->
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">年度</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">得点/配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">得点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">解答時間(分)</td>
                </tr>
                @foreach($records as $record)
                <tr>
                    <th class="border border-slate-300 px-4 w-1/12">
                        <a href="{{route('record.edit', $record)}}" class="text-blue-600">編集</a>
                    </td>
                    <td class="border border-slate-300 px-4">{{$record->date}}</td>
                    <!-- <td class="border border-slate-300 px-4">{{$record->user->name}}</td> -->
                    <!-- <td class="border border-slate-300 px-4">{{$record->question->type}}</td> -->
                    <td class="border border-slate-300 px-4">{{$record->question->year}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->no}}</td>
                    <td class="border border-slate-300 px-4">{{$record->question->content}}</td>
                    <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->question->point}}</td>
                    <td class="border border-slate-300 px-4">{{$record->score}}/{{$record->target_score}}{{$record->target_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$record->minute}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>