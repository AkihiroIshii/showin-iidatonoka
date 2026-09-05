<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">

            <!---------------------------------------- 小学生 ---------------------------------------->
            <x-h3 color="lime">小学生</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>小２</x-th>
                        <x-th>小３</x-th>
                        <x-th>小４</x-th>
                        <x-th>小５</x-th>
                        <x-th>小６</x-th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 小学算数 --}}
                    <tr>
                        <x-td>算数</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.mul100')}}">10倍、100倍</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.ratio1')}}">割合</a>
                                </x-button-link>
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.select_eq_decimal')}}">式の選択（小数）</a>
                                </x-button-link>
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.velocity1')}}">速さ１</a>
                                </x-button-link>
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.velocity2')}}">速さ２</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.fraction_muldiv')}}">分数の乗除</a>
                                </x-button-link>
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.ratio2')}}">比</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                    {{-- 小学国語 --}}
                    <tr>
                        <x-td>国語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.kanjiP2')}}">小２漢字</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.kanjiP3')}}">小３漢字</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="lime">
                                    <a href="{{route('workbook.unit.kanjiP4')}}">小４漢字</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>

            <!---------------------------------------- 数学 ---------------------------------------->
            <x-h3>数学</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>中１</x-th>
                        <x-th>中２</x-th>
                        <x-th>中３</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>式の計算</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.distributive_law1')}}">分配法則１</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.distributive_law2')}}">分配法則２</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.fractional_expression')}}">分数の文字式</a>
                                </x-button-link>

                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.expansion')}}">式の展開</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.factorization')}}">因数分解</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.sqrt_calc')}}">平方根の和差</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.sqrt_natural')}}">自然数になる\(\sqrt{an}\)</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>方程式</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.linear_equation1')}}">\(ax=b\)</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.linear_equation2')}}">\(\displaystyle \frac{b}{\,a\,}x=c\)</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.linear_equation3')}}">\(\displaystyle \frac{a}{\,x\,}=b\)</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.linear_equation4')}}">\(\displaystyle \frac{c}{\,ax+b\,}=d\)</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.algebraic_expression')}}">文字式で表す</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.setup_equation')}}">文章からの立式</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.simultaneous_equation')}}">連立方程式</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.simultaneous_equation2')}}">連立方程式（文章題）</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>関数</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.reading_coordinates')}}">座標の読み取り</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.plot_proportional_function')}}">比例（グラフ描画）</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.read_proportional_function')}}">比例（グラフ読取）</a>
                                </x-button-link>
                                {{-- <x-button-link>
                                    <a href="{{route('workbook.unit.plot_proportional_function')}}">比例（グラフ描画）</a>
                                </x-button-link> --}}
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.plot_linear_function')}}">一次関数（グラフ描画）</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.read_linear_function')}}">一次関数（グラフ読取）</a>
                                </x-button-link>
                                {{-- <x-button-link>
                                    <a href="{{route('workbook.unit.plot_linear_function')}}">一次関数（グラフ描画）</a>
                                </x-button-link> --}}
                                <x-button-link>
                                    <a href="{{route('workbook.unit.linear_function3')}}">２点を通る直線</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.plot_linear_function2')}}">交点の座標</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>図形</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.plane_figure')}}">平面図形</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.fan_figure')}}">おうぎ形</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.spacial_figure')}}">空間図形</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.corn_surface')}}">円錐の表面積</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.find_angle')}}">角度を求める</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.regular_polygon')}}">正多角形の角</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.proof_congruence1')}}">合同の証明１</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>データの活用</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.num_of_cases')}}">場合の数</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>総合</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.coordinates_triangle')}}">座標と三角形の面積</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>
            <div class="flex flex-wrap gap-4 font-bold">
                <x-button-link>
                    <a href="{{route('workbook.trigonometric_ratio')}}">三角比（数A）</a>
                </x-button-link>
            </div>

            <!---------------------------------------- 英語 ---------------------------------------->
            <x-h3 color="purple">英語</x-h3>
            <p class="text-center font-bold text-red-600">2026/9/5：「和訳」「英訳」を選べるようにしました。慣れるまでは「和訳」だけで練習しましょう。</p>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>中１</x-th>
                        <x-th>中２</x-th>
                        <x-th>中３</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>英単語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.unit.preposition')}}">前置詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.unit.e_word_verb1')}}">動詞１</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>英文法</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.be_verb')}}">be動詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.general_verb')}}">一般動詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.interrogative')}}">疑問詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.personal_pronoun')}}">代名詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.past_verb')}}">過去形</a>
                                </x-button-link>
                                {{-- <div>
                                    be動詞
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.be_verb1')}}">主語と動詞</a>
                                    </x-button-link>
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.be_verb2')}}">過去形</a>
                                    </x-button-link>
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.be_verb3')}}">疑問文・否定文</a>
                                    </x-button-link>
                                </div>
                                <div>
                                    一般動詞
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.general_verb1')}}">肯定文・疑問文・否定文</a>
                                    </x-button-link>
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.general_verb2')}}">三単現</a>
                                    </x-button-link>
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.general_verb3')}}">過去形</a>
                                    </x-button-link>
                                    <x-button-link color="purple">
                                        <a href="{{route('workbook.unit.general_verb4')}}">不規則動詞</a>
                                    </x-button-link>
                                </div> --}}
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.conjection')}}">接続詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.infinitive')}}">不定詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.gerund')}}">動名詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.auxiliary_verb')}}">助動詞</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.comparative')}}">比較級</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.passive_voice')}}">受け身</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.present_perfect')}}">現在完了</a>
                                </x-button-link>
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.svo_infinitive')}}">SVO+不定詞</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                    {{-- <tr>
                        <x-td>英文構造</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="purple">
                                    <a href="{{route('workbook.sentence_structure1')}}">be動詞と一般動詞</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr> --}}
                </tbody>
            </table>


            <!---------------------------------------- 理科 ---------------------------------------->
            <x-h3 color="green">理科</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>中１</x-th>
                        <x-th>中２</x-th>
                        <x-th>中３</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>生物</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>化学</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="green">
                                    <a href="{{route('workbook.unit.density')}}">密度</a>
                                </x-button-link>
                                <x-button-link color="green">
                                    <a href="{{route('workbook.unit.aqueous1')}}">水溶液１</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="green">
                                    <a href="{{route('workbook.chemical_reaction_equation')}}">化学反応式</a>
                                </x-button-link>
                                <x-button-link color="green">
                                    <a href="{{route('workbook.mass_change')}}">化学変化と質量変化</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>地学</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="green">
                                    <a href="{{route('workbook.unit.humidity')}}">湿度・水蒸気量</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>物理</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="green">
                                    <a href="{{route('workbook.unit.electromagnetism')}}">電磁気</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>全分野</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="green">
                                    <a href="{{route('workbook.science_terms_all')}}">用語の概念</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>



            <!---------------------------------------- 社会 ---------------------------------------->
            <x-h3 id="society" color="yellow">社会</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>中１</x-th>
                        <x-th>中２</x-th>
                        <x-th>中３</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>地理</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="yellow">
                                    <a href="{{route('workbook.unit.map_scale')}}">地図の縮尺</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="yellow">
                                    <a href="{{route('workbook.soc_kyushu')}}">九州地方</a>
                                </x-button-link>
                                <x-button-link color="yellow">
                                    <a href="{{route('workbook.soc_shikoku')}}">中国・四国地方</a>
                                </x-button-link>
                                <x-button-link color="yellow">
                                    <a href="{{route('workbook.soc_kinki')}}">近畿・中部地方</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>歴史</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="yellow">
                                    <a href="{{route('workbook.soc_kodai')}}">縄文、弥生、古墳</a>
                                </x-button-link>
                                {{-- <x-button-link color="yellow">
                                    <a href="{{route('workbook.soc_asuka_nara')}}">飛鳥、奈良</a>作成中
                                </x-button-link> --}}
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="yellow">
                                    <a href="{{route('workbook.soc_bakumatsu')}}">幕末</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>公民</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>

                        <!---------------------------------------- 社会 ---------------------------------------->
            <x-h3 color="red">国語</x-h3>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>中１</x-th>
                        <x-th>中２</x-th>
                        <x-th>中３</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>漢字</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                {{-- <x-button-link color="red">
                                    <a href="{{route('workbook.unit.map_scale')}}">地図の縮尺</a>
                                </x-button-link> --}}
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>国文法</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="red">
                                    <a href="{{route('workbook.jp_yougen')}}">用言</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>