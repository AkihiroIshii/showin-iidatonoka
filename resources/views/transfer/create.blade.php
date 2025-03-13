<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            振替申請
            @if(Auth::user()->role == "admin")
                ：{{$user->name}}
            @endif
        </h2>
    </x-slot>
    <div class="maxw-7xl mx-auto px-6"> 
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        @auth
        <div class="mt-2">
            <p class="font-bold">注意事項</p>
            <ul class="list-desc">
                <li>・高校生本人と保護者が申請できます。</li>
                <li>・LINEやお電話でも受け付けます。</li>
                <li>・振替希望日の２日前までに申請してください。</li>
                <li>・(1)の項目は入力必須です。</li>
                <li>・<span class="font-bold">無断欠席した分は振替できかねます。</span></li>
            </ul>
        </div>

        <form method="post" action="{{ route('transfer.store') }}">
            @csrf

            <div class="mt-8">
                <x-input-error :messages="$errors->get('sum_check')" class="mt-2" />
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                <label for="user_id" class="font-semibold mt-4">対象の生徒</label>
                <select type="string" name="user_id" class="w-auto py-2 border border-gray-300 rounded-md" id="user_id">
                    <option value="">選択してください。</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>     
            </div>

            <x-h3>欠席した日</x-h3>
            <div>
                (1)
                <div class="ml-4">
                    <x-input-error :messages="$errors->get('day_of_absence_1')" class="mt-2" />
                    <label for="day_of_absence_1" class="font-semibold mt-4">欠席日</label>
                    <input type="date" name="day_of_absence_1" class="w-auto py-2 border border-gray-300 rounded-md" id="day_of_absence_1" value="{{old('day_of_absence_1')}}">
                </div>
                <div class="ml-4">
                    <x-input-error :messages="$errors->get('time_from_absence_1')" class="mt-2" />
                    <label for="time_from_absence_1" class="font-semibold mt-4">開始時間</label>
                    <input type="time" name="time_from_absence_1" class="w-auto py-2 border border-gray-300 rounded-md" id="time_from_absence_1" value="{{old('time_from_absence_1')}}">
                </div>
                <div class="ml-4">
                    <x-input-error :messages="$errors->get('time_to_absence_1')" class="mt-2" />
                    <label for="time_to_absence_1" class="font-semibold mt-4">終了時間</label>
                    <input type="time" name="time_to_absence_1" class="w-auto py-2 border border-gray-300 rounded-md" id="time_to_absence_1" value="{{old('time_to_absence_1')}}">
                </div>
                <div class="ml-4">
                    <div>
                        <x-input-error :messages="$errors->get('reason_of_absence_1')" class="mt-2" />
                        <label for="reason_of_absence_1" class="font-semibold mt-4">欠席理由</label>
                        @php
                            $reasons = ['体調不良、怪我','学校行事','送迎不可','家庭の事情','悪天候'];
                        @endphp
                        <select type="string" name="reason_of_absence_1" class="w-auto py-2 border border-gray-300 rounded-md" id="reason_of_absence_1">
                            <option value="">選択してください。</option>
                            @foreach($reasons as $reason)
                                <option value="{{ $reason }}" {{ old('reason_of_absence_1') == $reason ? 'selected' : '' }}>
                                    {{ $reason }}
                                </option>
                            @endforeach
                        </select>     
                    </div>
                </div>
                <details class="mt-2 border border-gray-300 p-2 rounded-lg">
                    <summary class="cursor-pointer text-blue-500 font-semibold">あと２件追加できます。</summary>
                    (2)
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('day_of_absence_2')" class="mt-2" />
                        <label for="day_of_absence_2" class="font-semibold mt-4">欠席日</label>
                        <input type="date" name="day_of_absence_2" class="w-auto py-2 border border-gray-300 rounded-md" id="day_of_absence_2" value="{{old('day_of_absence_2')}}">
                    </div>
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('time_from_absence_2')" class="mt-2" />
                        <label for="time_from_absence_2" class="font-semibold mt-4">開始時間</label>
                        <input type="time" name="time_from_absence_2" class="w-auto py-2 border border-gray-300 rounded-md" id="time_from_absence_2" value="{{old('time_from_absence_2')}}">
                    </div>
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('time_to_absence_2')" class="mt-2" />
                        <label for="time_to_absence_2" class="font-semibold mt-4">終了時間</label>
                        <input type="time" name="time_to_absence_2" class="w-auto py-2 border border-gray-300 rounded-md" id="time_to_absence_2" value="{{old('time_to_absence_2')}}">
                    </div>
                    <div class="ml-4">
                        <div>
                            <x-input-error :messages="$errors->get('reason_of_absence_2')" class="mt-2" />
                            <label for="reason_of_absence_2" class="font-semibold mt-4">欠席理由</label>
                            @php
                                $reasons = ['体調不良、怪我','学校行事','送迎不可','家庭の事情','悪天候'];
                            @endphp
                            <select type="string" name="reason_of_absence_2" class="w-auto py-2 border border-gray-300 rounded-md" id="reason_of_absence_2">
                                <option value="">選択してください。</option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason }}" {{ old('reason_of_absence_2') == $reason ? 'selected' : '' }}>
                                        {{ $reason }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </div>
                    (3)
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('day_of_absence_3')" class="mt-2" />
                        <label for="day_of_absence_3" class="font-semibold mt-4">欠席日</label>
                        <input type="date" name="day_of_absence_3" class="w-auto py-2 border border-gray-300 rounded-md" id="day_of_absence_3" value="{{old('day_of_absence_3')}}">
                    </div>
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('time_from_absence_3')" class="mt-2" />
                        <label for="time_from_absence_3" class="font-semibold mt-4">開始時間</label>
                        <input type="time" name="time_from_absence_3" class="w-auto py-2 border border-gray-300 rounded-md" id="time_from_absence_3" value="{{old('time_from_absence_3')}}">
                    </div>
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('time_to_absence_3')" class="mt-2" />
                        <label for="time_to_absence_3" class="font-semibold mt-4">終了時間</label>
                        <input type="time" name="time_to_absence_3" class="w-auto py-2 border border-gray-300 rounded-md" id="time_to_absence_3" value="{{old('time_to_absence_3')}}">
                    </div>
                    <div class="ml-4">
                        <div>
                            <x-input-error :messages="$errors->get('reason_of_absence_3')" class="mt-2" />
                            <label for="reason_of_absence_3" class="font-semibold mt-4">欠席理由</label>
                            @php
                                $reasons = ['体調不良、怪我','学校行事','送迎不可','家庭の事情','悪天候'];
                            @endphp
                            <select type="string" name="reason_of_absence_3" class="w-auto py-2 border border-gray-300 rounded-md" id="reason_of_absence_3">
                                <option value="">選択してください。</option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason }}" {{ old('reason_of_absence_3') == $reason ? 'selected' : '' }}>
                                        {{ $reason }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </details>
                </div>

                <x-h3>振替希望日</x-h3>
                <div>
                    (1)
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('alternative_day_1')" class="mt-2" />
                        <label for="alternative_day_1" class="font-semibold mt-4">希望日</label>
                        <input type="date" name="alternative_day_1" class="w-auto py-2 border border-gray-300 rounded-md" id="alternative_day_1" value="{{old('alternative_day_1')}}">
                    </div>
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('time_from_alternative_1')" class="mt-2" />
                        <label for="time_from_alternative_1" class="font-semibold mt-4">開始時間</label>
                        <input type="time" name="time_from_alternative_1" class="w-auto py-2 border border-gray-300 rounded-md" id="time_from_alternative_1" value="{{old('time_from_alternative_1')}}">
                    </div>
                    <div class="ml-4">
                        <x-input-error :messages="$errors->get('time_to_alternative_1')" class="mt-2" />
                        <label for="time_to_alternative_1" class="font-semibold mt-4">終了時間</label>
                        <input type="time" name="time_to_alternative_1" class="w-auto py-2 border border-gray-300 rounded-md" id="time_to_alternative_1" value="{{old('time_to_alternative_1')}}">
                    </div>
                    <details class="mt-2 border border-gray-300 p-2 rounded-lg">
                        <summary class="cursor-pointer text-blue-500 font-semibold">あと２件追加できます。</summary>
                        (2)
                        <div class="ml-4">
                            <x-input-error :messages="$errors->get('alternative_day_2')" class="mt-2" />
                            <label for="alternative_day_2" class="font-semibold mt-4">希望日</label>
                            <input type="date" name="alternative_day_2" class="w-auto py-2 border border-gray-300 rounded-md" id="alternative_day_2" value="{{old('alternative_day_2')}}">
                        </div>
                        <div class="ml-4">
                            <x-input-error :messages="$errors->get('time_from_alternative_2')" class="mt-2" />
                            <label for="time_from_alternative_2" class="font-semibold mt-4">開始時間</label>
                            <input type="time" name="time_from_alternative_2" class="w-auto py-2 border border-gray-300 rounded-md" id="time_from_alternative_2" value="{{old('time_from_alternative_2')}}">
                        </div>
                        <div class="ml-4">
                            <x-input-error :messages="$errors->get('time_to_alternative_2')" class="mt-2" />
                            <label for="time_to_alternative_2" class="font-semibold mt-4">終了時間</label>
                            <input type="time" name="time_to_alternative_2" class="w-auto py-2 border border-gray-300 rounded-md" id="time_to_alternative_2" value="{{old('time_to_alternative_2')}}">
                        </div>
                        (3)
                        <div class="ml-4">
                            <x-input-error :messages="$errors->get('alternative_day_3')" class="mt-2" />
                            <label for="alternative_day_3" class="font-semibold mt-4">希望日</label>
                            <input type="date" name="alternative_day_3" class="w-auto py-2 border border-gray-300 rounded-md" id="alternative_day_3" value="{{old('alternative_day_3')}}">
                        </div>
                        <div class="ml-4">
                            <x-input-error :messages="$errors->get('time_from_alternative_3')" class="mt-2" />
                            <label for="time_from_alternative_3" class="font-semibold mt-4">開始時間</label>
                            <input type="time" name="time_from_alternative_3" class="w-auto py-2 border border-gray-300 rounded-md" id="time_from_alternative_3" value="{{old('time_from_alternative_3')}}">
                        </div>
                        <div class="ml-4">
                            <x-input-error :messages="$errors->get('time_to_alternative_3')" class="mt-2" />
                            <label for="time_to_alternative_3" class="font-semibold mt-4">終了時間</label>
                            <input type="time" name="time_to_alternative_3" class="w-auto py-2 border border-gray-300 rounded-md" id="time_to_alternative_3" value="{{old('time_to_alternative_3')}}">
                        </div>
                    </details>

                </div>
    
                <x-primary-button class="mt-4">
                    登録
                </x-primary-button>
            </form>
        @endauth
    </div>
</x-app-layout>