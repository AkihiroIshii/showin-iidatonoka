<x-app-layout>
    @if(Auth::user()->role == "admin" || (Auth::user()->grade == "塾長" && Auth::user()->campus_id == $user->campus_id))
        <x-slot name="header">
            @include('layouts.adminmenu')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                月間目標（管理者）＞{{ $user->name }}＞編集
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
            <p>月間目標を設定する場合：「月間目標 or 課題」と「目標日」を入力し、他は空欄で更新してください。</p>
            <p>課題を設定する場合　　：「月間目標 or 課題」を入力し、「状況」は "2" を入力してください。「目標日」は適当な日付を選んでください。</p>
            <form method="post" action="{{ route('usualtarget.update', $usualtarget) }}">
                @csrf
                @method('patch')

                <div class="mt-4">
                    <div>
                        <label for="content" class="font-semibold mt-4">月間目標 or 課題</label>
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
                </div>
                {{-- <div class="mt-8">
                    <div>
                        <label for="comment" class="font-semibold mt-4">振り返り</label>
                        <textarea name="comment" class="w-full py-2 border border-gray-300 rounded-md" id="comment">{{old('comment', $usualtarget->comment)}}</textarea>
                    </div>
                </div> --}}
                <div class="mt-8">
                    <div>
                        <label for="teacher_comment" class="font-semibold mt-4">先生の評価</label>
                        <textarea name="teacher_comment" class="w-full py-2 border border-gray-300 rounded-md" id="teacehr_comment">{{old('comment', $usualtarget->teacher_comment)}}</textarea>
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