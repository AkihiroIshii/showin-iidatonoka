<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ リンク集
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <!-- 変数定義 -->
        @php
            $trClass = 'bg-pink-200';
            $message = '';
        @endphp
        <div>
            <!-- 管理者用 -->
            @if(Auth::user()->role == "admin")
                <x-h3>管理者用</x-h3>
                <table class="border-separate border border-slate-400 m-auto table-fixed">
                    <thead>
                        <tr class="bg-gray-300">
                            <x-th>区分</x-th>
                            <x-th>内容</x-th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-blue-200">
                            <x-td>会計</x-td>
                            <x-td class="font-bold">
                                <div class="flex flex-wrap gap-4">
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://secure.freee.co.jp/" target="_blank">freee</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://showin.e-kaishu.jp/school.php" target="_blank">e海舟</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://showin.e-kaishu.net/webAccTfr/admin/login" target="_blank">e海舟(Web)</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://www.billing.ntt-east.co.jp/entrance" target="_blank">ビリング(NTT)</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://www3.lifecard.co.jp/WebDesk/" target="_blank">life card</a>
                                    </div>
                                </div>
                            </x-td>
                        </tr>
                        <tr class="bg-gray-200">
                            <x-td>管理画面（運用）</x-td>
                            <x-td class="font-bold">
                                <div class="flex flex-wrap gap-4">
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://www.showin-study.com/sms/smsSchool.php" target="_blank">生徒管理画面</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://showin-juku.jp/sReserve/management.php" target="_blank">体験予約システム</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-green-600">
                                        <a href="https://manager.line.biz/" target="_blank">LINE公式アカウント</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-green-600">
                                        <a href="https://www.and-mail.jp/school/" target="_blank">アンドメール</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://admin.jyukunavi.jp/#/admin_tool/admin/index" target="_blank">塾ナビ</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://showin-juku.jp/iida-tonoka/wp-login.php" target="_blank">松陰塾ホームページ</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="http://landisk-5d72d7/login" target="_blank">NAS</a>
                                    </div>
                                </div>
                            </x-td>
                        </tr>
                        <tr class="bg-sky-200">
                            <x-td>管理画面（教材）</x-td>
                            <x-td class="font-bold">
                                <div class="flex flex-wrap gap-4">
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-blue-600">
                                        <a href="https://www.mojiken.jp/mojiken_sms/smsSchool.php" target="_blank">moji蔵[管理]</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-purple-600">
                                        <a href="https://www.eikennet.jp/esms/smsSchool.php" target="_blank">英検ネットドリル[管理]</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-blue-600">
                                        <a href="https://trainer.kawaijukuone.jp/#/login" target="_blank">河合塾One[管理]</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://monoxer.com/schools/55052" target="_blank">Monoxer[管理]</a>
                                    </div>
                                </div>
                            </x-td>
                        </tr>
                        <tr class="bg-green-200">
                            <x-td>教材ログイン</x-td>
                            <x-td class="font-bold">
                                <div class="flex flex-wrap gap-4">
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-red-600">
                                        <a href="https://www.showin-study.com/aiShowinBrw/" target="_blank">AI-Showin</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-blue-600">
                                        <a href="https://www.mojiken.jp/mojiken/" target="_blank">moji蔵</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-purple-600">
                                        <a href="https://www.eikennet.jp/studyhtml5/" target="_blank">英検ネットドリル</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-red-600">
                                        <a href="https://school.veritas-academy.jp/#/" target="_blank">ベリタスアカデミー</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis text-blue-600">
                                        <a href="https://student.kawaijukuone.jp/#/login" target="_blank">河合塾One</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://app.monoxer.com/tasks" target="_blank">Monoxer</a>
                                    </div>
                                </div>
                            </x-td>
                        </tr>
                        <tr class="bg-gray-200">
                            <x-td>目標管理システム</x-td>
                            <x-td class="font-bold">
                                <div class="flex flex-wrap gap-4">
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://secure.sakura.ad.jp/rs/cp/" target="_blank">さくらレンタルサーバ</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://secure.sakura.ad.jp/rs/db/mysql5/index.php?route=/database/structure&db=ishii-akihiro_showin&server=135" target="_blank">phpmyadmin(さくら)</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="http://localhost:8080/index.php?route=/database/structure&db=showin_portal" target="_blank">phpMyAdmin(ローカル)</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://github.com/AkihiroIshii/showin-iidatonoka" target="_blank">github</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://tailwindcss.com/" target="_blank">tailWind CSS</a>
                                    </div>
                                </div>
                            </x-td>
                        </tr>
                        <tr>
                            <x-td>その他</x-td>
                            <x-td class="font-bold">
                                <div class="flex flex-wrap gap-4">
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://www.dust-nagano.com/content.php" target="_blank">有限会社ダスト</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://app.asana.com/" target="_blank">Asana</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://toggl.com/" target="_blank">toggl</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://kwd.kenkyusha.co.jp/lhe/dictionary/" target="_blank">英和辞典</a>
                                    </div>
                                    <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis">
                                        <a href="https://search.dual-d.net/SMK/main.cgi" target="_blank">国語辞典</a>
                                    </div>
                                </div>
                            </x-td>
                        </tr>
                    </tbody>
                </table>
            @endif



            <!-- 学習補助ツール -->
            <x-h3>学習補助ツール</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>教科</x-th>
                        <x-th>内容</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>数学</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://www.geogebra.org/calculator" target="_blank">GeoGebra(グラフ描画ツール)</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>理科</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-green-200">
                                    <a href="https://www.data.jma.go.jp/yoho/wxchart/quickmonthly.html" target="_blank">過去の実況天気図[気象庁]</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>社会</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://maps.ontarget.cc/azmap/" target="_blank">どこでも方位図法[(株)オンターゲット]</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://www.kunaicho.go.jp/learn/about/kosei/keizu.html" target="_blank">天皇系図[宮内庁]</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>国語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-red-200">
                                    <a href="https://www.sokunousokudoku.net/hakarukun/" target="_blank">読書速度ハカルくん[日本速読力教会]</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>英語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-purple-200">
                                    <a href="https://www.sokunousokudoku.net/measuresan/" target="_blank">英語総合読解力測定[日本速読力教会]</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>

            <!-- 教科書の付属資料 -->
            <x-h3>教科書の付属資料</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>教科</x-th>
                        <x-th>内容</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>数学</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://digi-keirin.com/js25/jsugaku/25jsugaku1.php" target="_blank">数学１</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://digi-keirin.com/js25/jsugaku/25jsugaku2.php" target="_blank">数学２</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://digi-keirin.com/js25/jsugaku/25jsugaku3.php" target="_blank">数学３</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>理科</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-green-200">
                                    <a href="https://tsho.jp/07j/r/1/" target="_blank">新しい科学１</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-green-200">
                                    <a href="https://tsho.jp/07j/r/2/" target="_blank">新しい科学２</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-green-200">
                                    <a href="https://tsho.jp/07j/r/3/" target="_blank">新しい科学３</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>社会</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://tks46.jp/07jhs/geo" target="_blank">中学生の地理</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://tks46.jp/07jhs/his" target="_blank">中学生の歴史</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://tks46.jp/07jhs/civ" target="_blank">中学生の公民</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>国語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-red-200">
                                    <a href="https://m-manabi.jp/07c/" target="_blank">国語１～３</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>英語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-purple-200">
                                    <a href="https://m-manabi.jp/06s/index2.html" target="_blank">Here We Go!（小学英語）</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-purple-200">
                                    <a href="https://sw121.tsho.jp/07jk/nh/1/" target="_blank">NEW HORIZON 1</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-purple-200">
                                    <a href="https://sw121.tsho.jp/07jk/nh/2/" target="_blank">NEW HORIZON 2</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-purple-200">
                                    <a href="https://sw121.tsho.jp/07jk/nh/3/" target="_blank">NEW HORIZON 3</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>

            <!-- 入試情報、検定情報 -->
            <x-h3>入試情報、検定情報</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>区分</x-th>
                        <x-th>内容</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>高校入試</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-green-200">
                                    <a href="https://www.pref.nagano.lg.jp/kyoiku/kyoiku/jukense/index.html" target="_blank">公立高校入試情報[県教委]</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-green-200">
                                    <a href="https://www.moshikai.jp/" target="_blank">なが模試</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>大学入試</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://www.dnc.ac.jp/" target="_blank">大学入試センター</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://www.keinet.ne.jp/university/ranking/" target="_blank">河合塾　入試難易予想ランキング表</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
                                    <a href="https://www.kawai-juku.ac.jp/zento/" target="_blank">河合塾 全統模試案内</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>検定</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://www.eiken.or.jp/eiken/schedule/" target="_blank">英検</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://www.su-gaku.net/suken/" target="_blank">数検・算検</a>
                                </div>
                                <div class="text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-yellow-200">
                                    <a href="https://www.nihongo.or.jp/" target="_blank">文字検</a>
                                </div>
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>




            {{-- <div class="flex flex-wrap gap-4">
                @foreach ($links as $link)
                    @php
                        if ($link->category == '学習システム') {
                            $trClass = 'bg-sky-200';
                        } elseif ($link->category == '学習補助ツール') {
                            $trClass = 'bg-pink-200';
                        } elseif ($link->category == '入試') {
                            $trClass = 'bg-green-200';
                        } elseif ($link->category == '管理') {
                            $trClass = 'bg-gray-200';
                        } elseif ($link->category == '会計') {
                            $trClass = 'bg-gray-400';
                        } else {
                            $trClass = 'bg-white';
                        }
                    @endphp
                    <div class="p-4 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis {!! $trClass !!}">
                        <a href="{{$link->link}}" target="_blank">{{$link->title}}</a>
                        @if(Auth::user()->role == "admin")
                            @if(isset($link->admin_link))
                                <a href="{{$link->admin_link}}" target="_blank" class="font-bold">[管理画面]</a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div> --}}
        </div>
</x-app-layout>