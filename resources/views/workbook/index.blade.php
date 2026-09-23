<x-app-layout>
    <x-slot name="header">
        @include('layouts.workbook_submenu') <!-- 問題集　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            練習問題
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    {{-- <a href="{{route('workbook.summary_list')}}" class="text-blue-600">テスト：リストへ</a> --}}
    <div class="mx-auto px-6 py-4">
        <!-- 変数定義 -->
        @php
            $trClass = '';
            $message = '';
        @endphp
        @if(Auth::user()->role == "admin")
            <a href="{{route('workbook.create')}}" :active="request()->routeIs('admin.workbook.create')" class="text-blue-600">新規登録</a>
        @endif
        <!-- 問題表示 -->
        <div>
            <form method="GET" action="{{ route('workbook.summary_list') }}">
                <!-- 和訳のみなど絞る場合はチェックボックスを表示 -->

                <x-h3 color="purple">英語</x-h3>
                <div class="flex">
                    <div class="px-6 w-24 shirink-0 font-bold">種別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <label>
                            <input type="radio" name="eng_type" value="並び替え" checked> 並び替え
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="空所補充" checked> 空所補充
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="全訳"> 全訳
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="読解"> 読解
                        </label>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-24 shirink-0 font-bold">学年別</div>
                    <div class="flex flex-wrap gap-y-2">
                        <label>
                            <input type="checkbox" name="eng_J1" value="1">中１
                        </label>
                        <label>
                            <input type="checkbox" name="eng_J2" value="1">中２
                        </label>
                        <label>
                            <input type="checkbox" name="eng_J3" value="1">中３
                        </label>
                        <button type="submit" name="target" value="eng_grade" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            学年別 問題表示
                        </button>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-36 shirink-0 font-bold">単元別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <label>
                            <input type="checkbox" name="eng_be_verb" value="1">be動詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_general_verb" value="1">一般動詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_interrogative" value="1">疑問詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_personal_pronoun" value="1">代名詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_past_verb" value="1">過去形
                        </label>
                        <label>
                            <input type="checkbox" name="eng_progressive_tense" value="1">進行形
                        </label>
                        <label>
                            <input type="checkbox" name="eng_conjection" value="1">接続詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_infinitive" value="1">不定詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_gerund" value="1">動名詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_auxiliary_verb" value="1">助動詞
                        </label>
                        <label>
                            <input type="checkbox" name="eng_comparative" value="1">比較級
                        </label>
                        <label>
                            <input type="checkbox" name="eng_passive_voice" value="1">受動態
                        </label>
                        <label>
                            <input type="checkbox" name="eng_present_perfect" value="1">現在完了
                        </label>
                        <label class="w-36">
                            <input type="checkbox" name="eng_svo_infinitive" value="1">SVO+不定詞
                        </label>
                        <label class="w-64">
                            <input type="checkbox" name="eng_postfix_modification" value="1">後置修飾（分詞、関係代名詞）
                        </label>
                        <button type="submit" name="target" value="eng_unit" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            単元別 問題表示
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>