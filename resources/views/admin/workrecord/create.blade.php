<x-app-layout>
    @if(Auth::user()->role == "admin")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ワーク演習＞新規登録＞{{ $user->name }}
            </h2>
        </x-slot>
        <div class="maxw-7xl mx-auto px-6"> 
            @if(session('message'))
                <div class="text-red-600 font-bold">
                    {{session('message')}}
                </div>
            @endif
            @auth
                <a href="{{route('admin.workrecord', $user)}}" :active="request()->routeIs('admin.workrecord')" class="text-blue-600">ワーク演習一覧</a>
                <form method="post" action="{{ route('admin.workrecord.store', $user) }}">
                    @csrf
                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            <label for="user_id" class="font-semibold mt-4">ユーザ名</label>
                            <input type="hidden" name="user_id" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="user_id" value="{{$user->id}}">{{$user->name}}
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('exam_id')" class="mt-2" />
                            <label for="exam_id" class="font-semibold mt-4">試験名</label>
                            <select type="integer" name="exam_id" class="w-auto py-2 border border-gray-300 rounded-md" id="exam_id">
                                <option value="">選択してください。</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->exam_name }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">科目</label>
                            @php
                                $subjects = ['国語','数学','社会','理科','英語'];
                            @endphp
                            <select type="string" name="subject" class="w-auto py-2 border border-gray-300 rounded-md" id="subject">
                                <option value="">選択してください。</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ old('subject') == $subject ? 'selected' : '' }}>
                                        {{ $subject }}
                                    </option>
                                @endforeach
                            </select>     
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('work_name')" class="mt-2" />
                            <label for="work_name" class="font-semibold mt-4">ワーク名</label>
                            <input type="string" name="work_name" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="work_name" value="{{old('work_name')}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('work_range')" class="mt-2" />
                            <label for="work_range" class="font-semibold mt-4">範囲</label>
                            <input type="string" name="work_range" class="w-auto py-2 border border-gray-300 rounded-md px-3" id="work_range" value="{{old('work_range')}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                            <label for="memo" class="font-semibold mt-4">メモ</label>
                            <textarea name="memo" class="w-full py-2 border border-gray-300 rounded-md" id="memo">{{old('memo')}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <label for="date_1st" class="font-semibold mt-4">学習完了日：１周目</label>
                            <input type="date" name="date_1st" class="w-full py-2 border border-gray-300 rounded-md" id="date_1st" value="{{old('date_1st')}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <label for="date_2nd" class="font-semibold mt-4">学習完了日：２周目</label>
                            <input type="date" name="date_2nd" class="w-full py-2 border border-gray-300 rounded-md" id="date_2nd" value="{{old('date_2nd')}}">
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <label for="date_3rd" class="font-semibold mt-4">学習完了日：３周目</label>
                            <input type="date" name="date_3rd" class="w-full py-2 border border-gray-300 rounded-md" id="date_3rd" value="{{old('date_3rd')}}">
                        </div>
                    </div>

                    <x-primary-button class="mt-4">
                        登録
                    </x-primary-button>
                </form>
            @endauth
        </div>
    @endif
</x-app-layout>