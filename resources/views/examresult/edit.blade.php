<x-app-layout>
    @if(Auth::user()->role == "admin")
    <x-slot name="header">
        @include('layouts.adminmenu')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            試験＞編集：{{$user->name}}
        </h2>
    </x-slot>
    <div class="maxw-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        <form method="post" action="{{ route('examresult.update', $examresult) }}">
            @csrf
            @method('patch')

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('exam_id')" class="mt-2" />
                    <label for="exam_id" class="font-semibold mt-4">試験</label>
                    <select type="string" name="exam_id" class="w-auto py-2 border border-gray-300 rounded-md" id="exam_id">
                        <option value="">選択してください。</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ old('exam_id', $examresult->exam_id) == $exam->id ? 'selected' : '' }}>
                                {{$exam->year}}年度：{{$exam->grade}}：{{$exam->exam_name }}
                            </option>
                        @endforeach
                    </select>     
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('score_japanese')" class="mt-2" />
                    <label for="score_japanese" class="font-semibold mt-4">得点：国語</label>
                    <input type="number" name="score_japanese" class="w-auto py-2 border border-gray-300 rounded-md" id="score_japanese" value="{{old('score_japanese', $examresult->score_japanese)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('score_society')" class="mt-2" />
                    <label for="score_society" class="font-semibold mt-4">得点：社会</label>
                    <input type="number" name="score_society" class="w-auto py-2 border border-gray-300 rounded-md" id="score_society" value="{{old('score_society', $examresult->score_society)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('score_math')" class="mt-2" />
                    <label for="score_math" class="font-semibold mt-4">得点：数学</label>
                    <input type="number" name="score_math" class="w-auto py-2 border border-gray-300 rounded-md" id="score_math" value="{{old('score_math', $examresult->score_math)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('score_science')" class="mt-2" />
                    <label for="score_science" class="font-semibold mt-4">得点：理科</label>
                    <input type="number" name="score_science" class="w-auto py-2 border border-gray-300 rounded-md" id="score_science" value="{{old('score_science', $examresult->score_science)}}">点　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('score_english')" class="mt-2" />
                    <label for="score_english" class="font-semibold mt-4">得点：英語</label>
                    <input type="number" name="score_english" class="w-auto py-2 border border-gray-300 rounded-md" id="score_english" value="{{old('score_english', $examresult->score_english)}}">点　(※半角で入力)
                </div>
            </div>


            <x-primary-button class="mt-4">
                更新
            </x-primary-button>
        </form>
    </div>
    @endif
</x-app-layout>