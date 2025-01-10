<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                管理者専用ページ（リンク集）
            </h2>
        </x-slot>
        <div class="mx-auto px-6 py-10">
            <div class="mx-auto px-6">
                <!-- よく使うページ -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">よく使うページ</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://www.showin-study.com/sms/smsSchool.php" target="_blank">生徒管理</a>
                        </li>
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://secure.freee.co.jp/" target="_blank">freee</a>
                        </li>
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://www3.lifecard.co.jp/WebDesk/" target="_blank">life card</a>
                        </li>
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://www.dropbox.com/home/%E6%9D%BE%E9%99%B0%E5%A1%BE%E9%A3%AF%E7%94%B0%E6%AE%BF%E5%B2%A1%E6%A0%A1?di=left_nav_browse" target="_blank">Dropbox</a>
                        </li>
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://www.geogebra.org/calculator" target="_blank">GeoGebra</a>
                        </li>
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://maps.ontarget.cc/azmap/" target="_blank">正距方位図</a>
                        </li>
                        <li class="flex-auto text-center py-0 border-r border-black">
                            <a href="https://kwd.kenkyusha.co.jp/lhe/dictionary/" target="_blank">英和辞典</a>
                        </li>
                        <li class="flex-auto text-center py-0">
                            <a href="https://search.dual-d.net/SMK/main.cgi" target="_blank">国語辞典</a>
                        </li>
                    </ul>
                </div>
                <!-- ログイン画面 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">学習システム　生徒ログイン画面</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.showin-study.com/aiShowinBrw/" target="_blank">AI-Showin</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://student.kawaijukuone.jp/#/login" target="_blank">河合塾One</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://school.veritas-academy.jp" target="_blank">ベリタス</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.mojiken.jp/mojiken/" target="_blank">文字検</a></li>
                        <li class="flex-auto text-center py-0"><a href="https://www.eikennet.jp/studyhtml5/" target="_blank">英検ND</a></li>
                    </ul>
                </div>
                <!-- 管理画面 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">管理画面</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://trainer.kawaijukuone.jp/#/login" target="_blank">河合塾One</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.nihongo.or.jp/mojiken_sms/smsSchool.php" target="_blank">文字検</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.eikennet.jp/esms/smsSchool.php" target="_blank">英検ND</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.and-mail.jp/school/" target="_blank">アンドメール</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://showin.e-kaishu.jp/school.php" target="_blank">e海舟</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://showin.e-kaishu.net/webAccTfr/admin/login.php" target="_blank">e海舟(Web)</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="http://landisk-5d72d7/login" target="_blank">NAS</a></li>
                        <li class="flex-auto text-center py-0"><a href="http://localhost:8080/index.php?route=/database/structure&db=showin_portal" target="_blank">phpMyAdmin</a></li>
                    </ul>
                </div>
                <!-- 塾生用ページ管理 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">塾生用ポータルサイト管理</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://secure.sakura.ad.jp/rs/cp/" target="_blank">さくらレンタルサーバ</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://secure.sakura.ad.jp/rs/db/mysql5/index.php?route=/database/structure&db=ishii-akihiro_showin&server=135" target="_blank">phpmyadmin</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://github.com/AkihiroIshii/showin-iidatonoka" target="_blank">github</a></li>
                    </ul>
                </div>
                <!-- 生徒募集 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">生徒募集</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.showin-juku.jp/sReserve/management.php" target="_blank">体験予約システム</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://admin.jyukunavi.jp/" target="_blank">塾ナビ管理画面</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://showin-juku.jp/iida-tonoka/wp-login.php" target="_blank">飯田殿岡校HP管理画面（WP）</a></li>        
                        <li class="flex-auto text-center py-0"><a href="https://manager.line.biz/" target="_blank">LINE公式アカウント管理画面</a></li>
                    </ul>
                </div>
                <!-- 高校入試情報 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">高校入試情報</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.pref.nagano.lg.jp/kyoiku/koko/saiyo-nyuushi/shiken/ko/r6/r6nyushi.html" target="_blank">令和６年度公立高等学校入学者選抜情報（長野県教育委員会）</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.moshikai.jp/" target="_blank">なが模試</a></li>
                        <li class="flex-auto text-center py-0"><a href="https://test.shingakukai.or.jp/" target="_blank">信学会学力テスト</a></li>
                    </ul>
                </div>
                <!-- 大学入試情報 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">大学入試情報</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.kawai-juku.ac.jp/zento/" target="_blank">河合塾 全統模試案内</a></li>
                        <li class="flex-auto text-center py-0"><a href="https://www.keinet.ne.jp/university/ranking/" target="_blank">河合塾　入試難易予想ランキング表</a></li>               
                    </ul>
                </div>
                <!-- その他 -->
                <div>
                    <h3 class="text-center font-semibold text-xl my-2 bg-green-100">その他</h3>
                    <ul class="flex ml-30 list-none">
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://app.asana.com/" target="_blank">Asana</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.dust-nagano.com/content.php" target="_blank">有限会社ダスト</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.eiken.or.jp/eiken/schedule/" target="_blank">英語検定　日程</a></li>
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://page.line.me/476hpite?openQrModal=true" target="_blank">飯田殿岡校LINE友だち追加</a></li>   
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://tailwindcss.com/" target="_blank">tailWind CSS</a></li>   
                        <li class="flex-auto text-center py-0 border-r border-black"><a href="https://www.billing.ntt-east.co.jp/entrance" target="_blank">ビリング(NTT)</a></li>       
                        <li class="flex-auto text-center py-0"><a href="https://www.linkprocessing.jp/" target="_blank">LinkProcessing</a></li>   
                    </ul>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>