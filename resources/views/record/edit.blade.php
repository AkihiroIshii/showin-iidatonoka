<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @else
            @include('layouts.pastexam')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習＞編集
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
        @if($record->user->id == $user->id)
            <form method="post" action="{{ route('record.update', $record) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <label for="date" class="font-semibold mt-4">解いた日</label>
                        <input type="date" name="date" class="w-auto py-2 border border-gray-300 rounded-md" id="date" value="{{old('date', $record->date)}}">
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                        <label for="year" class="font-semibold mt-4">過去問年度</label>
                        <select type="string" name="year" class="w-auto py-2 border border-gray-300 rounded-md" id="year">
                            <option value="">選択してください。</option>
                            @for ($i = 2024; $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ old('year', $record->question->year) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
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
                                <option value="{{ $subject }}" {{ old('subject', $record->question->subject) == $subject ? 'selected' : '' }}>
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
                            $noValues = ['1','2','3','4','5','全問'];
                            $noDisplays = ['問１','問２','問３','問４','問５','全問'];
                        @endphp
                        <select type="string" name="no" class="w-auto py-2 border border-gray-300 rounded-md" id="no">
                            <option value="">選択してください。</option>
                            @for($i = 0; $i < 6; $i++)
                                <option value="{{ $noValues[$i] }}" {{ old('no', $record->question->no) == $noValues[$i] ? 'selected' : '' }}>
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
                        <input type="number" min="0" max="100" name="score" class="w-auto py-2 border border-gray-300 rounded-md" id="score" value="{{old('score', $record->score)}}">点　(※半角で入力)
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('minute')" class="mt-2" />
                        <label for="minute" class="font-semibold mt-4">時間</label>
                        <input type="number" min="0" max="100" name="minute" class="w-auto py-2 border border-gray-300 rounded-md" id="minute" value="{{old('minute', $record->minute)}}">分　(※半角で入力)
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        @endif
    </div>
</x-app-layout>