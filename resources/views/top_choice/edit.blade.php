<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            志望校＞編集
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
            <form method="post" action="{{ route('top_choice.update', $top_choice) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                        <label for="school_name" class="font-semibold mt-4">学校名</label>
                        <input type="string" name="school_name" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="school_name" value="{{old('school_name', $top_choice->school_name)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                        <label for="department" class="font-semibold mt-4">学部、学科</label>
                        <input type="string" name="department" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="department" value="{{old('department', $top_choice->department)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('desired_ranking')" class="mt-2" />
                        <label for="desired_ranking" class="font-semibold mt-4">志望順位</label>
                        <input type="number" min="1" name="desired_ranking" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="desired_ranking" value="{{old('desired_ranking', $top_choice->desired_ranking)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('selection_method')" class="mt-2" />
                        <label for="selection_method" class="font-semibold mt-4">選抜方法</label>
                        <input type="string" name="selection_method" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="selection_method" value="{{old('selection_method', $top_choice->selection_method)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('num_capacity')" class="mt-2" />
                        <label for="num_capacity" class="font-semibold mt-4">募集定員</label>
                        <input type="number" min="1" name="num_capacity" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="num_capacity" value="{{old('num_capacity', $top_choice->num_capacity)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('exam_date')" class="mt-2" />
                        <label for="exam_date" class="font-semibold mt-4">本試験日</label>
                        <input type="date" name="exam_date" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="exam_date" value="{{old('exam_date', $top_choice->exam_date)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('subjects')" class="mt-2" />
                        <label for="subjects" class="font-semibold mt-4">入試科目</label>
                        <input type="string" name="subjects" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="subjects" value="{{old('subjects', $top_choice->subjects)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('mock_date')" class="mt-2" />
                        <label for="mock_date" class="font-semibold mt-4">模試日程</label>
                        <input type="date" name="mock_date" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="mock_date" value="{{old('mock_date', $top_choice->mock_date)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('mock_name')" class="mt-2" />
                        <label for="mock_name" class="font-semibold mt-4">模試名</label>
                        <input type="string" name="mock_name" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="mock_name" value="{{old('mock_name', $top_choice->mock_name)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('mock_judge')" class="mt-2" />
                        <label for="mock_judge" class="font-semibold mt-4">模試結果</label>
                        <input type="string" name="mock_judge" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="mock_judge" value="{{old('mock_judge', $top_choice->judge)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                        <label for="memo" class="font-semibold mt-4">メモ</label>
                        <textarea name="memo" class="w-full py-2 border border-gray-300 rounded-md" id="memo">{{old('memo', $top_choice->memo)}}</textarea>
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        @endauth
    </div>
</x-app-layout>