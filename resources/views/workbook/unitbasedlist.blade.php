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

            <!---------------------------------------- 数学 ---------------------------------------->
            <x-h3>数学</x-h3>
            <x-h4>中１</x-h4>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>単元</x-th>
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
                    </tr>
                    <tr>
                        <x-td>一次方程式</x-td>
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
                    </tr>
                    <tr>
                        <x-td>比例</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.plot_proportional_function')}}">グラフ描画</a>
                                </x-button-link>
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
                    </tr>
                </tbody>
            </table>

            <x-h4>中２</x-h4>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>単元</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>一次関数</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.plot_linear_function')}}">グラフ描画</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>

            <!---------------------------------------- 英語 ---------------------------------------->
            <x-h3>英語</x-h3>
            <x-h4>中１</x-h4>
            <table class="border-separate border border-slate-400 m-auto table-fixed">
                <thead>
                    <tr class="bg-gray-300">
                        <x-th>分野</x-th>
                        <x-th>単元</x-th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <x-td>英単語</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.e_word_verb1')}}">動詞１</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>be動詞</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.be_verb1')}}">主語と動詞</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.be_verb2')}}">過去形</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.be_verb3')}}">疑問文・否定文</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>一般動詞</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.general_verb1')}}">肯定文・疑問文・否定文</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.general_verb2')}}">三単現</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.general_verb3')}}">過去形</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.general_verb4')}}">不規則動詞</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>品詞</x-td>
                        <x-td class="font-bold">
                            <div class="flex flex-wrap gap-4">
                                <x-button-link>
                                    <a href="{{route('workbook.unit.pronoun')}}">代名詞</a>
                                </x-button-link>
                                <x-button-link>
                                    <a href="{{route('workbook.unit.preposition')}}">前置詞</a>
                                </x-button-link>
                            </div>
                        </x-td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>