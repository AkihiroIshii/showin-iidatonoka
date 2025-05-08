<x-app-layout>
    @if(Auth::user()->role == "admin" || Str::contains(Auth::user()->grade, ['中','高','保護者']))
        <x-slot name="header">
            @if(Auth::user()->role == "admin")
                @include('layouts.adminmenu')
            @endif
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                チャット（開発中：https://etama.jp/2000/）
                @if(Auth::user()->role == "admin")
                    ：{{$user->name}}
                @endif
            </h2>
        </x-slot>
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif

        <ul class="list-desc ml-4">
            <li>・申請中のものは編集できます。</li>
            <li>・承認済みのものは編集できません。</li>
        </ul>
        <!-- スマホ表示用 -->
        {{-- <div class="sm:hidden">
            <div class="mb-6">
                <p class="m-2"><a href="{{route('transfer.create', $user)}}" class="text-blue-600 font-bold">振替申請はこちら</a></p>
                @foreach($transfers as $transfer)
                    <div class="bg-sky-100 mb-4 p-2">
                        <p class="font-bold">
                            @if(Auth::user()->grade == '保護者')
                                {{$transfer->user_name}}（{{$transfer->status}}）　
                            @endif
                        </p>
                        <div class="ml-4">
                            <div class="mt-2">
                                <p>欠席した日（計{{$transfer->sum_t_abs}}分）</p>
                                <p>(1){{$transfer->day_of_absence_1}}　{{$transfer->formatted_time_from_absence_1}}～{{$transfer->formatted_time_to_absence_1}}</p>
                                <p>(2){{$transfer->day_of_absence_2}}　{{$transfer->formatted_time_from_absence_2}}～{{$transfer->formatted_time_to_absence_2}}</p>
                                <p>(3){{$transfer->day_of_absence_3}}　{{$transfer->formatted_time_from_absence_3}}～{{$transfer->formatted_time_to_absence_3}}</p>
                            </div>
                            <div class="mt-2">
                                <p>振替希望日（計{{$transfer->sum_t_alt}}分）</p>
                                <p>(1){{$transfer->alternative_day_1}}　{{$transfer->formatted_time_from_alternative_1}}～{{$transfer->formatted_time_to_alternative_1}}</p>
                                <p>(2){{$transfer->alternative_day_2}}　{{$transfer->formatted_time_from_alternative_2}}～{{$transfer->formatted_time_to_alternative_2}}</p>
                                <p>(3){{$transfer->alternative_day_3}}　{{$transfer->formatted_time_from_alternative_3}}～{{$transfer->formatted_time_to_alternative_3}}</p>
                            </div>
                            @if(Auth::user()->role == "admin" || $transfer->status == "申請中")
                                <x-primary-button class="mt-4">
                                    <a href="{{route('transfer.edit', $transfer)}}">編集</a>
                                </x-primary-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}

        <!-- PC表示用 -->
        <div id="chat-box">
            @foreach($messages as $msg)
                <p><strong>{{ $msg->user_id }}:</strong> {{ $msg->message }}</p>
            @endforeach
        </div>

        <input type="text" id="message-input" placeholder="メッセージを入力">
        <button id="send-btn">送信</button>
        {{-- <button onclick="sendMessage()">送信</button>
        <div>
            <button onclick="testGet()">GETテスト</button>
            <button onclick="sendFixedText()">POSTテスト</button>
        </div> --}}

        <script>
            document.getElementById('send-btn').addEventListener('click', () => {
                const message = document.getElementById('message-input').value;
                fetch('/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });
            });
        </script>

        {{-- <script>
            function sendMessage() {
                console.log("sendMessage() が呼ばれました！"); // ← 確認用
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const message = document.getElementById('message').value;
                console.log(message);
                fetch('/message/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('成功:', data);
                })
                .catch(error => {
                    console.error('エラー発生:', error);
                });
            }

            // チャンネル購読 & イベント受信
            // window.Echo.channel('chat-channel')
            //     .listen('.message.sent', (e) => {
            //         console.log('受信したメッセージ:', e.message);
            //         const chatBox = document.getElementById('chat-box');
            //         const newMessage = document.createElement('div');
            //         newMessage.textContent = e.message;
            //         chatBox.appendChild(newMessage);
            //     });

            //通信テスト用
            function sendFixedText() {
                const formData = new URLSearchParams();
                formData.append('message', '固定メッセージです！');

                fetch('/message/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('成功:', data);
                    alert(data.message); // 「固定メッセージです！」と表示される
                })
                .catch(error => {
                    console.error('エラー:', error);
                });
            }

            function testGet() {
                fetch('/message/test')
                    .then(response => response.json())
                    .then(data => {
                        console.log('成功:', data);
                        alert(data.message); // index 動いてます！ と表示される
                    })
                    .catch(error => {
                        console.error('エラー:', error);
                    });
            }
        </script> --}}
    @endif
</x-app-layout>