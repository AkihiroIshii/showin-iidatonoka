<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            @include('layouts.adminmenu')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                日々の目標（管理者）＞{{ $user->name }}＞編集
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
            <form method="post" action="{{ route('usualtarget.update', $usualtarget) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <label for="content" class="font-semibold mt-4">目標</label>
                        <textarea type="text" name="content" class="w-full py-2 border border-gray-300 rounded-md" id="content">{{old('content', $usualtarget->content)}}</textarea>
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="due_date" class="font-semibold mt-4">目標期限</label>
                        <input type="date" name="due_date" class="w-full py-2 border border-gray-300 rounded-md" id="due_date" value="{{old('due_date', $usualtarget->due_date)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="achieve_flg" class="font-semibold mt-4">状況</label>1:目標達成、0:未達成
                        <input type="text" name="achieve_flg" class="py-2 border border-gray-300 rounded-md" id="achieve_flg" value="{{old('achieve_flg', $usualtarget->achieve_flg)}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="comment" class="font-semibold mt-4">振り返り</label>
                        <textarea name="comment" class="w-full py-2 border border-gray-300 rounded-md" id="comment">{{old('comment', $usualtarget->comment)}}</textarea>
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="coin" class="font-semibold mt-4">獲得コイン数</label>
                        <input type="integer" name="coin" class="w-full py-2 border border-gray-300 rounded-md" id="coin" value="{{old('coin', $usualtarget->coin)}}">
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        </div>
    @endif
</x-app-layout>