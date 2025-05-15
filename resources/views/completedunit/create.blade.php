<x-app-layout>
    @if(Auth::user()->role == "admin")
    <x-slot name="header">
        @include('layouts.adminmenu')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クリアした単元＞新規登録：{{$user->name}}
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
        @php
            $teaching_materials = ['AI-Showin','moji蔵','河合塾One','ベリタスアカデミー'] //教材リスト
        @endphp
        <form method="post" action="{{ route('completedunit.store') }}">
            @csrf

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('teaching_material')" class="mt-2" />
                    <label for="teaching_material" class="font-semibold mt-4">教材</label>
                    <select type="string" name="teaching_material" class="w-auto py-2 border border-gray-300 rounded-md" id="teaching_material">
                        <option value="">選択してください。</option>
                        @foreach($teaching_materials as $teaching_material)
                            <option value="{{ $teaching_material }}" {{ old('teaching_material') == $teaching_material ? 'selected' : '' }}>
                                {{$teaching_material}}
                            </option>
                        @endforeach
                    </select>     
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('unit_id_aishowin')" class="mt-2" />
                    <label for="unit_id_aishowin" class="font-semibold mt-4">AI-Showinの単元</label>
                    <select type="string" name="unit_id_aishowin" class="w-auto py-2 border border-gray-300 rounded-md" id="unit_id_aishowin">
                        <option value="">選択してください。</option>
                        @foreach($aishowins as $aishowin)
                            <option value="{{ $aishowin->id }}" {{ old('unit_id_aishowin') == $aishowin->id ? 'selected' : '' }}>
                                {{$aishowin->grade}}：{{$aishowin->subject}}：{{$aishowin->unit}}
                            </option>
                        @endforeach
                    </select>     
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('num_loop')" class="mt-2" />
                    <label for="num_loop" class="font-semibold mt-4">学習モード周回数</label>
                    <input type="number" name="num_loop" class="w-auto py-2 border border-gray-300 rounded-md" id="num_loop" value="{{old('num_loop')}}"> 回　(※半角で入力)
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('completed_date')" class="mt-2" />
                    <label for="completed_date" class="font-semibold mt-4">クリアした日</label>
                    <input type="date" name="completed_date" class="w-auto py-2 border border-gray-300 rounded-md" id="completed_date" value="{{old('completed_date')}}">
                </div>
            </div>

            <div class="mt-8">
                <div>
                    <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                    <label for="memo" class="font-semibold mt-4">メモ</label>
                    <textarea type="date" name="memo" class="w-auto py-2 border border-gray-300 rounded-md" id="memo">{{old('memo')}}</textarea>
                </div>
            </div>

            <x-primary-button class="mt-4">
                登録
            </x-primary-button>
        </form>
    </div>
    @endif
</x-app-layout>