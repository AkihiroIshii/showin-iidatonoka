<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ユーザ＞登録
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
            <form method="post" action="{{ route('admin.user.store') }}">
                @csrf

                <div class="mt-8">
                    <div>
                        <label for="user_id" class="font-semibold mt-4">ユーザID</label>
                        <input type="string" name="user_id" class="w-auto py-2 border border-gray-300 rounded-md" id="user_id" value="{{old('user_id')}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="name" class="font-semibold mt-4">ユーザ名</label>
                        <input type="string" name="name" class="w-auto py-2 border border-gray-300 rounded-md" id="name" value="{{old('name')}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="password" class="font-semibold mt-4">パスワード</label>
                        <input type="password" name="password" class="w-auto py-2 border border-gray-300 rounded-md" id="password"  value="{{old('password')}}">
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                        <label for="school_id" class="font-semibold mt-4">学校</label>
                        <select type="string" name="school_id" class="w-auto py-2 border border-gray-300 rounded-md" id="school_id">
                            <option value="">選択してください。</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>     
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                        <label for="subject" class="font-semibold mt-4">学年</label>
                        @php
                            $grades = ['小４','小５','小６','中１','中２','中３','高１','高２','高３','保護者'];
                        @endphp
                        <select type="string" name="grade" class="w-auto py-2 border border-gray-300 rounded-md" id="grade">
                            <option value="">選択してください。</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>
                                    {{ $grade }}
                                </option>
                            @endforeach
                        </select>     
                    </div>
                </div>
                <div class="mt-8">
                    <div>
                        <label for="plan" class="font-semibold mt-4">通塾コース</label>
                        <input type="string" name="plan" class="w-auto py-2 border border-gray-300 rounded-md" id="plan" value="{{old('plan')}}">
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    登録
                </x-primary-button>
            </form>
        </div>
    @endif
</x-app-layout>