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
            <div id="meet"></div>

            <p>ルーム名：<span id="roomName">{{$room_name[0]}}</span></p>
            <x-primary-button class="mt-4" onclick="startMeeting()">
                ビデオ通話を開始
            </x-primary-button>
            <x-danger-button class="mt-4" onclick="endMeeting()">
                ビデオ通話を終了
            </x-danger-button>

            <script src="https://meet.jit.si/external_api.js"></script>
            <script>
                const domain = "meet.jit.si";
                const roomName = "showin_iidatonoka_{{$room_name[0]}}";

                function startMeeting() {
                    const domain = "meet.jit.si";
                    const roomName = "showin_iidatonoka_{{$room_name[0]}}";

                    const options = {
                        roomName: roomName,
                        parentNode: document.getElementById("meet"),
                        width: 800,
                        height: 600,
                        interfaceConfigOverwrite: {
                            SHOW_JITSI_WATERMARK: false, // ロゴ非表示
                            DISABLE_CHAT: false // チャット機能を有効化
                        },
                        configOverwrite: {
                            startWithVideoMuted: false, // ビデオ開始時の設定
                            startWithAudioMuted: false, // オーディオ開始時の設定
                            startScreenSharing: true, // 画面共有を有効化
                        }
                    };
                    api = new JitsiMeetExternalAPI(domain, options);
                }

                function endMeeting() {
                    if (api) {
                        api.dispose(); // 会議を終了
                    }
                }
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
