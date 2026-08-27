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
                            <p>\(\displaystyle {$per}\,\%\,は\,\\frac{{$per}}{\,100\,}\,倍なので、{$num}\,\\times\\frac{{$per}}{\,100\,}\, = {$val_per}.\)</p>
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

    // 一次方程式(2)
    public function linear_equation2() {
        // a, b, c をランダムに決める
        $a = rand(2, 9);
        $b = rand(1, 9);
        if ($a == $b) {
            $b = $a + rand(1,9);
        }
        $c = rand(1, 9);

        // x = ac / b
        $numerator = $a * $c;
        $denominator = $b;

        // 最大公約数を求める
        $gcd = $this->gcd($numerator, $denominator);

        // 約分
        $numerator /= $gcd;
        $denominator /= $gcd;

        // 分母が1なら整数として表示
        if ($denominator == 1) {
            $answer = $numerator;
        } else {
            $answer = $numerator . '/' . $denominator;
        }

        return view('workbook.unit.linear_equation2', compact('a','b','c','answer','numerator','denominator'));
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

    // 比例（グラフ描画）
    public function plot_proportional_function() {
        $a_sign = (-1)**rand(1,2);
        $a_numerator = rand(1, 4);
        $a_denominator = rand(1, 4);

        // 最大公約数を求める
        $gcd = $this->gcd($a_numerator, $a_denominator);

        // 約分
        $a_numerator /= $gcd;
        $a_denominator /= $gcd;

        // グラフ描画用
        $a = $a_sign * $a_numerator / $a_denominator;
        $size = 500;    //viewportの大きさ
        $val_size = 10; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺
        $p_x = $a_denominator; //代表点Pのx座標
        $p_y = $a_sign * $a_numerator; //代表点Pのy座標
        $q_x = -$a_denominator; //代表点Q(原点に対してPと対称な点)のx座標
        $q_y = $a_sign * -$a_numerator; //代表点Q(原点に対してPと対称な点)のy座標
        $plots = [
            'w_full' => $size,
            'w_half' => $size / 2,
            'from_x' => -$size / 2,
            'to_x' => $size / 2,
            'from_y' => $a * (-$size / 2),
            'to_y' => $a * ($size / 2),
            'p_x' => $p_x,
            'p_y' => $p_y,
            'q_x' => $q_x,
            'q_y' => $q_y,
            'scale' => $scale,        
        ];

        return view('workbook.unit.plot_proportional_function', compact('a_sign','a_numerator','a_denominator','plots'));
    }

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

    // 一次関数（グラフ描画）
    public function plot_linear_function() {
        $a_sign = (-1)**rand(1,2);
        $a_numerator = rand(1, 4);
        $a_denominator = rand(1, 4);
        $b = (-1)**rand(1,2) * rand(1,4);

        // 最大公約数を求める
        $gcd = $this->gcd($a_numerator, $a_denominator);

        // 約分
        $a_numerator /= $gcd;
        $a_denominator /= $gcd;

        // グラフ描画用
        $a = $a_sign * $a_numerator / $a_denominator;
        $size = 500;    //viewportの大きさ
        $val_size = 10; //実際の座標の大きさ
        $scale = $size / $val_size; //縮尺
        $x_seppen = -$b/$a; //x切片
        $p_x = $a_denominator; //代表点Pのx座標
        $p_y = $a * $p_x + $b; //代表点Pのy座標
        if(abs($p_y) > ($val_size-1) / 2) {
            $p_x = -$p_x;
            $p_y = $a * $p_x + $b;
        } // p_y がviewportに収まらない場合は、x = -x での代表点に変える。
        $plots = [
            'w_full' => $size,
            'w_half' => $size / 2,
            'from_x' => -$size / 2,
            'to_x' => $size / 2,
            'from_y' => $a * (-$size / 2) + ($b * $scale),
            'to_y' => $a * ($size / 2) + ($b * $scale),
            'p_x' => $p_x,
            'p_y' => $p_y,
            'scale' => $scale,        
        ];

        return view('workbook.unit.plot_linear_function', compact('a_sign','a_numerator','a_denominator','a','b','plots'));
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
                'a' => '<ul class="list-disc">
                            <li>すべての辺の長さが等しい。</li>
                            <li>すべての内角が\(\,90^{\circ}\)。</li>
                            <li>向かい合う辺が平行。</li>
                        </ul>',
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「正方形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "長方形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => '<ul class="list-disc">
                            <li>すべての内角が\(\,90^{\circ}\)。</li>
                            <li>向かい合う辺の長さが等しい。</li>
                            <li>向かい合う辺が平行。</li>
                        </ul>',
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「長方形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "平行四辺形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => '<ul class="list-disc">
                            <li>向かい合う角の大きさが等しい。</li>
                            <li>向かい合う辺の長さが等しい。</li>
                            <li>向かい合う辺が平行。</li>
                        </ul>',
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「平行四辺形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "正三角形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => '<ul class="list-disc">
                            <li>すべての辺の長さが等しい。</li>
                            <li>すべての内角が\(\,60^{\circ}\)。</li>
                        </ul>',
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「正三角形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "二等辺三角形の特徴をできるだけ挙げなさい。",
                'a_type' => 3,
                'a' => '<ul class="list-disc">
                            <li>頂角に接する二つの辺の長さが等しい。</li>
                            <li>２つの底角が等しい。</li>
                        </ul>',
                'e_type' => 1,
                'e' => "\(AB=AC\,\)のように明記されていなくても、「二等辺三角形」であれば上記の仮定をすべて含んでいる。",
            ],
            [
                'q_type' => 2,
                'q' => "平行な２本の直線を、別の１本の直線が横切るとき、わかることをすべて挙げなさい。",
                'a_type' => 3,
                'a' => '<ul class="list-disc">
                            <li>等しい錯角が存在する。</li>
                            <li>等しい同位角が存在する。</li>
                            <li>交点では、対頂角が等しい。</li>
                        </ul>',
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

    // 係数
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

    // 代名詞
    public function pronoun() {
        $questions = [
            [
                'q' => '私はペンを持っている。 ⇒ (　　) have a pen.',
                'a' => '( I ) have a pen.',
            ],
            [
                'q' => '彼はテニスが好きです。 ⇒ (　　) likes tennis.',
                'a' => '( He ) likes tennis.',
            ],
            [
                'q' => '彼女はピアノを弾きます。 ⇒ (　　) plays the piano.',
                'a' => '( She ) plays the piano.',
            ],
            [
                'q' => 'これは私の兄です。 ⇒ This is (　　) brother.',
                'a' => 'This is ( my ) brother.',
            ],
            [
                'q' => 'あなたの家は大きい。 ⇒ (　　) house is big.',
                'a' => '( Your ) house is big.',
            ],
            [
                'q' => 'ここが彼の部屋です。 ⇒ Here is (　　) room.',
                'a' => 'Here is ( his ) room.',
            ],
            [
                'q' => '彼女の名前はアリスです。 ⇒ (　　) name is Alice.',
                'a' => '( Her ) name is Alice.',
            ],
            [
                'q' => 'あれは私たちの父です。 ⇒ That is (　　) father.',
                'a' => 'That is ( our ) father.',
            ],
            [
                'q' => 'あれは彼らの車です。 ⇒ That is (　　) car.',
                'a' => 'That is ( their ) car.',
            ],
            [
                'q' => '誰かが私を呼んだ。 ⇒ Somebody called (　　).',
                'a' => 'Somebody called ( me ).',
            ],
            [
                'q' => '私はあなたを助けた。 ⇒ I helped (　　).',
                'a' => 'I helped ( you ).',
            ],
            [
                'q' => '母は彼を知っている。 ⇒ My mother knows (　　).',
                'a' => 'My mother knows ( him ).',
            ],
            [
                'q' => '私たちは彼女に会った。 ⇒ We saw (　　).',
                'a' => 'We saw ( her ).',
            ],
            [
                'q' => '私たちと遊ぼう。 ⇒  Let\'s play with (　　).',
                'a' => 'Let\'s play with ( us ).',
            ],
            [
                'q' => 'その犬は彼らを攻撃した。 ⇒  The dog attacked (　　).',
                'a' => 'The dog attacked ( them ).',
            ],
        ];
        $index = rand(0,count($questions)-1);
        $question = $questions[$index];
        return view('workbook.unit.pronoun', compact('question'));
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


    // 地図の縮尺
    public function map_scale() {
        $scale = 25000 * rand(1, 2);    //縮尺
        $d_map_cm = rand(2, 10);  //地図上の距離(cm)
        $d_real_cm = $scale * $d_map_cm;   //実際の距離(cm)
        $d_real_km = $d_real_cm / 100 / 1000;   //実際の距離(km)

        return view('workbook.unit.map_scale', compact('scale','d_map_cm','d_real_cm','d_real_km'));
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