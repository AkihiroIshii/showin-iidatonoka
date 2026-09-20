<x-app-layout>
    <x-slot name="header">
        @if(Auth::user()->role == "admin")
            @include('layouts.adminmenu')
        @endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            格言＞編集
        </h2>
    </x-slot>
    <div class="maxw-7xl mx-auto px-6"> 
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        @auth
            <form method="post" action="{{ route('kakugen.update', $kakugen) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('sentence')" class="mt-2" />
                        <label for="sentence" class="font-semibold mt-4">格言</label>
                        <textarea type="text" name="sentence" class="w-3/4 py-2 border border-gray-300 rounded-md" id="sentence">{{old('sentence', $kakugen->sentence)}}</textarea>
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('person')" class="mt-2" />
                        <label for="person" class="font-semibold mt-4">人物</label>
                        <input type="string" name="person" class="w-auto py-2 border border-gray-300 rounded-md" id="person" value="{{old('person', $kakugen->person)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                        <label for="reference" class="font-semibold mt-4">出典</label>
                        <input type="date" name="reference" class="w-auto py-2 border border-gray-300 rounded-md" id="reference" value="{{old('reference', $kakugen->reference)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        <label for="comment" class="font-semibold mt-4">コメント</label>
                        <textarea type="text" name="comment" class="w-3/4 py-2 border border-gray-300 rounded-md" id="comment">{{old('comment', $kakugen->comment)}}</textarea>
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        @endauth
    </div>
</x-app-layout>