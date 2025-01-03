<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習の記録　更新フォーム
        </h2>
    </x-slot>
    <div class="maxw-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        @auth
            {{Auth::id()}}ログイン中
        @endauth
        @if($record->user->id==Auth::id())
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
                        <label for="year" class="font-semibold mt-4">過去問年度</label>
                        <input type="string" list="list_year" name="year" class="w-auto py-2 border border-gray-300 rounded-md" id="year" value="{{old('year', $record->question->year)}}">
                        <datalist id="list_year">
                            <option value="2024"></option>
                            <option value="2023"></option>
                            <option value="2022"></option>
                            <option value="2021"></option>
                            <option value="2020"></option>
                            <option value="2019"></option>
                        </datalist>     
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="subject" class="font-semibold mt-4">科目</label>
                        <input type="string" list="list_subject" name="subject" class="w-auto py-2 border border-gray-300 rounded-md" id="subject" value="{{old('subject', $record->question->subject)}}">
                        <datalist id="list_subject">
                            <option value="国語"></option>
                            <option value="数学"></option>
                            <option value="社会"></option>
                            <option value="理科"></option>
                            <option value="英語"></option>
                        </datalist>     
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="no" class="font-semibold mt-4">大問番号</label>
                        <input type="string" list="list_no" name="no" class="w-auto py-2 border border-gray-300 rounded-md" id="no" value="{{old('no', $record->question->no)}}">
                        <datalist id="list_no">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                            <option value="全問"></option>
                        </datalist>     
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="score" class="font-semibold mt-4">得点</label>
                        <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        <input type="integer" name="score" class="w-auto py-2 border border-gray-300 rounded-md" id="score" value="{{old('score', $record->score)}}">点
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="minute" class="font-semibold mt-4">時間</label>
                        <x-input-error :messages="$errors->get('minute')" class="mt-2" />
                        <input type="integer" name="minute" class="w-auto py-2 border border-gray-300 rounded-md" id="minute" value="{{old('minute', $record->minute)}}">分
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
            <x-primary-button class="mt-4">
                <a href="{{route('record')}}" class="text-blue-600">一覧に戻る</a>
            </x-primary-button>
        @endif
    </div>
</x-app-layout>