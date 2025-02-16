<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$user->name}}さんのダッシュボード
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp

        <!-- 更新情報 -->
        <p class="bg-yellow-200 px-4">2/16 更新情報</p>
        <ul style="list-style:circle;" class="px-4">
            <li>「イベント」、「リンク集」、「高校入試倍率」、「音源」、「景品」のメニューを、「その他情報」に集約しました。</li>
            <li>「その他情報」メニュー内に、「目的別対策」を追加しました。</li>
        </ul>

        <!-- 普段の目標を表示 -->
        <x-h3>挑戦中の目標</x-h3>
        <div class="mb-6">
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">目標期限</td>
                </tr>
                @foreach($usualtargets as $usualtarget)
                    <tr>
                        <td class="border border-slate-300 px-4">{{$usualtarget->content}}</td>
                        <td class="border border-slate-300 px-4">{{$usualtarget->formatted_due_date}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        
        <x-h3>直近２ヵ月間のイベント</x-h3>
        <!-- イベントが登録されていない場合のメッセージ表示 -->
        @if(Auth::user()->role != "admin")
            @if($numEvent == 0)
                <div class="ml-4 mb-4">
                    <p>
                        <span style="font-size:1rem;color:red;font-weight:bold;">
                            (※)自分の学校の試験日などが表示されない人は、学校の年間予定表を先生に持ってきてください。先生が登録しておきます。
                        </span>
                    </p>
                </div>
            @endif
        @endif

        <!-- イベント表示 -->
        <div>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <tr class="bg-gray-300">
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">日付</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">内容</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">関連校</td>
                    <th style="position:sticky;top:0;background-color:white;" class="border border-slate-300 px-4">お知らせ</td>
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

</x-app-layout>
