{{-- <form method="GET" action="{{ route('meeting.join') }}">
    <p>ルーム名：<span id="roomName">{{$room_name[0]}}</span></p>
    <input type="text" name="roomName" placeholder="会議の名前を入力">
    <button type="submit">参加</button>
</form> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            テレ・スタディ（ビデオ通話）
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
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
    </div>
</x-app-layout>
