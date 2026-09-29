<x-app-layout>
    @if(Auth::user()->role == "admin" || Auth::user()->grade == "塾長")
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                問題集＞新規登録
            </h2>
        </x-slot>
        <div class="maxw-7xl mx-auto px-6"> 
            @if(session('message'))
                <div class="text-red-600 font-bold">
                    {{session('message')}}
                </div>
            @endif
            @auth
                <form method="post" action="{{ route('workbook.store') }}">
                    @csrf

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">科目</label>
                            @php
                                $subjects = ['英語','社会'];
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
                        <x-input-error :messages="$errors->get('field')" class="mt-2" />
                        <label for="field" class="font-semibold mt-4">分野</label>
                        <select type="string" name="field" class="w-auto py-2 border border-gray-300 rounded-md" id="field">
                            <option value="">まず教科を選択してください</option>
                        </select>
                    </div>

                    <div class="mt-8">
                        <x-input-error :messages="$errors->get('q_type')" class="mt-2" />
                        <label for="q_type" class="font-semibold mt-4">種別</label>
                        <select type="string" name="q_type" class="w-auto py-2 border border-gray-300 rounded-md" id="q_type">
                            <option value="">まず教科を選択してください</option>
                        </select>
                    </div>

                    <div class="mt-8">
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                        <label for="unit" class="font-semibold mt-4">単元</label>
                        <select type="string" name="unit" class="w-auto py-2 border border-gray-300 rounded-md" id="unit">
                            <option value="">まず教科を選択してください</option>
                        </select>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            <label for="subject" class="font-semibold mt-4">学年</label>
                            @php
                                $grades = ['P1','P2','P3','P4','P5','P6','J1','J2','J3','H1','H2','H3'];
                            @endphp
                            <select type="string" name="grade" class="w-auto py-2 border border-gray-300 rounded-md" id="grade">
                                <option value="">選択してください。</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>
                                        {{ $grade }}
                                    </option>
                                @endforeach
                            </select>
                            この単元を学習する学年
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('term')" class="mt-2" />
                            <label for="term" class="font-semibold mt-4">学期</label>
                            @php
                                $terms = [1, 2, 3];
                            @endphp
                            <select type="string" name="term" class="w-auto py-2 border border-gray-300 rounded-md" id="term">
                                <option value="">選択してください。</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term }}" {{ old('term') == $term ? 'selected' : '' }}>
                                        {{ $term }}
                                    </option>
                                @endforeach
                            </select>     
                            学習する学期（目安）。まだ用途が決まっていないので適当でよいです。
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('question')" class="mt-2" />
                            <label for="question" class="font-semibold mt-4">問題</label>
                            <textarea name="question" class="w-full h-32 py-2 border border-gray-300 rounded-md" id="question">{{old('question')}}</textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                            <label for="answer" class="font-semibold mt-4">答え</label>
                            <textarea name="answer" class="w-full py-2 border border-gray-300 rounded-md" id="answer">{{old('answer')}}</textarea>
                        </div>
                    </div>


                    <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('explanation')" class="mt-2" />
                            <label for="explanation" class="font-semibold mt-4">解説</label>
                            <textarea name="explanation" class="w-full h-32 py-2 border border-gray-300 rounded-md" id="explanation">{{old('explanation')}}</textarea>
                        </div>
                    </div>

                    {{-- <div class="mt-8">
                        <div>
                            <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                            <label for="reference" class="font-semibold mt-4">参考</label>
                            <textarea name="reference" class="w-full py-2 border border-gray-300 rounded-md" id="reference">{{old('reference')}}</textarea>
                        </div>
                    </div> --}}


                    <x-primary-button class="mt-4">
                        登録
                    </x-primary-button>
                </form>
            @endauth
        </div>
    @endif

