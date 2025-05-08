<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            テレ・スタディ（ビデオ通話）
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-4">
        <!-- テレ・スタディについて -->
        <div class="mt-8">
            <x-h3>テレ・スタディについて</x-h3>
            <ul>
                <li>・悪天候などで塾に行けないときは、先生とビデオ通話をしながらご自宅で学習できます。</li>
                <li>・ビデオ通話を利用するには、先生の許可が必要です。事前にご連絡ください。</li>
                <li class="ml-4">(※)ビデオ通話には、Jitsiを使います（メールアドレス不要）。</li>
            </ul>
        </div>

        @if($room_name->isEmpty())
            <p>通話用のルームが存在しません。塾長に確認してください。</p>
        @else
            <div class="mt-8">
                <x-h3>テレ・スタディの準備</x-h3>
                <u1 class="list-decimal">
                    <li>始める時間を、事前に塾長と決めておいてください。授業開始までに、下に書いてある通話の準備をしておきましょう。</li>
                    <li>
                        右のボタンをクリックし、ルーム名をコピーします。
                        <x-primary-button class="mt-4" onclick="copyButton('roomName')">
                            ルーム名をコピー
                        </x-primary-button>
                        　(※)ルーム名：<span id="roomName">showin_iidatonoka_{{$room_name[0]}}</span>
                    </li>
                    <li>
                        右のボタンを押して、Jitsi Meetのページを開きます。
                        <x-primary-button class="mt-4">
                            <a href="https://meet.jit.si/" target="_blank">Jitsi Meetを開く(外部)</a>
                        </x-primary-button>        
                    </li>
                    <li>コピーしたルーム名を画面中央のボックスに貼り付け、すぐ右の「ミーティングを開始」をクリックします。</li>
                    <li>「あなたの名前を入力して下さい」と書かれているボックスに、名前を入れます（ひらがな、ニックネームでもOK）。</li>
                    <li>
                        カメラはオフにしてもOKです。「ミーティングに参加」を押します。
                        <ul class="ml-4">
                            <li>(※)<span class="font-bold">英語の画面が出てきたら、下の方の「Join in browser」を押してください。</span>その後、「ミーティングを開始」します。</li>
                            <li>(※)「ホストの到着を待っています...」が出たら、そのまま先生が参加するまで待っていてください。</li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="mt-8">
                <x-h3>テレ・スタディの進め方</x-h3>
                <ul class="list-decimal ml-4">
                    <li>接続したら、学習する内容を先生と決めます。</li>
                    <li>
                        学習を進めます。
                        <ul class="ml-4">
                            <li>(※)カメラとマイクはオフ（ミュート）にしてもよいです。</li>
                            <li>(※)質問したいときは、マイクをオンにして話しかけてください。（先生はイヤホンをつけているので、映っていなくても聞こえます。）</li>
                            <li class="font-bold">(※)先生が声をかけるときもあるので、スピーカーはオンにしておいてください。</li>
                        </ul>
                    </li>
                    <li>最後に学習内容を振り返ります。</li>
                    <li>あいさつをしたら、ブラウザのタブを閉じて通話を終わります。</li>
                </ul>
            </div>


            {{-- <div>
                ルーム名：<span id="roomName">showin_iidatonoka_{{$room_name[0]}}</span>
                <x-primary-button class="mt-4" onclick="copyButton('roomName')">
                    ルーム名をコピー
                </x-primary-button>
            </div>
            <div>
                Jitsi Meetを開き、ルーム名を入力して、「ミーティングを開始」してください。
                <x-primary-button class="mt-4">
                    <a href="https://meet.jit.si/" target="_blank">Jitsi Meetを開く(外部)</a>
                </x-primary-button>    
            </div> --}}

            <script>
                function copyButton(elementId) {
                    // 指定したIDの要素のテキストを取得
                    var element = document.getElementById(elementId);
        
                    // テキストをクリップボードにコピー
                    navigator.clipboard.writeText(element.textContent);
                }
            </script>
            
            {{-- <div id="meet"></div>

            <p>ルーム名：<span id="roomName">{{$room_name[0]}}</span></p>
            <x-primary-button class="mt-4" onclick="startMeeting()">
                ビデオ通話を開始
            </x-primary-button>
            <x-danger-button class="mt-4" onclick="endMeeting()">
                ビデオ通話を終了
            </x-danger-button> --}}

            {{-- <script src="https://meet.jit.si/external_api.js"></script> --}}
            {{-- <script src='https://8x8.vc/vpaas-magic-cookie-fff7e061860c4bfebf77924c135bfbeb/external_api.js' async></script> --}}
            <script>
                // // const domain = "meet.jit.si";
                // // const domain = "8x8.vc";
                // // const roomName = "showin_iidatonoka_{{$room_name[0]}}";

                // function startMeeting() {
                //     // const domain = "meet.jit.si";
                //     const domain = "8x8.vc";
                //     const roomName = "showin_iidatonoka_{{$room_name[0]}}";

                //     const options = {
                //         roomName: roomName,
                //         parentNode: document.getElementById("meet"),
                //         jwt: "{{ $jwtToken }}", // ここでJWTを渡す
                //         width: 800,
                //         height: 600,
                //         interfaceConfigOverwrite: {
                //             SHOW_JITSI_WATERMARK: false, // ロゴ非表示
                //             DISABLE_CHAT: false // チャット機能を有効化
                //         },
                //         configOverwrite: {
                //             startWithVideoMuted: false, // ビデオ開始時の設定
                //             startWithAudioMuted: false, // オーディオ開始時の設定
                //             startScreenSharing: true, // 画面共有を有効化
                //         }
                //     };
                //     api = new JitsiMeetExternalAPI(domain, options);
                // }

                // function endMeeting() {
                //     if (api) {
                //         api.dispose(); // 会議を終了
                //     }
                // }
            </script>
        @endif

    </div>
</x-app-layout>


{{-- <!DOCTYPE html>
<html>
  <head>
    <script src='https://8x8.vc/vpaas-magic-cookie-fff7e061860c4bfebf77924c135bfbeb/external_api.js' async></script>
    <style>html, body, #jaas-container { height: 100%; }</style>
    <script type="text/javascript">
      window.onload = () => {
        const api = new JitsiMeetExternalAPI("8x8.vc", {
          roomName: "vpaas-magic-cookie-fff7e061860c4bfebf77924c135bfbeb/SampleAppSolarLibertiesExpireNotably",
          parentNode: document.querySelector('#jaas-container'),
                        // Make sure to include a JWT if you intend to record,
                        // make outbound calls or use any other premium features!
                        // jwt: "null"
        });
      }
    </script>
  </head>
  <body><div id="jaas-container" /></body>
</html> --}}
