<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題集
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
        @if(Auth::user()->role == "admin" || Auth::user()->grade == "塾長")
            <a href="{{route('workbook.create')}}" :active="request()->routeIs('workbook.create')" class="text-blue-600">新規登録</a>
        @endif
        <!-- 問題表示 -->
        <div>
            <form method="GET" action="{{ route('workbook.summary_list') }}">
                <!-- 和訳のみなど絞る場合はチェックボックスを表示 -->

                <!--------------- 英語 --------------->
                <x-h3 color="purple">英語</x-h3>
                <p class="font-semibold text-l">＜学年別＞</p>
                <div class="flex">
                    <div class="px-6 w-32 shirink-0 font-bold">種別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <label>
                            <input type="radio" name="eng_type" value="並び替え" checked> 並び替え
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="空所補充"> 空所補充
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="和訳"> 和訳
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="英作文"> 英作文
                        </label>
                        {{-- <label>
                            <input type="radio" name="eng_type" value="全訳"> 全訳
                        </label>
                        <label>
                            <input type="radio" name="eng_type" value="読解"> 読解
                        </label> --}}
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">学年</div>
                    <div class="flex flex-wrap gap-y-2">
                        <!-- 問題集に存在する学年のみチェックボックスを表示 -->
                        @foreach($grades['eng'] as $eng_grade)
                            <label class="w-auto px-4">
                                <input type="checkbox" name="eng_{{ $eng_grade->physical_name }}" value="1">{{ $eng_grade->grade }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="eng_grade" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            学年別 問題表示
                        </button>
                    </div>
                </div>
                <p class="font-semibold text-l">＜単元別＞</p>
                {{-- <div class="flex mt-4">
                    <div class="px-6 w-24 shirink-0 font-bold">単元別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['eng'] as $eng_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $eng_unit->physical_name }}" value="1">{{ $eng_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="eng_unit" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            単元別 問題表示
                        </button>
                    </div>
                </div> --}}
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">並び替え</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['eng_order'] as $eng_order_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $eng_order_unit->physical_name }}" value="1">{{ $eng_order_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="eng_order_unit" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            並び替え 問題表示
                        </button>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">空所補充</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['eng_blank'] as $eng_blank_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $eng_blank_unit->physical_name }}" value="1">{{ $eng_blank_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="eng_blank_unit" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            空所補充 問題表示
                        </button>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">和訳</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['eng_translation'] as $eng_translation_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $eng_translation_unit->physical_name }}" value="1">{{ $eng_translation_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="eng_translation_unit" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            和訳 問題表示
                        </button>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">英作文</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['eng_composition'] as $eng_composition_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $eng_composition_unit->physical_name }}" value="1">{{ $eng_composition_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="eng_composition_unit" class="inline-block p-2 rounded shadow bg-purple-200 font-bold">
                            英作文 問題表示
                        </button>
                    </div>
                </div>

                <!--------------- 社会 --------------->
                <x-h3 color="yellow">社会</x-h3>
                <div class="flex">
                    <div class="px-6 w-24 shirink-0 font-bold">種別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <label>
                            <input type="radio" name="soc_type" value="用語" checked> 用語
                        </label>
                        <label>
                            <input type="radio" name="soc_type" value="説明"> 説明
                        </label>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">地理</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['geo'] as $geo_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $geo_unit->physical_name }}" value="1">{{ $geo_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="geo_unit" class="inline-block p-2 rounded shadow bg-yellow-200 font-bold">
                            地理 問題表示
                        </button>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">歴史</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['his'] as $his_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $his_unit->physical_name }}" value="1">{{ $his_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="his_unit" class="inline-block p-2 rounded shadow bg-yellow-200 font-bold">
                            歴史 問題表示
                        </button>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-32 shirink-0 font-bold">公民</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['civ'] as $civ_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $civ_unit->physical_name }}" value="1">{{ $civ_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="civ_unit" class="inline-block p-2 rounded shadow bg-yellow-200 font-bold">
                            公民 問題表示
                        </button>
                    </div>
                </div>

                {{-- <!--------------- 理科 --------------->
                <x-h3 color="green">理科</x-h3>
                <div class="flex">
                    <div class="px-6 w-24 shirink-0 font-bold">種別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <label>
                            <input type="radio" name="sci_type" value="用語" checked> 用語
                        </label>
                        <label>
                            <input type="radio" name="sci_type" value="説明"> 説明
                        </label>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-24 shirink-0 font-bold">単元別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['sci'] as $sci_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $sci_unit->physical_name }}" value="1">{{ $sci_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="geo_unit" class="inline-block p-2 rounded shadow bg-green-200 font-bold">
                            理科 問題表示
                        </button>
                    </div>
                </div>

                <!--------------- 国語 --------------->
                <x-h3 color="red">国語</x-h3>
                <div class="flex">
                    <div class="px-6 w-24 shirink-0 font-bold">種別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <label>
                            <input type="radio" name="jap_type" value="用語" checked> 用語
                        </label>
                        <label>
                            <input type="radio" name="jap_type" value="説明"> 説明
                        </label>
                    </div>
                </div>
                <div class="flex mt-4">
                    <div class="px-6 w-24 shirink-0 font-bold">単元別</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                        <!-- 問題集に存在する単元のみチェックボックスを表示 -->
                        @foreach($units['jap'] as $geo_unit)
                            <label class="w-auto pl-2">
                                <input type="checkbox" name="{{ $jap_unit->physical_name }}" value="1">{{ $jap_unit->logical_name }}
                            </label>
                        @endforeach
                        <button type="submit" name="target" value="geo_unit" class="inline-block p-2 rounded shadow bg-red-200 font-bold">
                            国語 問題表示
                        </button>
                    </div>
                </div> --}}

            </form>
        </div>
    </div>
</x-app-layout>