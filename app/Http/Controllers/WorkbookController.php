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

    // 一次関数（グラフ描画）
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
                'q' => '彼は英語を勉強した。 ⇒ She (　　) English.',
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
}