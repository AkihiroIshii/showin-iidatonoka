<x-app-layout>
    <x-slot name="header">
        @include('layouts.adminmenu')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            コイン（AI-Showin以外）＞{{ $user->name }}＞登録
        </h2>
    </x-slot>

    <div class="maxw-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        @if($errors->any())
            <div class="text-red-600 font-bold">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('coin.store') }}">
            @csrf

            <div class="mt-8">
                <div>
                    <label for="change_date" class="font-semibold mt-4">日付</label>
                    <input type="date" name="change_date" class="w-full py-2 border border-gray-300 rounded-md" id="change_date">
                </div>
            </div>
            <div class="mt-8">
                <div>
                    <label for="memo" class="font-semibold mt-4">内容</label>
                    <input type="text" name="memo" class="w-full py-2 border border-gray-300 rounded-md" id="memo">
                </div>
            </div>
            <div class="mt-8">
                <div>
                    <label for="coin" class="font-semibold mt-4">コイン数</label>
                    <input type="integer" name="coin" class="w-full py-2 border border-gray-300 rounded-md" id="coin">
                </div>
            </div>

            <x-primary-button class="mt-4">
                登録
            </x-primary-button>
        </form>
    </div>
</x-app-layout>