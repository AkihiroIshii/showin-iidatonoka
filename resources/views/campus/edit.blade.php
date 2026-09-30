<x-app-layout>
    @if(Auth::user()->role == "admin" || Auth::user()->grade == "塾長")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                設定（塾長専用ページ）
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
            <form method="post" action="{{ route('campus.update', $campus) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('setting_code')" class="mt-2" />
                        <label for="setting_code" class="font-semibold w-36 mt-4">問題集の表示対象</label>
                        @php
                            $setting_codes = [
                                '0' => '自校舎のオリジナル問題のみ。',
                                '1' => '飯田殿岡校の問題も表示する。',
                                '2' => '飯田殿岡校の問題と格言を表示する。',
                            ];
                        @endphp
                        <select type="string" name="setting_code" class="w-auto py-2 border border-gray-300 rounded-md" id="subject">
                            <option value="">選択してください。</option>
                            @foreach($setting_codes as $key => $val)
                                <option value="{{ $key }}" {{ old('subject', $campus->setting_code) == $key ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>　(※)格言はダッシュボードにランダム表示されます。    
                    </div>
                </div>
                
                {{-- <div class="mt-8">
                    <div>
                        <label for="content" class="font-semibold mt-4">月間目標</label>
                        <textarea type="text" name="content" class="w-full py-2 border border-gray-300 rounded-md h-48" id="content">{{old('content', $usualtarget->content)}}</textarea>
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
                        <label for="achieve_flg" class="font-semibold mt-4">状況</label>2:現在の課題、1:目標達成、0:未達成
                        <input type="text" name="achieve_flg" class="py-2 border border-gray-300 rounded-md" id="achieve_flg" value="{{old('achieve_flg', $usualtarget->achieve_flg)}}">
                    </div>
                </div> --}}

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        </div>
    @endif
</x-app-layout>