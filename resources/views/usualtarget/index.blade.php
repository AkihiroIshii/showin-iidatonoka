<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            月間目標
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp
        
        <!-- 新規作成 -->
        @if(Auth::user()->role == "admin")
            <a href="{{route('usualtarget.create', $user)}}" class="text-blue-600">新規作成</a>
        @endif

        {{-- <!-- 獲得コイン数を表示 -->        
        @if(Auth::user()->grade != "保護者")
            <x-h3>目標達成で獲得したコイン</x-h3>
            <div>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">先月</th>
                        <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">今月</th>
                    </tr>
                    <tr class="bg-gray-300">
                        <td style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">{{$lastMonthCoinSum}}枚</td>
                        <td style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">{{$thisMonthCoinSum}}枚</td>
                    </tr>
                </table>
                <div class="mr-4 mb-4 text-right">
                    (※)ここで獲得したコインは、毎月一日ごろに前月分をまとめてAI-Showinに反映します。
                </div>
            </div>
        @endif --}}

        <!-- 普段の目標を表示 -->
        <x-h3>月間目標</x-h3>
        <!-- スマホ表示用 -->
        <div class="sm:hidden">
            <!-- 普段の目標を表示 -->
            @foreach($grouped_usualtargets as $usualtargets)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$usualtargets[0]["name"]}}</x-h4>
                    </div>
                @endif
                @foreach($usualtargets as $usualtarget)
                    <div class="bg-sky-100 mb-4 p-2">
                        {{-- <p>目標期限：{{$usualtarget->formatted_due_date}}</p> --}}
                        <p class="mb-4"><span class="font-bold">目標：</span>{{$usualtarget->content}}</p>
                        @if(!empty($usualtarget->comment))
                            <p class="mb-4">
                                <span class="font-bold">コメント：</span>
                                <ul>
                                    <li>⇒{{$usualtarget->achieve_mark}}</li>
                                    <li>{{$usualtarget->comment}}</li>
                                </ul>
                            </p>
                        @endif
                        {{-- <p>獲得コイン数：{{$usualtarget->coin}}</p> --}}
                        @if(!empty($usualtarget->teacher_comment))
                            <p class="mb-4"><span class="font-bold">先生の評価：</span>{{$usualtarget->teacher_comment}}</p>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- PC表示用 -->
        <div class="hidden sm:block mb-6 max-w-full">
            {{-- <p>獲得コイン数は、次の条件を満たすと多くもらえるかも、、？　(※)評価基準は変わることがあります。</p>
            <p>⇒目標や振り返りが具体的である。／無理のない目標設定ができている。／計画性がある。／意欲的に挑戦している。／柔軟に軌道修正ができている。など</p> --}}

            @foreach($grouped_usualtargets as $usualtargets)
                @if(Auth::user()->grade == "保護者")
                    <div class="mt-6">
                        <x-h4>{{$usualtargets[0]["name"]}}</x-h4>
                    </div>
                @endif
                <table class="border-separate border border-slate-400 m-auto table-fixed mt-2">
                    <tr class="bg-gray-300">
                        @if(Auth::user()->role == "admin")
                            <th></th>
                        @endif
                        {{-- <x-th>設定日</x-th> --}}
                        <x-th>目標</x-th>
                        {{-- <x-th>目標期限</x-th> --}}
                        <x-th>振り返り</x-th>
                        {{-- <x-th>先生の評価</x-th> --}}
                        {{-- <x-th>獲得コイン数</x-th> --}}
                    </tr>
                    @foreach($usualtargets as $usualtarget)
                        <tr>
                            @if(Auth::user()->role == "admin")
                                <th class="border border-slate-300 px-4 w-1/12">
                                    <a href="{{route('usualtarget.edit', $usualtarget)}}" class="text-blue-600">編集</a>
                                </th>
                            @endif
                            {{-- <td class="border border-slate-300 px-4">{{$usualtarget->formatted_set_date}}</td> --}}
                            <td class="border border-slate-300 px-4"><pre class="whitespace-pre-wrap">{{$usualtarget->content}}</pre></td>
                            {{-- <td class="border border-slate-300 px-4"><pre class="whitespace-pre-wrap">{{$usualtarget->formatted_due_date}}</pre></td> --}}
                            <td class="border border-slate-300 px-4">
                                @if(!empty($usualtarget->comment))
                                    <ul>
                                        <li>{{$usualtarget->achieve_mark}}</li>
                                        <li>{{$usualtarget->comment}}</li>
                                    </ul>
                                @endif
                                @if(!empty($usualtarget->teacher_comment))
                                    <p><span class="font-bold">先生の評価：</span>{{$usualtarget->teacher_comment}}</p>
                                @endif
                            </td>
                            {{-- <td class="border border-slate-300 px-4">{{$usualtarget->coin}}</td> --}}
                        </tr>
                    @endforeach
                </table>
            @endforeach
        </div>
        
    </div>
</x-app-layout>