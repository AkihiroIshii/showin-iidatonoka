<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                問題集＞編集
            </h2>
        </x-slot>
        <div class="maxw-7xl mx-auto px-6"> 
            @if(session('message'))
                <div class="text-red-600 font-bold">
                    {{session('message')}}
                </div>
            @endif
            @auth
                <form method="post" action="{{ route('workbook.update', $workbook) }}">
                    @csrf
                    @method('patch')

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">科目</label>
                            @php
                                $subjects = ['国語','数学','算数','社会','理科','英語','化学','物理'];
                            @endphp
                            <select type="string" name="subject" class="w-auto py-2 border border-gray-300 rounded-md" id="subject">
                                <option value="">選択してください。</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ old('subject', $workbook->subject) == $subject ? 'selected' : '' }}>
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
                            <input type="string" name="field" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="field" value="{{old('field', $workbook->field)}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('q_type')" class="mt-2" />
                            <label for="q_type" class="font-semibold mt-4">種別</label>
                            <input type="string" name="q_type" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="q_type" value="{{old('q_type', $workbook->q_type)}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                            <label for="unit" class="font-semibold mt-4">単元</label>
                            <input type="string" name="unit" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="unit" value="{{old('unit', $workbook->unit)}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">学年</label>
                            @php
                                $grades = ['P1','P2','P3','P4','P5','P6','J1','J2','J3','H1','H2','H3'];
                            @endphp
                            <select type="string" name="grade" class="w-auto py-2 border border-gray-300 rounded-md" id="grade">
                                <option value="">選択してください。</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade }}" {{ old('grade', $workbook->grade) == $grade ? 'selected' : '' }}>
                                        {{ $grade }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('term')" class="mt-2" />
                            <label for="term" class="font-semibold mt-4">学期</label>
                            @php
                                $terms = [1,2,3];
                            @endphp
                            <select type="integer" name="term" class="w-auto py-2 border border-gray-300 rounded-md" id="term">
                                <option value="">選択してください。</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term }}" {{ old('term', $workbook->term) == $term ? 'selected' : '' }}>
                                        {{ $term }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('question')" class="mt-2" />
                            <label for="question" class="font-semibold mt-4">問題</label>
                            <textarea name="question" class="w-full py-2 border border-gray-300 rounded-md" id="question">{{old('question', $workbook->question)}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                            <label for="answer" class="font-semibold mt-4">答え</label>
                            <textarea name="answer" class="w-full py-2 border border-gray-300 rounded-md" id="answer">{{old('answer', $workbook->answer)}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('explanation')" class="mt-2" />
                            <label for="explanation" class="font-semibold mt-4">解説</label>
                            <textarea name="explanation" class="w-full py-2 border border-gray-300 rounded-md" id="explanation">{{old('explanation', $workbook->explanation)}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                            <label for="reference" class="font-semibold mt-4">参考</label>
                            <textarea name="reference" class="w-full py-2 border border-gray-300 rounded-md" id="reference">{{old('reference', $workbook->reference)}}</textarea>
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