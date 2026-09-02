<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\UserTrait;
use App\Models\Workbook;

class WorkbookController extends Controller
{
    use UserTrait;

    public function reference() {
        return view('workbook.reference');
    }

    public function grammar() {
        return view('workbook.grammar');
    }

    public function reading() {
        return view('workbook.reading');
    }

    public function randomsetting() {
        return view('workbook.randomsetting');
    }

    // public function answersheet() {
    //     return redirect(asset('pdf/answersheet.pdf'));
    // }


    public function index(User $user) {
        $user = $this->targetUser(Auth::user());

        $workbooks = Workbook::query()
            ->orderBy('subject','asc')
            ->orderBy('grade','desc')
            ->get();

        return view('workbook.index', compact('user','workbooks'));
    }

    public function unitbasedlist(User $user) {
        $user = $this->targetUser(Auth::user());

        $workbooks = Workbook::query()
            ->orderBy('subject','asc')
            ->orderBy('grade','desc')
            ->get();

        return view('workbook.unitbasedlist', compact('user','workbooks'));
    }

    /***************** 単元別問題作成 *****************/
    // 10倍、100倍
    public function mul100() {
        $a = rand(2, 9);
        $m1 = 10 ** rand(0, 2);
        $b = rand(2, 9);
        $m2 = 10 ** rand(1, 2);
        $ans = $a * $m1 * $b * $m2;

        return view('workbook.unit.mul100', compact('a','b','m1','m2','ans'));
    }
 
