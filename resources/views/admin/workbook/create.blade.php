<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                問題集＞新規登録
            </h2>
        </x-slot>
        <div class="maxw-7xl mx-auto px-6"> 
            @if(session('message'))
                <div class="text-red-600 font-bold">
                    {{session('message')}}
                </div>
            @endif
            @auth
                <form method="post" action="{{ route('admin.workbook.store') }}">
                    @csrf

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">科目</label>
                            @php
                                $subjects = ['国語','数学','算数','社会','理科','英語'];
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
                            <x-input-error :messages="$errors->get('field')" class="mt-2" />
                            <label for="field" class="font-semibold mt-4">分野</label>
                            <input type="string" name="field" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="field" value="{{old('field')}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">学年</label>
                            @php
                                $grades = ['小４','小５','小６','中１','中２','中３','高１','高２','高３'];
                            @endphp
                            <select type="string" name="grade" class="w-auto py-2 border border-gray-300 rounded-md" id="grade">
                                <option value="">選択してください。</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>
                                        {{ $grade }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('question')" class="mt-2" />
                            <label for="guestion" class="font-semibold mt-4">問題</label>
                            <textarea name="question" class="w-full py-2 border border-gray-300 rounded-md" id="question">{{old('question')}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                            <label for="answer" class="font-semibold mt-4">答え</label>
                            <textarea name="answer" class="w-full py-2 border border-gray-300 rounded-md" id="answer">{{old('answer')}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                            <label for="reference" class="font-semibold mt-4">参考</label>
                            <textarea name="reference" class="w-full py-2 border border-gray-300 rounded-md" id="reference">{{old('reference')}}</textarea>
                        </div>
                    </div>


                    <x-primary-button class="mt-4">
                        登録
                    </x-primary-button>
                </form>
            @endauth
        </div>
    @endif
</x-app-layout>