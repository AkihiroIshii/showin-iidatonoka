<x-app-layout>
    <x-slot name="header">
        @include('layouts.infomenu') <!-- その他情報　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            その他情報 ＞ リンク集
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp
        <div>
            <div class="flex flex-wrap gap-4">
                @foreach ($links as $link)
                    @php
                        if ($link->category == '学習システム') {
                            $trClass = 'bg-sky-200';
                        } elseif ($link->category == '学習補助ツール') {
                            $trClass = 'bg-pink-200';
                        } elseif ($link->category == '入試') {
                            $trClass = 'bg-green-200';
                        } elseif ($link->category == '管理') {
                            $trClass = 'bg-gray-200';
                        } elseif ($link->category == '会計') {
                            $trClass = 'bg-gray-400';
                        } else {
                            $trClass = 'bg-white';
                        }
                    @endphp
                    <div class="p-4 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis {!! $trClass !!}">
                        <a href="{{$link->link}}" target="_blank">{{$link->title}}</a>
                        @if(Auth::user()->role == "admin")
                            @if(isset($link->admin_link))
                                <a href="{{$link->admin_link}}" target="_blank" class="font-bold">[管理画面]</a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
</x-app-layout>