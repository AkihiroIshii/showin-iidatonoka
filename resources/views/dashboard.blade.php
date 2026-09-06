<x-app-layout>
    <x-slot name="header">
        <div class="text-right text-sm font-bold text-blue-700">(※)帰るときは必ずログアウト（Log Out）↑</div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$user->name}}さんのダッシュボード
        </h2>
    </x-slot>
    <!-- 変数定義 -->
    @php
        $trClass = '';
        $message = '';
    @endphp

    <!-- スマホ表示用 -->
    {{-- <div class="sm:hidden"> --}}
        {{-- <x-nav-link :href="route('workbook.unitbasedlist')" :active="request()->routeIs('workbook.unitbasedlist')">
            単元別学習
        </x-nav-link> --}}
        
        <!-- 普段の目標を表示 -->
        {{-- <x-h3>挑戦中の目標</x-h3>
        @foreach($usualtargets as $usualtarget)
            <div class="bg-sky-100 mb-4 p-2">
                <p>
                    <span class="font-bold">{{$usualtarget->name}}</span>
                    目標期限：{{$usualtarget->formatted_due_date}}
                </p>
                <p>{{$usualtarget->content}}</p>
            </div>
        @endforeach --}}
        
        {{-- <x-h3>直近２ヵ月間のイベント</x-h3>
        @foreach($events as $event)
            <div class="bg-blue-100 mb-4 p-2">
                <p class="font-bold">{{$event->formatted_date}}：{{$event->name}}<p>
                <p>{{$event->content}}</p>
            </div>
        @endforeach --}}
    {{-- </div> --}}

    <!-- PC表示用 -->
    {{-- <div class="hidden sm:block mx-auto px-6 py-4"> --}}

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            {{-- <x-nav-link :href="route('workbook.unitbasedlist')" :active="request()->routeIs('workbook.unitbasedlist')">
                単元別学習
            </x-nav-link> --}}
            {{-- <x-nav-link :href="route('workbook.randomsetting')" :active="request()->routeIs('workbook.randomsetting')">
                ランダム出題
            </x-nav-link> --}}
            {{-- <x-nav-link :href="route('event')" :active="request()->routeIs('event')">
                スケジュール管理
            </x-nav-link>
            <x-nav-link :href="route('admin.workbook')" :active="request()->routeIs('admin.workbook')">
                先生のおすすめ
            </x-nav-link> --}}
        </div>

        <!-- 現在の課題を表示 -->
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    @if(Auth::user()->role == "admin")
                        <x-th></x-th>
                    @endif
                    <x-th>生徒名</x-th>
                    <x-th>現在の課題</x-th>
                </tr>
                @foreach($kadais as $kadai)
                    <tr>
                        @if(Auth::user()->role == "admin")
                            <th class="border border-slate-300 px-4 w-1/12">
                                <a href="{{route('usualtarget.edit',  ['usualtarget' => $kadai->id])}}" class="text-blue-600">編集</a>
                            </th>
                        @endif
                        <td class="border border-slate-300 px-4">{{$kadai->name}}</td>
                        <td class="border border-slate-300 px-4">
                            <pre class="whitespace-pre-wrap">{{$kadai->content}}
                        </td>
                    </tr>
                @endforeach
            </table>

            <table class="mt-6 border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <x-th>生徒名</x-th>
                    <x-th>今月の目標</x-th>
                    <x-th>目標期限</x-th>
                </tr>
                @foreach($usualtargets as $usualtarget)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$usualtarget->name}}</td>
                        <td class="border border-slate-300 px-4">{{$usualtarget->content}}</td>
                        <td class="border border-slate-300 px-4">{{$usualtarget->formatted_due_date}}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{-- このシステムについて --}}
        <x-h3>このシステムについて</x-h3>
        <div class="inline-block pl-5 text-lg leading-[2]">
            <ul class="pl-5 list-disc">
                <li>松陰塾 飯田殿岡校 生徒向けの<span class="font-bold">補助教材</span>です。特定の分野を繰り返し演習したいときや、自主学習に使ってください。左上の「単元別学習」から単元を選べます。</li>
                <li>保護者との<span class="font-bold">目標共有</span>も兼ねています。課題と併せて上に記載しておりますので、家庭学習の参考になさってください。</li>
                <li>中３生は<span class="font-bold">過去問演習の記録管理</span>としても使います。</li>
            </ul>
        </div>

        {{-- 中学生のテスト勉強について --}}
        <x-h3>中学生のテスト勉強について</x-h3>
        <div class="mx-auto text-lg leading-[2]">
            <table class="mt-6 border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <x-th>教科</x-th>
                    <x-th>目標点数</x-th>
                    <x-th>学習の方針</x-th>
                </tr>
                <tr class="bg-sky-100">
                    <td rowspan="3" class="border border-slate-500 px-4">数学</td>
                    <td class="border border-slate-500 px-4">80点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>応用問題で解けない問題は、解説をしっかり読んで理解しましょう。</li>
                            <li>時間内に解けるように、関数や図形は様々なパターンに慣れておきましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-sky-100">
                    <td class="border border-slate-500 px-4">60点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>文章を読み取り、関係式で表せるようにしましょう。</li>
                            <li>関数は式（y=～）とグラフのイメージが繋がるようにしましょう。</li>
                            <li>ワークは基礎問題を完璧にしてから応用問題に取り組みましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-sky-100">
                    <td class="border border-slate-500 px-4">40点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li class="font-bold">応用問題に時間をかけるよりも、各分野の基礎をスラスラ解けるようにしましょう。</li>
                            <li>「絶対値」「自然数」「移項」など、数学用語の概念を理解しておきましょう。</li>
                            <li>計算ミスが多い場合、そもそも移項や約分のやり方が間違っているかもしれません。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-purple-100">
                    <td rowspan="3" class="border border-slate-500 px-4">英語</td>
                    <td class="border border-slate-500 px-4">80点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>時間内に文章を読めるように、長文になれておきましょう。</li>
                            <li>英作文が難しい時は、日本語での表現を簡単にしましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-purple-100">
                    <td class="border border-slate-500 px-4">60点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>教科書の本文はスラスラ音読できるようにしましょう。</li>
                            <li>教科書のkey sentenceは英語で書けるようにしておきましょう。</li>
                            <li>ワークは基礎問題を完璧にしてから応用問題に取り組みましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-purple-100">
                    <td class="border border-slate-500 px-4">40点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>英単語は覚えましょう。</li>
                            <li>教科書の本文は、QRコードの朗読を聞きながら目で追えるようにしましょう。</li>
                            <li>教科書のkey sentenceを理解し、<span class="font-bold">ワークの穴埋めと並び替えはできるようにしましょう。</span></li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-red-100">
                    <td rowspan="3" class="border border-slate-500 px-4">国語</td>
                    <td class="border border-slate-500 px-4">80点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>中３生は初見の文章も増えてきます。文章題を多く解いて慣れましょう。</li>
                            <li>古文や漢文は、まず音読できるように。意味は現代語訳と照らし合わせて確認しましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-red-100">
                    <td class="border border-slate-500 px-4">60点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>漢字の問題は全問正解できるくらいにしておきましょう。</li>
                            <li>文法は繰り返し演習が必要です。ワークを通して理解しましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-red-100">
                    <td class="border border-slate-500 px-4">40点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li class="font-bold">教科書の本文の内容を理解しておきましょう。</li>
                            <li>音読できない漢字があれば、その内容も理解できていないと思ってください。</li>
                            <li>設問の指示に従いましょう（抜き出せ、ひらがなで書け、など）。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-green-100">
                    <td rowspan="3" class="border border-slate-500 px-4">理科</td>
                    <td class="border border-slate-500 px-4">80点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>実験の文章題を時間内に解けるように、繰り返し演習して慣れましょう。</li>
                            <li>中２以降は、過不足のある化学反応の問題に慣れておきましょう。</li>
                            <li>用語の概念を説明できるように、理解しておきましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-green-100">
                    <td class="border border-slate-500 px-4">60点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>文章を読み取り、関係式で表せるようにしましょう。</li>
                            <li>理科の計算で比の関係は頻繁に使います。分数の方程式にも慣れましょう。</li>
                            <li>中２以降は、化学式を書けるようにしておきましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-green-100">
                    <td class="border border-slate-500 px-4">40点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li class="font-bold">実験の問題に取り組む前に、まず基礎用語を覚えましょう。</li>
                            <li>計算問題は、用語の概念が理解できてから取り組みましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-yellow-100">
                    <td rowspan="3" class="border border-slate-500 px-4">社会</td>
                    <td class="border border-slate-500 px-4">80点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>雨温図や数量のグラフを読み取れるようにしましょう。</li>
                            <li>仏教やキリスト教など、各時代の人々の思想を踏まえて史実を捉えましょう。</li>
                            <li>幕末以降は各国の敵対関係に注目しましょう。政治経済の理解も必要です。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-yellow-100">
                    <td class="border border-slate-500 px-4">60点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>扇状地などの用語について、説明できるようにしましょう。</li>
                            <li>各時代の末期には重大な出来事があります。経緯を理解しましょう。</li>
                        </ul>
                    </td>
                </tr>
                <tr class="bg-yellow-100">
                    <td class="border border-slate-500 px-4">40点</td>
                    <td class="border border-slate-500 px-4">
                        <ul class="pl-5 list-disc">
                            <li>代表的な国の位置を覚えましょう。教科書は太字の用語を覚えましょう。</li>
                            <li>歴史は、それぞれの時代の代表的な人物を、まずは一人ずつ覚えましょう。</li>
                            <li class="font-bold">各時代の中心地を把握しましょう（飛鳥時代⇒奈良、鎌倉時代⇒神奈川）。</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        
        {{-- <x-h3>直近２ヵ月間のイベント</x-h3>
        <!-- イベント表示 -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <x-th>日付</x-th>
                    <x-th>内容</x-th>
                    <x-th>関連校</x-th>
                    <x-th>お知らせ</x-th>
                </tr>
                @foreach($events as $event)
                    @php
                        // 試験イベントの場合
                        if ($event->test_flg == true) {
                            $trClass = 'bg-orange-200';

                            if(Auth::user()->role != "admin") {
                                $message = '<ul style="list-style:circle;" class="px-2">
                                                <li>通い放題＆兄弟特典：試験日の２週間前から１時間延長できます。</li>
                                                <li>試験範囲が書かれた紙を学校でもらったら、先生に見せてください。</li>
                                                <li>試験後、テスト成績表・問題・解説・答案は、先生に見せてください。</li>
                                            </ul>';
                            }
                        // 松陰塾イベントの場合
                        } elseif ($event->school_id == 901) {
                            $trClass = 'bg-sky-200';
                            $message = '';
                        } else {
                            $trClass = '';
                            $message = '';
                        }
                    @endphp
                    <tr class="{!! $trClass !!}">
                        <td class="border border-slate-500 px-4">{{$event->formatted_date}}</td>
                        <td class="border border-slate-500 px-4">{{$event->content}}</td>
                        <td class="border border-slate-500 px-4">{{$event->name}}</td>
                        <td class="border border-slate-500 px-4">{!! $message !!}</td>
                    </tr>
                @endforeach
            </table>
        </div> --}}
    {{-- </div> --}}

    {{-- <!-- イベントが登録されていない場合のメッセージ表示 -->
    <div class="ml-4 mb-4">
        <p>
            <span style="font-size:1rem;color:red;font-weight:bold;">
                (※)自分の学校の試験日などが表示されない人は、学校の年間予定表を先生に持ってきてください。先生が登録しておきます。
            </span>
        </p>
    </div> --}}

</x-app-layout>
