<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            基本の公式集
            <span style="font-size:1rem;color:green;">　　ピンとこない式があったら早急に確認しよう(`・ω・´)</span>
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            <h3>数学の公式</h3>
            <div class="content-subject w-30">
            <div class="content-block-1">
                    <h4>方程式の変形（中１）</h4>
                    <ul>
                        <li>
                            <p>移項　(※)ここでは両辺から \(a\) を引いている。</p>
                            $$
                            \begin{align*}
                                x+a &= b \\
                                x &= b-a
                                \end{align*}
                            $$
                        </li>
                        <li>
                            <p>\(x\) の係数の逆数(ここでは \( \frac{1}{a} \) )を両辺に掛ける。</p>
                            $$ ax=b $$
                            $$ x=\frac{b}{a} $$
                        </li>
                        <li>
                            <p>すべての項に同じ数（ここでは \(6\) ）を掛ける</p>
                            $$
                            \begin{align*}
                                \frac{1}{3}x + 1 &= \frac{5}{6} \\
                                \\
                                2x + 6 &= 5
                            \end{align*}
                            $$
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>平面図形（中１）</h4>
                    <ul>
                        <li>
                            <p>半径 \(r\) の円の面積 \(S\)</p>
                            $$ S=\pi r^2 $$
                        </li>
                        <li>
                            <p>半径 \(r\) の円の周の長さ \(l\)</p>
                            $$ l=2\pi r $$
                        </li>
                        <li>
                            <p>半径 \(r\)、中心角 \( a^\circ \) のおうぎ形の面積 \(S\)</p>
                            $$ S=\pi r^2 \times \frac{a}{360}$$
                        </li>
                        <li>
                            <p>底辺 \(a\)、高さ \(h\) の三角形の面積 \(S\)</p>
                            $$ S=\frac{1}{2}ah$$
                        </li>
                        <li>
                            <p>上底 \(a\)、下底 \(b\)、高さ \(h\) の台形の面積 \(S\)</p>
                            $$ S=\frac{1}{2}(a+b)h$$
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>空間図形（中１）</h4>
                    <ul>
                    <li>
                            <p>底面積 \(S\)、高さ \(h\) の円柱、角柱の体積 \(V\)</p>
                            $$ V=Sh $$
                        </li>
                        <li>
                            <p>底面積 \(S\)、高さ \(h\) の円すい、角すいの体積 \(V\)</p>
                            $$ V=\frac{1}{3}Sh $$
                        </li>
                        <li>
                            <p>底面積 \(S\)、高さ \(h\) の円すい、角すいの体積 \(V\)</p>
                            $$ V=\frac{1}{3}Sh $$
                        </li>
                        <li>
                            <p>半径 \(r\) の球の体積 \(V\)</p>
                            $$ V=\frac{4}{3}\pi r^3 $$
                        </li>
                        <li>
                            <p>半径 \(r\) の球の表面積 \(S\)</p>
                            $$ S=4\pi r^2 $$
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>式の展開など（中３）</h4>
                    <ul>
                    <li>
                            $$ (a+b)^2 = a^2+2ab+b^2 $$
                        </li>
                        <li>
                            $$ (a-b)^2 = a^2-2ab+b^2 $$
                        </li>
                        <li>
                            $$ (a+b)(a-b) = a^2-b^2 $$
                        </li>
                        <li>
                            <p>二次方程式：解の公式</p>
                            $$ ax^2+bx+c=0 $$ において、
                            $$ x=\frac{-b \pm \sqrt{b^2-4ac}}{2a} $$
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>関数の形</h4>
                    <ul>
                    <li>
                            <p>比例（中１）</p>
                            $$ y=ax $$
                        </li>
                        <li>
                            <p>反比例（中１）</p>
                            $$ y=\frac{a}{x} $$
                        </li>
                        <li>
                            <p>一次関数（中２）</p>
                            $$ y=ax+b$$
                        </li>
                        <li>
                            <p>二次関数（中３）</p>
                            $$ y=ax^2 $$
                        </li>
                    </ul>
                </div>
            </div>

            <h3>理科の公式</h3>
            <div class="content-subject w-45">
            <div class="content-block-1">
                    <h4>化学</h4>
                    <ul>
                        <li>
                            <p>物質の密度（中１）</p>
                            $$ 密度[g/cm^3]=\frac{質量[g]}{体積[cm^3]} $$
                        </li>
                        <li>
                            <p>質量パーセント濃度（中１）</p>
                            $$ 質量パーセント濃度[\%]=\frac{溶質[g]}{溶液[g]} \times 100 $$
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>地学</h4>
                    <ul>
                        <li>
                            <p>水蒸気量（中２）</p>
                            $$ 水蒸気量[g/m^3]=\frac{水蒸気の質量[g]}{空間の体積[m^3]} $$
                        </li>
                        <li>
                            <p>湿度（中２）</p>
                            $$ 湿度[\%]=\frac{水蒸気量[g/m^3]}{飽和水蒸気量[g/m^3]} \times 100 $$
                            <p style="text-align:center;">(※)飽和水蒸気量は温度によって変わるので注意</p>
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>物理：電流</h4>
                    <ul>
                        <li>
                            <p>オームの法則（中２）</p>
                            $$ 電圧V[V]=抵抗R[\Omega] \times 電流I[A] $$
                        </li>
                        <li>
                            <p>直列回路（中２）</p>
                            $$ I=I_1=I_2,　V=V_1+V_2,　R=R_1+R_2 $$
                        </li>
                        <li>
                            <p>並列回路（中２）</p>
                            $$ I=I_1+I_2,　V=V_1=V_2,　\frac{1}{R}=\frac{1}{R_1}+\frac{1}{R_2} $$
                        </li>
                        <li>
                            <p>電力 \(W\)、電力量 \(P\)（中２）</p>
                            $$ W=VI,　P[J]=Wt（t は秒数）$$
                        </li>
                    </ul>
                </div>
                <div class="content-block-1">
                    <h4>物理：力学</h4>
                    <ul>
                        <li>
                            <p>仕事（中３）</p>
                            $$ 仕事[J]=力の大きさ[N] \times 動いた距離[m] $$
                        </li>
                        <li>
                            <p>仕事（中３）</p>
                            $$ 仕事率[W]=\frac{仕事[J]}{かかった時間[s]} $$
                        </li>
                        <li>
                            <p>圧力（中２）</p>
                            $$ 圧力[Pa]=\frac{面を垂直に押す力[N]}{力が働く面積[m^3]} $$
                        </li>
                    </ul>
                </div>
            </div>

            <h3>社会の公式</h3>
            <div class="content-subject w-45">
                <div class="content-block-1">
                    <h4>地理</h4>
                    <ul>
                        <li>
                            <p>経度差が \(x^\circ\) の２地点の時差 \(T\)（中１）</p>
                            $$ 360^\circ :24[時間] = x^\circ :T[時間] $$
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>