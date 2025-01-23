<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            中学英語（英文読解）
        </h2>
    </x-slot>
    @auth
        <div style="display:flex;">
            <div class="px-6 py-4 text-lg font-semibold">
                <a href="{{route('workbook.grammar')}}" class="text-blue-600 font-semibold">英文法</a>
            </div>
            <div class="px-6 py-4 text-lg font-semibold">
                ＞英文読解
            </div>
        </div>

        <div class="content-block">
            <p>◎高校入試過去問を題材にして、読解練習をしてみよう！</p>

            <h2>
                2024年度　英語　問３
            </h2>
            <div class="explanation-content">
                <div>
                    <p>
                        まずは一つ目の発表の文章について、構造を把握して読む練習をしましょう。<span class="sub">主語</span>と<span class="verb">動詞</span>に色を付けてあります。
                    </p>
                    <div class="content-inner-block">
                        <p><span class="sub">Carnival in Rio de Janeiro</span> <span class="verb">is</span> a very big festival [in Brazil].</p>
                        <p>（<span class="sub">リオデジャネイロのカーニバル</span><span class="verb">は</span>[ブラジルでは]とても大きなお祭りのひとつ<span class="verb">です</span>。）</p>
                    </div>
                    <div class="content-inner-block">
                        <p><span class="sub">You</span> <span class="verb">can enjoy</span> watching parades [with big floats(山車)].</p>
                        <p>（<span class="sub">あなた</span>は[山車と一緒に]パレードを見ることを<span class="verb">楽しむことができます</span>。）</p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            <span class="sub">The streets</span> <span class="verb">are</span> full of music.
                        </p>
                        <p>
                            （<span class="sub">その通り</span><span class="verb">は</span>音楽でいっぱい<span class="verb">です</span>。）
                        </p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            <span class="sub">I</span> <span class="verb">wear</span> special clothes and <span class="verb">take part in</span> the event [with my friends].
                        </p>
                        <p>
                            （<span class="sub">私</span>は特別な服を<span class="verb">着て</span>、[友だちと一緒に]そのイベントに<span class="verb">参加します</span>。）
                        </p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            <span class="sub">It</span><span class="verb">'s</span> fun, so <span class="sub">I</span> <span class="verb">want to keep</span> joining the Carnival [even when I get older].
                        </p>
                        <p>
                            （<span class="sub">それ</span><span class="verb">は</span>楽しい。だから<span class="sub">私</span>は[たとえ年を取っても]そのカーニバルに参加することを<span class="verb">続けたい</span>。）
                        </p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            <span class="sub">The Carnival</span> <span class="verb">is held</span> [for about five days], but <span class="sub">it</span> <span class="verb">takes</span> about a year [to prepare for it].
                        </p>
                        <p>
                            （<span class="sub">そのカーニバル</span>は[約5日間]<span class="verb">開催される</span>。しかし、<span class="sub">それ</span>は[それを準備するのに]約一年<span class="verb">かかる</span>。）
                        </p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            For example, <span class="sub">we</span> <span class="verb">create</span> floats and <span class="verb">practice</span> dancing.
                        </p>
                        <p>
                            （例えば、<span class="sub">私たち</span>は山車を<span class="verb">作り</span>、踊りの<span class="verb">準備をする</span>。）
                        </p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            <span class="sub">These efforts</span> <span class="verb">make</span> <span class="underline">the Carnival</span> <span class="underline">special</span> [to us].
                        </p>
                        <p>
                            （<span class="sub">これらの努力</span>はそのカーニバルを[私たちにとって]特別なものに<span class="verb">する</span>。）
                        </p>
                    </div>
                    <div class="content-inner-block">
                        <p>
                            <span class="sub">This</span> <span class="verb">is</span> the thing (that) <span class="sub">I</span> <span class="verb">want to tell</span> you [the most].
                        </p>
                        <p>
                            （<span class="sub">これ</span><span class="verb">が</span>、<span class="sub">私</span>があなたたちに[最も]<span class="verb">伝えたい</span>ことです。）
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-block">
            <h2>
                2024年度　英語　問４
            </h2>
            <div class="explanation-content">
                <p>
                    関係代名詞を含む長めの文について、構造を見てみましょう。
                </p>
                <div class="content-inner-block">
                    <p>第2段落　1行目</p>
                    <p>[One year and four months after getting the seeds], <span class="sub">making a powder from the flower (which) he grew</span> <span class="verb">was</span> successful.</p>
                    <p>（[種を手に入れてから1年と4か月後]、<span class="sub">彼が育てた花から粉を作ること</span><span class="verb">は</span>成功<span class="verb">だった</span>。）</p>
                    <div class="comment">
                        <ul>
                            <li>文の前半（カンマまで）は補足説明で、重要なのは趣旨が述べられている後半です。</li>
                            <li>原文では関係代名詞(which)が省略されていることに注意しましょう。</li>
                            <li>主格(he)は文頭にくるのが普通なので、文中にある場合はその直前に関係代名詞がある可能性を考えましょう。</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</x-app-layout>