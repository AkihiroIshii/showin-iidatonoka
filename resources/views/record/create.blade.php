<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @else
            @include('layouts.pastexam')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習＞新規登録
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
            <form method="post" action="{{ route('record.store') }}">
                @csrf

                <div class="mt-8">
                    <div>
                        <label for="date" class="font-semibold mt-4">解いた日</label>
                        <input type="date" name="date" class="w-auto py-2 border border-gray-300 rounded-md" id="date" value="<?php echo date('Y-m-j');?>">
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                        <label for="year" class="font-semibold mt-4">過去問年度</label>
                        @php
                            $years = ['2025','2024','2023','2022','2021','2020','なが模試 第1回','なが模試 第2回','なが模試 第3回','なが模試 第4回','なが模試 第5回','なが模試 第6回','なが模試 第7回','なが模試 第8回'];
                        @endphp
                        <select type="string" name="year" class="w-auto py-2 border border-gray-300 rounded-md" id="year">
                            <option value="">選択してください。</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>     
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        <label for="subject" class="font-semibold mt-4">科目</label>
                        @php
                            $subjects = ['国語','数学','社会','理科','英語'];
                        @endphp
                        <select type="string" name="subject" class="w-auto py-2 border border-gray-300 rounded-md" id="subject">
                            <option value="">選択してください。</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject }}" {{ old('subject') == $subject ? 'selected' : '' }}>
                                    {{ $subject }}
                                </option>
                            @endforeach
                        </select>     
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('no')" class="mt-2" />
                        <label for="no" class="font-semibold mt-4">大問番号</label>
                        @php
                            $noValues = ['1','2','3','4','5','6','7','8','9','全問'];
                            $noDisplays = ['問１','問２','問３','問４','問５','問６','問７','問８','問９','全問'];
                        @endphp
                        <select type="string" name="no" class="w-auto py-2 border border-gray-300 rounded-md" id="no">
                            <option value="">選択してください。</option>
                            @for($i = 0; $i < 10; $i++)
                                <option value="{{ $noValues[$i] }}" {{ old('no') == $noValues[$i] ? 'selected' : '' }}>
                                    {{ $noDisplays[$i] }}
                                </option>
                            @endfor
                        </select>     
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        <label for="score" class="font-semibold mt-4">得点</label>
                        <input type="number" min="0" max="100" name="score" class="w-auto py-2 border border-gray-300 rounded-md" id="score" value="{{old('score')}}">点　(※半角で入力)
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('minute')" class="mt-2" />
                        <label for="minute" class="font-semibold mt-4">時間</label>
                        <input type="number" min="0" max="100" name="minute" class="w-auto py-2 border border-gray-300 rounded-md" id="minute" value="{{old('minute')}}">分　(※半角で入力)
                    </div>
                </div>


                <x-primary-button class="mt-4">
                    登録
                </x-primary-button>
            </form>
        @endauth
    </div>
</x-app-layout>