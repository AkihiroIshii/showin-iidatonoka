<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            検定＞編集
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
            <form method="post" action="{{ route('kentei.update', $kentei) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        <label for="name" class="font-semibold mt-4">検定名</label>
                        <input type="string" name="name" class="w-auto py-2 border border-gray-300 rounded-md" id="name" value="{{old('name', $kentei->name)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                        <label for="grade" class="font-semibold mt-4">級</label>
                        <input type="string" name="grade" class="w-auto py-2 border border-gray-300 rounded-md" id="grade" value="{{old('grade', $kentei->grade)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('first_date')" class="mt-2" />
                        <label for="first_date" class="font-semibold mt-4">一次試験日</label>
                        <input type="date" name="first_date" class="w-auto py-2 border border-gray-300 rounded-md" id="first_date" value="{{old('first_date', $kentei->first_date)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('first_score')" class="mt-2" />
                        <label for="first_score" class="font-semibold mt-4">一次試験得点</label>
                        <input type="number" name="first_score" class="w-auto py-2 border border-gray-300 rounded-md" id="first_score" value="{{old('first_score', $kentei->first_score)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('second_date')" class="mt-2" />
                        <label for="second_date" class="font-semibold mt-4">二次試験日</label>
                        <input type="date" name="second_date" class="w-auto py-2 border border-gray-300 rounded-md" id="second_date" value="{{old('second_date', $kentei->second_date)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('second_score')" class="mt-2" />
                        <label for="second_score" class="font-semibold mt-4">二次試験得点</label>
                        <input type="number" name="second_score" class="w-auto py-2 border border-gray-300 rounded-md" id="second_score" value="{{old('second_score', $kentei->second_score)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('result')" class="mt-2" />
                        <label for="result" class="font-semibold mt-4">合否結果</label>
                        <input type="string" name="result" class="w-auto py-2 border border-gray-300 rounded-md" id="result" value="{{old('result', $kentei->result)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                        <label for="memo" class="font-semibold mt-4">メモ</label>
                        <textarea name="memo" class="w-full py-2 border border-gray-300 rounded-md" id="memo">{{old('memo', $kentei->memo)}}</textarea>
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        @endauth
    </div>
</x-app-layout>