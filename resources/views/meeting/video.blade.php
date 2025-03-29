<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            テレ・スタディ（ビデオ通話）
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        @if($room_name->isEmpty())
            <p>通話用のルームが存在しません。塾長に確認してください。</p>
        @else
            <div>
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
            </div>

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

        <!-- テレ・スタディについて -->
        <div class="mt-8">
            <p class="font-bold">テレ・スタディについて</p>
            <ul>
                <li>・悪天候などで塾に行けないときは、ご自宅で学習できます。</li>
                <li>・ビデオ通話を利用するには、先生の許可が必要です。事前にご連絡ください。</li>
            </ul>
        </div>
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
