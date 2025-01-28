<x-app-layout>
    <x-slot name="header">
        @include('layouts.pastexam') <!-- 過去問演習　共通メニュー -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去問演習＞目標設定＞編集
        </h2>
    </x-slot>
    <div class="maxw-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        @if($target->user->id==Auth::id())
            <form method="post" action="{{ route('target.update', $target) }}">
                @csrf
                @method('patch')

                <div class="mt-8">
                    <div>
                        <label for="subject" class="font-semibold mt-4">科目</label>
                        <input type="hidden" list="list_subject" name="subject" class="w-auto py-2 border border-gray-300 rounded-md" id="subject" value="{{old('subject', $target->subject)}}">
                        <datalist id="list_subject">
                            <option value="国語"></option>
                            <option value="数学"></option>
                            <option value="社会"></option>
                            <option value="理科"></option>
                            <option value="英語"></option>
                        </datalist>
                        {{old('subject', $target->subject)}}
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="no" class="font-semibold mt-4">大問番号</label>
                        <input type="hidden" list="list_no" name="no" class="w-auto py-2 border border-gray-300 rounded-md" id="no" value="{{old('no', $target->no)}}">
                        <datalist id="list_no">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                            <option value="全問"></option>
                        </datalist>     
                        {{old('no', $target->no)}}
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="target_score" class="font-semibold mt-4">目標点</label>
                        <x-input-error :messages="$errors->get('target_score')" class="mt-2" />
                        <input type="integer" name="target_score" class="w-auto py-2 border border-gray-300 rounded-md" id="score" value="{{old('score', $target->target_score)}}">点
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="target_minute" class="font-semibold mt-4">目標時間</label>
                        <x-input-error :messages="$errors->get('target_minute')" class="mt-2" />
                        <input type="integer" name="target_minute" class="w-auto py-2 border border-gray-300 rounded-md" id="minute" value="{{old('minute', $target->target_minute)}}">分
                    </div>
                </div>

                <div class="mt-8">
                    <div>
                        <label for="id" class="font-semibold mt-4"></label>
                        <input type="hidden" name="id" class="w-auto py-2 border border-gray-300 rounded-md" id="id" value="{{old('id', $target->id)}}">
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    更新
                </x-primary-button>
            </form>
        @endif
    </div>
</x-app-layout>