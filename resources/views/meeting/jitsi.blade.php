<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jitsi Meet</title>
</head>
<body>
    <div id="meet"></div>

    <button onclick="startMeeting()">会議を開始</button>
    <button onclick="endMeeting()">会議を終了</button>

    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        let api;

        function startMeeting() {
            const domain = "meet.jit.si";
            const roomName = "showin_iidatonoka_2009j020";

            const options = {
                // roomName: "LaravelJitsiMeeting_{{ uniqid() }}", // 一意のルーム名
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
</body>
</html>