<script>
    // PHPの$unitsをJavaScriptに渡す
    const units = @json($units);

    const subjectSelect = document.getElementById('subject');
    const fieldSelect = document.getElementById('field');
    const qtypeSelect = document.getElementById('q_type');
    const unitSelect = document.getElementById('unit');

    // 教科ごとの分野
    const fields = {
        '英語': ['英単語', '英文法'],
        '社会': ['地理', '歴史', '公民'],
    };

    // 教科ごとの種別
    const qtypes = {
        '英語': ['並び替え', '空所補充'],
        '社会': ['用語', '説明'],
    };

    // 分野の更新
    function updateFields() {

        const subject = subjectSelect.value;

        console.log('subject =', subject);

        // 一旦、fieldを空にする
        fieldSelect.innerHTML = '';

        // その教科に対応するfieldを取得
        const fieldList = fields[subject] || [];

        console.log('fieldList =', fieldList);

        if (fieldList.length === 0) {
            fieldSelect.innerHTML =
                '<option value="">選択してください</option>';
            return;
        }

        // 先頭の項目
        const firstOption = document.createElement('option');
        firstOption.value = '';
        firstOption.textContent = '選択してください';
        fieldSelect.appendChild(firstOption);

        // fieldを追加
        fieldList.forEach(field => {
            const option = document.createElement('option');

            option.value = field;
            option.textContent = field;

            fieldSelect.appendChild(option);
        });
    }

    // 種別の更新
    function updateQtypes() {

        const subject = subjectSelect.value;

        // 一旦、fieldを空にする
        qtypeSelect.innerHTML = '';

        // その教科に対応するfieldを取得
        const qtypeList = qtypes[subject] || [];

        console.log('qtypeList =', qtypeList);

        if (qtypeList.length === 0) {
            qtypeSelect.innerHTML =
                '<option value="">選択してください</option>';
            return;
        }

        // 先頭の項目
        const firstOption = document.createElement('option');
        firstOption.value = '';
        firstOption.textContent = '選択してください';
        qtypeSelect.appendChild(firstOption);

        // 種別を追加
        qtypeList.forEach(qtype => {
            const option = document.createElement('option');

            option.value = qtype;
            option.textContent = qtype;

            qtypeSelect.appendChild(option);
        });
    }

    // 単元の更新
    function updateUnits() {

        const subject = subjectSelect.value;

        // 一旦空にする
        unitSelect.innerHTML = '';

        if (subject === '') {
            unitSelect.innerHTML =
                '<option value="">まず教科を選択してください</option>';
            return;
        }

        // 選択した教科だけに絞る
        const filteredUnits = units.filter(unit => {
            return unit.subject === subject;
        });

        // 先頭の項目
        const firstOption = document.createElement('option');
        firstOption.value = '';
        firstOption.textContent = '単元を選択してください';
        unitSelect.appendChild(firstOption);

        // 単元を追加
        filteredUnits.forEach(unit => {

            const option = document.createElement('option');

            option.value = unit.logical_name;
            option.textContent = unit.logical_name;

            unitSelect.appendChild(option);
        });
    }

    // 単元の更新（社会）
    function updateUnitsSociety() {

        const subject = subjectSelect.value;

        if (subject === '社会') {
            const field = fieldSelect.value;

            // 一旦空にする
            unitSelect.innerHTML = '';

            // 選択した分野だけに絞る
            const filteredUnits = units.filter(unit => {
                return unit.field === field;
            });

            // 先頭の項目
            const firstOption = document.createElement('option');
            firstOption.value = '';
            firstOption.textContent = '単元を選択してください';
            unitSelect.appendChild(firstOption);

            // 単元を追加
            filteredUnits.forEach(unit => {

                const option = document.createElement('option');

                option.value = unit.logical_name;
                option.textContent = unit.logical_name;

                unitSelect.appendChild(option);
            });
        }
    }

    // 教科が変更されたとき
    subjectSelect.addEventListener('change', updateFields);
    subjectSelect.addEventListener('change', updateQtypes);
    subjectSelect.addEventListener('change', updateUnits);

    // 分野が変更されたとき
    fieldSelect.addEventListener('change', updateUnitsSociety);

    // 初期表示
    updateFields();
    updateQtypes();
    updateUnits();
</script>

</x-app-layout>