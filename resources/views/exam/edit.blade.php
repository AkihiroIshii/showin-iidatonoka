<x-app-layout>
    @if(Auth::user()->role == "admin")
    <x-slot name="header">
        @include('layouts.adminmenu')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            試験＞編集
        </h2>
    </x-slot>
    <div class="maxw-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        <form method="post" action="{{ route('exam.update', $exam) }}">
            @csrf
            @method('patch')

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                    <label for="school_id" class="font-semibold mt-4">学校</label>
                    <select type="string" name="school_id" class="w-auto py-2 border border-gray-300 rounded-md" id="school_id">
                        <option value="">選択してください。</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id', $exam->school_id) == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>     
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    <label for="year" class="font-semibold mt-4">年度</label>
                    <input type="number" name="year" class="w-auto py-2 border border-gray-300 rounded-md" id="year" value="{{old('year', $exam->year)}}">(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                    <label for="subject" class="font-semibold mt-4">学年</label>
                    @php
                        $grades = ['中１','中２','中３','高１','高２','高３'];
                    @endphp
                    <select type="string" name="grade" class="w-auto py-2 border border-gray-300 rounded-md" id="grade">
                        <option value="">選択してください。</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade }}" {{ old('grade', $exam->grade) == $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                        @endforeach
                    </select>     
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('no')" class="mt-2" />
                    <label for="no" class="font-semibold mt-4">no</label>
                    <input type="number" name="no" class="w-auto py-2 border border-gray-300 rounded-md" id="no" value="{{old('no', $exam->no)}}">(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <label for="exam_date" class="font-semibold mt-4">試験日</label>
                    <input type="date" name="exam_date" class="w-auto py-2 border border-gray-300 rounded-md" id="exam_date" value="{{old('date', $exam->exam_date)}}">
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('exam_name')" class="mt-2" />
                    <label for="exam_name" class="font-semibold mt-4">試験名</label>
                    <input type="text" name="exam_name" class="w-auto py-2 border border-gray-300 rounded-md" id="exam_name" value="{{old('exam_name', $exam->exam_name)}}">(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('avg_japanese')" class="mt-2" />
                    <label for="avg_japanese" class="font-semibold mt-4">平均点：国語</label>
                    <input type="number" step="0.1" name="avg_japanese" class="w-auto py-2 border border-gray-300 rounded-md" id="avg_japanese" value="{{old('avg_japanese', $exam->avg_japanese)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('avg_society')" class="mt-2" />
                    <label for="avg_society" class="font-semibold mt-4">平均点：社会</label>
                    <input type="number" step="0.1" name="avg_society" class="w-auto py-2 border border-gray-300 rounded-md" id="avg_society" value="{{old('avg_society', $exam->avg_society)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('avg_math')" class="mt-2" />
                    <label for="avg_math" class="font-semibold mt-4">平均点：数学</label>
                    <input type="number" step="0.1" name="avg_math" class="w-auto py-2 border border-gray-300 rounded-md" id="avg_math" value="{{old('avg_math', $exam->avg_math)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('avg_science')" class="mt-2" />
                    <label for="avg_science" class="font-semibold mt-4">平均点：理科</label>
                    <input type="number" step="0.1" name="avg_science" class="w-auto py-2 border border-gray-300 rounded-md" id="avg_science" value="{{old('avg_science', $exam->avg_science)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('avg_english')" class="mt-2" />
                    <label for="avg_english" class="font-semibold mt-4">平均点：英語</label>
                    <input type="number" step="0.1" name="avg_english" class="w-auto py-2 border border-gray-300 rounded-md" id="avg_english" value="{{old('avg_english', $exam->avg_english)}}">点　(※半角で入力)
                </div>
            </div>


            <x-primary-button class="mt-4">
                更新
            </x-primary-button>
        </form>
    </div>
    @endif
</x-app-layout>