    // 割合
    public function ratio1() {
        $num = 10 * rand(1, 20);
        $wari = rand(1, 9); //割
        $waribiki = 10 - $wari;     //例：6割＝4割引
        $bu = rand(1, 9); //分
        $per_array = [1, 2, 4, 5, 10, 12, 20, 25, 50, 80];  // % の候補
        $per_idx = array_rand($per_array);
        $per = $per_array[$per_idx];
        $val1 = $num * (0.1 * $wari); 
        $val2 = $num * (0.01 * $bu);
        $val_waribiki = $num * (1 - 0.1 * $wari);
        $val_1wari = $num * 0.1;
        $val_1bu = $num * 0.01;
        $val_1per = $num * 0.01;
        $val_per = $num * 0.01 * $per;
        $val_per2 = 0.01 * $per;
        
        $questions = [
            [
                'q' => "\({$num}\,の\,{$wari}\,割はいくつか。\)",
                'a' => "{$val1}",
                'e' => "<div>
                            <p>\(\displaystyle {$wari}\,割は\,0.{$wari}\\left(=\\frac{{$wari}}{\,10\,} \\right)倍なので、{$num}\,\\times\,0.{$wari} = {$val1}.\)</p>
                            <p>\(\displaystyle {$num}\,の\,1\,割（0.1倍）が\,{$val_1wari}\,なので、{$val_1wari}\,\\times{$wari} = {$val1}\,と計算してもよい.\)</p>
                        </div>",
            ],
            [
                'q' => "\({$num}\,の\,{$bu}\,分（ぶ）はいくつか。\)",
                'a' => "{$val2}",
                'e' => "<div>
                            <p>\(\displaystyle {$bu}\,分は\,0.0{$bu}\\left(=\\frac{{$bu}}{\,100\,} \\right)倍なので、{$num}\,\\times\,0.0{$bu} = {$val2}.\)</p>
                            <p>\(\displaystyle {$num}\,の\,1\,分（0.01倍）が\,{$val_1bu}\,なので、{$val_1bu}\,\\times{$bu} = {$val2}\,と計算してもよい.\)</p>
                        </div>",
            ],
            [
                'q' => "\({$num}\,の\,{$per}\,\%\,はいくつか。\)",
                'a' => "{$val_per}",
                'e' => "<div>
                            <p>\(\displaystyle {$per}\,\%\,は\,{$val_per2}\\left(=\\frac{{$per}}{\,100\,} \\right)\,倍なので、{$num}\,\\times{$val_per2} = {$val_per}.\)</p>
                            <p>\(\displaystyle {$num}\,の\,1\,\%（0.01倍）が\,{$val_1per}\,なので、{$val_1per}\,\\times{$per} = {$val_per}\,と計算してもよい.\)</p>
                        </div>",
            ],
            [
                'q' => "\({$num}\,の\,{$wari}\,割引はいくつか。\)",
                'a' => "{$val_waribiki}",
                'e' => "<div>
                            <p>\(\displaystyle {$wari}\,割は\,0.{$wari}\\left(=\\frac{{$wari}}{\,10\,} \\right)倍なので、{$num}\,\\times\,0.{$wari} = {$val1}.\)</p>
                            <p>\(これをもとの値から割り引くと、{$num} - {$val1} = {$val_waribiki}.\)</p>
                            <p>\(また、{$wari}\,割引はもとの値の{$waribiki}\,割と同じなので、{$num} \\times 0.{$waribiki} = {$val_waribiki}\,と計算してもよい.\)</p>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "割合";
        return view('workbook.unit.child', compact('unitname','question'));
    }

    // 式の選択（小数）
    public function select_eq_decimal() {
        $a = 0.3 * rand(1, 9);
        $b = 0.3 * rand(1, 9);
        $n = rand(2, 9);
        
        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の値を求めるための<span class=\"underline\">計算式</span>を答えなさい。</p>
                        <p class=\"text-xl\">{$a} の {$b} 倍はいくつか。<p>",
                'a_type' => 1,
                'a' => "{$a} × {$b}",
                'e_type' => 1,
                'e' => "2 の 3 倍はいくつかを考えると、計算式は 2 × 3。小数も同様に考えればよい。",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の値を求めるための<span class=\"underline\">計算式</span>を答えなさい。</p>
                        <p class=\"text-xl\">{$a} は {$b} の何倍か。<p>",
                'a_type' => 1,
                'a' => "{$a} ÷ {$b}",
                'e_type' => 3,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-desc\">
                                <li>6 は 2 の何倍かを考えると、計算式は 6 ÷ 2。小数も同様に考えればよい。</li>
                                <li>小さい数を大きい数でわることもある（2 ÷ 6 など）。慣れておくこと。</li>
                            </ul>
                        </div>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の値を求めるための<span class=\"underline\">計算式</span>を答えなさい。</p>
                        <p class=\"text-xl\">ジュースを {$n} 人に {$a} L ずつ配るためには、何 L 必要か。<p>",
                'a_type' => 1,
                'a' => "{$n} × {$a}",
                'e_type' => 1,
                'e' => "ジュースを 5 人に 2 L ずつ配ることを考えると、必要な量の計算式は 5 × 2。小数も同様に考えればよい。",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の値を求めるための<span class=\"underline\">計算式</span>を答えなさい。</p>
                        <p class=\"text-xl\">{$a} L のジュースを {$n} 人で同じ量ずつ分けると、一人分は何 L か。<p>",
                'a_type' => 1,
                'a' => "{$a} ÷ {$n}",
                'e_type' => 1,
                'e' => "8 L のジュースを 4 人で分けることを考えると、一人分の計算式は 8 ÷ 4。小数も同様に考えればよい。",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "式の選択（小数）";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 速さ１
    public function velocity1() {
        $v = rand(2, 9);    // m/s
        $t = 10 * rand(1, 9);    // s
        $d = $v * $t;   // m

        $questions = [
            [
                'q' => "\,{$d}\,\mathrm{m}\,の距離を\,{$t}\,秒で通過する物体の速さ（秒速）を求めなさい。",
                'a' => "{$v}\,\mathrm{m/秒}",
                'e' => "秒速とは、１秒あたりに進む距離のことである。よって、\mathrm{秒速[m/秒] = 距離[m] \div 時間[秒] = {$d}[m] \div {$t}[秒] = {$v}[m/秒] }。",
            ],
            [
                'q' => "\,{$d}\,\mathrm{m}\,の距離を、秒速\,{$v}\,\mathrm{m}で通過するのにかかる時間を求めなさい。",
                'a' => "{$t}\,秒",
                'e' => "秒速\,{$v}\,\mathrm{m}とは、1\,秒で\,{$v}\,\mathrm{m}\,進む速さのことである。
                        よって、\mathrm{かかる時間[秒] = 距離[m] \div 速さ[m/秒] = {$d}[m] \div {$v}[m/秒] = {$t}[秒] }。",
            ],
            [
                'q' => "秒速\,{$v}\,\mathrm{m}で\,{$t}\,秒間動き続けると、何\,\mathrm{m}\,進むか。",
                'a' => "{$d}\,\mathrm{m}",
                'e' => "秒速\,{$v}\,\mathrm{m}とは、1\,秒で\,{$v}\,\mathrm{m}\,進む速さのことである。
                        よって、\mathrm{{$t}秒あればその\,{$t}\,倍進めるので、{$v}[m/秒] \\times {$t}[秒] = {$d}[m] }。",
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.velocity1', compact('question'));
    }

    // 速さ２
    public function velocity2() {
        $v_ms = rand(2, 9);    // m/s
        $t_s = 10 * rand(1, 9);    // s
        $d_m = $v_ms * $t_s;   // m

        $v_mm = $v_ms * 60; // m/min
        $v_km = $v_mm / 1000; // km/min

        // 時速算出用（上記の変数と独立）
        $v_km2 = rand(2, 9);    //km/min
        $v_kh2 = $v_km2 * 60; // km/h

        // さらに独立な変数
        $v_kh3 = 18 * rand(1, 20);   // km/h
        $v_ms3 = $v_kh3 * 1000 / 3600;   // m/s

        $questions = [
            [
                'q' => "秒速\,{$v_ms}\,\mathrm{m}\,を分速 [\mathrm{m/分}] に直せ。",
                'a' => "{$v_mm}\,\mathrm{m/分}",
                'e' => "\mathrm{秒速\,{$v_ms}\,m\,では1秒間に\,{$v_ms}\,m\,進むので、1分間（60秒間）あれば\,{$v_ms} \\times 60 = {$v_mm}\,m\,進める。}",
            ],
            [
                'q' => "分速\,{$v_mm}\,\mathrm{m}\,を秒速 [\mathrm{m/秒}] に直せ。",
                'a' => "{$v_ms}\,\mathrm{m/秒}",
                'e' => "\mathrm{分速\,{$v_mm}\,m\,では1分間（60秒間)に\,{$v_mm}\,m\,進む。1秒間では\,{$v_mm} \div 60 = {$v_ms}\,m\,しか進まない。}",
            ],
            [
                'q' => "分速\,{$v_mm}\,\mathrm{m}\,を、\mathrm{km}\,単位の分速 [\mathrm{km/分}] に直せ。",
                'a' => "{$v_km}\,\mathrm{km/分}",
                'e' => "\mathrm{分速であることに変わりはないので、距離の単位の違いだけ考えればよい。1km=1000mなので、{$v_mm} \div 1000 = {$v_km}。}",
            ],
            [
                'q' => "分速\,{$v_km2}\,\mathrm{km}\,を時速 [\mathrm{km/時}] に直せ。",
                'a' => "{$v_kh2}\,\mathrm{km/時}",
                'e' => "\mathrm{分速\,{$v_km2}\,km\,では1分間に\,{$v_km2}\,km\,進むので、1時間（60分間）あれば\,{$v_km2} \\times 60 = {$v_kh2}\,km\,進める。}",
            ],
            [
                'q' => "時速\,{$v_kh3}\,\mathrm{km}\,を秒速 [\mathrm{m/秒}] に直せ。",
                'a' => "{$v_ms3}\,\mathrm{m/秒}",
                'e' => "\mathrm{
                            {$v_kh3}\,[km/時] = \\frac{ \,{{ $v_kh3 }}\,[km]\, }{ 1\,[時間] }
                            = \\frac{ \,{{ $v_kh3 }}\\times 1000\,[m]\, }{ 60 \\times 60\,[秒] }
                            = {$v_ms3}\,[m/秒]
                        }",
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.velocity2', compact('question'));
    }

    // 分数の乗除
    public function fraction_muldiv() {
        $primes1 = $this->get_primes(4, 11);
        $a = $primes1[0];
        $b = $primes1[1];
        $c = $primes1[2];
        $d = $primes1[3];
        $numerator = $b * $d;
        $denominator = $a * $c;

        $primes2 = $this->get_primes(2, 11);
        $m = $primes2[0];
        $n = $primes2[1];
        $ma = $m * $a;
        $md = $m * $d;
        $nb = $n * $b;
        $nc = $n * $c;

        $questions = [
            [
                'q' => "\(\displaystyle \\frac{\,{$b}\,}{\,{$a}\,}\\times\\frac{\,{$d}\,}{\,{$c}\,}\,を計算しなさい。 \)",
                'a' => "\\frac{\,{$numerator}\,}{{$denominator}}",
                'e' => "<div>
                            \(\displaystyle
                                \\frac{\,{$b}\,}{\,{$a}\,}\\times\\frac{\,{$d}\,}{\,{$c}\,}\,
                                = \\frac{\,{$b}\\times{$d}\,}{\,{$a}\\times{$c}\,}
                                = \\frac{\,{$numerator}\,}{{$denominator}}
                            \)
                        </div>",
            ],
            [
                'q' => "\(\displaystyle \\frac{\,{$nb}\,}{\,{$ma}\,}\\times\\frac{\,{$md}\,}{\,{$nc}\,}\,を計算しなさい。 \)",
                'a' => "\\frac{\,{$numerator}\,}{{$denominator}}",
                'e' => "<div>
                            <p>\( まず\,{$ma}\,と\,{$md}\,、\,{$nb}\,と\,{$nc}\,をそれぞれ約分してから計算する。 \)</p>
                            \(\displaystyle
                                \\frac{\,{$nb}\,}{\,{$ma}\,}\\times\\frac{\,{$md}\,}{\,{$nc}\,}
                                = \\frac{\,{$b}\,}{\,{$a}\,}\\times\\frac{\,{$d}\,}{\,{$c}\,}
                                = \\frac{\,{$numerator}\,}{{$denominator}}
                            \)
                        </div>",
            ],
            [
                'q' => "\(\displaystyle \\frac{\,{$b}\,}{\,{$a}\,}\\div\\frac{\,{$c}\,}{\,{$d}\,}\,を計算しなさい。 \)",
                'a' => "\\frac{\,{$numerator}\,}{{$denominator}}",
                'e' => "<div>
                            \(\displaystyle
                                \\frac{\,{$b}\,}{\,{$a}\,}\\div\\frac{\,{$c}\,}{\,{$d}\,}\,
                                =\\frac{\,{$b}\,}{\,{$a}\,}\\times\\frac{\,{$d}\,}{\,{$c}\,}\,
                                = \\frac{\,{$b}\\times{$d}\,}{\,{$a}\\times{$c}\,}
                                = \\frac{\,{$numerator}\,}{{$denominator}}
                            \)
                        </div>",
            ],
            [
                'q' => "\(\displaystyle \\frac{\,{$nb}\,}{\,{$ma}\,}\\div\\frac{\,{$nc}\,}{\,{$md}\,}\,を計算しなさい。 \)",
                'a' => "\\frac{\,{$numerator}\,}{{$denominator}}",
                'e' => "<div>
                            <p>\( わり算をかけ算に直したら、次に\,{$ma}\,と\,{$md}\,、\,{$nb}\,と\,{$nc}\,をそれぞれ約分する。 \)</p>
                            \(\displaystyle
                                \\frac{\,{$nb}\,}{\,{$ma}\,}\\div\\frac{\,{$nc}\,}{\,{$md}\,}
                                = \\frac{\,{$nb}\,}{\,{$ma}\,}\\times\\frac{\,{$md}\,}{\,{$nc}\,}
                                = \\frac{\,{$b}\,}{\,{$a}\,}\\times\\frac{\,{$d}\,}{\,{$c}\,}
                                = \\frac{\,{$numerator}\,}{{$denominator}}
                            \)
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "分数の乗除";
        return view('workbook.unit.child', compact('unitname','question'));
    }

    // 比
    public function ratio2() {
        $primes1 = $this->get_primes(3, 13);
        $multi = rand(2, 6);    //倍率
        $mul10 = 10 ** rand(1,2);      //小数用
        $div = $primes1[0];
        $b = $primes1[1];
        $a = $primes1[2];
        $am = $a * $multi;
        $bm = $b * $multi;
        $c = $b * $div;
        // $cm = $c * $multi;
        $am_deci = $am / $mul10;
        $bm_deci = $bm / $mul10;

        // t/s = v/u, v=mt
        $primes2 = $this->get_primes(4, 13);
        $m = $primes2[0];
        $s = $primes2[1];
        $u = $primes2[2];
        $t = $primes2[3];
        $v = $m * $t;
        $ms = $m * $s;

        $questions = [
            [
                'q' => "\( {$am}:{$bm}\,を簡単な整数比で表しなさい。 \)",
                'a' => "{$a}:{$b}",
                'e' => "<div>
                            \(いずれも\,{$multi}\,の倍数である。\)
                        </div>",
            ],
            [
                'q' => "\(\displaystyle \\frac{{$a}}{{$div}}:{$b}\,を簡単な整数比で表しなさい。 \)",
                'a' => "{$a}:{$c}",
                'e' => "<div>
                            <p>\(それぞれ\,{$div}\,倍する。\)</p>
                            <p>\(\displaystyle \\frac{{$a}}{{$div}}:{$b} = \\left(\\frac{{$a}}{{$div}}\\times {$div}\\right):({$b}\\times {$div}) = {$a}:{$c}.\)</p>
                        </div>",
            ],
            [
                'q' => "\(\displaystyle \\frac{\,{$t}\,}{\,{$s}\,}:\\frac{\,{$v}\,}{\,{$u}\,}\,を簡単な整数比で表しなさい。 \)",
                'a' => "{$u}:{$ms}",
                'e' => "<div>
                            <p>\(\displaystyle 分子同士が簡単な整数比になるので、まずそれぞれを\,{$t}\,で割るとよい。 \)</p>
                            <p>\(\displaystyle
                                \\frac{\,{$t}\,}{\,{$s}\,}:\\frac{\,{$v}\,}{\,{$u}\,}
                                = \\frac{\,1\,}{\,{$s}\,}:\\frac{\,{$m}\,}{\,{$u}\,}
                                = {$u}:{$ms}
                            \)</p>
                        </div>",
            ],
            [
                'q' => "\( {$am_deci}:{$bm_deci}\,を簡単な整数比で表しなさい。 \)",
                'a' => "{$a}:{$b}",
                'e' => "<div>
                            <p>\(まず整数比にするために\,{$mul10}\,倍すると扱いやすくなる。\)</p>
                            <p>\({$am_deci}:{$bm_deci} = ({$am_deci}\\times{$mul10}):({$bm_deci}\\times{$mul10}) = {$am}:{$bm} = {$a}:{$b} \)</p>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "比";
        return view('workbook.unit.child', compact('unitname','question'));
    }

    // 分配法則１
    public function distributive_law1() {
        $a = (-1)**rand(1,2) * rand(2, 9);
        $b = (-1)**rand(1,2) * rand(2, 9);
        $c = (-1)**rand(1,2) * rand(2, 9);

        return view('workbook.unit.distributive_law1', compact('a','b','c'));
    }

    // 分配法則２
    public function distributive_law2() {
        $a = rand(2, 9);
        $b = (-1)**rand(1,2) * rand(2, 9);
        $c = (-1)**rand(1,2) * rand(2, 9);
        $d = (-1)**rand(1,2) * $a * rand(2, 9);

        return view('workbook.unit.distributive_law2', compact('a','b','c','d'));
    }

    // 分数の文字式
    public function fractional_expression() {
        $p = rand(2, 9);
        $q = (-1)**rand(1,2) * rand(2, 9);

        return view('workbook.unit.fractional_expression', compact('p','q'));
    }

    // 一次方程式(1)
    public function linear_equation1() {
        $a = (-1)**rand(1,2) * rand(2, 9);
        $x = (-1)**rand(1,2) * rand(2, 9);

        $b = $a * $x;

        return view('workbook.unit.linear_equation1', [
            'a' => $a,
            'b' => $b,
            'answer' => $x,
        ]);
    }

    // // 一次方程式(2)(※)旧
    // public function linear_equation2() {
    //     // a, b, c をランダムに決める
    //     $a = rand(2, 9);
    //     $b = rand(1, 9);
    //     if ($a == $b) {
    //         $b = $a + rand(1,9);
    //     }
    //     $c = rand(1, 9);

    //     // x = ac / b
    //     $numerator = $a * $c;
    //     $denominator = $b;

    //     // 最大公約数を求める
    //     $gcd = $this->gcd($numerator, $denominator);

    //     // 約分
    //     $numerator /= $gcd;
    //     $denominator /= $gcd;

    //     // 分母が1なら整数として表示
    //     if ($denominator == 1) {
    //         $answer = $numerator;
    //     } else {
    //         $answer = $numerator . '/' . $denominator;
    //     }

    //     return view('workbook.unit.linear_equation2', compact('a','b','c','answer','numerator','denominator'));
    // }

    // 一次方程式(2)
    public function linear_equation2() {
        // a, b, c をランダムに決める
        $primes = $this->get_primes(2, 11);    // 11以下の素数を2つ取得する。
        $a = $primes[0];
        $b = $primes[1];
        $c = rand(1, 9);

        // x = ac / b
        $numerator = $a * $c;
        $denominator = $b;

        $ans_str = $this->fracnum_to_str($numerator, $denominator, "", 1);

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の方程式を解きなさい。</p>
                        <p>\(\displaystyle \\frac{\,$b\,}{\,$a\,}x={$c}\)</p>
                        ",
                'a_type' => 2,
                'a' => "{$ans_str}",
                'e_type' => 3,
                'e' => "<p>\(x\) の係数の逆数を両辺にかけると、</p>
                        <p>\(\displaystyle \\frac{\,$b\,}{\,$a\,}x \\times \\frac{\,$a\,}{\,$b\,} = {$c} \\times \\frac{\,$a\,}{\,$b\,}\)</p>
                        <p>左辺は約分すると \(x\) だけが残るので、右辺を計算すれば、</p>
                        <p>\(\displaystyle x={$ans_str}\)</p>
                        ",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "\(\displaystyle \\frac{b}{\,a\,}x=c\)";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 一次方程式(3)
    public function linear_equation3() {
        $a = (-1)**rand(1,2) * rand(2, 9);
        $b = (-1)**rand(1,2) * rand(2, 9);

        // x = a / b
        $numerator = $a;
        $denominator = $b;

        // 最大公約数を求める
        $gcd = $this->gcd($a, $b);

        // 約分
        $numerator /= $gcd;
        $denominator /= $gcd;

        // 答えの符号
        $ans_sign = "";
        if ($numerator * $denominator < 0) {
            $ans_sign = "-";
        }
        // 答えの分母と分子を正の数にする
        $numerator = abs($numerator);
        $denominator = abs($denominator);
        return view('workbook.unit.linear_equation3', compact('a','b','ans_sign','numerator','denominator'));
    }

    // 一次方程式(4)
    public function linear_equation4() {
        $a = (-1)**rand(1,2) * rand(2, 9);
        $b = rand(2, 9);
        $c = (-1)**rand(1,2) * rand(2, 9);
        $d = (-1)**rand(1,2) * rand(2, 9);

        // x = (c - bd) / ad
        $numerator = $c - $b * $d;
        $denominator = $a * $d;

        // 最大公約数を求める
        $gcd = $this->gcd($numerator, $denominator);

        // 約分
        $numerator /= $gcd;
        $denominator /= $gcd;

        // 答えの符号
        $ans_sign = "";
        if ($numerator * $denominator < 0) {
            $ans_sign = "-";
        }
        // 答えの分母と分子を正の数にする
        $numerator = abs($numerator);
        $denominator = abs($denominator);
        return view('workbook.unit.linear_equation4', compact('a','b','c','d','ans_sign','numerator','denominator'));
    }

    // 文字式で表す
    public function algebraic_expression() {
        $m = 10 * rand(2, 8);
        $n = rand(2, 9);

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p>時速 {$m} km で a 時間走った時の距離[km]。</p>
                        ",
                'a_type' => 2,
                'a' => "{$m}\,a",
                'e_type' => 3,
                'e' => "<p>距離 ＝ 速さ × 時間。</p>
                        <p>1 時間で {$m} km 走るので、その a 倍の {$m}a km 走る。</p>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p>距離 \(a\) km を時速 {$m} km で走るのにかかる時間。</p>
                        ",
                'a_type' => 1,
                'a' => "\(\\frac{a}{\,{$m}\,}\) 時間",
                'e_type' => 3,
                'e' => "<p>時間 ＝ 距離 ÷ 速さ。</p>
                        <p>時速 {$m} km は、1 時間あたりに {$m} km 進む速さのこと。</p>
                        <p>例えば、a = " . $n*$m . " km なら " . $n . " 時間かかる。</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p>距離 \(a\) km を {$m} 時間で走る速さ。</p>
                        ",
                'a_type' => 1,
                'a' => "時速 \(\\frac{a}{\,{$m}\,}\) km",
                'e_type' => 3,
                'e' => "<p>速さ ＝ 距離 ÷ 時間。</p>
                        <p>速さとは、単位時間あたりに進む距離のこと。</p>
                        <p>例えば a = " . $n*$m . " km なら、時速 " . $n . " km。</p>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p>1 個 {$m} 円のりんごを a 個買う時の金額[円]。</p>
                        ",
                'a_type' => 2,
                'a' => "{$m}\,a",
                'e_type' => 1,
                'e' => "1 個あたりの価格を単価という。",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p>a L のジュースを {$n} 人で等分したときの一人分の量[L]。</p>
                        ",
                'a_type' => 2,
                'a' => "\\frac{a}{\,{$n}\,}",
                'e_type' => 1,
                'e' => "a = " . 6*$n . " L なら、" . 6*$n . " ÷ {$n} = 6 L。",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p>一辺の長さが " . $n . "a cm の正方形の面積[cm\(^2\)]。</p>
                        ",
                'a_type' => 2,
                'a' => $n**2 . "a^2",
                'e_type' => 3,
                'e' => "<p>長方形の面積は 縦 × 横 で求まる。</p>
                        <p>正方形は縦と横が等しいので、(" . $n . "a × " . $n . "a) = " . $n**2 . "a\(^2\) cm\(^2\)。</p>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の数量を文字式で表しなさい。</p>
                        <p> a 円の {$n} 割引きの値段。</p>
                        ",
                'a_type' => 2,
                'a' => "0." . (10-$n) . "a \\left(=\\frac{" . (10 - $n) . "}{10} a \\right)",
                'e_type' => 3,
                'e' => "<p>a 円の {$n} 割が 0.{$n}a 円なので、</p>
                        <p>元の値段からこの分を引けばよい。</p>
                        <p>\(a - 0.{$n}a = 0." . (10-$n) . "a\)</p>
                        ",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "文字式で表す";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 文章からの立式
    public function setup_equation() {
        $l1 = 400 + 200 * rand(0, 10);  // 400～2400m
        $l2 = 400 + 200 * rand(0, 10);
        $L = $l1 + $l2;
        $t1 = rand(2, 10);
        $t2 = rand(2, 10);
        $T = $t1 + $t2;
        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>道のりが \(L\) m の 2 地点 A, B 間を、彦星は分速 \(a\) m で A 地点から B 地点に、</p>
                        <p>織姫は分速 \(b\) m で B 地点から A 地点に向かって同時刻に走り始める。</p>
                        <p>そのあと二人が途中で出会ったのは、出発してから \(t\) 分後であった。</p>
                        <p>\(L\) を \(a,b,t\) を使って表しなさい。</p>
                        ",
                'a_type' => 2,
                'a' => "L=a\,t+b\,t",
                'e_type' => 3,
                'e' => "<p>道のり \(L\) を表すので、他の量も m の単位に合わせる。</p>
                        <p>速さ × 時間 が道のりなので、二人が出会う地点を X とすると、</p>
                        <p>A, X 間の道のりは \(a\,t\)、X, B 間の道のりは \(b\,t\) と表せる。</p>
                        <p>よって、これらを合計すれば A, B 間の道のりになるので、\(L=a\,t + b\,t\)。</p>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>昔あるところに彦星と織姫が暮らしていた。</p>
                        <p>ある日、彦星は分速 \(a\) m で駅に向かって歩いていた。</p>
                        <p>彦星がお弁当を忘れたことに気付いた織姫が、</p>
                        <p>彦星が家を出た \({$t1}\) 分後に家を出て、分速 \(b\) m で走って追いかけた。</p>
                        <p>織姫が彦星に追いついたのは、彦星が出発してから \(t\) 分後であった。</p>
                        <p>\(b\) を \(a,t\) を使って表しなさい。</p>
                        ",
                'a_type' => 2,
                'a' => "b=\\frac{at}{\,t-{$t1}\,}",
                'e_type' => 3,
                'e' => "<p>織姫が追いついたとき、二人が歩いた道のりが等しいことに注目する。</p>
                        <p>彦星は分速 \(a\) m で \(t\) 分歩いたので、その道のりは \((a\,t)\) m と表せる。</p>
                        <p>また、織姫は分速 \(b\) m で \((t-{$t1})\) 分走ったので、その道のりは \(b\,(t-{$t1})\) m と表せる。</p>
                        <p>これらの道のりは一致するので、\(a\,t = b\,(t-{$t1})\)。これを \(b\) について解けば、\(\displaystyle b=\\frac{at}{\,t-{$t1}\,}\)。",
            ],
            [
                'q_type' => 3,
                'q' => "<p>彦星の家から駅までは \(L\) m ある。</p>
                        <p>ある日、彦星は分速 \(a\) m で家から駅に向かって歩いていた。</p>
                        <p>家から {$l1} m 進んだところで織姫と会い、そこからは分速 \(b\) m で一緒に駅まで歩いた。</p>
                        <p>彦星が家をでてから駅に着くまでにかかった時間 \(T\) を、\(L,\,a,\,b\) を使って表しなさい。</p>
                        ",
                'a_type' => 2,
                'a' => "T=\\frac{ \,{$l1}\, }{a} + \\frac{ L - \,{$l1}\, }{b}",
                'e_type' => 3,
                'e' => "<p>彦星が一人で歩いた時間と、織姫と二人で歩いた時間にわけて考える。</p>
                        <p>彦星はまず {$l1} m を分速 \(a\) m で 歩いたので、かかった時間は \(\displaystyle \\frac{\,{$l1}\,}{a}\) 分と表せる。</p>
                        <p>また、織姫と会ってからは、残りの道のり \((L - {$l1})\) m を 分速 \(b\) m で歩いたので、</p>
                        <p>かかった時間は \(\displaystyle \\frac{ L - \,{$l1}\, }{b}\) 分と表せる。これらを合計すれば、\(\displaystyle T=\\frac{ \,{$l1}\, }{a} + \\frac{ L - \,{$l1}\, }{b}\)。</p>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "文章からの立式";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // // 比例（グラフ描画）(※)old
    // public function plot_proportional_function() {
    //     $a_sign = (-1)**rand(1,2);
    //     $a_numerator = rand(1, 4);
    //     $a_denominator = rand(1, 4);

    //     // 最大公約数を求める
    //     $gcd = $this->gcd($a_numerator, $a_denominator);

    //     // 約分
    //     $a_numerator /= $gcd;
    //     $a_denominator /= $gcd;

    //     // グラフ描画用
    //     $a = $a_sign * $a_numerator / $a_denominator;
    //     $size = 500;    //viewportの大きさ
    //     $val_size = 10; //実際の座標の大きさ
    //     $scale = $size / $val_size; //縮尺
    //     $p_x = $a_denominator; //代表点Pのx座標
    //     $p_y = $a_sign * $a_numerator; //代表点Pのy座標
    //     $q_x = -$a_denominator; //代表点Q(原点に対してPと対称な点)のx座標
    //     $q_y = $a_sign * -$a_numerator; //代表点Q(原点に対してPと対称な点)のy座標
    //     $plots = [
    //         'w_full' => $size,
    //         'w_half' => $size / 2,
    //         'from_x' => -$size / 2,
    //         'to_x' => $size / 2,
    //         'from_y' => $a * (-$size / 2),
    //         'to_y' => $a * ($size / 2),
    //         'p_x' => $p_x,
    //         'p_y' => $p_y,
    //         'q_x' => $q_x,
    //         'q_y' => $q_y,
    //         'scale' => $scale,        
    //     ];

    //     return view('workbook.unit.plot_proportional_function', compact('a_sign','a_numerator','a_denominator','plots'));
    // }

    // 座標の読み取り
    public function reading_coordinates() {
        $x = (-1)**rand(1,2) * rand(0, 4);
        $y = (-1)**rand(1,2) * rand(0, 4);

        // グラフ描画用
        $size = 300;    //viewportの大きさ
        $val_size = 10; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺

        // プロット用パラメータ
        $w_full = $size;
        $w_half = $size / 2;

        $plot_para = [
            'w_full' => $size,
            'w_half' => $size / 2,
        ];

        $plot_contents = "
            <!-- 座標軸先端の矢印を定義 -->
            <defs>
                <marker id=\"arrow\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"6\" markerHeight=\"6\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"black\"/>
                </marker>
            </defs>
            <!-- x軸とy軸を作成 -->
            <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half*0.95 . "\" y2=\"0\" stroke=\"black\" stroke-width=\"3\" marker-end=\"url(#arrow)\"/>
            <line x1=\"0\" y1=\"" . -$w_half*0.95 . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"3\" marker-start=\"url(#arrow)\"/>
            <circle
                cx=\"" . ( $x * $scale ) . "\"
                cy=\"" . ( -$y * $scale ) . "\"
                r=\"8\"
                fill=\"red\"
            />
        ";
        // 座標軸を追加
        for ($i = -4; $i <= 4; $i++) {
            $plot_contents .= "<line x1=\"" . -$w_half . "\" y1=\"" . $i*$scale . "\" x2 =\"" . $w_half . "\" y2=\"" . $i*$scale . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
            $plot_contents .= "<line x1=\"" . $i*$scale . "\" y1=\"" . -$w_half . "\" x2=\"" . $i*$scale . "\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
        }


        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 5,
                'q' => "<p>赤丸の位置の座標を答えなさい。</p>
                        <p>太線は \(x\) 軸と\(y\) 軸で、一目盛の大きさを 1 とする。</p>",
                'a_type' => 2,
                'a' => "({$x},\,{$y})",
                'e_type' => 3,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class='list-disc'>
                                <li>\(x\) 軸と \(y\) 軸の交点が原点で、その座標は \((0,\,0)\)。</li>
                                <li>\(x\) 軸は数直線と同じで、右が正、左が負。</li>
                                <li>\(y\) 軸も数直線と同じで、上が正、下が負。</li>
                            </ul>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "座標の読み取り";
        return view('workbook.unit_template', compact('unitname','question','plot_para','plot_contents'));
    }

    // 比例（グラフ描画）
    public function plot_proportional_function() {
        $a_numerator = (-1)**rand(1,2) * rand(1, 4);
        $a_denominator = rand(1, 4);

        // 約分しておく
        $sim_frac = $this->simplify_fraction($a_numerator, $a_denominator);
        $a_numerator = $sim_frac['numerator'];
        $a_denominator = $sim_frac['denominator'];

        $a = $a_numerator / $a_denominator;
        $a_str = $this->fracnum_to_str($a_numerator, $a_denominator, "", 1);
        $ax_str = $this->fracnum_to_str($a_numerator, $a_denominator, "x", 1);
        $zougen_str = $a > 0 ? "増える" : "減る";

        // グラフ描画用
        $size = 300;    //viewportの大きさ
        $val_size = 12; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺

        // プロット用パラメータ
        $w_full = $size;
        $w_half = $size / 2;
        $from_x = -$size / 2;
        $to_x = $size / 2;
        $from_y = $a * (-$size / 2);
        $to_y = $a * ($size / 2);
        // 座標の表示場所
        if ($a > 0) {
            if ($a >= 1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($a_numerator - 0.5) * $scale ];
            // 0 < a < 1
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($a_numerator + 0.5) * $scale ];
            }
        // a < 0
        } else {
            if ($a <= -1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($a_numerator - 0.5) * $scale ];
            // -1 < a < 0
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($a_numerator - 1) * $scale ];
            }
        }

        $plot_par_a = [
            'w_full' => $size,
            'w_half' => $size / 2,
        ];

        $plot_con_a = "";
        // 座標軸を作成
        for ($i = -$val_size/2; $i <= $val_size/2; $i++) {
            $plot_con_a .= "<line x1=\"" . -$w_half . "\" y1=\"" . $i*$scale . "\" x2 =\"" . $w_half . "\" y2=\"" . $i*$scale . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
            $plot_con_a .= "<line x1=\"" . $i*$scale . "\" y1=\"" . -$w_half . "\" x2=\"" . $i*$scale . "\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
        }

        $plot_con_a .= "
            <!-- 座標軸先端の矢印を定義 -->
            <defs>
                <marker id=\"arrow\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"6\" markerHeight=\"6\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"black\"/>
                </marker>
                <marker id=\"arrow2\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"4\" markerHeight=\"4\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"blue\"/>
                </marker>
            </defs>
            <!-- x軸とy軸を作成 -->
            <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half*0.95 . "\" y2=\"0\" stroke=\"black\" stroke-width=\"3\" marker-end=\"url(#arrow)\"/>
            <line x1=\"0\" y1=\"" . -$w_half*0.95 . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"3\" marker-start=\"url(#arrow)\"/>
            <!-- 関数 -->
            <line x1=\"" . $from_x . "\" y1=" . -$from_y . " x2=\"" . $to_x . "\" y2=" . -$to_y . " stroke=\"red\" stroke-width=\"2\" />
            <!-- 解説用の点と補助線 -->
            <line x1=\"0\" y1=\"0\" x2=\"" . $a_denominator*$scale*0.95 . "\" y2=\"0\" stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <line x1=\"" . $a_denominator*$scale . "\" y1=\"0\" x2=\"" . $a_denominator*$scale . 
                    "\" y2=" . -$a_numerator*$scale*0.9 . " stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <circle cx=\"" . ( $a_denominator * $scale ) . "\" cy=\"" . ( -$a_numerator * $scale ) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . $posi_text['x'] . "\" y=\"" . $posi_text['y'] . "\" font-weight=\"bold\" font-size=\"22\" fill=\"red\" >
                ({$a_denominator},{$a_numerator})
            </text>
        ";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ(旧)、6:グラフ(新)
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の関数のグラフを描画しなさい。</p>
                         $$ y = {$ax_str} $$",
                'a_type' => 6,
                'a' => "<p>下図の赤線</p>",
                'e_type' => 3,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class='list-disc'>
                                <li>\(x = 0\) のとき \(y = 0\) なので、原点 \((0,\,0)\) を通る。</li>
                                <li>比例定数（\(x\) の係数）が正なら右上がり、負なら右下がり。</li>
                                <li>比例定数（\(x\) の係数）が \(\displaystyle {$a_str}\) なので、
                                    <span class=\"text-blue-600\">\(x\) が \({$a_denominator}\) 増えると \(y\) は \(" . abs($a_numerator) . "\) {$zougen_str}。</span></li>
                                    </ul>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "比例（グラフ描画）";
        return view('workbook.unit_template', compact('unitname','question','plot_par_a','plot_con_a'));
    }

    // 比例（グラフの読み取り）
    public function read_proportional_function() {
        $a_numerator = (-1)**rand(1,2) * rand(1, 4);
        $a_denominator = rand(1, 4);

        // 約分しておく
        $sim_frac = $this->simplify_fraction($a_numerator, $a_denominator);
        $a_numerator = $sim_frac['numerator'];
        $a_denominator = $sim_frac['denominator'];

        $a = $a_numerator / $a_denominator;
        $a_str = $this->fracnum_to_str($a_numerator, $a_denominator, "", 1);
        $ax_str = $this->fracnum_to_str($a_numerator, $a_denominator, "x", 1);
        $zougen_str = $a > 0 ? "増える" : "減る";

        // グラフ描画用
        $size = 300;    //viewportの大きさ
        $val_size = 12; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺

        // プロット用パラメータ
        $w_full = $size;
        $w_half = $size / 2;
        $from_x = -$size / 2;
        $to_x = $size / 2;
        $from_y = $a * (-$size / 2);
        $to_y = $a * ($size / 2);
        // 座標の表示場所
        if ($a > 0) {
            if ($a >= 1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($a_numerator - 0.5) * $scale ];
            // 0 < a < 1
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($a_numerator + 0.5) * $scale ];
            }
        // a < 0
        } else {
            if ($a <= -1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($a_numerator - 0.5) * $scale ];
            // -1 < a < 0
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($a_numerator - 1) * $scale ];
            }
        }

        $plot_par_q = [
            'w_full' => $size,
            'w_half' => $size / 2,
        ];

        $plot_con_q = "";
        // 座標軸を作成
        for ($i = -$val_size/2; $i <= $val_size/2; $i++) {
            $plot_con_q .= "<line x1=\"" . -$w_half . "\" y1=\"" . $i*$scale . "\" x2 =\"" . $w_half . "\" y2=\"" . $i*$scale . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
            $plot_con_q .= "<line x1=\"" . $i*$scale . "\" y1=\"" . -$w_half . "\" x2=\"" . $i*$scale . "\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
        }

        $plot_con_q .= "
            <!-- 座標軸先端の矢印を定義 -->
            <defs>
                <marker id=\"arrow\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"6\" markerHeight=\"6\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"black\"/>
                </marker>
                <marker id=\"arrow2\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"4\" markerHeight=\"4\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"blue\"/>
                </marker>
            </defs>
            <!-- x軸とy軸を作成 -->
            <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half*0.95 . "\" y2=\"0\" stroke=\"black\" stroke-width=\"3\" marker-end=\"url(#arrow)\"/>
            <line x1=\"0\" y1=\"" . -$w_half*0.95 . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"3\" marker-start=\"url(#arrow)\"/>
            <!-- 関数 -->
            <line x1=\"" . $from_x . "\" y1=" . -$from_y . " x2=\"" . $to_x . "\" y2=" . -$to_y . " stroke=\"red\" stroke-width=\"2\" />
        ";
        $plot_par_e = $plot_par_q;
        $plot_con_e = $plot_con_q . "
            <!-- 解説用の点と補助線 -->
            <line x1=\"0\" y1=\"0\" x2=\"" . $a_denominator*$scale*0.95 . "\" y2=\"0\" stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <line x1=\"" . $a_denominator*$scale . "\" y1=\"0\" x2=\"" . $a_denominator*$scale . 
                    "\" y2=" . -$a_numerator*$scale*0.9 . " stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <circle cx=\"" . ( $a_denominator * $scale ) . "\" cy=\"" . ( -$a_numerator * $scale ) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . $posi_text['x'] . "\" y=\"" . $posi_text['y'] . "\" font-weight=\"bold\" font-size=\"22\" fill=\"red\" >
                ({$a_denominator},{$a_numerator})
            </text>
        ";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ(旧)、6:グラフ(新)
        $questions = [
            [
                'q_type' => 6,
                'q' => "次のグラフを関数の式で表しなさい。",
                'a_type' => 2,
                'a' => "y = {$ax_str}",
                'e_type' => 6,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class='list-disc'>
                                <li>原点 \((0,\,0)\) を通る直線なので、比例の式（\(y=ax\)）で表せる。</li>
                                <li><span class=\"text-blue-600\">\(x\) が \({$a_denominator}\) 増えると \(y\) は \(" . abs($a_numerator) . "\) {$zougen_str}ので、</span>
                                    比例定数 \(a\) は \(\displaystyle {$a_str}\)。
                                </li>
                            </ul>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "比例（グラフの読み取り）";
        return view('workbook.unit_template', compact('unitname','question','plot_par_q','plot_con_q','plot_par_e','plot_con_e'));
    }

    // // 比例（グラフ描画）（旧）
    // public function plot_proportional_function() {
    //     $a_sign = (-1)**rand(1,2);
    //     $a_numerator = rand(1, 4);
    //     $a_denominator = rand(1, 4);

    //     // 最大公約数を求める
    //     $gcd = $this->gcd($a_numerator, $a_denominator);

    //     // 約分
    //     $a_numerator /= $gcd;
    //     $a_denominator /= $gcd;

    //     // グラフ描画用
    //     $a = $a_sign * $a_numerator / $a_denominator;
    //     $size = 500;    //viewportの大きさ
    //     $val_size = 10; //実際の座標の大きさ
    //     $scale = $size / $val_size; //縮尺
    //     $p_x = $a_denominator; //代表点Pのx座標
    //     $p_y = $a_sign * $a_numerator; //代表点Pのy座標
    //     $q_x = -$a_denominator; //代表点Q(原点に対してPと対称な点)のx座標
    //     $q_y = $a_sign * -$a_numerator; //代表点Q(原点に対してPと対称な点)のy座標

    //     // プロット用パラメータ
    //     $w_full = $size;
    //     $w_half = $size / 2;
    //     $from_x = -$size / 2;
    //     $to_x = $size / 2;
    //     $from_y = $a * (-$size / 2);
    //     $to_y = $a * ($size / 2);

    //     $plot_para = [
    //         'w_full' => $size,
    //         'w_half' => $size / 2,
    //     ];
    //     $plot_contents = "
    //         <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half . "\" y2=\"0\" stroke=\"black\" />

    //         <line x1=\"0\" y1=\"" . -$w_half . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" />

    //         <line x1=\"" . $from_x . "\" y1=" . -$from_y . "
    //             x2=\"" . $to_x . "\" y2=" . -$to_y . "
    //             stroke=\"red\"
    //             stroke-width=\"2\" />

    //         <circle
    //             cx=\"" . ( $p_x * $scale ) . "\"
    //             cy=\"" . ( -$p_y * $scale ) . "\"
    //             r=\"5\"
    //             fill=\"red\"
    //         />
    //         <text
    //             x=\"" . ( $p_x * $scale + 10 ) . "\"
    //             y=\"" . ( -$p_y * $scale ) . "\"
    //             font-size=\"16\"
    //         >
    //             ({$p_x},{$p_y})
    //         </text>

    //         <circle
    //             cx=\"" . ( $q_x * $scale ) . "\"
    //             cy=\"" . ( -$q_y * $scale ) . "\"
    //             r=\"5\"
    //             fill=\"red\"
    //         />
    //         <text
    //             x=\"" . ( $q_x * $scale + 10 ) . "\"
    //             y=\"" . ( -$q_y * $scale ) . "\"
    //             font-size=\"16\"
    //         >
    //             ({$q_x},{$q_y})
    //         </text>
    //     ";
    //     // 傾きの文字列作成
    //     $a_sign_str = $this->num_to_str($a_sign, 1, 1);
    //     $a_str = $a_sign < 0 ? "-" : "";
    //     if ($a_denominator == 1) {
    //         if ($a_numerator != 1) {
    //            $a_str = $a_str.$a_numerator;
    //         }
    //     } else {
    //         $a_str = $a_str."\\frac{".$a_numerator."}{ \,".$a_denominator."\, }";
    //     }
    //     $a_val_str = abs($a) == 1 ? $a_str."1" : $a_str;

    //     // q：問、a：答、e：解説
    //     // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
    //     $questions = [
    //         [
    //             'q_type' => 3,
    //             'q' => "<p>次の関数のグラフを描画しなさい。</p>
    //                     $$ y = {$a_str}x $$",
    //             'a_type' => 5,
    //             'a' => "a",
    //             'e_type' => 3,
    //             'e' => "<div class=\"pl-5 text-left\">
    //                         <ul class='list-disc'>
    //                             <li>比例のグラフは原点を通る。</li>
    //                             <li>比例定数（傾き）が正なら右上がり、負なら右下がり。</li>
    //                             <li>ここでは比例定数（傾き）が \(\displaystyle {$a_val_str}\) なので、 \(x\) が \({$a_denominator}\) 増えるごとに \(y\) は \({$a_sign_str}{$a_numerator}\) 増える。</li>
    //                         </ul>
    //                     </div>",
    //         ],
    //     ];
    //     $q_index = rand(0,count($questions)-1);
    //     $question = $questions[$q_index];
    //     $unitname = "比例（グラフ描画）";
    //     return view('workbook.unit_template', compact('unitname','question','plot_para','plot_contents'));
    // }
    
    // 平面図形
    public function plane_figure() {
        $questions = [
            [
                'q' => '半径\,r\,の円の円周の長さ\,l',
                'a' => 'l=2\\pi r',
                'e' => '公式として覚える（にぱいあーる）。',
            ],
            [
                'q' => '半径\,r\,の円の面積\,S',
                'a' => 'S=\\pi r^2',
                'e' => '公式として覚える（ぱいあーる にじょう）。',
            ],
            [
                'q' => '半径\,r\,、中心角\,a^{\\circ}\,のおうぎ形の孤の長さ\,l',
                'a' => 'l=2\\pi r \\times \\frac{a}{360}',
                'e' => '[半径\,r\,の円の円周の長さ] \\times [円に対する中心角の比率]。',
            ],
            [
                'q' => '半径\,r\,、中心角\,a^{\\circ}\,のおうぎ形の面積\,S',
                'a' => 'S=\\pi r^2 \\times \\frac{a}{360}',
                'e' => '[半径\,r\,の円の面積] \\times [円に対する中心角の比率]。',
            ],
            [
                'q' => '半径\,r\,、孤の長さ\,l\,のおうぎ形の面積\,S',
                'a' => 'S=\\pi r^2 \\times \\frac{l}{2\\pi r}',
                'e' => '2\\pi r\,は半径\,r\,の円の円周の長さ。',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.plane_figure', compact('question'));
    }

    // 空間図形
    public function spacial_figure() {
        $questions = [
            [
                'q' => '底面積\,S\,、高さ\,h\,の円柱・角柱の体積\,V',
                'a' => 'V=Sh',
                'e' => '公式として覚える。',
            ],
            [
                'q' => '底面積\,S\,、高さ\,h\,の円すい・角すいの体積\,V',
                'a' => 'V=\\frac{1}{\\,3\\,}Sh',
                'e' => '公式として覚える。',
            ],
            [
                'q' => '半径\,r\,の球の体積\,V',
                'a' => 'V=\\frac{4}{\\,3\\,}\\pi r^3',
                'e' => '公式として覚える。',
            ],
            [
                'q' => '半径\,r\,の球の表面積\,S',
                'a' => 'S=4\\pi r^2',
                'e' => '公式として覚える。',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.spacial_figure', compact('question'));
    }

    // 円錐の表面積
    public function corn_surface() {
        $r = rand(1, 6);
        $R = $r * rand(2, 6);   //R:母線（大円の半径）> r:底面の半径
        $a = 360 * $r / $R;   //展開した側面（おうぎ形）の中心角
        $Sf_str = ($r * $R) . "\pi";
        $r2 = $r**2;
        $R2 = $R**2;
        $S_str = (($r*$R) + $r2) . "\pi";
        
        $imageUrl_q = route('secure.file', ['folder' => 'workbook', 'filename' => 'corn_q.png']);
        $imageUrl_e1 = route('secure.file', ['folder' => 'workbook', 'filename' => 'corn_e1.png']);
        $imageUrl_e2 = route('secure.file', ['folder' => 'workbook', 'filename' => 'corn_e2.png']);
        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>\(底面の半径が\,{$r}\,\mathrm{cm}、母線が\,{$R}\,\mathrm{cm}\,の円錐の表面積を求めよ。\)</p>
                        <img src=\"{$imageUrl_q}\" class=\"mx-auto\" >",
                'a_type' => 2,
                'a' => "{$S_str}\,\mathrm{cm}^2",
                'e_type' => 3,
                'e' => "<img src=\"{$imageUrl_e1}\" class=\"mx-auto\" >
                        <img src=\"{$imageUrl_e2}\" class=\"mx-auto\" >
                        <p>円錐を展開すると、底面は半径 \(r\) = {$r} cm の円、側面は半径 \(R\) = {$R} cm の扇形になる。</p>
                        <p>(※)必ず円錐の展開図を描いて考えること。</p>
                        <p>底面の円周は、側面の扇形の孤の部分と重なっていたので、それらの長さは一致する。</p>
                        <p class=\"text-center\">[底面の円周の長さ] = [扇形の孤の長さ]</p>
                        <p>この扇形の孤の長さは、半径 \(R\) の大円の円周 \((=2\pi R)\) に、360\(^{\circ}\) に対する中心角の比率をかけた値になる。</p>
                        <p>そこで、扇形の中心角の大きさを \(a^{\circ}\) とおけば、\(\displaystyle 2\pi r = 2\pi R \\times \\frac{a}{\,360\,}\, \)が成り立つ。</p>
                        <p>両辺を \(2\pi\) で割ると、\(\displaystyle r = R \\times \\frac{a}{\,360\,}\)。これを \(a\) について解くと、</p>
                        <p>\(\displaystyle a = \\frac{r}{\,R\,} \\times 360 = \\frac{{$r}}{\,{$R}\,} \\times 360 = {$a}^{\circ}\). よって、扇形の面積 \(S_f\) は、</p>
                        <p>\(S_f =\) [大円の面積] \(\\times\) [中心角の比率]
                            \(\displaystyle= \pi R^2 \\times \\frac{a}{\,360\,}
                                = {$R2}\pi \\times \\frac{{$a}}{\,360\,} = {$Sf_str}\,\mathrm{cm}^2\)</p>
                        <p>さて、底面の面積を \(S_c\) とすると、\(S_c = \pi r^2 = \pi \\times {$r}^2 = {$r2}\pi\, \mathrm{cm}^2\) である。</p>
                        <p>したがって、円錐の表面積は、\(S_f + S_c = {$Sf_str} + {$r2}\pi = {$S_str}\,\mathrm{cm}^2\)。

                        <p class=\"mt-8 text-center font-bold\"><別解（中心角を求めない解き方）></p>
                        <p>半径（ \(R\) cm とする）が等しい円と扇形を比べると、孤の長さの比と面積比は等しい。</p>
                        <p class=\"text-center\">\(円周の長さ:孤の長さ = 円の面積:扇形の面積\)</p>
                        <p>孤の長さを \(l\) cm、扇形の面積を \(S_f\) cm\(^2\) とすると、\(2\pi R:l = \pi R^2:S_f\)。よって、\(\displaystyle S_f=\\frac{\,Rl\,}{2}\)。</p>
                        <p>また、この扇形の孤の長さ \(l\) は、底面の円周の長さに一致するので、\(l=2\pi r\) と表せる。</p>
                        <p>これを先ほどの式に代入すると、\(\displaystyle S=\\frac{\,Rl\,}{2}=\\frac{\,2\pi rR\,}{2}=\pi rR = \pi \\times {$r} \\times {$R} = {$Sf_str}\, \mathrm{cm}^2\)。</p>
                        <p>さて、底面の面積を \(S_c\) とすると、\(S_c = \pi r^2 = \pi \\times {$r}^2 = {$r2}\pi \, \mathrm{cm}^2\) である。</p>
                        <p>したがって、円錐の表面積は、\(S_f + S_c = {$Sf_str} + {$r2}\pi = {$S_str}\,\mathrm{cm}^2\)。
                        ",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "円錐の表面積";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 座標と三角形の面積
    public function coordinates_triangle() {
        // ３点を定義（P1はy>0, P2はx2=x1でy<0）
        $x1 = (-1)**rand(1,2) * rand(0, 4);
        $y1 = rand(1, 4);
        $x2 = $x1;
        $y2 = -rand(1, 4);
        $x3 = rand(-4, 4);
        while($x3 == $x1) {
            $x3 = rand(-4, 4);
        }
        $y3 = rand(-4, 4);

        // 説明用
        $y2abs = abs($y2);
        $AB = $y1 - $y2;
        $CH = abs($x3 - $x1);
        $S = $this->fracnum_to_str($AB * $CH, 2, "", 1);
        // $S = $this->fracnum_to_str(2, 2, "", 1);

        // グラフ描画用
        $size = 300;    //viewportの大きさ
        $val_size = 10; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺

        // プロット用パラメータ
        $w_full = $size;
        $w_half = $size / 2;

        $plot_par_q = [
            'w_full' => $size,
            'w_half' => $size / 2,
        ];

        $plot_con_q = "
            <!-- 座標軸先端の矢印を定義 -->
            <defs>
                <marker id=\"arrow\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"6\" markerHeight=\"6\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"black\"/>
                </marker>
            </defs>
            <!-- x軸とy軸を作成 -->
            <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half*0.95 . "\" y2=\"0\" stroke=\"black\" stroke-width=\"3\" marker-end=\"url(#arrow)\"/>
            <line x1=\"0\" y1=\"" . -$w_half*0.95 . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"3\" marker-start=\"url(#arrow)\"/>
            <!-- ３点を描画 -->
            <circle cx=\"" . ( $x1 * $scale ) . "\" cy=\"" . ( -$y1 * $scale ) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . ( $x1 * $scale + 10 ) . "\" y=\"" . ( -$y1 * $scale ) . "\" font-size=\"20\">A</text>
            <circle cx=\"" . ( $x2 * $scale ) . "\" cy=\"" . ( -$y2 * $scale ) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . ( $x2 * $scale + 10 ) . "\" y=\"" . ( -$y2 * $scale ) . "\" font-size=\"20\">B</text>
            <circle cx=\"" . ( $x3 * $scale ) . "\" cy=\"" . ( -$y3 * $scale ) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . ( $x3 * $scale + 10 ) . "\" y=\"" . ( -$y3 * $scale ) . "\" font-size=\"20\">C</text>
            ";
        // 座標軸を追加
        for ($i = -4; $i <= 4; $i++) {
            $plot_con_q .= "<line x1=\"" . -$w_half . "\" y1=\"" . $i*$scale . "\" x2 =\"" . $w_half . "\" y2=\"" . $i*$scale . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
            $plot_con_q .= "<line x1=\"" . $i*$scale . "\" y1=\"" . -$w_half . "\" x2=\"" . $i*$scale . "\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
        }

        // 解説用グラフ
        $plot_par_e = $plot_par_q;
        $plot_con_e = $plot_con_q . 
            "<polygon points=\"" . $x1*$scale . " " . -$y1*$scale . ", "
                                . $x2*$scale . " " . -$y2*$scale . ", "
                                . $x3*$scale . " " . -$y3*$scale . "\" fill=\"red\" fill-opacity=\"0.3\" />
            <line x1=\"" . ($x1 * $scale) . "\" y1=\"" . -($y1 * $scale) . "\" x2=\"" . ($x2 * $scale) . "\" y2=\"" . -($y2 * $scale) . "\" stroke=\"red\" stroke-width=\"2\" /> 
            <circle cx=\"" . ( $x3 * $scale ) . "\" cy=\"" . ( -$y3 * $scale ) . "\" r=\"5\" fill=\"blue\" />
            <text x=\"" . ( $x3 * $scale + 10 ) . "\" y=\"" . ( -$y3 * $scale ) . "\" font-size=\"20\">C</text>
            <circle cx=\"" . ( $x1 * $scale ) . "\" cy=\"" . ( -$y3 * $scale ) . "\" r=\"5\" fill=\"blue\" />
            <text x=\"" . ( $x1 * $scale + 10 ) . "\" y=\"" . ( -$y3 * $scale ) . "\" font-size=\"20\">H</text>
            <line x1=\"" . ($x1 * $scale) . "\" y1=\"" . -($y3 * $scale) . "\" x2=\"" . ($x3 * $scale) . "\" y2=\"" . -($y3 * $scale) . "\" stroke=\"blue\" stroke-width=\"2\" />
            ";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:廃止、6:グラフ描画
        $questions = [
            [
                'q_type' => 6,
                'q' => "<p>\(\\triangle \mathrm{ABC}\) の面積を求めなさい。</p>
                        <p>ただし、一目盛の長さを 1 とする。</p>",
                'a_type' => 2,
                'a' => "{$S}",
                'e_type' => 6,
                'e' => "<p>下図のように H を取ると、AB は底辺、CH は高さと考えられる。</p>
                        <p>よって、\(\displaystyle \\triangle \mathrm{ABC}
                                        = \\frac{1}{\,2\,}\mathrm{AB} \\times \mathrm{CH}
                                        = \\frac{1}{\,2\,}\\times {$AB} \\times {$CH}
                                        = {$S}。\)</p>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "座標と三角形の面積";
        return view('workbook.unit_template', compact('unitname','question', 'plot_par_q','plot_con_q', 'plot_par_e','plot_con_e'));
    }

    // 連立方程式
    public function simultaneous_equation() {
        // ax + by = p, cx + dy = q
        $a = rand(1, 5);
        $b = (-1)**rand(1,2)*rand(1, 5);
        $c = (-1)**rand(1,2)*rand(1, 5);
        while ($a == $c) {
        $c = (-1)**rand(1,2)*rand(1, 5);
        }
        $d = (-1)**rand(1,2)*rand(1, 5);
        $x = (-1)**rand(1,2)*rand(1, 9);
        $y = (-1)**rand(1,2)*rand(1, 9);
        $p = $a * $x + $b * $y;
        $q = $c * $x + $d * $y;

        //係数の比を簡単にできたらしておく
        $gcd_abp = $this->gcd($this->gcd($a, $b), $p);
        // dd($gcd_abp);
        $a = $a / $gcd_abp;
        $b = $b / $gcd_abp;
        $p = $p / $gcd_abp;
        $gcd_cdq = $this->gcd($this->gcd($c, $d), $q);
        $c = $c / $gcd_cdq;
        $d = $d / $gcd_cdq;
        $q = $q / $gcd_cdq;

        // 表示する数式用
        $ax_str = $this->num_to_str($a, 1, 1) . "x";
        $by_str = $this->num_to_str($b, 0, 1) . "y";
        $cx_str = $this->num_to_str($c, 1, 1) . "x";
        $dy_str = $this->num_to_str($d, 0, 1) . "y";

        // x,yどちらの項を揃えるか決める
        $lcm_ac = $this->lcm(abs($a), abs($c));
        $lcm_bd = $this->lcm(abs($b), abs($d));
        // a2x + b2y = p2, c2x + d2y = q2
        if($lcm_ac < $lcm_bd) {
            // xの項を揃える
            $target = "x";
            $m1 = $lcm_ac / abs($a); //第一式の倍率
            $m2 = $lcm_ac / abs($c); //第二式の倍率
            $which_pm = $a * $c > 0 ? "m" : "p";    //係数の符号が同じならひき算(minus)、違うならたし算(plus)
            $eq_after_pm = ($which_pm == "m") ? 
                            $this->num_to_str($b*$m1 - $d*$m2, 1, 1)."y":
                            $this->num_to_str($b*$m1 + $d*$m2, 1, 1)."y";
        } else {
            // yの項を揃える
            $target = "y";
            $m1 = $lcm_bd / abs($b); //第一式の倍率
            $m2 = $lcm_bd / abs($d); //第二式の倍率
            $which_pm = $b * $d > 0 ? "m" : "p";    //係数の符号が同じならひき算(minus)、違うならたし算(plus)
            $eq_after_pm = ($which_pm == "m") ? 
                            $this->num_to_str($a*$m1 - $c*$m2, 1, 1)."x":
                            $this->num_to_str($a*$m1 + $c*$m2, 1, 1)."x";
        }
        // 解説用文字列
        $a2_str = $this->num_to_str($a * $m1, 1, 1);
        $b2_str = $this->num_to_str($b * $m1, 0, 1);
        $p2 = $p * $m1;
        
        $c2_str = $this->num_to_str($c * $m2, 1, 1);
        $d2_str = $this->num_to_str($d * $m2, 0, 1);
        $q2 = $q * $m2;

        $eq_after_pm .= ($which_pm == "m") ? "=".($p2 - $q2) : "=".($p2 + $q2);

        $e_str = "";
        if ($m1 > 1 || $m2 > 1) {
            $e_str .= "<p>" .
                ($m1 > 1 ? "<p>一つ目の式を\(\,{$m1}\,\)倍" : "") .
                ($m1 > 1 && $m2 > 1 ? "、" : "") .
                ($m2 > 1 ? "二つ目の式を\(\,{$m2}\,\)倍" : "") .
                "して、\({$target}\,\)の項の係数を揃える。</p>";
        }
        $e_str .= "<p class=\"text-center\">
                \(
                    \,
                    \\left\{
                    \\begin{aligned}
                        {$a2_str}x & {$b2_str}y = {$p2}\\\\
                        {$c2_str}x & {$d2_str}y = {$q2}
                        \\end{aligned}
                    \\right.
                \)</p>
                <p>一つ目の式";
        $e_str .= ($which_pm == "p") ? "に二つ目の式を足して、" : "から二つ目の式を引いて、";
        $e_str .= "\({$eq_after_pm}\)。";
        // 係数が１でなければ続きの文を追加。
        if (!($eq_after_pm[0] == "x" || $eq_after_pm[0] == "y")) {
            $e_str .= "よって、\(" . ($target == "x" ? "y={$y}" : "x={$x}") . "\)。</p>";
        } else {
            $e_str .= "</p>";
        }
        $e_str .= "<p>これをいずれかの式に代入すれば、\(";
        $e_str .= ($target == "x" ? "x={$x}" : "y={$y}") . "\,\)も求まる。</p>";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の連立方程式を解きなさい。</p>
                        \(
                            \,
                            \\left\{
                            \\begin{aligned}
                                {$ax_str} & {$by_str} = {$p} \\\\
                                {$cx_str} & {$dy_str} = {$q}
                                \\end{aligned}
                            \\right.
                        \)
                        ",
                'a_type' => 2,
                'a' => "x={$x},\,y={$y}",
                'e_type' => 3,
                'e' => "{$e_str}",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "連立方程式";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 連立方程式（文章題）
    public function simultaneous_equation2() {
        // a:大人人数、b:子供人数、da:大人割引率（割）、db:子供割引率、x:大人料金、y:子供料金
        $a = rand(1, 5);
        $b = rand(1, 8);
        $da = rand(1, 2);
        $db = rand(2, 5);
        $x = 10 * rand(50, 100);
        $y = 10 * rand(20, 40);
        $x = 50 * rand(10, 20); //500～1000円
        $y = 20 * rand(10, 20); //200～400円

        $da_bar = 10 - $da; //2割引(da=2)なら8割(da_bar=8)
        $db_bar = 10 - $db;

        // ax + by = p, a(1-0.1da)x + b(1-0.1db)y
        $p = $a * $x + $b * $y;
        $dp = $a * (1-0.1*$da) * $x + $b * (1-0.1*$db) * $y;

        // 表示する数式用
        $ax_str = $this->num_to_str($a, 1, 1) . "x";
        $by_str = $this->num_to_str($b, 0, 1) . "y"; 
        $dax_str = $this->num_to_str($a, 1, 1) . "x \\times 0.{$da_bar}";
        $dby_str = "{$this->num_to_str($b, 0, 1)}y \\times 0.{$db_bar}"; 

        $e_str = "<p>大人料金を\(\,x\,\)、子供料金を\(\,y\,\)とすると、昼間の料金について次式が成り立つ。</p>";
        $e_str .= "<p class=\"text-center\">\({$ax_str} {$by_str} = {$p}\)</p>";
        $e_str .= "<p>また、{$da} 割引は元の {$da_bar} 割、{$db} 割引は元の {$db_bar} 割なので、夜間の料金について次式が成り立つ。</p>";
        $e_str .= "<p class=\"text-center\">\({$dax_str} {$dby_str} = {$dp}\)</p>";
        $e_str .= "<p>これらの連立方程式を解くと、\(x={$x}、y={$y}\) が求まる。</p>";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>大人 {$a} 人、子供 {$b} 人で動物園に行く。昼間の入園料は、合計{$p}円である。</p>
                        <p>また、夜間は大人が {$da} 割引、子どもは {$db} 割引になり、同じ人数でも{$dp}円で入れる。</p>
                        <p>大人と子供の入園料をそれぞれ求めなさい。</p>
                        ",
                'a_type' => 3,
                'a' => "<p class=\"text-center\">大人：\({$x}\) 円、子供：\({$y}\) 円   </p>",
                'e_type' => 3,
                'e' => "{$e_str}",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "連立方程式";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 一次関数（グラフ描画）
    public function plot_linear_function() {
        $a_numerator = (-1)**rand(1, 2) * rand(1, 4);
        $a_denominator = rand(1, 3);
        $b = (-1)**rand(1, 2) * rand(1, 3);

        // 約分しておく
        $sim_frac = $this->simplify_fraction($a_numerator, $a_denominator);
        $a_numerator = $sim_frac['numerator'];
        $a_denominator = $sim_frac['denominator'];

        $a = $a_numerator / $a_denominator;
        $a_str = $this->fracnum_to_str($a_numerator, $a_denominator, "", 1);
        $ax_str = $this->fracnum_to_str($a_numerator, $a_denominator, "x", 1);
        $b_str = $b > 0 ? ("+" . $b) : $b;
        $zougen_str = $a > 0 ? "増える" : "減る";

        // グラフ描画用
        $size = 300;    //viewportの大きさ
        $val_size = 16; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺
        $py = $a * $a_denominator + $b;    // プロットする点Pでの y の値

        // プロット用パラメータ
        $w_full = $size;
        $w_half = $size / 2;
        $from_x = -$size / 2;
        $to_x = $size / 2;
        $from_y = $a * (-$size / 2) + $b * $scale;
        // dd($from_y);
        $to_y = $a * ($size / 2) + $b * $scale;
        // $to_y = 0;
        // 座標の表示場所
        if ($a > 0) {
            if ($a >= 1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($py - 0.5) * $scale ];
            // 0 < a < 1
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($py + 0.5) * $scale ];
            }
        // a < 0
        } else {
            if ($a <= -1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($py - 0.5) * $scale ];
            // -1 < a < 0
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($py - 1.5) * $scale ];
            }
        }

        $plot_par_a = [
            'w_full' => $size,
            'w_half' => $size / 2,
        ];

        $plot_con_a = "";
        // 座標軸を作成
        for ($i = -$val_size/2; $i <= $val_size/2; $i++) {
            $plot_con_a .= "<line x1=\"" . -$w_half . "\" y1=\"" . $i*$scale . "\" x2 =\"" . $w_half . "\" y2=\"" . $i*$scale . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
            $plot_con_a .= "<line x1=\"" . $i*$scale . "\" y1=\"" . -$w_half . "\" x2=\"" . $i*$scale . "\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
        }

        $plot_con_a .= "
            <!-- 座標軸先端の矢印を定義 -->
            <defs>
                <marker id=\"arrow\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"6\" markerHeight=\"6\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"black\"/>
                </marker>
                <marker id=\"arrow2\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"4\" markerHeight=\"4\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"blue\"/>
                </marker>
            </defs>
            <!-- x軸とy軸を作成 -->
            <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half*0.95 . "\" y2=\"0\" stroke=\"black\" stroke-width=\"3\" marker-end=\"url(#arrow)\"/>
            <line x1=\"0\" y1=\"" . -$w_half*0.95 . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"3\" marker-start=\"url(#arrow)\"/>
            <!-- 関数 -->
            <line x1=\"" . $from_x . "\" y1=" . -$from_y . " x2=\"" . $to_x . "\" y2=" . -$to_y . " stroke=\"red\" stroke-width=\"2\" />
            <!-- 解説用の点と補助線 -->
            <line x1=\"0\" y1=\"" . -$b*$scale . "\" x2=\"" . $a_denominator*$scale*0.95 . "\" y2=\"" . -$b*$scale . "\" stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <line x1=\"" . $a_denominator*$scale . "\" y1=\"" . -$b*$scale . "\" x2=\"" . $a_denominator*$scale . 
                    "\" y2=" . (-$a_numerator*$scale*0.9 -$b*$scale) . " stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <circle cx=\"" . ( $a_denominator * $scale ) . "\" cy=\"" . ( -$a_numerator * $scale -$b*$scale) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . $posi_text['x'] . "\" y=\"" . $posi_text['y'] . "\" font-weight=\"bold\" font-size=\"22\" fill=\"red\" >
                ({$a_denominator},{$py})
            </text>
        ";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ(旧)、6:グラフ(新)
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の関数のグラフを描画しなさい。</p>
                         $$ y = {$ax_str} {$b_str} $$",
                'a_type' => 6,
                'a' => "<p>下図の赤線</p>",
                'e_type' => 3,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class='list-disc'>
                                <li>切片が \({$b}\) なので、\((0,\,{$b})\) を通る。</li>
                                <li>傾き（\(x\) の係数）が正なら右上がり、負なら右下がり。</li>
                                <li>傾き（\(x\) の係数）が \(\displaystyle {$a_str}\) なので、
                                    <span class=\"text-blue-600\">\(x\) が \({$a_denominator}\) 増えると \(y\) は \(" . abs($a_numerator) . "\) {$zougen_str}。</span></li>
                            </ul>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "一次関数（グラフ描画）";
        return view('workbook.unit_template', compact('unitname','question','plot_par_a','plot_con_a'));
    }

    // 一次関数（グラフ描画）(※)old2
    // public function plot_linear_function() {
    //     $a_sign = (-1)**rand(1,2);
    //     $a_numerator = rand(1, 4);
    //     $a_denominator = rand(1, 4);
    //     $b = (-1)**rand(1,2) * rand(1,4);

    //     // 最大公約数を求める
    //     $gcd = $this->gcd($a_numerator, $a_denominator);

    //     // 約分
    //     $a_numerator /= $gcd;
    //     $a_denominator /= $gcd;

    //     // グラフ描画用
    //     $a = $a_sign * $a_numerator / $a_denominator;
    //     $size = 500;    //viewportの大きさ
    //     $val_size = 10; //実際の座標の大きさ
    //     $scale = $size / $val_size; //縮尺
    //     $x_seppen = -$b/$a; //x切片
    //     $p_x = $a_denominator; //代表点Pのx座標
    //     $p_y = $a * $p_x + $b; //代表点Pのy座標
    //     if(abs($p_y) > ($val_size-1) / 2) {
    //         $p_x = -$p_x;
    //         $p_y = $a * $p_x + $b;
    //     } // p_y がviewportに収まらない場合は、x = -x での代表点に変える。
    //     // プロット用パラメータ
    //     $w_full = $size;
    //     $w_half = $size / 2;
    //     $from_x = -$size / 2;
    //     $to_x = $size / 2;
    //     $from_y = $a * (-$size / 2) + ($b * $scale);
    //     $to_y = $a * ($size / 2) + ($b * $scale);

    //     $plot_para = [
    //         'w_full' => $size,
    //         'w_half' => $size / 2,
    //     ];
    //     $plot_contents = "
    //         <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half . "\" y2=\"0\" stroke=\"black\" />

    //         <line x1=\"0\" y1=\"" . -$w_half . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" />

    //         <line x1=\"" . $from_x . "\" y1=" . -$from_y . "
    //             x2=\"" . $to_x . "\" y2=" . -$to_y . "
    //             stroke=\"red\"
    //             stroke-width=\"2\" />

    //         <circle
    //             cx=\"0\" 
    //             cy=\"" . ( -$b * $scale ) . "\"
    //             r=\"5\"
    //             fill=\"red\"
    //         />
    //         <text
    //             x=\"10\" 
    //             y=\"" . ( -$b * $scale ) . "\"
    //             font-size=\"16\"
    //         >
    //             (0,{$b})
    //         </text>

    //         <circle
    //             cx=\"" . ( $p_x * $scale ) . "\"
    //             cy=\"" . ( -$p_y * $scale ) . "\"
    //             r=\"5\"
    //             fill=\"red\"
    //         />
    //         <text
    //             x=\"" . ( $p_x * $scale + 10 ) . "\"
    //             y=\"" . ( -$p_y * $scale ) . "\"
    //             font-size=\"16\"
    //         >
    //             ({$p_x},{$p_y})
    //         </text>

    //     ";
    //     // 傾きの文字列作成
    //     $a_sign_str = $this->num_to_str($a_sign, 1, 1);
    //     $a_str = $a_sign < 0 ? "-" : "";
    //     if ($a_denominator == 1) {
    //         if ($a_numerator != 1) {
    //            $a_str = $a_str.$a_numerator;
    //         }
    //     } else {
    //         $a_str = $a_str."\\frac{".$a_numerator."}{ \,".$a_denominator."\, }";
    //     }
    //     if ($b >= 0) {
    //         $fx_str = $a_str . "x\,+{$b}";
    //     } else {
    //         $fx_str = $a_str . "x\,{ $b }";
    //     }
    //     $a_val_str = abs($a) == 1 ? $a_str."1" : $a_str;

    //     // q：問、a：答、e：解説
    //     // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
    //     $questions = [
    //         [
    //             'q_type' => 3,
    //             'q' => "<p>次の関数のグラフを描画しなさい。</p>
    //                     $$ y = {$fx_str} $$",
    //             'a_type' => 5,
    //             'a' => "a",
    //             'e_type' => 3,
    //             'e' => "<div class=\"pl-5 text-left\">
    //                         <ul class=\"list-disc\">
    //                             <li>切片が \({ $b }\) なので、\( (0,{ $b }) \) の点を通る。</li>
    //                             <li>\(y=ax+b\) のグラフは、\(y=ax\) のグラフを \(y\) 軸方向に \(b\) だけ平行移動したグラフになる。</li>
    //                             <li>傾きが正なら右上がり、負なら右下がり。</li>
    //                             <li>ここでは傾きが \(\displaystyle {$a_val_str}\) なので、 \(x\) が \({$a_denominator}\) 増えるごとに \(y\) は \({$a_sign_str}{$a_numerator}\) 増える。</li>
    //                         </ul>
    //                     </div>",
    //         ],
    //     ];
    //     $q_index = rand(0,count($questions)-1);
    //     $question = $questions[$q_index];
    //     $unitname = "一次関数（グラフ描画）";
    //     return view('workbook.unit_template', compact('unitname','question','plot_para','plot_contents'));
    // }

    // // 一次関数（グラフ描画）(※)old
    // public function plot_linear_function() {
    //     $a_sign = (-1)**rand(1,2);
    //     $a_numerator = rand(1, 4);
    //     $a_denominator = rand(1, 4);
    //     $b = (-1)**rand(1,2) * rand(1,4);

    //     // 最大公約数を求める
    //     $gcd = $this->gcd($a_numerator, $a_denominator);

    //     // 約分
    //     $a_numerator /= $gcd;
    //     $a_denominator /= $gcd;

    //     // グラフ描画用
    //     $a = $a_sign * $a_numerator / $a_denominator;
    //     $size = 500;    //viewportの大きさ
    //     $val_size = 10; //実際の座標の大きさ
    //     $scale = $size / $val_size; //縮尺
    //     $x_seppen = -$b/$a; //x切片
    //     $p_x = $a_denominator; //代表点Pのx座標
    //     $p_y = $a * $p_x + $b; //代表点Pのy座標
    //     if(abs($p_y) > ($val_size-1) / 2) {
    //         $p_x = -$p_x;
    //         $p_y = $a * $p_x + $b;
    //     } // p_y がviewportに収まらない場合は、x = -x での代表点に変える。
    //     $plots = [
    //         'w_full' => $size,
    //         'w_half' => $size / 2,
    //         'from_x' => -$size / 2,
    //         'to_x' => $size / 2,
    //         'from_y' => $a * (-$size / 2) + ($b * $scale),
    //         'to_y' => $a * ($size / 2) + ($b * $scale),
    //         'p_x' => $p_x,
    //         'p_y' => $p_y,
    //         'scale' => $scale,        
    //     ];

    //     return view('workbook.unit.plot_linear_function', compact('a_sign','a_numerator','a_denominator','a','b','plots'));
    // }

    // 一次関数（グラフ読取）
    public function read_linear_function() {
        $a_numerator = (-1)**rand(1, 2) * rand(1, 4);
        $a_denominator = rand(1, 3);
        $b = (-1)**rand(1, 2) * rand(1, 3);

        // 約分しておく
        $sim_frac = $this->simplify_fraction($a_numerator, $a_denominator);
        $a_numerator = $sim_frac['numerator'];
        $a_denominator = $sim_frac['denominator'];

        $a = $a_numerator / $a_denominator;
        $a_str = $this->fracnum_to_str($a_numerator, $a_denominator, "", 1);
        $ax_str = $this->fracnum_to_str($a_numerator, $a_denominator, "x", 1);
        $b_str = $b > 0 ? ("+" . $b) : $b;
        $zougen_str = $a > 0 ? "増える" : "減る";

        // グラフ描画用
        $size = 300;    //viewportの大きさ
        $val_size = 16; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺
        $py = $a * $a_denominator + $b;    // プロットする点Pでの y の値

        // プロット用パラメータ
        $w_full = $size;
        $w_half = $size / 2;
        $from_x = -$size / 2;
        $to_x = $size / 2;
        $from_y = $a * (-$size / 2) + $b * $scale;
        // dd($from_y);
        $to_y = $a * ($size / 2) + $b * $scale;
        // $to_y = 0;
        // 座標の表示場所
        if ($a > 0) {
            if ($a >= 1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($py - 0.5) * $scale ];
            // 0 < a < 1
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($py + 0.5) * $scale ];
            }
        // a < 0
        } else {
            if ($a <= -1) {
                $posi_text = ['x' => ($a_denominator + 0.5)*$scale, 'y' => -($py - 0.5) * $scale ];
            // -1 < a < 0
            } else {
                $posi_text = ['x' => ($a_denominator - 2)*$scale, 'y' => -($py - 1.5) * $scale ];
            }
        }

        $plot_par_q = [
            'w_full' => $size,
            'w_half' => $size / 2,
        ];

        $plot_con_q = "";
        // 座標軸を作成
        for ($i = -$val_size/2; $i <= $val_size/2; $i++) {
            $plot_con_q .= "<line x1=\"" . -$w_half . "\" y1=\"" . $i*$scale . "\" x2 =\"" . $w_half . "\" y2=\"" . $i*$scale . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
            $plot_con_q .= "<line x1=\"" . $i*$scale . "\" y1=\"" . -$w_half . "\" x2=\"" . $i*$scale . "\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"0.4\"/>";
        }

        $plot_con_q .= "
            <!-- 座標軸先端の矢印を定義 -->
            <defs>
                <marker id=\"arrow\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"6\" markerHeight=\"6\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"black\"/>
                </marker>
                <marker id=\"arrow2\" viewBox=\"0 0 10 10\" refX=\"5\" refY=\"5\"
                    markerWidth=\"4\" markerHeight=\"4\" orient=\"auto-start-reverse\">
                    <path d=\"M0,0 L10,5 L0,10 Z\" fill=\"blue\"/>
                </marker>
            </defs>
            <!-- x軸とy軸を作成 -->
            <line x1=\"" . -$w_half . "\" y1=\"0\" x2 =\"" . $w_half*0.95 . "\" y2=\"0\" stroke=\"black\" stroke-width=\"3\" marker-end=\"url(#arrow)\"/>
            <line x1=\"0\" y1=\"" . -$w_half*0.95 . "\" x2=\"0\" y2=\"" . $w_half . "\" stroke=\"black\" stroke-width=\"3\" marker-start=\"url(#arrow)\"/>
            <!-- 関数 -->
            <line x1=\"" . $from_x . "\" y1=" . -$from_y . " x2=\"" . $to_x . "\" y2=" . -$to_y . " stroke=\"red\" stroke-width=\"2\" />
        ";
        $plot_par_e = $plot_par_q;
        $plot_con_e = $plot_con_q . "
            <!-- 解説用の点と補助線 -->
            <line x1=\"0\" y1=\"" . -$b*$scale . "\" x2=\"" . $a_denominator*$scale*0.95 . "\" y2=\"" . -$b*$scale . "\" stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <line x1=\"" . $a_denominator*$scale . "\" y1=\"" . -$b*$scale . "\" x2=\"" . $a_denominator*$scale . 
                    "\" y2=" . (-$a_numerator*$scale*0.9 -$b*$scale) . " stroke=\"blue\" stroke-width=\"3\" marker-end=\"url(#arrow2)\" />
            <circle cx=\"" . ( $a_denominator * $scale ) . "\" cy=\"" . ( -$a_numerator * $scale -$b*$scale) . "\" r=\"5\" fill=\"red\" />
            <text x=\"" . $posi_text['x'] . "\" y=\"" . $posi_text['y'] . "\" font-weight=\"bold\" font-size=\"22\" fill=\"red\" >
                ({$a_denominator},{$py})
            </text>
        ";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ(旧)、6:グラフ(新)
        $questions = [
            [
                'q_type' => 6,
                'q' => "次のグラフを関数の式で表しなさい。",
                'a_type' => 2,
                'a' => "y = {$ax_str} {$b_str}",
                'e_type' => 6,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class='list-disc'>
                                <li>直線なので、一次関数の式（\(y=ax+b\)）で表せる。</li>
                                <li>\((0,\,{$b})\) を通るので、切片は \(b={$b}\) 。</li>
                                <li><span class=\"text-blue-600\">\(x\) が \({$a_denominator}\) 増えると \(y\) は \(" . abs($a_numerator) . "\) {$zougen_str}ので、</span>
                                    傾き \(a\) は \(\displaystyle {$a_str}\)。
                                </li>
                            </ul>
                        </div>",
            ],
            // [
            //     'q_type' => 6,
            //     'q' => "次のグラフを関数の式で表しなさい。",
            //     'a_type' => 2,
            //     'a' => "y = {$ax_str}",
            //     'e_type' => 6,
            //     'e' => "<div class=\"pl-5 text-left\">
            //                 <ul class='list-disc'>
            //                     <li>原点 \((0,\,0)\) を通る直線なので、比例の式（\(y=ax\)）で表せる。</li>
            //                     <li><span class=\"text-blue-600\">\(x\) が \({$a_denominator}\) 増えると \(y\) は \(" . abs($a_numerator) . "\) {$zougen_str} ので、</span>
            //                         比例定数 \(a\) は \(\displaystyle {$a_str}\) 。
            //                     </li>
            //                 </ul>
            //             </div>",
            // ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "一次関数（グラフ読み取り）";
        return view('workbook.unit_template', compact('unitname','question','plot_par_q','plot_con_q','plot_par_e','plot_con_e'));
    }

    // ２点を通る直線
    public function linear_function3() {
        // y=ax+b
        $a = (-1)**rand(1,2) * rand(1,4);
        $b = (-1)**rand(1,2) * rand(1,4);
        
        // 点P、Qの座標を決める。
        $p_x = (-1)**rand(1,2) * rand(1,4);
        $p_y = $a * $p_x + $b;
        $q_x = (-1)**rand(1,2) * rand(1,4);
        while ($p_x == $q_x) {
            $q_y = (-1)**rand(1,2) * rand(1,4);
        }
        $q_y = $a * $q_x + $b;

        // 文字列変数
        $str_px = $p_x < 0 ? "({$p_x})" : "{$p_x}";
        if ($p_x < $q_x) {
            $str_subx = $p_x < 0 ? "{$q_x} - ({$p_x})" : "{$q_x} - {$p_x}";
            $str_suby = $p_y < 0 ? "{$q_y} - ({$p_y})" : "{$q_y} - {$p_y}";
        } else {
            $str_subx = $q_x < 0 ? "{$p_x} - ({$q_x})" : "{$p_x} - {$q_x}";
            $str_suby = $q_y < 0 ? "{$p_y} - ({$q_y})" : "{$p_y} - {$q_y}";
        }
        $str_equation = $b < 0 ? "y={$this->sign($a)}x {$b}" : "y={$this->sign($a)}x + {$b}";

        // グラフ描画用
        $size = 500;    //viewportの大きさ
        $val_size = max(abs($p_x), abs($p_y), abs($q_x), abs($q_y)) * 4;   //実際の座標の大きさ 
        $scale = $size / $val_size;  // 交点が範囲に収まるようにスケールを決める。
        $plots = [
            'w_full' => $size,
            'w_half' => $size / 2,
            'from_x' => -$size / 2,
            'to_x' => $size / 2,
            'from_y' => $a * (-$size / 2) + ($b * $scale),
            'to_y' => $a * ($size / 2) + ($b * $scale),
            'a' => $a,
            'b' => $b,
            'p_x' => $p_x,
            'p_y' => $p_y,
            'q_x' => $q_x,
            'q_y' => $q_y,
            'scale' => $scale,        
        ];

        $questions = [
            [
                'q' => "\(\,\mathrm{P({$p_x},{$p_y}),Q({$q_x},{$q_y})\,}を通る直線の式を求めなさい。\)",
                'a' => "{$str_equation}",
                'e' => "<div>
                            <p>\(\ 求める直線の式を\,y=ax+b\,とおく。\)</p>
                            <p>\(\displaystyle P,Q\,の座標より、a=\\frac{ \,y\,座標の差\, }{ \,x\,座標の差\, } = \\frac{ \,{$str_suby}\, }{ \,{$str_subx}\, } = {$a}.\)</p>
                            <p>\(よって、y={$this->sign($a)}x+b\,と表せる。ここに\,P\,の座標を代入すると、{$p_y}={$a}\\times{$str_px}+b.\)</p>
                            <p>\(これを\,b\,について解くと、b={$b}。よって、直線の式は、{$str_equation}\,である。\)</p>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "２点を通る直線";
        return view('workbook.unit.linear_function3', compact('unitname','question','plots'));
    }

    // 一次関数（交点の座標）
    public function plot_linear_function2() {
        // y1=ax+b, y2=cx+d, 交点の座標を(p_x, p_y)とする。
        $a = (-1)**rand(1,2) * rand(1,4);
        $b = (-1)**rand(1,2) * rand(1,4);
        $c = (-1)**rand(1,2) * rand(1,4);
        
        // a = c になっていたら c を変更
        while ($a == $c) {
            $c = (-1)**rand(1,2) * rand(1,4);
        }

        // 先に交点のx座標を決める。
        $p_x = (-1)**rand(1,2) * rand(1,4);
        $p_y = $a * $p_x + $b;

        // y2の切片dが決まる。
        $d = ($a - $c) * $p_x + $b;

        // グラフ描画用
        $size = 500;    //viewportの大きさ
        $val_size = max(abs($p_x), abs($p_y)) * 4;   //実際の座標の大きさ 
        $scale = $size / $val_size;  // 交点が範囲に収まるようにスケールを決める。
        $plots = [
            'w_full' => $size,
            'w_half' => $size / 2,
            'from_x' => -$size / 2,
            'to_x' => $size / 2,

            'from_y1' => $a * (-$size / 2) + ($b * $scale),
            'to_y1' => $a * ($size / 2) + ($b * $scale),
            'from_y2' => $c * (-$size / 2) + ($d * $scale),
            'to_y2' => $c * ($size / 2) + ($d * $scale),

            'p_x' => $p_x,
            'p_y' => $p_y,
            'scale' => $scale,        
        ];

        return view('workbook.unit.plot_linear_function2', compact('a','b','c','d','plots'));
    }

    // 正多角形の角
    public function regular_polygon() {
        $ns = [
            5 => "五",
            6 => "六",
            8 => "八",
            9 => "九",
            10 => "十",
            12 => "十二",
        ];
        $n = array_rand($ns);
        $n_str = $ns[$n];
        $n_2 = $n - 2;
        $angle_in_total = 180 * ($n - 2);
        $angle_in = $angle_in_total / $n;  //内角
        $angle_out = 360 / $n;   //外角

        $questions = [
            [
                'q' => "\(正\,{$n_str}\,角形の内角の和は何度か。\)",
                'a' => "{$angle_in_total}^{\circ}",
                'e' => "<div>
                            <p>\(正\,n\,角形は\,(n-2)\,個の三角形に分割できる（四角形や五角形で確かめてみるとよい）。\)</p>
                            <p>\(三角形の内角の和は180^{\circ}なので、それが\,(n-2)\,個ある正\,n\,角形の内角の和は、180(n-2).\)</p>
                            <p>\(\displaystyle よって、正\,{$n_str}\,角形（n={$n}）の内角の和は、180({$n}-2) = {$angle_in_total}^{\circ}.\)</p>
                        </div>",
            ],
            [
                'q' => "\(正\,{$n_str}\,角形の内角ひとつは何度か。\)",
                'a' => "{$angle_in}^{\circ}",
                'e' => "<div>
                            <p>\(正\,n\,角形は\,(n-2)\,個の三角形に分割できる（四角形や五角形で確かめてみるとよい）。\)</p>
                            <p>\(三角形の内角の和は180^{\circ}なので、それが\,(n-2)\,個ある正\,n\,角形の内角の和は、180(n-2).\)</p>
                            <p>\(\displaystyle これより、これを\,n\,等分すれば内角ひとつの角度\,\\frac{ \,180(n-2)\, }{ n }\,が求まる。\)</p>
                            <p>\(\displaystyle よって、正\,{$n_str}\,角形（n={$n}）の内角ひとつの角度は、\\frac{ \,180({$n}-2)\, }{ {$n} } = {$angle_in}^{\circ}.\)</p>
                        </div>",
            ],
            [
                'q' => "\(内角の和が\,{$angle_in_total}^{\circ}\,の正多角形がある。角の数を答えなさい。\)",
                'a' => "{$n}",
                'e' => "<div>
                            <p>\(正\,n\,角形は\,(n-2)\,個の三角形に分割できる（四角形や五角形で確かめてみるとよい）。\)</p>
                            <p>\(三角形の内角の和は180^{\circ}なので、それが\,(n-2)\,個ある正\,n\,角形の内角の和は、180(n-2).\)</p>
                            <p>\(\displaystyle よって、180(n-2) = {$angle_in_total}\,を解いて、n={$n}.\)</p>
                        </div>",
            ],
            [
                'q' => "\(ひとつの外角が\,{$angle_out}^{\circ}\,の正多角形がある。角の数を答えなさい。\)",
                'a' => "{$n}",
                'e' => "<div>
                            <p>\(多角形の外角の和は\,360^{\circ}\,である。\)</p>
                            <p>\(\displaystyle 正\,n\,角形の外角はこれを\,n\,等分した値になるので、\\frac{\,360\,}{n}. \)</p>
                            <p>\(\displaystyle よって、\\frac{\,360\,}{ {$n} } = {$angle_out}\,を解いて、n={$n}.\)</p>
                        </div>",
            ],
            [
                'q' => "\(正{$n_str}角形の外角ひとつの角度を求めなさい。\)",
                'a' => "{$angle_out}^{\circ}",
                'e' => "<div>
                            <p>\(多角形の外角の和は\,360^{\circ}\,である。\)</p>
                            <p>\(\displaystyle 正\,n\,角形の外角はこれを\,n\,等分した値になるので、\\frac{\,360\,}{n}. \)</p>
                            <p>\(\displaystyle よって、正{$n_str}角形（n={$n}）の外角は、\\frac{\,360\,}{ {$n} } = {$angle_out}^{\circ}.\)</p>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "正多角形の角";
        return view('workbook.unit.child', compact('unitname','question'));
    }

    // 合同の証明１
    public function proof_congruence1() {
        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）
        $questions = [
            [
                'q_type' => 2,
                'q' => "正方形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>すべての辺の長さが等しい。</li>
                                <li>すべての内角が\(\,90^{\circ}\)。</li>
                                <li>向かい合う辺が平行。</li>
                            </ul>
                        </div>",
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「正方形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "長方形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>すべての内角が\(\,90^{\circ}\)。</li>
                                <li>向かい合う辺の長さが等しい。</li>
                                <li>向かい合う辺が平行。</li>
                            </ul>
                        </div>",
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「長方形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "平行四辺形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>向かい合う角の大きさが等しい。</li>
                                <li>向かい合う辺の長さが等しい。</li>
                                <li>向かい合う辺が平行。</li>
                            </ul>
                        </div>",
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「平行四辺形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "正三角形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>すべての辺の長さが等しい。</li>
                                <li>すべての内角が\(\,60^{\circ}\)。</li>
                            </ul>
                        </div>
                        ",
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「正三角形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "二等辺三角形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>頂角に接する二つの辺の長さが等しい。</li>
                                <li>２つの底角が等しい。</li>
                            </ul>
                        </div>",
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「二等辺三角形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "平行な２本の直線を、別の１本の直線が横切るとき、わかることをすべて挙げなさい。",
                'a_type' => 3,
                'a' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>等しい錯角が存在する。</li>
                                <li>等しい同位角が存在する。</li>
                                <li>交点では、対頂角が等しい。</li>
                            </ul>
                        </div>",
                'e_type' => 1,
                'e' => "平行線があれば、錯角や同位角がないか確認しよう。",
            ],
            [
                'q_type' => 2,
                'q' => "\\triangle \mathrm{ABC}\,について、\mathrm{AB=AC}\,であるとき、他に成り立つ関係式を挙げなさい。",
                'a_type' => 2,
                'a' => '\mathrm{\\angle ABC = \\angle ACB}',
                'e_type' => 1,
                'e' => "二等辺三角形の底角は等しい。",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "合同の証明";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 角度を求める
    public function find_angle() {
        // 変数
        $ang1 = 10 * rand(2, 14);   // 20～140°
        $ang_rest = 180 - $ang1;    // 他２角の和
        $ang_base = $ang_rest / 2;  // ang1を頂角とする二等辺三角形の底角。
        $ang2 = $ang_base + (-1)**rand(1,2) * rand(10, $ang_base);
        $ang3 = 180 - ($ang1 + $ang2);

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）
        $questions = [
            [
                'q_type' => 2,
                'q' => "\\triangle \mathrm{ABC}\,について、\mathrm{AB=AC\, ,\\angle ABC = {$ang_base}^{\circ}\,であるとき、\\angle BAC を求めよ。}",
                'a_type' => 2,
                'a' => "{$ang1}^{\circ}",
                'e_type' => 3,
                'e' => "<p>\(ノートに\,\mathrm{\\triangle \mathrm{ABC}}\,を描いて考えましょう。\)</p>
                        <p>\(扱いやすくするため、\,\mathrm{\\angle \mathrm{BAC}=\mathnormal{a}^{\circ},
                            \\angle \mathrm{ABC}=\mathnormal{b}^{\circ},\\angle \mathrm{ACB}=\mathnormal{c}^{\circ} }\,とする。\)</p>
                        <p>\(二等辺三角形の底角は等しいので、b = c = {$ang_base}^{\circ}.\)</p> 
                        <p>\(三角形の内角の和は\,180^{\circ}\,なので、\)</p>
                        \\[
                            \\begin{aligned}
                                a + b + c &= 180 \\\\
                                a + {$ang_base} + {$ang_base} &= 180 \\\\
                                a & = 180 - {$ang_rest} \\\\
                                a &= {$ang1}^{\circ}.
                            \\end{aligned}
                        \\]
                        ",
            ],
            [
                'q_type' => 2,
                'q' => "\\triangle \mathrm{ABC}\,について、\mathrm{AB=AC\, ,\\angle BAC = {$ang1}^{\circ}\,であるとき、\\angle ABC を求めよ。}",
                'a_type' => 2,
                'a' => "{$ang_base}^{\circ}",
                'e_type' => 3,
                'e' => "<p>\(ノートに\,\mathrm{\\triangle \mathrm{ABC}}\,を描いて考えましょう。\)</p>
                        <p>\(扱いやすくするため、\,\mathrm{\\angle \mathrm{BAC}=\mathnormal{a}^{\circ},
                            \\angle \mathrm{ABC}=\mathnormal{b}^{\circ},\\angle \mathrm{ACB}=\mathnormal{c}^{\circ} }\,とする。\)</p>
                        <p>\(三角形の内角の和は\,180^{\circ}\,で、a = {$ang1}^{\circ}\,なので、\)</p>
                        \\[
                            \\begin{aligned}
                                a + b + c &= 180 \\\\
                                {$ang1} + b + c &= 180 \\\\
                                b + c &= {$ang_rest}.
                            \\end{aligned}
                        \\]
                        <p>\(二等辺三角形の底角は等しいので、b = c。よって、 b = {$ang_rest} / 2 = {$ang_base}^{\circ}.\)</p> 
                        ",
            ],
            [
                'q_type' => 2,
                'q' => "平行四辺形\,\mathrm{ABCD}\,について、\mathrm{\\angle ABD = {$ang1}^{\circ}\,であるとき、\\angle BDC を求めよ。}",
                'a_type' => 2,
                'a' => "{$ang1}^{\circ}",
                'e_type' => 2,
                'e' => "図を描いて考えましょう。\mathrm{AB /\!/ DC}\,より、錯角は等しいから、\mathrm{\\angle ABD = \\angle BDC}.",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "角度を求める";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 場合の数
    public function num_of_cases() {
        $m = rand(2, 9);
        $n = rand(2, 9);
        $l = rand(4, 9);    // 少し大きめの値
        $k = rand(4, 9);    // 少し大きめの値

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）、5:グラフ描画
        $questions = [
            [
                'q_type' => 1,
                'q' => "種類の違うコインを \(n\) 枚投げるとき、裏表の組み合わせは何通り考えられるか。",
                'a_type' => 1,
                'a' => "\(2^n\) 通り",
                'e_type' => 3,
                'e' => "<p>まず、一枚目のコインの裏表の出方が 2 通りある。</p>
                        <p>それぞれについて、一枚目のコインの裏表の出方が 2 通りある。</p>
                        <p>三枚目以降も同様に考えると、2 × 2 × ...  × 2 = 2\(^n\) と表せる。</p>
                        <p>三枚なら、2\(^3\) = 8 通りである。具体的には次の通り（○:表、×:裏）。</p>
                        <p>(○,○,○),(○,○, ×),(○, × ,○),(○, × , ×),</p>
                        <p>(× ,○,○),(× ,○, ×),(× , × ,○),(× , × , ×) </p>
                        ",
            ],
            [
                'q_type' => 1,
                'q' => "大きさの違うサイコロを \(n\) 個転がすとき、出る目の組み合わせは何通り考えられるか。",
                'a_type' => 1,
                'a' => "\(6^n\) 通り",
                'e_type' => 3,
                'e' => "<p>まず、一つ目のサイコロの目の出方が 6 通りある。</p>
                        <p>それぞれについて、二つ目のサイコロの目の出方が 6 通りある。</p>
                        <p>三つ目以降も同様に考えると、6 × 6 × ...  × 6 = 6\(^n\) と表せる。</p>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>1 から \(n\) までの自然数が 1 つずつ書かれたカード（\(n\) 枚）がある。</p>
                        <p>3 枚続けて引き、引いた順に百の位、十の位、一の位となる</p>
                        <p>3 桁の自然数を作る。ただし、引いたカードはもとに戻さないとする。</p>
                        <p>作られる自然数は何通り考えられるか。</p>",
                'a_type' => 1,
                'a' => "\(n(n-1)(n-2)\) 通り",
                'e_type' => 3,
                'e' => "<p>まず、一枚目（百の位）が \(n\) 通りある。</p>
                        <p>二枚目（十の位）は、残りの \((n-1)\) 枚から選ばれる。</p>
                        <p>三枚目（一の位）は、残りの \((n-2)\) 枚から選ばれる。</p>
                        <p>イメージしにくければ、\(n=3\) のときなどを具体的に考えてみる。</p>
                        <p>このとき、百の位は 3 通り、十の位は 2通り、一の位は 1 通りであるので、</p>
                        <p>3 × 2 × 1 = 6 通りになる（123, 132, 213, 231, 312, 321）。</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>1 から {$l} までの自然数が 1 つずつ書かれたカード（{$l} 枚）がある。</p>
                        <p>2 枚続けて引き、引いた順に十の位、一の位となる</p>
                        <p>2 桁の自然数を作る。ただし、引いたカードはもとに戻さないとする。</p>
                        <p>作られる自然数は何通り考えられるか。</p>",
                'a_type' => 1,
                'a' => $l*($l-1) . " 通り",
                'e_type' => 3,
                'e' => "<p>まず、一枚目（十の位）が {$l} 通りある。</p>
                        <p>二枚目（一の位）は、残りの " . ($l-1) . " 枚から選ばれる。</p>
                        <p>よって、{$l} × " . ($l-1) . " = " . $l*($l-1) ." 通り。</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>1 から {$l} までの自然数が 1 つずつ書かれたカード（{$l} 枚）がある。</p>
                        <p>一枚選んで数を確認し、それを戻してシャッフルしてからもう一度選ぶ。</p>
                        <p>一枚目を十の位、二枚目を一の位とする 2 桁の自然数を作る。</p>
                        <p>作られる自然数は何通り考えられるか。</p>",
                'a_type' => 1,
                'a' => $l**2 . " 通り",
                'e_type' => 3,
                'e' => "<p>カードを戻すので、一枚目（十の位）も二枚目（一の位）も {$l} 通りある。</p>
                        <p>よって、{$l} × {$l} = " . $l**2 ." 通り。</p>
                        ",
            ],
            [
                'q_type' => 1,
                'q' => "{$l} 人の中から、班長と副班長を選ぶ。組み合わせは何通り考えられるか。",
                'a_type' => 1,
                'a' => $l*($l-1) . " 通り",
                'e_type' => 3,
                'e' => "<p>まず班長を決めると、{$l} 人から選ぶので {$l} 通り。</p>
                        <p>副班長は残りのメンバーから選ぶので、" . ($l-1) . " 通り。</p>
                        <p>よって、{$l} × " . ($l-1) . " = " . $l*($l-1) ." 通り。先に副班長を決める場合も同様である。</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>男子 {$k} 人、女子 {$l} 人から、それぞれ一人ずつ代表者を選ぶ。</p>
                        <p>組み合わせは何通り考えられるか。</p>",
                'a_type' => 1,
                'a' => $k*$l . " 通り",
                'e_type' => 1,
                'e' => "男子が {$k} 通り、女子が {$l} 通りなので、{$k} × {$l} = " . $k*$l . " 通り。",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "場合の数";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 式の展開
    public function expansion() {
        $a = (-1)**rand(1, 2) * rand(1, 13);
        $b = (-1)**rand(1, 2) * rand(1, 13);
        while (abs($a) == abs($b)) {
            $b = rand(1, 9);
        }
        $ab_add_str = $this->sign2($a + $b);
        $ab_mul_str = $this->sign_num($a * $b);
        $a_str = $this->sign_num($a);
        $b_str = $this->sign_num($b);

        // (x+a)^2, (x-a)^2, (x+a)(x-a) 用
        $a_abs = abs($a);
        // $anega = -abs($a);
        $a2_str = 2 * $a_abs;
        $apow_str = $a**2;

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の計算をしなさい。</p>
                        <p>\( (x{$a_str})(x{$b_str}) \)",
                'a_type' => 2,
                'a' => "x^2 {$ab_add_str}x {$ab_mul_str}",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)(x+b)=x^2+(a+b)x+ab\,\)</p>
                        <p>\( ここでは、a={$a},\,b={$b}\,なので、 \)</p>
                        \\[
                            \\begin{aligned}
                                (x {$a_str})(x {$b_str}) &= x^2+\{({$a_str})+({$b_str})\}x+\{({$a_str})\\times({$b_str})\} \\\\
                                                &= x^2 {$ab_add_str}x {$ab_mul_str}. \\\\
                            \\end{aligned}
                        \\]
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の計算をしなさい。</p>
                        <p>\( (x+{$a_abs})^2 \)",
                'a_type' => 2,
                'a' => "x^2 + {$a2_str}x + {$apow_str}",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)^2=x^2+2ax+a^2\,\)</p>
                        <p>\( ここでは、a={$a_abs}\,なので、 \)</p>
                        \\[
                            \\begin{aligned}
                                (x + {$a_abs})^2 &= x^2+(2\\times{$a_abs})x+{$a_abs}^2 \\\\
                                                &= x^2 + {$a2_str}x + {$apow_str}. \\\\
                            \\end{aligned}
                        \\]
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の計算をしなさい。</p>
                        <p>\( (x-{$a_abs})^2 \)",
                'a_type' => 2,
                'a' => "x^2 - {$a2_str}x + {$apow_str}",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)^2=x^2-2ax+a^2\,\)</p>
                        <p>\( ここでは、a={$a_abs}\,なので、 \)</p>
                        \\[
                            \\begin{aligned}
                                (x - {$a_abs})^2 &= x^2-(2\\times{$a_abs})x+{$a_abs}^2 \\\\
                                                &= x^2 - {$a2_str}x + {$apow_str}. \\\\
                            \\end{aligned}
                        \\]
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の計算をしなさい。</p>
                        <p>\( (x+{$a_abs})(x-{$a_abs}) \)",
                'a_type' => 2,
                'a' => "x^2 - {$apow_str}",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)(x-a)=x^2-a^2\,\)</p>
                        <p>\( ここでは、a={$a_abs}\,なので、 \)</p>
                        \\[
                            \\begin{aligned}
                                (x + {$a_abs})(x - {$a_abs}) &= x^2-{$a_abs}^2 \\\\
                                                &= x^2 - {$apow_str}. \\\\
                            \\end{aligned}
                        \\]
                        ",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "式の展開";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 因数分解
    public function factorization() {
        $a = (-1)**rand(1, 2) * rand(1, 13);
        $b = (-1)**rand(1, 2) * rand(1, 13);
        while (abs($a) == abs($b)) {
            $b = rand(1, 9);
        }
        $ab_add = $a + $b;
        $ab_mul = $a * $b;
        $ab_add_str = $this->num_to_str($ab_add, 0, 1);
        $ab_mul_str = $this->num_to_str($ab_mul, 0, 0);
        $a_str = $this->num_to_str($a, 0, 0);
        $b_str = $this->num_to_str($b, 0, 0);

        // (x+a)^2, (x-a)^2, (x+a)(x-a) 用
        $a_abs = abs($a);
        $a2_str = 2 * $a_abs;
        $apow_str = $a**2;

        //因数分解用
        $ab_add_str2 = $this->num_to_str($a + $b, 1, 2);

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）
        $questions = [
            [
                'q_type' => 3,
                'q' => "<p>次の式を因数分解しなさい。</p>
                        <p>\( x^2 {$ab_add_str}x {$ab_mul_str} \)",
                'a_type' => 2,
                'a' => "(x{$a_str})(x{$b_str})",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)(x+b)=x^2+(a+b)x+ab\,\)</p>
                        <p>\( ここでは、a+b={$ab_add},\,ab={$ab_mul}\,となる\,a,b\,の組み合わせを考える。 \)</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の式を因数分解しなさい。</p>
                        <p>\( x^2 + {$a2_str}x + {$apow_str} \)",
                'a_type' => 2,
                'a' => "(x+{$a_abs})^2",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)^2=x^2+2ax+a^2\,\)</p>
                        <p>\( ここでは、{$a2_str}=2\\times{$a_abs},\,{$apow_str}={$a_abs}^2\,になっているので、a={$a_abs}。 \)</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の式を因数分解しなさい。</p>
                        <p>\( x^2 - {$a2_str}x + {$apow_str} \)",
                'a_type' => 2,
                'a' => "(x-{$a_abs})^2",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x-a)^2=x^2-2ax+a^2\,\)</p>
                        <p>\( ここでは、{$a2_str}=2\\times{$a_abs},\,{$apow_str}={$a_abs}^2\,になっているので、a={$a_abs}。 \)</p>
                        ",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の式を因数分解しなさい。</p>
                        <p>\( x^2 - {$apow_str} \)",
                'a_type' => 2,
                'a' => "(x+{$a_abs})(x-{$a_abs})",
                'e_type' => 3,
                'e' => "<p>\(展開の公式より、\)</p>
                        <p class='text-center'>\( (x+a)(x-a)=x^2-a^2\,\)</p>
                        <p>\( ここでは、{$apow_str} = {$a_abs}^2\,なので、a={$a_abs}。 \)</p>
                        ",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "因数分解";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 平方根
    public function sqrt_calc() {
        // √a = p√b
        $b_arr = [2, 3, 5, 7, 11];
        $b_idx = array_rand($b_arr);
        $b = $b_arr[$b_idx];

        $p1 = rand(2, 6);
        $a1 = pow($p1, 2) * $b;
        $p2 = rand(2, 6);
        while($p1 == $p2) {
            $p2 = rand(2, 6);
        }
        $a2 = pow($p2, 2) * $b;
        $add_p1p2 = $p1 + $p2;
        // $sub_p1p2 = ($p1 - $p2 == -1 ? "-" : $p1 - $p2);
        $sub_p1p2 = $this->sign($p1 - $p2);

        $questions = [
            [
                'q' => "<div>
                            <p>\(次の計算をしなさい。\)</p>
                            <p>\( \sqrt{{$a1}} + \sqrt{{$a2}} \)</p>
                        </div>",
                'a' => "{$add_p1p2}\sqrt{$b}",
                'e' => "<div>
                            \( \sqrt{{$a1}} + \sqrt{{$a2}} = \sqrt{{$p1}^2 \\times {$b}} + \sqrt{{$p2}^2 \\times {$b}}
                            = {$p1}\sqrt{{$b}} + {$p2}\sqrt{{$b}} = {$add_p1p2}\sqrt{$b} \)
                        </div>",
            ],
            [
                'q' => "<div>
                            <p>\(次の計算をしなさい。\)</p>
                            <p>\( \sqrt{{$a1}} - \sqrt{{$a2}} \)</p>
                        </div>",
                'a' => "{$sub_p1p2}\sqrt{$b}",
                'e' => "<div>
                            \( \sqrt{{$a1}} - \sqrt{{$a2}} = \sqrt{{$p1}^2 \\times {$b}} - \sqrt{{$p2}^2 \\times {$b}}
                            = {$p1}\sqrt{{$b}} - {$p2}\sqrt{{$b}} = {$sub_p1p2}\sqrt{$b} \)
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "平方根の和差";
        return view('workbook.unit.child', compact('unitname','question'));
    }

    // 自然数になるような √(an)
    public function sqrt_natural() {
        $ns = [2, 3, 5, 7, 11, 13];
        $n_index = rand(0, count($ns)-1);
        $n = $ns[$n_index];   //自然数 n
        // √(an) = p√(qn)
        $q = $n;
        $ps = [2, 3, 5];
        $p_index = rand(0, count($ps)-1);
        $p = $ps[$p_index];
        $a = pow($p, 2) * $q;

        $question = [
            'q' => "n\,を自然数とする。\\sqrt{ {{ $a }} n}\,が自然数となるような\,n\,のうち、最小の値を求めなさい。",
            'a' => "{$n}",
            'e' => "\\sqrt{ {$a}n } = {$p}\\sqrt{ {$q}n }\,なので、\\sqrt{ {$q}n }\,が自然数になればよい。",
        ];

        return view('workbook.unit.sqrt_natural', compact('n','p','a','question'));
    }

    /******** 共通関数 **********/
    // 最大公約数
    private function gcd($a, $b)
    {
        while ($b != 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }

        return abs($a);
    }

    // 最小公倍数
    private function lcm($a, $b)
    {
        return abs($a * $b) / $this->gcd($a, $b);
    }

    // 約分
    private function simplify_fraction($numerator, $denominator)
    {
        // 最大公約数を求める
        $gcd = $this->gcd($numerator, $denominator);

        // 約分
        $numerator /= $gcd;
        $denominator /= $gcd;
        return [
            'numerator' => $numerator,
            'denominator' => $denominator,
        ];
    }

    // 数字を文字に変換（分数対応版）
    // $numerator:分子、$denominator:分母
    // $moji:文字列(x,yなど。定数なら"")
    // $first:1=>初項、0=>初項ではない（2項目以降）
    private function fracnum_to_str($numerator, $denominator, $moji, $first)
    {
        $out_str = "";

        // 最大公約数を求める
        $gcd = $this->gcd($numerator, $denominator);

        // 約分
        $numerator /= $gcd;
        $denominator /= $gcd;

        // 値を算出
        $val = $numerator / $denominator;

        // 整数フラグ
        $int_flg = is_int($val) ? 1 : 0;

        // 整数ならそのまま使う（ただし絶対値）
        if ($int_flg == 1) {
            //係数($mojiあり)で絶対値が 1 なら、係数 1 は出力しない。
            if ($moji != "" && abs($val) == 1) {
                $coeff = "";    // 係数
            } else {
                $coeff = abs($val);
            }
        // 非整数ならTeXでの分数表示の形にする。
        } else {
            $coeff = "\\frac{\," . abs($numerator) ."\,}{\," . abs($denominator) . "\,}";
        }

        // 正の数のとき
        if ($val > 0) {
            // 初項でないなら、係数に＋を付ける。
            if ($first != 1) {
                $coeff = "+" . $coeff;
            }
            $out_str = $coeff . $moji;
        // 負の数のとき
        } else {
            // "-"と文字(x,yなど)を付ける
            $out_str = "-" . $coeff . $moji;
            // 初項でないなら（）で囲む
            if ($first != 1) {
                // 非整数（分数）なら大き目の（）で囲む
                if ($int_flg == 0) {
                    $out_str = "\\left(" . $out_str ." \\right)";
                } else {
                    $out_str = "(" . $out_str . ")";
                }
            }
        }
        return $out_str;
    }

    // 数字を文字に変換
    // $n    :変数
    // $first:1=>初項、0=>初項ではない（2項目以降）
    // $coeff:1=>係数、0=>係数ではない（定数）
    private function num_to_str($n, $first, $coeff)
    {
        // 初項、定数
        if ($first == 1 && $coeff == 0) {
            return $n;
        // 初項、係数
        } else if ($first == 1 && $coeff == 1) {
            if ($n == 1) {
                return "";
            } else if ($n == -1) {
                return "-";
            } else {
                return $n;
            }
        // 2項目以降、係数
        } else if ($first == 0 && $coeff == 1) {
            if ($n == 1) {
                return "+";
            } else if ($n == -1) {
                return "-";
            } else if ($n > 0) {
                return "+".$n;
            } else {
                return $n;
            }
        // 2項目以降、定数
        } else {
            if ($n > 0) {
                return "+".$n;
            } else {
                return $n;
            }
        }
    }
    
    // 係数（前に項がないとき）
    private function sign($n)
    {
        if ($n == 1) {
            return "";
        } elseif ($n == -1) {
            return "-";
        } else {
            return $n;
        }
    }

    // 係数２（前に項があるとき）
    private function sign2($n)
    {
        if ($n == 1) {
            return "+";
        } elseif ($n == -1) {
            return "-";
        } elseif ($n > 0) {
            return "+".$n;
        } else {
            return $n;
        }
    }

    // 符号付き数（定数項）
    private function sign_num($n)
    {
        if ($n > 0) {
            return "+".$n;
        } else {
            return $n;
        }
    }

    // 素数の取得(取得数、最大値)
    private function get_primes($count, $max)
    {
        $primes = [
            2, 3, 5, 7, 11, 13, 17, 19,
            23, 29, 31, 37, 41, 43, 47,
            53, 59, 61, 67, 71, 73, 79, 83,
            89, 97
        ];

        $primes = array_filter($primes, fn($n) => $n <= $max);

        $keys = array_rand($primes, $count);

        if ($count == 1) {
            $keys = [$keys];
        }

        return array_values(array_map(fn($key) => $primes[$key], $keys));
    }

    // 英単語_主語（三人称単数）の取得
    // private function get_sub_third_singular()
    // {
    //     // e:英単語、j:和訳
    //     $words = [
    //         ['e' => 'This', 'j' => 'これ'],
    //         ['e' => 'That', 'j' => 'あれ'],
    //         ['e' => 'It', 'j' => 'それ'],
    //     ];
    //     $index = rand(0,count($words)-1);
    //     $word = $words[$index];
    //     return $word;
    // }

    // 英単語_名詞の取得
    private function get_noun()
    {
        // e:英単語、j:和訳、p:複数形、i:不定冠詞
        $words = [
            ['e' => 'pen', 'j' => 'ペン', 'p' => 'pens', 'i' => 'a'],
            ['e' => 'book', 'j' => '本', 'p' => 'books', 'i' => 'a'],
            ['e' => 'car', 'j' => '車', 'p' => 'cars', 'i' => 'a'],
            ['e' => 'house', 'j' => '家', 'p' => 'houses', 'i' => 'a'],
            ['e' => 'apple', 'j' => 'りんご', 'p' => 'apples', 'i' => 'an'],
            ['e' => 'egg', 'j' => '卵', 'p' => 'eggs', 'i' => 'an'],
            ['e' => 'dog', 'j' => '犬', 'p' => 'dogs', 'i' => 'a'],
            ['e' => 'cat', 'j' => '猫', 'p' => 'cats', 'i' => 'a'],
            ['e' => 'tree', 'j' => '木', 'p' => 'trees', 'i' => 'a'],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 英単語_形容詞の取得
    private function get_adjective()
    {
        // e:英単語、j:和訳、c:比較級、l:最大級
        $words = [
            ['e' => 'tall', 'j' => '背が高い', 'jp' => '背が高かった', 'jpq' => '背が高かったですか', 'jpnot' => '背が高くなかった', 'c' => 'taller', 'l' => 'tallest'],
            ['e' => 'kind', 'j' => '親切だ', 'jp' => '親切でした', 'jpq' => '親切でしたか', 'jpnot' => '親切ではなかった', 'c' => 'kinder', 'l' => 'kindest'],
            ['e' => 'shy', 'j' => '内気だ', 'jp' => '内気でした', 'jpq' => '内気でしたか', 'jpnot' => '内気ではなかった', 'c' => 'shier', 'l' => 'shiest'],
            ['e' => 'cool', 'j' => '冷静だ', 'jp' => '冷静でした', 'jpq' => '冷静でしたか', 'jpnot' => '冷静ではなかった', 'c' => 'cooler', 'l' => 'coolest'],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 英単語_副詞の取得
    private function get_adverb()
    {
        // comp:比較級、larg:最大級
        $words = [
            ['e' => 'fast', 'j' => '速く', 'comp' => 'faster', 'larg' => 'fastest'],
            ['e' => 'slowly', 'j' => 'ゆっくり', 'comp' => 'more slowly', 'larg' => 'most slowly'],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 英単語_動詞の取得
    private function get_verb()
    {
        // e:英単語、j:和訳、p:複数形、i:不定冠詞
        $words = [
            ['e' => 'walk', 'eL' => 'Walk', 'es' => 'walks', 'ep' => 'walked', 'epp' => 'walked', 'eing' => 'walking',
                'j' => '歩く', 'jp' => '歩いた', 'jing' => '歩いている', 'jnot' => '歩かない', 'jq' => '歩きますか', 'jpnot' => '歩かなかった', 'jprenyo' => '歩き'],
            ['e' => 'study', 'eL' => 'Study', 'es' => 'studies', 'ep' => 'studied', 'epp' => 'studied', 'eing' => 'studying',
                'j' => '勉強する', 'jp' => '勉強した', 'jing' => '勉強している', 'jnot' => '勉強しない', 'jq' => '勉強しますか', 'jpnot' => '勉強しなかった', 'jprenyo' => '勉強し'],
            ['e' => 'run', 'eL' => 'Run', 'es' => 'runs', 'ep' => 'ran', 'epp' => 'run', 'eing' => 'running',
                'j' => '走る', 'jp' => '走った', 'jing' => '走っている', 'jnot' => '走らない', 'jq' => '走りますか', 'jpnot' => '走らなかった', 'jprenyo' => '走り'],
            ['e' => 'think', 'eL' => 'Think', 'es' => 'thinks', 'ep' => 'thought', 'epp' => 'thought', 'eing' => 'thinking',
                'j' => '考える', 'jp' => '考えた', 'jing' => '考えている', 'jnot' => '考えない', 'jq' => '考えますか', 'jpnot' => '考えなかった', 'jprenyo' => '考え'],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 英文法 be動詞
    public function be_verb() {
        // 主語
        $subjects = [
            ['e' => 'This', 'j' => 'これ', 'el' => 'this'],
            ['e' => 'That', 'j' => 'あれ', 'el' => 'that'],
            ['e' => 'It', 'j' => 'それ', 'el' => 'it'],
        ];
        $idx = rand(0, count($subjects)-1);
        $s = $subjects[$idx];
        $c = $this->get_noun();

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$c['j']}です。",
                'a_type' => 1,
                'a' => "{$s['e']} is {$c['i']} {$c['e']}.",
                'e_type' => 1,
                'e' => '"A is B."の形になる。なお、Bの頭文字が母音(aiueoの音)の場合、不定冠詞は"an"になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} is {$c['i']} {$c['e']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は{$c['j']}です。",
                'e_type' => 1,
                'e' => '"A is B."の形になる。なお、Bの頭文字が母音(aiueoの音)の場合、不定冠詞は"an"になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$c['j']}ではありません。",
                'a_type' => 1,
                'a' => "{$s['e']} isn't {$c['i']} {$c['e']}.",
                'e_type' => 1,
                'e' => '"A isn\'t B."の形になる。なお、Bの頭文字が母音(aiueoの音)の場合、不定冠詞は"an"になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} isn't {$c['i']} {$c['e']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は{$c['j']}ではありません。",
                'e_type' => 1,
                'e' => '"A isn\'t B."の形になる。なお、Bの頭文字が母音(aiueoの音)の場合、不定冠詞は"an"になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$c['j']}ですか。",
                'a_type' => 1,
                'a' => "Is {$s['el']} {$c['i']} {$c['e']}?",
                'e_type' => 1,
                'e' => '"Is A B?"の形になる。なお、Bの頭文字が母音(aiueoの音)の場合、不定冠詞は"an"になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "Is {$s['el']} {$c['i']} {$c['e']}?",
                'a_type' => 1,
                'a' => "{$s['j']}は{$c['j']}ですか。",
                'e_type' => 1,
                'e' => '"Is A B?"の形になる。なお、Bの頭文字が母音(aiueoの音)の場合、不定冠詞は"an"になる。',
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "AはBです。";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 英文法 一般動詞
    public function general_verb() {
        // 主語 'es'=1:三人称単数
        $subjects = [
            ['e' => 'I', 'es' => 0, 'el' => 'I', 'j' => '私', ],
            ['e' => 'We', 'es' => 0, 'el' => 'we', 'j' => '私たち', ],
            ['e' => 'He', 'es' => 1, 'el' => 'he', 'j' => '彼',],
        ];
        $idx = rand(0, count($subjects)-1);
        $s = $subjects[$idx];
        $v = $this->get_verb();
        $vs = $s['es'] == 1 ? $v['es'] : $v['e'];
        $do_does = $s['es'] == 1 ? "does" : "do";
        $Do_Does = $s['es'] == 1 ? "Does" : "Do";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$v['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$vs}.",
                'e_type' => 1,
                'e' => '"S V."の形になる。なお、Sが三人称単数の場合、Vにsが付く。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$v['jnot']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$do_does}n't {$v['e']}.",
                'e_type' => 1,
                'e' => '"S don\'t V."の形になる。なお、Sが三人称単数の場合、"S doesn\'t V."になる"。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$v['jq']}。",
                'a_type' => 1,
                'a' => "{$Do_Does} {$s['el']} {$v['e']}?",
                'e_type' => 1,
                'e' => '"Do S V?"の形になる。なお、Sが三人称単数の場合、"Does S V?"になる"。',
            ],
            // [
            //     'q_type' => 4,
            //     'q1' => "次の文を英訳しなさい。",
            //     'q2' => "{$s['j']}は{$v['jp']}。",
            //     'a_type' => 1,
            //     'a' => "{$s['e']} {$v['ep']}.",
            //     'e_type' => 3,
            //     'e' => '<p>"S V."の形で、Vは過去形になる。</p>
            //             <p>規則動詞はV+edの形になるが、不規則動詞は暗記するしかない。</p>',
            // ],
            // [
            //     'q_type' => 4,
            //     'q1' => "次の文を英訳しなさい。",
            //     'q2' => "{$s['j']}は{$v['jpnot']}。",
            //     'a_type' => 1,
            //     'a' => "{$s['e']} didn't {$v['e']}.",
            //     'e_type' => 1,
            //     'e' => '"S didn\'t V."の形で、Vは原形になる。',
            // ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "一般動詞";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 英文法 疑問詞
    public function interrogative() {
        // 主語 'es'=1:三人称単数
        $interrogatives = [
            ['e' => 'Who', 'j' => '誰が'],
            ['e' => 'What', 'j' => '何を'],
            ['e' => 'Where', 'j' => 'どこで'],
            ['e' => 'When', 'j' => 'いつ'],
            ['e' => 'Why', 'j' => 'なぜ'],
            ['e' => 'How', 'j' => 'どのように'],
        ];
        $idx = rand(0, count($interrogatives)-1);
        $wh = $interrogatives[$idx];

        $q_whos = [
            ['e' => 'reads the book', 'j' => 'その本を読む'],
            ['e' => 'swims', 'j' => '泳ぐ'],
            ['e' => 'studies', 'j' => '勉強する'],
        ];
        $idx = rand(0, count($q_whos)-1);
        $q_who = $q_whos[$idx];

        $q_whats = [
            ['e' => 'What do you read?', 'j' => 'あなたは何を読むのですか。'],
            ['e' => 'What does she like?', 'j' => '彼女は何が好きですか。'],
            ['e' => 'What do you need?', 'j' => 'あなたは何が必要ですか。'],
        ];
        $idx = rand(0, count($q_whats)-1);
        $q_what = $q_whats[$idx];

        $q_elses = [
            ['e' => 'do you read the book', 'j' => 'その本を読む'],
            ['e' => 'does she swim', 'j' => '彼女は泳ぐ'],
            ['e' => 'do you study', 'j' => '勉強する'],
        ];
        $idx = rand(0, count($q_elses)-1);
        $q_else = $q_elses[$idx];

        $q_no = rand(1, 6);    // 5W1Hのどれを使うか。
        if ($q_no == 1) {
            $qj = "誰が{$q_who['j']}のですか。";
            $qe = "Who {$q_who['e']}?";
            $e = '"Who V?"の形になる。Whoは三人称単数扱い。';
        } else if ($q_no == 2) {
            $qj = "{$q_what['j']}";
            $qe = "{$q_what['e']}";
            $e = '"What+疑問文"の形になる。';
        } else if ($q_no == 3) {
            $qj = "いつ{$q_else['j']}のですか。";
            $qe = "When {$q_else['e']}?";
            $e = '"When+疑問文"の形になる。';
        } else if ($q_no == 4) {
            $qj = "どこで{$q_else['j']}のですか。";
            $qe = "Where {$q_else['e']}?";
            $e = '"Where+疑問文"の形になる。';
        } else if ($q_no == 5) {
            $qj = "なぜ{$q_else['j']}のですか。";
            $qe = "Why {$q_else['e']}?";
            $e = '"Why+疑問文"の形になる。';
        } else if ($q_no == 6) {
            $qj = "どのように{$q_else['j']}のですか。";
            $qe = "How {$q_else['e']}?";
            $e = '"How+疑問文"の形になる。';
        }

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$qj}",
                'a_type' => 1,
                'a' => "{$qe}",
                'e_type' => 1,
                'e' => "{$e}",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$qe}",
                'a_type' => 1,
                'a' => "{$qj}",
                'e_type' => 1,
                'e' => "{$e}",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "疑問詞";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 英文法 人称代名詞
    public function personal_pronoun() {
        // 主語 'es'=1:三人称単数
        $subjects = [
            ['e' => 'I', 'es' => 0, 'el' => 'I', 'j' => '私は', ],
            ['e' => 'You', 'es' => 0, 'el' => 'you', 'j' => 'あなたは', ],
            ['e' => 'He', 'es' => 1, 'el' => 'he', 'j' => '彼は',],
            ['e' => 'She', 'es' => 1, 'el' => 'she', 'j' => '彼女は',],
            ['e' => 'Tom', 'es' => 1, 'el' => 'Tom', 'j' => 'トムは',],
            ['e' => 'We', 'es' => 0, 'el' => 'we', 'j' => '私たちは', ],
            ['e' => 'They', 'es' => 0, 'el' => 'we', 'j' => '彼らは', ],
        ];
        $idx1 = rand(0, count($subjects)-1);
        $s = $subjects[$idx1];
        // 動詞
        $verbs = [
            ['e' => 'know', 'es' => 'knows', 'j' => '知っている', ],
            ['e' => 'like', 'es' => 'likes', 'j' => '好いている', ],
            ['e' => 'need', 'es' => 'needs', 'j' => '必要としている', ],
        ];
        $idx2 = rand(0, count($verbs)-1);
        $v = $verbs[$idx2];
        $vs = $s['es'] == 1 ? $v['es'] : $v['e'];
        // 目的語
        $objects = [
            ['e' => 'me', 'j' => '私を', ],
            ['e' => 'you', 'j' => 'あなたを', ],
            ['e' => 'him', 'j' => '彼を', ],
            ['e' => 'her', 'j' => '彼女を', ],
            ['e' => 'Tom', 'j' => 'トムを', ],
            ['e' => 'us', 'j' => '私たちを', ],
            ['e' => 'them', 'j' => '彼らを', ],
        ];
        $idx3 = rand(0, count($objects)-1);
        $o = $objects[$idx3];
        // 所有格
        $possessives = [
            ['e' => 'my', 'j' => '私の', ],
            ['e' => 'your', 'j' => 'あなたの', ],
            ['e' => 'his', 'j' => '彼の', ],
            ['e' => 'her', 'j' => '彼女の', ],
            ['e' => 'Tom\'s', 'j' => 'トムの', ],
            ['e' => 'our', 'j' => '私たちの', ],
            ['e' => 'their', 'j' => '彼らの', ],
        ];
        $idx4 = rand(0, count($possessives)-1);
        $p = $possessives[$idx4];


        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']} {$o['j']} {$v['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$vs} {$o['e']}.",
                'e_type' => 1,
                'e' => '<主語+動詞+目的語>の形の文。人称代名詞は主語か所有格か目的語かで単語が異なる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$vs} {$o['e']}.",
                'a_type' => 1,
                'a' => "{$s['j']} {$o['j']} {$v['j']}。",
                'e_type' => 1,
                'e' => '<主語+動詞+目的語>の形の文。人称代名詞は主語か所有格か目的語かで単語が異なる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$p['j']}番です。",
                'a_type' => 1,
                'a' => "It's {$p['e']} turn.",
                'e_type' => 1,
                'e' => '人称代名詞は主語か所有格か目的語かで単語が異なる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "It's {$p['e']} turn.",
                'a_type' => 1,
                'a' => "{$p['j']}番です。",
                'e_type' => 1,
                'e' => '人称代名詞は主語か所有格か目的語かで単語が異なる。',
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "代名詞";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 英文法 過去形
    public function past_verb() {
        // 主語 'es'=1:三人称単数
        $subjects = [
            ['e' => 'You', 'es' => 0, 'el' => 'you', 'j' => 'あなた', ],
            ['e' => 'She', 'es' => 1, 'el' => 'she', 'j' => '彼女',],
            ['e' => 'Tom', 'es' => 1, 'el' => 'Tom', 'j' => 'トム',],
            ['e' => 'They', 'es' => 0, 'el' => 'they', 'j' => '彼ら',],
        ];
        $idx = rand(0, count($subjects)-1);
        $s = $subjects[$idx];
        $v = $this->get_verb();
        $a = $this->get_adjective();
        $be = $s['es'] == 1 ? "was" : "were";
        $Be = $s['es'] == 1 ? "Was" : "Were";

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$v['jp']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$v['ep']}.",
                'e_type' => 3,
                'e' => '<p>"S V."の形で、Vは過去形になる。</p>
                        <p>規則動詞はV+edの形になるが、不規則動詞は暗記するしかない。</p>',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$v['ep']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は{$v['jp']}。",
                'e_type' => 3,
                'e' => '<p>"S V."の形で、Vは過去形になる。</p>
                        <p>規則動詞はV+edの形になるが、不規則動詞は暗記するしかない。</p>',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$v['jpnot']}。",
                'a_type' => 1,
                'a' => "{$s['e']} didn't {$v['e']}.",
                'e_type' => 1,
                'e' => '"S didn\'t V."の形で、Vは原形になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} didn't {$v['e']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は{$v['jpnot']}。",
                'e_type' => 1,
                'e' => '"S didn\'t V."の形で、Vは原形になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$v['jprenyo']}ましたか。",
                'a_type' => 1,
                'a' => "Did {$s['el']} {$v['e']}?",
                'e_type' => 1,
                'e' => '"Did S V?"の形で、Vは原形になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "Did {$s['el']} {$v['e']}?",
                'a_type' => 1,
                'a' => "{$s['j']}は{$v['jprenyo']}ましたか。",
                'e_type' => 1,
                'e' => '"Did S V?"の形で、Vは原形になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$a['jp']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$be} {$a['e']}.",
                'e_type' => 1,
                'e' => '"A was B."の形になる。Aが二人称や複数名詞のときは、"A were B."になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$be} {$a['e']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は{$a['jp']}。",
                'e_type' => 1,
                'e' => '"A was B."の形になる。Aが二人称や複数名詞のときは、"A were B."になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$a['jpnot']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$be}n't {$a['e']}.",
                'e_type' => 1,
                'e' => '"A wasn\'t B."の形になる。Aが二人称や複数名詞のときは、"A weren\'t B."になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$be}n't {$a['e']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は{$a['jpnot']}。",
                'e_type' => 1,
                'e' => '"A wasn\'t B."の形になる。Aが二人称や複数名詞のときは、"A weren\'t B."になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は{$a['jpq']}。",
                'a_type' => 1,
                'a' => "{$Be} {$s['el']} {$a['e']}?",
                'e_type' => 1,
                'e' => '"Was A B?"の形になる。Aが二人称や複数名詞のときは、"Were A B?"になる。',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$Be} {$s['el']} {$a['e']}?",
                'a_type' => 1,
                'a' => "{$s['j']}は{$a['jpq']}。",
                'e_type' => 1,
                'e' => '"Was A B?"の形になる。Aが二人称や複数名詞のときは、"Were A B?"になる。',
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "過去形";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 英文法 接続詞
    public function conjection() {
        $sentences = [
            ['e' => 'I lived in Nagano when I was a student.', 'j' => '（私が）学生だったとき、私は長野に住んでいた。', ],
            ['e' => 'I saw Tom when I was running.', 'j' => '（私が）走っていたとき、トムに会った。', ],
            ['e' => 'If you like nature, let\'s go hiking.', 'j' => 'もし（あなたが）自然が好きなら、ハイキングに行こう。', ],
            ['e' => 'If it rains tomorrow, we will stay home.', 'j' => 'もし明日雨が降ったら、私たちは家にいるだろう。', ],
            ['e' => 'I think that she is right.', 'j' => '私は、彼女は正しいと思う。', ],
            ['e' => 'He says that English is easy.', 'j' => '彼は、英語は簡単だと言う。', ],
            ['e' => 'I like them because they are kind.', 'j' => '彼らは親切なので、私は彼らが好きです。', ],
            ['e' => 'She went home because she felt sick.', 'j' => '彼女は具合が悪いので家に帰りました。', ],
        ];
        $idx = rand(0, count($sentences)-1);
        $s = $sentences[$idx];

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}",
                'a_type' => 1,
                'a' => "{$s['e']}",
                'e_type' => 3,
                'e' => '<p>\("S_1 V_1～\,\mathrm{when}\,S_2 V_2～."のように、接続詞は２つの文をつなげられる。\)</p>
                        <p>\("\mathrm{When}\,S_2 V_2～, S_1 V_1～."でもよい。\mathrm{if, because}も同様だが、\mathrm{that}は先頭に置かない。\)</p>',
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']}",
                'a_type' => 1,
                'a' => "{$s['j']}",
                'e_type' => 3,
                'e' => '<p>\("S_1 V_1～\,\mathrm{when}\,S_2 V_2～."のように、接続詞は２つの文をつなげられる。\)</p>
                        <p>\("\mathrm{When}\,S_2 V_2～, S_1 V_1～."でもよい。\mathrm{if, because}も同様だが、\mathrm{that}は先頭に置かない。\)</p>',
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "接続詞";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 英文法 比較級
    public function comparative() {
        // 主語 'es'=1:三人称単数
        $subjects = [
            ['e' => 'You', 'es' => 0, 'el' => 'you', 'j' => 'あなた', 'be' => 'are',],
            ['e' => 'She', 'es' => 1, 'el' => 'she', 'j' => '彼女', 'be' => 'is',],
            ['e' => 'Tom', 'es' => 1, 'el' => 'Tom', 'j' => 'トム', 'be' => 'is',],
            ['e' => 'They', 'es' => 0, 'el' => 'they', 'j' => '彼ら', 'be' => 'are',],
        ];
        $idx = rand(0, count($subjects)-1);
        $s = $subjects[$idx];
        // 動詞
        $verbs = [
            ['e' => 'run', 'es' => 'runs', 'j' => '走る', ],
            ['e' => 'walk', 'es' => 'walks', 'j' => '歩く', ],
            ['e' => 'swim', 'es' => 'swims', 'j' => '泳ぐ', ],
        ];
        $idx = rand(0, count($verbs)-1);
        $v = $verbs[$idx];
        $vs = $s['es'] == 1 ? $v['es'] : $v['e'];
        // 修飾語
        // $modifiers = [
        //     ['e' => 'in this class', 'j' => 'このクラスで', ],
        //     ['e' => 'in this country', 'j' => 'この国で', ],
        //     ['e' => 'in my family', 'j' => '私の家族の中で', ],
        // ];
        // $idx = rand(0, count($modifiers)-1);
        // $m = $modifiers[$idx];
        
        // $v = $this->get_verb();     // 動詞の取得
        $kei = $this->get_adjective();   // 形容詞を取得
        $fuku = $this->get_adverb();   // 副詞を取得

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は最も{$kei['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$s['be']} the {$kei['l']}.",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$s['be']} <span class=\"underline\">{$kei['e']}</span>.\"
                            （{$s['j']}は{$kei['j']}。）の下線部（形容詞）を最大級にした表現。</p>
                        <p>最大級の形が\"the ○○est\"か\"the most ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$s['be']} the {$kei['l']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は最も{$kei['j']}。",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$s['be']} <span class=\"underline\">{$kei['e']}</span>.\"
                            （{$s['j']}は{$kei['j']}。）の下線部（形容詞）を最大級にした表現。</p>
                        <p>最大級の形が\"the ○○est\"か\"the most ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}はさらに{$kei['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$s['be']} {$kei['c']}.",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$s['be']} <span class=\"underline\">{$kei['e']}</span>.\"
                            （{$s['j']}は{$kei['j']}。）の下線部（形容詞）を比較級にした表現。</p>
                        <p>最大級の形が\"○○er\"か\"more ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$s['be']} {$kei['c']}.",
                'a_type' => 1,
                'a' => "{$s['j']}はさらに{$kei['j']}。",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$s['be']} <span class=\"underline\">{$kei['e']}</span>.\"
                            （{$s['j']}は{$kei['j']}。）の下線部（形容詞）を比較級にした表現。</p>
                        <p>最大級の形が\"○○er\"か\"more ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}はメアリーと同じくらい{$kei['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$s['be']} as {$kei['e']} as Mary.",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$s['be']} <span class=\"underline\">{$kei['e']}</span>.\"
                            （{$s['j']}は{$kei['j']}。）の下線部（形容詞）を同格にした表現。</p>
                        <p>\"as {$kei['e']}\" が「同じくらい{$kei['j']}」、\"as Mary\"が「メアリー（がそうであるの）と」を意味する。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$s['be']} as {$kei['e']} as Mary.",
                'a_type' => 1,
                'a' => "{$s['j']}はメアリーと同じくらい{$kei['j']}。",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$s['be']} <span class=\"underline\">{$kei['e']}</span>.\"
                            （{$s['j']}は{$kei['j']}。）の下線部（形容詞）を同格にした表現。</p>
                        <p>\"as {$kei['e']}\" が「同じくらい{$kei['j']}」、\"as Mary\"が「メアリー（がそうであるの）と」を意味する。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}は最も{$fuku['j']}{$v['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$vs} the {$fuku['larg']}.",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$vs} <span class=\"underline\">{$fuku['e']}</span>.\"
                            （{$s['j']}は{$fuku['j']}{$v['j']}。）の下線部（副詞）を最大級にした表現。</p>
                        <p>最大級の形が\"the ○○est\"か\"the most ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$vs} the {$fuku['larg']}.",
                'a_type' => 1,
                'a' => "{$s['j']}は最も{$fuku['j']}{$v['j']}。",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$vs} <span class=\"underline\">{$fuku['e']}</span>.\"
                            （{$s['j']}は{$fuku['j']}{$v['j']}。）の下線部（副詞）を最大級にした表現。</p>
                        <p>最大級の形が\"the ○○est\"か\"the most ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}はさらに{$fuku['j']}{$v['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$vs} {$fuku['comp']}.",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$vs} <span class=\"underline\">{$fuku['e']}</span>.\"
                            （{$s['j']}は{$fuku['j']}{$v['j']}。）の下線部（副詞）を比較級にした表現。</p>
                        <p>最大級の形が\"○○er\"か\"more ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$vs} {$fuku['comp']}.",
                'a_type' => 1,
                'a' => "{$s['j']}はさらに{$fuku['j']}{$v['j']}。",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$vs} <span class=\"underline\">{$fuku['e']}</span>.\"
                            （{$s['j']}は{$fuku['j']}{$v['j']}。）の下線部（副詞）を比較級にした表現。</p>
                        <p>最大級の形が\"○○er\"か\"more ○○\"かは単語による。辞書で確認すること。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を英訳しなさい。",
                'q2' => "{$s['j']}はメアリーと同じくらい{$fuku['j']}{$v['j']}。",
                'a_type' => 1,
                'a' => "{$s['e']} {$vs} as {$fuku['e']} as Mary.",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$vs} <span class=\"underline\">{$fuku['e']}</span>.\"
                            （{$s['j']}は{$fuku['j']}{$v['j']}。）の下線部（副詞）を同格にした表現。</p>
                        <p>\"as {$fuku['e']}\" が「同じくらい{$fuku['j']}」、\"as Mary\"が「メアリー（がそうであるの）と」を意味する。</p>",
            ],
            [
                'q_type' => 4,
                'q1' => "次の文を和訳しなさい。",
                'q2' => "{$s['e']} {$vs} as {$fuku['e']} as Mary.",
                'a_type' => 1,
                'a' => "{$s['j']}はメアリーと同じくらい{$fuku['j']}{$v['j']}。",
                'e_type' => 3,
                'e' => "<p>\"{$s['e']} {$vs} <span class=\"underline\">{$fuku['e']}</span>.\"
                            （{$s['j']}は{$fuku['j']}{$v['j']}。）の下線部（副詞）を同格にした表現。</p>
                        <p>\"as {$fuku['e']}\" が「同じくらい{$fuku['j']}」、\"as Mary\"が「メアリー（がそうであるの）と」を意味する。</p>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "比較級";
        return view('workbook.unit_template', compact('unitname','question'));
    }


    // 英単語　動詞１
    public function e_word_verb1() {
        $questions = [
            ['q' => '買う', 'a' => 'buy'],
            ['q' => '持ってくる', 'a' => 'bring'],
            ['q' => '建てる', 'a' => 'build'],
            ['q' => '捕まえる', 'a' => 'catch'],
            ['q' => '掃除する', 'a' => 'clean'],
            ['q' => '料理する', 'a' => 'cook'],
            ['q' => '描く', 'a' => 'draw/paint'],
            ['q' => '飲む', 'a' => 'drink'],
            ['q' => '楽しむ', 'a' => 'enjoy'],
            ['q' => '飛ぶ', 'a' => 'fly'],
            ['q' => '助ける', 'a' => 'help'],
            ['q' => '知っている', 'a' => 'know'],
            ['q' => '去る、置いていく', 'a' => 'leave'],
            ['q' => '意味する', 'a' => 'mean'],
            ['q' => '必要とする', 'a' => 'need'],
            ['q' => '開ける', 'a' => 'open'],
            ['q' => '拾う', 'a' => 'pick'],
            ['q' => '乗る', 'a' => 'ride'],
            ['q' => '立つ', 'a' => 'stand'],
            ['q' => '考える、思う', 'a' => 'think'],
            ['q' => '訪れる', 'a' => 'visit'],
            ['q' => '着ている', 'a' => 'wear'],
            ['q' => '(文字や手紙を)書く', 'a' => 'write'],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.e_word_verb1', compact('question'));
    }

    // be動詞（主語と動詞）
    public function be_verb1() {
        $questions = [
            [
                'q' => '私は強い。 ⇒ (　　) (　　) strong.',
                'a' => '( I ) ( am ) strong.',
            ],
            [
                'q' => 'あなたは強い。 ⇒ (　　) (　　) strong.',
                'a' => '( You ) ( are ) strong.',
            ],
            [
                'q' => '彼は強い。 ⇒ (　　) (　　) strong.',
                'a' => '( He ) ( is ) strong.',
            ],
            [
                'q' => '彼女は強い。 ⇒ (　　) (　　) strong.',
                'a' => '( She ) ( is ) strong.',
            ],
            [
                'q' => '私たちは強い。 ⇒ (　　) (　　) strong.',
                'a' => '( We ) ( are ) strong.',
            ],
            [
                'q' => 'あなたたちは強い。 ⇒ (　　) (　　) strong.',
                'a' => '( You ) ( are ) strong.',
            ],
            [
                'q' => '彼らは強い。 ⇒ (　　) (　　) strong.',
                'a' => '( They ) ( are ) strong.',
            ],
            [
                'q' => 'タケシは強い。 ⇒ (　　) (　　) strong.',
                'a' => '( Takeshi ) ( is ) strong.',
            ],
            [
                'q' => '太郎と花子は強い。 ⇒ (　　) (　　) (　　) (　　) strong.',
                'a' => '( Taro ) ( and ) ( Hanako ) ( are ) strong.',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.be_verb1', compact('question'));
    }

    // be動詞（過去形）
    public function be_verb2() {
        $questions = [
            [
                'q' => '私は強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( I ) ( was ) strong.',
            ],
            [
                'q' => 'あなたは強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( You ) ( were ) strong.',
            ],
            [
                'q' => '彼は強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( He ) ( was ) strong.',
            ],
            [
                'q' => '彼女は強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( She ) ( was ) strong.',
            ],
            [
                'q' => '私たちは強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( We ) ( were ) strong.',
            ],
            [
                'q' => 'あなたたちは強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( You ) ( were ) strong.',
            ],
            [
                'q' => '彼らは強かった。 ⇒ (　　) (　　) strong.',
                'a' => '( They ) ( were ) strong.',
            ],
            [
                'q' => '太郎と花子は強かった。 ⇒ (　　) (　　) (　　) (　　) strong.',
                'a' => '( Taro ) ( and ) ( Hanako ) ( were ) strong.',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.be_verb2', compact('question'));
    }

    // be動詞（疑問文・否定文）
    public function be_verb3() {
        $questions = [
            [
                'q' => '私は強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( I ) ( am ) ( not ) strong.',
            ],
            [
                'q' => 'あなたは強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( You ) ( are ) ( not ) strong.',
            ],
            [
                'q' => '彼は強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( He ) ( is ) ( not ) strong.',
            ],
            [
                'q' => '彼女は強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( She ) ( is ) ( not ) strong.',
            ],
            [
                'q' => '私たちは強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( We ) ( are ) ( not ) strong.',
            ],
            [
                'q' => 'あなたたちは強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( You ) ( are ) ( not ) strong.',
            ],
            [
                'q' => '彼らは強くない。 ⇒ (　　) (　　) (　　) strong.',
                'a' => '( They ) ( are ) ( not ) strong.',
            ],

            [
                'q' => '私は強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Am ) ( I ) strong?',
            ],
            [
                'q' => 'あなたは強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Are ) ( you ) strong?',
            ],
            [
                'q' => '彼は強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Is ) ( he ) strong?',
            ],
            [
                'q' => '彼女は強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Is ) ( she ) strong?',
            ],
            [
                'q' => '私たちは強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Are ) ( we ) strong?',
            ],
            [
                'q' => 'あなたたちは強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Are ) ( you ) strong?',
            ],
            [
                'q' => '彼らは強いですか。 ⇒ (　　) (　　) strong?',
                'a' => '( Are ) ( they ) strong?',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.be_verb3', compact('question'));
    }

    // 一般動詞（肯定文・否定文・疑問文）
    public function general_verb1() {
        $questions = [
            [
                'q' => '私はテニスをします。 ⇒ I (　　) tennis.',
                'a' => 'I ( play ) tennis.',
            ],
            [
                'q' => '私はテニスをしません。 ⇒ I (　　) (　　) tennis.',
                'a' => 'I ( don\'t ) ( play ) tennis.',
            ],
            [
                'q' => 'あなたはテニスをしますか。 ⇒ (　　) (　　) (　　) tennis?',
                'a' => '( Do ) ( you ) ( play ) tennis?',
            ],
            [
                'q' => '私たちは京都を知っている。 ⇒ We (　　) Kyoto.',
                'a' => 'We ( know ) Kyoto.',
            ],
            [
                'q' => '私たちは京都を知りません。 ⇒ We (　　) (　　) Kyoto.',
                'a' => 'We ( don\'t ) ( know ) Kyoto.',
            ],
            [
                'q' => 'あなたたちは京都を知っていますか。 ⇒ (　　) (　　) (　　) Kyoto?',
                'a' => '( Do ) ( you ) ( know ) Kyoto?',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.general_verb1', compact('question'));
    }

    // 一般動詞（三単現）
    public function general_verb2() {
        $questions = [
            [
                'q' => '彼女はテニスをします。 ⇒ She (　　) tennis.',
                'a' => 'She ( plays ) tennis.',
            ],
            [
                'q' => '彼女はテニスをしません。 ⇒ She (　　) (　　) tennis.',
                'a' => 'She ( doesn\'t ) ( play ) tennis.',
            ],
            [
                'q' => '彼女はテニスをしますか。 ⇒ (　　) (　　) (　　) tennis?',
                'a' => '( Does ) ( she ) ( play ) tennis?',
            ],
            [
                'q' => 'トムは大阪が好きです。 ⇒ Tom (　　) Osaka.',
                'a' => 'Tom ( likes ) Osaka.',
            ],
            [
                'q' => 'トムは大阪に住んでいません。 ⇒ Tom (　　) (　　) in Osaka.',
                'a' => 'Tom ( doesn\'t ) ( live ) in Osaka.',
            ],
            [
                'q' => 'トムは大阪を訪れるでしょうか。 ⇒ (　　) (　　) (　　) Osaka?',
                'a' => '( Does ) ( Tom ) ( visit ) Osaka?',
            ],
            [
                'q' => 'それは10分かかります。 ⇒ It (　　) ten minutes.',
                'a' => 'It ( takes ) ten minutes.',
            ],
            [
                'q' => 'それは10分かかりません。 ⇒ It (　　) (　　) ten minutes.',
                'a' => 'It ( doesn\'t ) ( take ) ten minutes.',
            ],
            [
                'q' => 'それは10分かかりますか。 ⇒ (　　) (　　) (　　) ten minutes?',
                'a' => '( Does ) ( it ) ( take ) ten minutes?',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.general_verb2', compact('question'));
    }

    // 一般動詞（過去形）
    public function general_verb3() {
        $questions = [
            [
                'q' => '彼女は公園まで歩いた。 ⇒ She (　　) to the park.',
                'a' => 'She ( walked ) to the park.',
            ],
            [
                'q' => '彼は英語を勉強した。 ⇒ He (　　) English.',
                'a' => 'He ( studied ) English.',
            ],
            [
                'q' => '私は音楽を聴いた。 ⇒ I (　　) to the music.',
                'a' => 'I ( listened ) to the music.',
            ],
            [
                'q' => '私は父に感謝した。 ⇒ I (　　) my father.',
                'a' => 'I ( thanked ) my father.',
            ],
            [
                'q' => 'あなたは昨日ピアノを弾きましたか。 ⇒ (　　) (　　) (　　) the piano yesterday?.',
                'a' => '( Did ) ( you ) ( play ) the piano yesterday?',
            ],
            [
                'q' => '彼は先週あなたの家に来ましたか。 ⇒ (　　) (　　) (　　) to your house last week?',
                'a' => '( Did ) ( he ) ( come ) to your house last week?',
            ],
            [
                'q' => '彼らは2年前、東京に住んでいましたか。 ⇒ (　　) (　　) (　　) in Tokyo two years ago?',
                'a' => '( Did ) ( they ) ( live ) in Tokyo two years ago?',
            ],
            [
                'q' => 'その車はここに止まらなかった。 ⇒ The car (　　) (　　) here.',
                'a' => 'The car ( didn\'t ) ( stop ) here',
            ],
            [
                'q' => '私たちはこの話を知らなかった。 ⇒ We (　　) (　　) this story.',
                'a' => 'We ( didn\'t ) ( know ) this story.',
            ],
            [
                'q' => '彼らは車を持っていなかった。 ⇒ They (　　) (　　) a car.',
                'a' => 'They ( didn\'t ) ( have ) a car.',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.general_verb3', compact('question'));
    }

    // 一般動詞（不規則動詞）
    public function general_verb4() {
        $questions = [
            [
                'q' => '彼女は手紙を書いた。 ⇒ She (　　) a letter.',
                'a' => 'She ( wrote ) a letter.',
            ],
            [
                'q' => '彼は一杯の紅茶を飲んだ。 ⇒ He (　　) a cup of tea.',
                'a' => 'He ( drank/had ) a cup of tea.',
            ],
            [
                'q' => '私たちは学校まで走った。 ⇒ We (　　) to our school.',
                'a' => 'We ( ran ) to our school.',
            ],
            [
                'q' => 'それは2時間かかった。 ⇒ It (　　) two hours.',
                'a' => 'It ( took ) two hours.',
            ],
            [
                'q' => 'その試合は10時に始まった。 ⇒ The game (　　) at ten.',
                'a' => 'The game ( began/started ) at ten.',
            ],
            [
                'q' => '私はノートを買った。 ⇒ I (　　) a notebook.',
                'a' => 'I ( bought ) a notebook.',
            ],
            [
                'q' => '彼らは私たちを知っていた。 ⇒ They (　　) us.',
                'a' => 'They ( knew ) us.',
            ],
            [
                'q' => '私は君のお母さんに会った。 ⇒  I (　　) your mother.',
                'a' => 'They ( saw/met ) your mother.',
            ],
            [
                'q' => '彼は一冊の本を持ってきた。 ⇒ He (　　) a book.',
                'a' => 'He ( brought ) a book.',
            ],
            [
                'q' => '姉は鎌倉まで運転した。 ⇒ My sister (　　) to Kamakura .',
                'a' => 'My sister ( drove ) to Kamakura.',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.general_verb4', compact('question'));
    }



    // 前置詞
    public function preposition() {
        $questions = [
            [
                'q' => '机の上にノートがある。 ⇒ There is a notebook (　　) the desk.',
                'a' => 'There is a notebook ( on ) the desk.',
            ],
            [
                'q' => '机の下に猫がいる。 ⇒ There is a cat (　　) the desk.',
                'a' => 'There is a cat ( under ) the desk.',
            ],
            [
                'q' => '机のそばに猫がいる。 ⇒ There is a cat (　　) the desk.',
                'a' => 'There is a cat ( by/near ) the desk.',
            ],
            [
                'q' => '箱の中に猫がいる。 ⇒ There is a cat (　　) the box.',
                'a' => 'There is a cat ( in ) the box.',
            ],
            [
                'q' => '少女が猫と遊んでいる。 ⇒ A girl is playing (　　) a cat.',
                'a' => 'A girl is playing ( with ) a cat.',
            ],
            [
                'q' => '猫が机の周りを走っている。 ⇒ A cat is running (　　) the desk.',
                'a' => 'A cat is running ( around ) the desk.',
            ],
            [
                'q' => '私たちは愛媛から来ました。 ⇒ We came (　　) Ehime.',
                'a' => 'We came ( from ) Ehime.',
            ],
            [
                'q' => '公園に行こう。 ⇒ Let\'s go (　　) the park.',
                'a' => 'Let\'s go ( to ) the park.',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.preposition', compact('question'));
    }

    /********** 英語まとめ **************/
    // be動詞と一般動詞
    public function sentence_structure1() {
        // 変数

        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）
        $questions = [
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは三人称単数とする。</p>
                            <p class="text-3xl">AはBである。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A is B.",
                'e_type' => 1,
                'e' => "三人称単数は「彼、彼女、それ、太郎、学校」などである。",
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞とする。</p>
                            <p class="text-3xl">AはBである。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A are B.",
                'e_type' => 1,
                'e' => "複数名詞は「彼ら、彼女ら、それら、太郎と花子、２冊の本」などである。",
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは一人称単数または三人称単数とする。</p>
                            <p class="text-3xl">AはBでした。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A was B.",
                'e_type' => 1,
                'e' => "一人称単数は「自分」、三人称単数は「彼、彼女、それ、太郎、学校」などである。",
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞とする。</p>
                            <p class="text-3xl">AはBでした。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A were B.",
                'e_type' => 1,
                'e' => "複数名詞は「彼ら、彼女ら、それら、太郎と花子、２冊の本」などである。",
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは三人称単数とする。</p>
                            <p class="text-3xl">AはBですか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Is A B?",
                'e_type' => 1,
                'e' => '"Is she angry?"（彼女は怒っていますか？）、"Is this your pen?"（これはあなたのペンですか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞とする。</p>
                            <p class="text-3xl">AはBですか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Are A B?",
                'e_type' => 1,
                'e' => '"Are you tired?"（あなたは疲れていますか。）、"Are they your friends?"（彼らはあなたの友だちですか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは三人称単数とする。</p>
                            <p class="text-3xl">AはBではない。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A is not B. または A isn't B.",
                'e_type' => 1,
                'e' => '"It isn\'t mine."（これは私のものではない。）、"He is not ready."（彼は準備できていない。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞とする。</p>
                            <p class="text-3xl">AはBではない。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A are not B. または A aren't B.",
                'e_type' => 1,
                'e' => '"We are not hungry."（私たちはお腹が空いていない。）、"They aren\'t French."（彼らはフランス人ではない。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは三人称単数、Bは地名とする。</p>
                            <p class="text-3xl">AはBにいます。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A is in B.",
                'e_type' => 1,
                'e' => '"He is in Tokyo."（彼は東京にいます。）、"She is in Italy."（彼女はイタリアにいます。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞、Bは地名とする。</p>
                            <p class="text-3xl">AはBにいます。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A are in B.",
                'e_type' => 1,
                'e' => '"They are in Tokyo."（彼らは東京にいます。）、"We are in Italy."（私たちはイタリアにいます。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは三人称単数、Bは地名とする。</p>
                            <p class="text-3xl">AはBにいました。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A was in B.",
                'e_type' => 1,
                'e' => '"He was in Tokyo."（彼は東京にいました。）、"She was in Italy."（彼女はイタリアにいました。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞、Bは地名とする。</p>
                            <p class="text-3xl">AはBにいました。</p>
                        </div>',
                'a_type' => 1,
                'a' => "A were in B.",
                'e_type' => 1,
                'e' => '"They were in Tokyo."（彼らは東京にいました。）、"We were in Italy."（私たちはイタリアにいました。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは三人称単数、Bは地名とする。</p>
                            <p class="text-3xl">AはBにいましたか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Was A in B?",
                'e_type' => 1,
                'e' => '"Was he in Tokyo?"（彼は東京にいましたか。）、"Was she in Italy?"（彼女はイタリアにいましたか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Aは複数名詞、Bは地名とする。</p>
                            <p class="text-3xl">AはBにいましたか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Were A in B?",
                'e_type' => 1,
                'e' => '"Were they in Tokyo?"（彼らは東京にいましたか。）、"Were you in Italy?"（あなたたちはイタリアにいましたか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは複数名詞、Vは一般動詞とする。</p>
                            <p class="text-3xl">Sは毎日Vする。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S V every day.",
                'e_type' => 1,
                'e' => '"They study every day."（彼らは毎日勉強する。）、"We run every day."（私たちは毎日走る。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは三人称単数、Vは一般動詞とする。</p>
                            <p class="text-3xl">Sは毎日Vする。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S Vs every day.",
                'e_type' => 1,
                'e' => '"He studies every day."（彼は毎日勉強する。）、"She runs every day."（彼女は毎日走る。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは複数名詞、Vは一般動詞とする。</p>
                            <p class="text-3xl">Sは毎日Vしますか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Do S V every day?",
                'e_type' => 1,
                'e' => '"Do They study every day?"（彼らは毎日勉強しますか。）、"Do you run every day?"（あなたたちは毎日走りますか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは三人称単数、Vは一般動詞とする。</p>
                            <p class="text-3xl">Sは毎日Vしますか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Does S V every day?",
                'e_type' => 1,
                'e' => '"Does he study every day?"（彼は毎日勉強しますか。）、"Does she run every day?"（彼女は毎日走りますか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Vは一般動詞（規則動詞）とする。</p>
                            <p class="text-3xl">Sは昨日Vした。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S Ved yesterday.",
                'e_type' => 1,
                'e' => '"We walked yesterday."（私たちは昨日歩いた。）、"The event ended yesterday."（そのイベントは昨日終わった。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Vは一般動詞とする。</p>
                            <p class="text-3xl">Sは昨日Vしましたか。</p>
                        </div>',
                'a_type' => 1,
                'a' => "Did S V yesterday?",
                'e_type' => 1,
                'e' => '"Did They study yesterday?"（彼らは昨日勉強しましたか。）、"Did you run yesterday?"（あなたは昨日走りましたか。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Vは一般動詞とする。</p>
                            <p class="text-3xl">Sは昨日Vしなかった。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S did not V yesterday. または S didn't V yesterday.",
                'e_type' => 1,
                'e' => '"They did not study yesterday."（彼らは昨日勉強しなかった。）、"I didn\'t run yesterday."（私は昨日走らなかった。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは三人称単数、Vは一般動詞とする。</p>
                            <p class="text-3xl">S は今 V している。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S is Ving now.",
                'e_type' => 1,
                'e' => '"He is studying now."（彼は今勉強している。）、"She is running now."（彼女は今走っている。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは複数名詞、Vは一般動詞とする。</p>
                            <p class="text-3xl">S は今 V している。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S are Ving now.",
                'e_type' => 1,
                'e' => '"They are studying now."（彼らは今勉強している。）、"We are running now."（私たちは今走っている。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは三人称単数、Vは一般動詞とする。</p>
                            <p class="text-3xl">S はその時 V していた。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S was Ving then.",
                'e_type' => 1,
                'e' => '"He was studying then."（彼はその時勉強していた。）、"She was running now."（彼女はその時走っていた。）、など。',
            ],
            [
                'q_type' => 3,
                'q' => '<div class="text-center">
                            <p>次の文を英訳しなさい。ただし、Sは複数名詞、Vは一般動詞とする。</p>
                            <p class="text-3xl">S はその時 V していた。</p>
                        </div>',
                'a_type' => 1,
                'a' => "S were Ving then.",
                'e_type' => 1,
                'e' => '"They were studying then."（彼らはその時勉強していた。）、"We were running then."（私たちはその時走っていた。）、など。',
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "be動詞と一般動詞";
        return view('workbook.unit_template', compact('unitname','question'));
    }


    // 密度
    public function density() {
        $v = rand(1, 10);   //体積[cm^3]
        $d = 0.1 * rand(1, 20);   //密度
        $m = $d * $v;  //質量[g]

        $questions = [
            [
                'q' => "質量\,{$m}\,\mathrm{g}、体積\,{$v}\,\mathrm{cm}^3\,の物体の密度を求めなさい。",
                'a' => "{$d}\,\mathrm{g/cm}^3",
                'e' => "\mathrm{密度\,d[g/cm^3] = \\frac{質量\,m[g]}{\,体積\,V[cm^3]\,}より、d = \\frac{ {$m} }{ \,{$v}\, } = {$d}\,g/cm^3}。",
            ],
            [
                'q' => "密度\,{$d}\,\mathrm{g/cm^3}、体積\,{$v}\,\mathrm{cm}^3\,の物体の質量を求めなさい。",
                'a' => "{$m}\,\mathrm{g}",
                'e' => "\mathrm{密度\,d[g/cm^3] = \\frac{質量\,m[g]}{\,体積\,V[cm^3]\,}より、m = dV = {$d} \\times {$v} = {$m}\,g}。",
            ],
            [
                'q' => "密度\,{$d}\,\mathrm{g/cm^3}、質量\,{$m}\,\mathrm{g}\,の物体の体積を求めなさい。",
                'a' => "{$v}\,\mathrm{cm^3}",
                'e' => "\mathrm{密度\,d[g/cm^3] = \\frac{質量\,m[g]}{\,体積\,V[cm^3]\,}より、V = \\frac{m}{\,d\,} = \\frac{ {$m} }{ \,{$d}\, } = {$v}\,cm^3}。",
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.density', compact('question'));
    }

    // 水溶液１
    public function aqueous1() {
        // c = s/L * 100
        $L = 10 * rand(5, 20);   //溶液の質量[g]
        $c = 2 * rand(1, 5);   //濃度[%]
        $s = $c * $L / 100;  //溶質の質量[g]

        $questions = [
            [
                'q' => "食塩\,{$s}\,\mathrm{g}\,が溶けている、{$L}\,\mathrm{g}\,の食塩水がある。この水溶液の質量パーセント濃度を求めなさい。",
                'a' => "{$c}\,\mathrm{\%}",
                'e' => "\mathrm{質量パーセント濃度\,c\,[\%] = \\frac{溶質の質量\,s\,[g]}{\,溶液の質量\,L\,[g]\,}\\times 100\,より、
                        c=\\frac{s}{\,L\,}=\\frac{ \,{$s}\, }{ \,{$L}\, } \\times 100 = {$c}\,[\%]}。",
            ],
            [
                'q' => "質量パーセント濃度\,{$c}\,\mathrm{\%}\,の食塩水\,{$L}\,\mathrm{g}\,には、何\,\mathrm{g}\,の食塩が溶けているか。",
                'a' => "{$s}\,\mathrm{g}",
                'e' => "\mathrm{質量パーセント濃度\,c\,[\%] = \\frac{溶質の質量\,s\,[g]}{\,溶液の質量\,L\,[g]\,}\\times 100\,より、
                        {$c}=\\frac{ \,s\, }{ \,{$L}\, } \\times 100。これを解いて、s={$s}\,g}。",
            ],
            [
                'q' => "\,{$s}\,\mathrm{g}\,の食塩が溶けている、質量パーセント濃度\,{$c}\,\mathrm{\%}\,の食塩水の質量を求めなさい。",
                'a' => "{$L}\,\mathrm{g}",
                'e' => "\mathrm{質量パーセント濃度\,c\,[\%] = \\frac{溶質の質量\,s\,[g]}{\,溶液の質量\,L\,[g]\,}\\times 100\,より、
                        {$c}=\\frac{ \,{$s}\, }{ \,L\, } \\times 100。これを解いて、L={$L}\,g}。",
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.aqueous1', compact('question'));
    }

    // 湿度
    public function humidity() {
        // h = m/M * 100
        $h = rand(1, 90);   //湿度
        $M = rand(5, 20);   //飽和水蒸気量[g/m^3]
        $m = $M * $h / 100;  //実際の水蒸気量[g/m^3]

        $questions = [
            [
                'q' => "\(ある気温での飽和水蒸気量が\,{$M}\,\mathrm{g/m^3}\,で、実際の水蒸気量は\,{$m}\,\mathrm{g/m^3}\,とする。このときの湿度を求めなさい。\)",
                'a' => "{$h}\,\mathrm{\%}",
                'e' => "<p>\(\displaystyle
                            \mathrm{湿度\,h\,[\%] = \\frac{実際の水蒸気量\,\mathnormal{m}\,[g/m^3]}{\,飽和水蒸気量\,M\,[g/m^3]\,}\\times 100\,より、
                            h=\\frac{\mathnormal{m}}{\,M\,}=\\frac{ \,{$m}\, }{ \,{$M}\, } \\times 100 = {$h}\,[\%]}。
                        \)</p>",
            ],
            [
                'q' => "\(ある気温での飽和水蒸気量が\,{$M}\,\mathrm{g/m^3}\,で、湿度は\,{$h}\,\mathrm{\%}\,とする。このときの水蒸気量を求めなさい。\)",
                'a' => "{$m}\,\mathrm{g/m^3}",
                'e' => "<p>\(\displaystyle
                            \mathrm{湿度\,h\,[\%] = \\frac{実際の水蒸気量\,\mathnormal{m}\,[g/m^3]}{\,飽和水蒸気量\,M\,[g/m^3]\,}\\times 100\,より、
                            {$h}=\\frac{\,\mathnormal{m}\,}{\,{$M}\,}\\times 100。これを解いて、\mathnormal{m}={$m}\,[g/m^3]}。
                        \)</p>",
            ],
            [
                'q' => "\(ある気温での水蒸気量が\,{$m}\,\mathrm{g/m^3}\,で、湿度は\,{$h}\,\mathrm{\%}\,とする。このときの飽和水蒸気量を求めなさい。\)",
                'a' => "{$M}\,\mathrm{g/m^3}",
                'e' => "<p>\(\displaystyle
                            \mathrm{湿度\,h\,[\%] = \\frac{実際の水蒸気量\,\mathnormal{m}\,[g/m^3]}{\,飽和水蒸気量\,M\,[g/m^3]\,}\\times 100\,より、
                            {$h}=\\frac{\,{$m}\,}{\,M\,}\\times 100。これを解いて、M={$M}\,[g/m^3]}。
                        \)</p>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "湿度・水蒸気量";
        return view('workbook.unit.child', compact('unitname','question'));
    }

    // 電磁気
    public function electromagnetism() {
        $i1 = 0.2 * rand(1, 10);
        $r1 = 0.5 * rand(1, 10);
        if ( is_float($i1) && is_float($r1) ){
            $r1 = rand(1, 5);   // I,R がともに小数だと V が細かくなるため、R だけ整数にする。
        }
        $v1 = $r1 * $i1;
        $w1 = $v1 * $i1;

        $i2 = 0.1 * rand(1, 10);
        $r2 = 0.5 * rand(1, 10);
        if ( is_float($i2) && is_float($r2) ){
            $r2 = rand(1, 5);   // I,R がともに小数だと V が細かくなるため、R だけ整数にする。
        }
        $v2 = $r2 * $i2;

        $w3 = 100 * rand(1, 6); //熱量計算用の電力
        $t3 = rand(1, 5);   // 時間（分）
        $q3 = $w3 * ($t3 * 60);

        $V_series = $v1 + $v2;
        $R_series = $r1 + $r2;
        $I_series = $i1 + $i2;
        // 並列回路の合成抵抗用（整数のみ） 1/R = 1/r3 + 1/r4
        $r3 = rand(1,10);
        $r4 = rand(1,10);
        $R_para_numerator = $r3 + $r4;
        $R_para_denominator = $r3 * $r4;
        // 最大公約数を求める
        $gcd = $this->gcd($R_para_numerator, $R_para_denominator);
        // 約分
        $R_para_numerator /= $gcd;
        $R_para_denominator /= $gcd;
        $R_para_answer = ($R_para_numerator == 1)
            ? "{$R_para_denominator}\,\mathrm{\Omega}"
            : "\\frac{{$R_para_denominator}}{\,{$R_para_numerator}\,}\,\mathrm{\Omega}";

        $questions = [
            [
                'q' => "ある素子に、{$v1}\,\mathrm{V}\,の電圧がかかっており、{$i1}\,\mathrm{A}\,の電流が流れている。この素子の抵抗は何\,\Omega\,か。",
                'a' => "{$r1}\,\mathrm{\Omega}",
                'e' => "オームの法則より、V=RI。よって、R=\\frac{V}{\,I\,}=\\frac{ {$v1} }{ \,{$i1}\, } = {$r1}\,\mathrm{\Omega}。",
            ],
            [
                'q' => "抵抗が\,{$r1}\,\Omega\,の素子に、{$v1}\,\mathrm{V}\,の電圧がかかっているとき、何\,\mathrm{A}\,の電流が流れているか。",
                'a' => "{$i1}\,\mathrm{A}",
                'e' => "オームの法則より、V=RI。よって、I=\\frac{V}{\,R\,}=\\frac{ {$v1} }{ \,{$r1}\, } = {$i1} \,\mathrm{A}。",
            ],
            [
                'q' => "抵抗が\,{$r1}\,\Omega\,の素子に、{$i1}\,\mathrm{A}\,の電流が流れているとき、何\,\mathrm{V}\,の電圧がかかっているか。",
                'a' => "{$v1}\,\mathrm{V}",
                'e' => "オームの法則より、V=RI。よって、V=RI={$r1}\\times{$i1}  = {$v1} \,\mathrm{V}。",
            ],
            [
                'q' => "{$r1}\,\mathrm{\Omega}\,の素子と、{$r2}\,\mathrm{\Omega}\,の素子が、直列に繋がれている。合成抵抗は何\,\mathrm{\Omega}\,か。",
                'a' => "{$R_series}\,\Omega",
                'e' => "直列回路の合成抵抗は、各素子の抵抗の和になるので、{$r1}+{$r2}={$R_series}\,\mathrm{\Omega}。",
            ],
            [
                'q' => "{$r3}\,\mathrm{\Omega}\,の素子と、{$r4}\,\mathrm{\Omega}\,の素子が、並列に繋がれている。合成抵抗は何\,\mathrm{\Omega}\,か。",
                'a' => "{$R_para_answer}",
                'e' => "並列回路の合成抵抗\,R\,は、各素子の抵抗の逆数の和になるので、
                        \\frac{1}{\,R\,} = \\frac{1}{\,{$r3}\,} + \\frac{1}{\,{$r4}\,} 
                        = \\frac{ \,{$R_para_numerator}\, }{ {$R_para_denominator} }。
                        よって、R={$R_para_answer}。",
            ],
            [
                'q' => "２つの素子が直列に繋がれており、それぞれ\,{$v1}\,\mathrm{V}, \,{$v2}\,\mathrm{V}\,の電圧がかかっている。全体の電圧は何\,\mathrm{V}\,か。",
                'a' => "{$V_series}\,\mathrm{V}",
                'e' => "直列回路全体の電圧は、各素子にかかる電圧の和になるので、{$v1}+{$v2}={$V_series}\,\mathrm{V}。",
            ],
            [
                'q' => "２つの素子が並列に繋がれており、それぞれ\,{$i1}\,\mathrm{A}, \,{$i2}\,\mathrm{A}\,の電流が流れている。全体の電流は何\,\mathrm{A}\,か。",
                'a' => "{$I_series}\,\mathrm{A}",
                'e' => "並列回路全体の電流は、各素子に流れる電流の和になるので、{$i1}+{$i2}={$I_series}\,\mathrm{A}。",
            ],
            [
                'q' => "電熱線に\,{$v1}\,\mathrm{V}\,の電圧をかけると、\,{$i1}\,\mathrm{A}\,の電流が流れた。この電熱線に生じる電力は何\,\mathrm{W}\,か。",
                'a' => "{$w1}\,\mathrm{W}",
                'e' => "W=VI= {$v1}\\times{$i1} = {$w1}\,\mathrm{W}",
            ],
            [
                'q' => "{$w3}\mathrm{W}\,の電化製品を\,{$t3}\,分使った時、生じる熱量は何\,\mathrm{J}\,か。",
                'a' => "{$q3}\,\mathrm{J}",
                'e' => "Q=Wt = {$w3}\\times ({$t3} \\times 60)  = {$q3} \,\mathrm{J}\,（t\,は秒であることに注意）。",
            ],
            [
                'q' => "直線状の導線を電流が流れるとき、その周辺ではどのような向きに磁界が生じるか。（記述不要。イメージできたら答えを確認。）",
                'a' => "右手を「いいね」にしたときの親指の指す向きを電流の方向として、他の４本の指の向きが磁界の向きになる。",
                'e' => "試験では図が載っていると思います。右手を「いいね」にして色々な向きで考えられるようにしましょう。",
            ],
            [
                'q' => "コイル状の導線を電流が流れるとき、その周辺ではどのような向きに磁界が生じるか。（記述不要。イメージできたら答えを確認。）",
                'a' => "右手を「いいね」にしたときの親指以外の４本の指が指す向きを電流の方向として、親指の向きが磁界の向きになる。",
                'e' => "コイルの外側では回り込むように磁界が生じます。教科書などで図のイメージを確認しておきましょう。",
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.electromagnetism', compact('v1','i1','r1','question'));
    }

    // 理科 用語の理解
    public function science_terms_all() {
        $terms = [
            ['term' => '震度', 'mean' => '場所ごとにゆれの大きさを表す指標。', 'explanation' => '震度\,0\,から震度\,7\,まで\,10\,段階ある（震度\,5\,と\,6\,のみ弱・強にわかれる）。'],
            ['term' => 'マグニチュード', 'mean' => '地震そのものの規模を表す指標。', 'explanation' => '震度はゆれの大きさを示すが、場所によって異なる。マグニチュードは場所に依らない。'],
            ['term' => '溶質', 'mean' => '溶液に解けている物質のこと。', 'explanation' => '例えば、食塩水は水が溶媒で食塩が溶質である。'],

            ['term' => '水蒸気量', 'mean' => '1m^3\,あたりの水蒸気の質量。', 'explanation' => '質量は\,g\,を用いるので、水蒸気量の単位は\,g/m^3\,である。'],
            ['term' => '飽和水蒸気量', 'mean' => '湿度100\%のときの水蒸気量。', 'explanation' => '質量は\,g\,を用いるので、水蒸気量の単位は\,g/m^3\,である。'],

            ['term' => '電解質', 'mean' => '水に溶かすと電流が流れる物質。', 'explanation' => '食塩は電解質だが、砂糖は非電解質である。'],
            ['term' => '電離', 'mean' => '物質が水に溶けて陽イオンと陰イオンにわかれること。', 'explanation' => '例えば、塩化銅(CuCl_2)は銅イオン(Cu^{2+})と塩化物イオン(Cl^-)に電離する。'],
            ['term' => '酸', 'mean' => '電離すると水素イオンを生じる化合物。', 'explanation' => '塩酸(HCl)、硫酸(H_2 SO_4)、酢酸(CH_3 COOH)などがある。'],
            ['term' => 'アルカリ', 'mean' => '電離すると水酸化物イオンを生じる化合物。', 'explanation' => '水酸化ナトリウム(NaOH)、水酸化カルシウム(Ca(OH)_2)などがある。'],
        ];
        $idx = rand(0,count($terms)-1);
        $term = $terms[$idx];
        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 2,
                'q' => "「{$term['term']}」の意味を説明しなさい。",
                'a_type' => 2,
                'a' => "\mathrm{ {$term['mean']} }",
                'e_type' => 2,
                'e' => "\mathrm{ {$term['explanation']} }",
            ],
            [
                'q_type' => 3,
                'q' => "<p>次の意味をもつ用語を答えなさい。</p>
                        <p class=\"text-xl\">\(\mathrm{ {$term['mean']} }\)</p>",
                'a_type' => 2,
                'a' => "{$term['term']}",
                'e_type' => 2,
                'e' => "\mathrm{ {$term['explanation']} }",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "理科 用語の理解";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 地図の縮尺
    public function map_scale() {
        $scale = 25000 * rand(1, 2);    //縮尺
        $d_map_cm = rand(2, 10);  //地図上の距離(cm)
        $d_real_cm = $scale * $d_map_cm;   //実際の距離(cm)
        $d_real_km = $d_real_cm / 100 / 1000;   //実際の距離(km)

        return view('workbook.unit.map_scale', compact('scale','d_map_cm','d_real_cm','d_real_km'));
    }

    // 国語_動詞の取得
    private function get_jp_verb()
    {
        // 連用は２種用意⇒you1:～ます、you2:～た
        $words = [
            ['word' => '知る', 'katsuyou' => '五段活用', 'gokan' => '知', 'mi' => 'ら', 'you1' => 'り', 'you2' => 'っ', 'tai' => 'る', 'ka' => 'れ', 'mei' => 'れ',],
            ['word' => '笑う', 'katsuyou' => '五段活用', 'gokan' => '笑', 'mi' => 'わ', 'you1' => 'い', 'you2' => 'っ', 'tai' => 'う', 'ka' => 'え', 'mei' => 'え',],
            ['word' => '起きる', 'katsuyou' => '上一段活用', 'gokan' => '起', 'mi' => 'き', 'you1' => 'き', 'you2' => 'き', 'tai' => 'きる', 'ka' => 'きれ', 'mei' => 'きろ',],
            ['word' => '染みる', 'katsuyou' => '上一段活用', 'gokan' => '染', 'mi' => 'み', 'you1' => 'み', 'you2' => 'み', 'tai' => 'みる', 'ka' => 'みれ', 'mei' => 'みろ',],
            ['word' => '食べる', 'katsuyou' => '下一段活用', 'gokan' => '食', 'mi' => 'べ', 'you1' => 'べ', 'you2' => 'べ', 'tai' => 'べる', 'ka' => 'べれ', 'mei' => 'べろ',],
            ['word' => '当てる', 'katsuyou' => '下一段活用', 'gokan' => '当', 'mi' => 'て', 'you1' => 'て', 'you2' => 'て', 'tai' => 'てる', 'ka' => 'てれ', 'mei' => 'てろ',],
            ['word' => '来る', 'katsuyou' => 'カ行変格段活用', 'gokan' => '', 'mi' => 'こ', 'you1' => 'き', 'you2' => 'き', 'tai' => 'くる', 'ka' => 'くれ', 'mei' => 'こい',],
            ['word' => '勉強する', 'katsuyou' => 'サ行変格段活用', 'gokan' => '勉強', 'mi' => 'し', 'you1' => 'し', 'you2' => 'し', 'tai' => 'する', 'ka' => 'すれ', 'mei' => 'しろ',],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 国語_形容詞の取得
    private function get_jp_adjective()
    {
        // 連用は２種用意⇒you1:～なる、you2:～た
        $words = [
            ['word' => '白い', 'gokan' => '白', 'mi' => 'かろ', 'you1' => 'く', 'you2' => 'かっ', 'tai' => 'い', 'ka' => 'けれ',],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 国語_形容動詞の取得
    private function get_jp_keidou()
    {
        // 連用は２種用意⇒you1:～なる、you2:～た
        $words = [
            ['word' => '静かだ', 'gokan' => '静か', 'mi' => 'だろ', 'you1' => 'に', 'you2' => 'だっ', 'tai' => 'な', 'ka' => 'なら',],
        ];
        $index = rand(0,count($words)-1);
        $word = $words[$index];
        return $word;
    }

    // 国文法
    public function jp_yougen() {
        $v = $this->get_jp_verb();

        $idx1 = rand(1, 3); //1:動詞、2:形容詞、3:形容動詞

        if ($idx1 == 1) {
            $word = $this->get_jp_verb();
            $w_type = "動詞";
            $next = ['mi' => 'ない', 'you1' => 'ます', 'you2' => 'た', 'tai' => 'とき', 'ka' => 'ば',];
            $e_part = "<li>動詞は動作などを表し、終止形「<span class=\"underline\">{$word['word']}</span>」はウ段の音で終わる。</li>
                        <li>
                            未然形：<span class=\"underline\">{$word['gokan']}{$word['mi']}</span>ない、
                            連用形：<span class=\"underline\">{$word['gokan']}{$word['you1']}</span>ます・
                                    <span class=\"underline\">{$word['gokan']}{$word['you2']}</span>た、
                            連体形：<span class=\"underline\">{$word['gokan']}{$word['tai']}</span>とき、
                            仮定形：<span class=\"underline\">{$word['gokan']}{$word['ka']}</span>ば、
                            命令形：<span class=\"underline\">{$word['gokan']}{$word['mei']}</span>
                        </li>";
        } elseif ($idx1 == 2) {
            $word = $this->get_jp_adjective();
            $w_type = "形容詞";
            $next = ['mi' => 'う', 'you1' => 'なる', 'you2' => 'た', 'tai' => 'とき', 'ka' => 'ば',];
            $e_part = "<li>形容詞は状態などを表し、終止形「<span class=\"underline\">{$word['word']}</span>」は「い」で終わる。</li>
                        <li>
                            未然形：<span class=\"underline\">{$word['gokan']}{$word['mi']}</span>う、
                            連用形：<span class=\"underline\">{$word['gokan']}{$word['you1']}</span>なる・
                                    <span class=\"underline\">{$word['gokan']}{$word['you2']}</span>た、
                            連体形：<span class=\"underline\">{$word['gokan']}{$word['tai']}</span>とき、
                            仮定形：<span class=\"underline\">{$word['gokan']}{$word['ka']}</span>ば
                        </li>";
        } else {
            $word = $this->get_jp_keidou();
            $w_type = "形容動詞";
            $next = ['mi' => 'う', 'you1' => 'なる', 'you2' => 'た', 'tai' => 'とき', 'ka' => 'ば',];
            $e_part = "<li>形容動詞は状態などを表し、終止形「<span class=\"underline\">{$word['word']}</span>」は「だ」、「です」で終わる。</li>
                        <li>
                            未然形：<span class=\"underline\">{$word['gokan']}{$word['mi']}</span>う、
                            連用形：<span class=\"underline\">{$word['gokan']}{$word['you1']}</span>なる・
                                    <span class=\"underline\">{$word['gokan']}{$word['you2']}</span>た、
                            連体形：<span class=\"underline\">{$word['gokan']}{$word['tai']}</span>とき、
                            仮定形：<span class=\"underline\">{$word['gokan']}{$word['ka']}</span>ば
                        </li>";
        }

        $types = ['mi', 'you1', 'you2', 'tai', 'ka'];
        $idx2 = rand(0,count($types)-1);
        $type = $types[$idx2];
        $typenames = [
            'mi' => '未然形',
            'you1' => '連用形',
            'you2' => '連用形',
            'tai' => '連体形',
            'ka' => '仮定形',
        ];
        $typename = $typenames[$type];
        $changed_part = $word[$type];
        // q：問、a：答、e：解説
        // type・・・1:短文（数式なし or 部分的数式）、2:短文（全体的に数式）、3:複数行（htmlタグあり）、4:2行（変数あり）
        $questions = [
            [
                'q_type' => 1,
                'q' => "「{$v['word']}」の活用の種類を答えなさい。",
                'a_type' => 1,
                'a' => "{$v['katsuyou']}",
                'e_type' => 3,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                <li>{$v['word']}の未然形は、「{$v['gokan']}<span class=\"underline\">{$v['mi']}</span>」ない。</li>
                                <li>未然形（～ない）にしたときに、ア段なら「五段活用」、イ段なら「上一段活用」、エ段なら「下一段活用」。</li>
                                <li>「来る」は「カ行変格活用」。</li>
                                <li>「する」、「～する」は「サ行変格活用」。</li>
                            </ul>
                        </div>",
            ],
            [
                'q_type' => 3,
                'q' => "<p>下線部の品詞と活用形を答えなさい。</p>
                        <p class=\"text-3xl\"><span class=\"underline\">{$word['gokan']}{$changed_part}</span>{$next[$type]}</p>",
                'a_type' => 1,
                'a' => "{$w_type}、{$typename}",
                'e_type' => 3,
                'e' => "<div class=\"pl-5 text-left\">
                            <ul class=\"list-disc\">
                                {$e_part}
                            </ul>
                        </div>",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "用言";
        return view('workbook.unit_template', compact('unitname','question'));
    }

    // 小２漢字
    public function kanjiP2() {
        $questions = [
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'えんそくで うみの ちかくの こうえんに いった。',
                'a' => "遠足で海の近くの公園に行った。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'ふゆの よぞらに ほしが ひかっている。',
                'a' => "冬の夜空に星が光っている。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'あのくもは さかなみたいな かたちをしている。',
                'a' => "あの雲は魚みたいな形をしている。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'いもうとの しんゆうが いえに きた。',
                'a' => "妹の親友が家に来た。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'あすは がっこうが やすみです。',
                'a' => "明日は学校が休みです。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'でんわが なっている。',
                'a' => "電話が鳴っている。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'せんせいが こうばんの まえで はなしている。',
                'a' => "先生が交番の前で話している。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'いけの ちかくに ほそい みちがある。',
                'a' => "池の近くに細い道がある。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'もくようびの ごごは こくごと さんすうを まなびます。',
                'a' => "木曜日の午後は国語と算数を学びます。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'あねが かよっている こうこうは とてもひろいです。',
                'a' => "姉が通っている高校はとても広いです。",
                'e' => "",
            ],
        ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "小２漢字";
        return view('workbook.unit.template_kanji', compact('unitname','question'));
    }

    // 小３漢字
    public function kanjiP3() {
        $questions = [
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'なつまつりで きんぎょすくいをした。',
                'a' => "夏祭りで金魚すくいをした。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'あたらしい ふでばこを かった。',
                'a' => "新しい筆箱を買った。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'うんどうかいの リレーを ぜんそくりょくで はしった。',
                'a' => "運動会のリレーを全速力で走った。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'きょねんの はるよりも さむく かんじる。',
                'a' => "去年の春よりも寒く感じる。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'ちゅうおう としょかんの ほんをしらべて べんきょうした。',
                'a' => "中央図書館の本を調べて勉強した。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'きゅうに はなじが ではじめた。',
                'a' => "急に鼻血が出始めた。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'りかの じゅぎょうで でんりゅうを おそわった。',
                'a' => "理科の授業で電流を教わった。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'これは がっきゅういいんちょうの しんぞくの むかしの しゃしんだ。',
                'a' => "これは学級委員長の親族の昔の写真だ。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'はしの むこうに じんじゃがある。',
                'a' => "橋の向こうに神社がある。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'けんきゅうしゃに そうだんする。',
                'a' => "研究者に相談する。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'おもたい にもつを もちかえった。',
                'a' => "重たい荷物を持ち帰った。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'きみとの しょうぶは おわっていない。',
                'a' => "君との勝負は終わっていない。",
                'e' => "",
            ],
       ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "小３漢字";
        return view('workbook.unit.template_kanji', compact('unitname','question'));
    }

    // 小４漢字
    public function kanjiP4() {
        $questions = [
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'がっしゅくでの とっくんの せいかが しあいに あらわれた。',
                'a' => "合宿での特訓の成果が試合に表れた。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'きかいに ひつような ざいりょうが ふそくしている。',
                'a' => "機械に必要な材料が不足している。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'かごしまから ひこうきで えひめに たびだつ。',
                'a' => "鹿児島から飛行機で愛媛に旅立つ。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'ともだちと わなげで あそんだ。',
                'a' => "友達と輪投げで遊んだ。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'ふくだいじんが もんだいはつげんをした。',
                'a' => "副大臣が問題発言をした。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'うんどうかいで ときょうそうへの さんかを きぼうする。',
                'a' => "運動会で徒競走への参加を希望する。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'りかの じっけんで かがみを つかう。',
                'a' => "理科の実験で鏡を使う。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'そうこに とりの すが ある。',
                'a' => "倉庫に鳥の巣がある。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'れんぞく しゅつじょうの きろくを うちたてる。',
                'a' => "連続出場の記録を打ち立てる。",
                'e' => "",
            ],
            [
                'q1' => '次の文を漢字を使って書きましょう。',
                'q2' => 'きゅうしょくで やきにくを のこさず たべた。',
                'a' => "給食で焼肉を残さず食べた。",
                'e' => "",
            ],
       ];
        $q_index = rand(0,count($questions)-1);
        $question = $questions[$q_index];
        $unitname = "小４漢字";
        return view('workbook.unit.template_kanji', compact('unitname','question'));
    }
}