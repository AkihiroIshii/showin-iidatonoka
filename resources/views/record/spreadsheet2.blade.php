<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の集計表（年度区別なし）
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
        <!-- <p><b style="color:red;">(※)新規登録は上のメニューから↑</b></p> -->
        <!-- <x-primary-button class="mt-4">
            <a href="{{route('record.create')}}" class="text-blue-600">新規登録</a>
        </x-primary-button> -->
        <!-- <x-primary-button class="mt-4">
            <a href="{{route('record.explanation')}}" class="text-blue-600">過去問解説（作成中）</a>
        </x-primary-button> -->
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録　集計表（科目-大問ごと）
        </h2> -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed whitespace-nowrap">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">科目</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">大問</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">挑戦回数</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均配点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">最高点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均点/目標点</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">平均(分)</td>
                </tr>
                @foreach($questions as $question)
                <tr>
                    <td class="border border-slate-300 px-4">{{$question->subject}}</td>
                    <td class="border border-slate-300 px-4">{{$question->no}}</td>
                    <td class="border border-slate-300 px-4">{{$question->count}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_point}}</td>
                    <td class="border border-slate-300 px-4">{{$question->max_score}}/{{$question->target_score}}{{$question->max_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_score}}/{{$question->target_score}}{{$question->avg_mark}}</td>
                    <td class="border border-slate-300 px-4">{{$question->avg_minute}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>