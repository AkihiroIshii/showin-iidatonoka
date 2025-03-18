<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$user->name}}さんのダッシュボード
        </h2>
    </x-slot>
    <!-- 変数定義 -->
    @php
        $trClass = '';
        $message = '';
    @endphp

    <!-- 更新情報 -->
    @if(Auth::user()->grade == "保護者")
        <p class="bg-yellow-200 px-4">更新情報</p>
        <ul class="list-disc px-8">
            <li>3/11 メニューに「検定」を追加しました。</li>
            <li>3/11 メニューに「志望校」を追加しました。（中高生対象）</li>
            <li>3/9  メニューに「試験結果」を追加しました。（中高生対象）</li>
        </ul>
    @else
        <p class="bg-yellow-200 px-4">更新情報</p>
        <ul class="list-disc px-8">
            <li>3/18 「試験結果」から問題と解答を閲覧できるようにしました。</li>
            <li>3/11 メニューに「検定」を追加しました。</li>
            <li>3/11 メニューに「志望校」を追加しました。（中高生対象）</li>
        </ul>
    @endif

    <!-- スマホ表示用 -->
    <div class="sm:hidden">
        <!-- 志望校を表示 -->
        @if(Str::contains(Auth::user()->grade, ['中','高','保護者']))
        <x-h3>志望校</x-h3>
        <div class="mb-6">
            @if(Auth::user()->grade != '保護者')
                <p><a href="{{route('top_choice.create', $user)}}" class="text-blue-600 font-bold">新規作成</a></p>
            @endif
            @foreach($top_choices as $choice)
                <div class="bg-sky-100 mb-4 p-2">
                    <p class="font-bold">
                        @if(Auth::user()->grade == '保護者')
                            {{$choice->name}}　 
                        @endif
                        第{{$choice->desired_ranking}}志望
                    </p>
                    <div class="ml-4">
                        <p>学校名：{{$choice->school_name}} </p>
                        <p>学部、学科：{{$choice->department}}</p>
                        <p>本試験日：{{$choice->exam_date}}</p>
                        <p>選抜方法：{{$choice->selection_method}}</p>
                        <p>募集定員：{{$choice->num_capacity}}</p>
                        <p>入試科目：{{$choice->subjects}}</p>
                        <p>模試：{{$choice->mock_date}}　{{$choice->mock_name}}　{{$choice->mock_judge}}</p>
                        <p>メモ：{{$choice->memo}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <!-- 普段の目標を表示 -->
        <x-h3>挑戦中の目標</x-h3>
        @foreach($usualtargets as $usualtarget)
            <div class="bg-sky-100 mb-4 p-2">
                <p>
                    <span class="font-bold">{{$usualtarget->name}}</span>
                    目標期限：{{$usualtarget->formatted_due_date}}
                </p>
                <p>{{$usualtarget->content}}</p>
            </div>
        @endforeach
        
        <x-h3>直近２ヵ月間のイベント</x-h3>
        @foreach($events as $event)
            <div class="bg-blue-100 mb-4 p-2">
                <p class="font-bold">{{$event->formatted_date}}：{{$event->name}}<p>
                <p>{{$event->content}}</p>
            </div>
        @endforeach
    </div>

    <!-- PC表示用 -->
    <div class="hidden sm:block mx-auto px-6 py-4">

        <!-- 志望校を表示 -->
        @if(Str::contains(Auth::user()->grade, ['中','高','保護者']))
            <x-h3>志望校</x-h3>
            <div class="mb-6">
                @if(Auth::user()->grade != '保護者')
                    <a href="{{route('top_choice.create', $user)}}" class="text-blue-600 font-bold">新規作成</a>
                @endif
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <tr class="bg-gray-300">
                        <x-th></x-th>
                        <x-th>志望順位</x-th>
                        <x-th>学校名</x-th>
                        <x-th>学部、学科</x-th>
                        <x-th>選抜方法</x-th>
                        <x-th>定員</x-th>
                        <x-th>入試日</x-th>
                        <x-th>入試科目</x-th>
                        <x-th>模試日</x-th>
                        <x-th>模試名</x-th>
                        <x-th>模試判定</x-th>
                        <x-th>メモ</x-th>
                    </tr>
                    @foreach($top_choices as $choice)
                        <tr>
                            <td class="border border-slate-300 px-4">
                                @if(Auth::user()->grade == '保護者')
                                    {{$choice->name}}
                                @else
                                    <a href="{{route('top_choice.edit', $choice)}}" class="text-blue-600">編集</a>
                                @endif
                            </td>
                            <td class="border border-slate-300 px-4">{{$choice->desired_ranking}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->school_name}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->department}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->selection_method}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->num_capacity}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->exam_date}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->subjects}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->mock_date}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->mock_name}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->mock_judge}}</td>
                            <td class="border border-slate-300 px-4">{{$choice->memo}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

        <!-- 普段の目標を表示 -->
        <x-h3>挑戦中の目標</x-h3>
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <x-th>生徒名</x-th>
                    <x-th>目標期限</x-th>
                    <x-th>目標</x-th>
                </tr>
                @foreach($usualtargets as $usualtarget)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$usualtarget->name}}</td>
                        <td class="border border-slate-300 px-4">{{$usualtarget->formatted_due_date}}</td>
                        <td class="border border-slate-300 px-4">{{$usualtarget->content}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        
        <x-h3>直近２ヵ月間のイベント</x-h3>
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
                        <td class="border border-slate-300 px-4">{{$event->formatted_date}}</td>
                        <td class="border border-slate-300 px-4">{{$event->content}}</td>
                        <td class="border border-slate-300 px-4">{{$event->name}}</td>
                        <td class="border border-slate-300 px-4">{!! $message !!}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <!-- イベントが登録されていない場合のメッセージ表示 -->
    <div class="ml-4 mb-4">
        <p>
            <span style="font-size:1rem;color:red;font-weight:bold;">
                (※)自分の学校の試験日などが表示されない人は、学校の年間予定表を先生に持ってきてください。先生が登録しておきます。
            </span>
        </p>
    </div>

</x-app-layout>
