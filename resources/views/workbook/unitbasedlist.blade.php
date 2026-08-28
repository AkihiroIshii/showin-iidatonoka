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
                        <x-td>関数</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.plot_proportional_function')}}">比例（グラフ描画）</a>
                                </x-button-link>
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.plot_linear_function')}}">一次関数（グラフ描画）</a>
                                </x-button-link>
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
                                    <a href="{{route('workbook.unit.spacial_figure')}}">空間図形</a>
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
                </tbody>
            </table>


            <!---------------------------------------- 英語 ---------------------------------------->
            <x-h3 color="purple">英語</x-h3>
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
                                    <a href="{{route('workbook.unit.pronoun')}}">代名詞</a>
                                </x-button-link>
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
                            </div>
                        </x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
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
                </tbody>
            </table>



            <!---------------------------------------- 社会 ---------------------------------------->
            <x-h3 color="yellow">社会</x-h3>
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
                    {{-- <tr>
                        <x-td>国文法</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link color="red">
                                    <a href="{{route('workbook.unit.map_scale')}}">地図の縮尺</a>
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

        </div>
    </div>
</x-app-layout>