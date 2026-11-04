import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import $ from 'jquery';
import Chart from 'chart.js/auto';


// chart.jsの表示用グローバル変数
let myChart1 = null;
let myChart2 = null;
let myChart3 = null;
let myChart4 = null;

$(function () {
    $('#display-button').on('click', function () {
        // 既存のグラフがあれば破棄
        switch (window.pageConfig?.jsAction) {
            case 'make_harmony':
                // 再生中の場合（停止するとき）は破棄しない
                // if(audioCtxes.length==3){
                //     break;
                // }
            default:                           
                myChart1 && myChart1.destroy();
                myChart2 && myChart2.destroy();
                myChart3 && myChart3.destroy();
                myChart4 && myChart4.destroy();
                break;
        }
        switch (window.pageConfig?.jsAction) {
            case 'n_ary_numeral':
                n_ary_numeral();
                break;
            case 'series_sums_vs_integrals':
                series_sums_vs_integrals();
                break;
            case 'matrix_notation':
                matrix_notation();
                break;
            case 'make_harmony':
                    loadAndSound();
                    $(this).html('停止');
                    dispWaveFunc();
                break;
            // case 'make_harmony':
            //     // 再生中の場合は停止
            //     if(audioCtxes.length==3){
            //         releaseAudio();
            //         $(this).html('再生（音が流れます）');
            //     // 停止中の場合は再生
            //     }else{
            //         loadAndSound();
            //         $(this).html('停止');
            //         dispWaveFunc();
            //     }
            //     break;
            case 'joukowski':
                joukowski();
                break;
        }
    });
    // 入力パラメータの値が変更された時
    $(".parameter").on('change', function() {
        switch (window.pageConfig?.jsAction) {
            case 'make_harmony':
                // $(".parameter").on('change', function() {
                //     // 再生中の場合は処理を実行
                //     if(audioCtxes.length==3){
                //         // 再生中のaudioCtxを閉じる
                //         releaseAudio();
                //         // 更新されたパラメータで再生
                //         loadAndSound();
                //         dispWaveFunc();
                //     }
                // });
                // break;
        }
    });
});

/*******************************************************
* 十進数からn進数への変換
********************************************************/
function n_ary_numeral() {
    // パラメータを取得
    var para_a = Number($("#para_a").val());
    var para_b = Number($("#para_b").val());

    // パラメータチェック
    if (!Number.isInteger(para_a) || !Number.isInteger(para_b)
        || para_a < 2 || para_b < 2 || para_a > 999 || para_b > 999){
        alert('基数nと変換する数は、2〜999の自然数を入力してください。');
        return;
    }
    // 変数定義
    var quotient; // 商
    var remainder; // 余り
    var previous_remainder = 0; // １つ前の計算での余り
    var converted = ''; // 変換後(n進数表記)
    var remain_terms; // 残りの項
    var buff_equation; // 数式
    var radix = para_a; // 基数
    var decimal = para_b; // 変換したい十進数

    buff_equation = decimal;

    // 十進数が0になるまで基数で割り続ける
    for (var i = 0; decimal > 0; i++) {
        // 十進数を基数で割る
        quotient = Math.floor(decimal / radix);
        remainder = decimal % radix;

        // 余りの羅列を記録
        converted = remainder + converted;
        // 残りの項を作成
        if (i == 0)
        {
            remain_terms = '';
        }
        else if (i == 1)
        {
            remain_terms = previous_remainder + ' \\times ' + radix + '^{' + (i - 1) + '}';
        }
        else
        {
            remain_terms = previous_remainder + ' \\times ' + radix + '^{' + (i - 1) + '}+' + remain_terms;
        }

        // 数式を追加
        // buff_equation += '&=& (' + quotient + '\\times' + radix + '+' + remainder + ')\\times' + radix + '^{' + i + '}';
        buff_equation += '&= (' + quotient + ' \\times ' + radix + '+' + remainder + ') \\times ' + radix + '^{' + i + '}';
        if (i > 0)
        {
            buff_equation += '+' + remain_terms;
        }
        buff_equation += '\\\\';
        // 値を更新
        decimal = quotient;
        previous_remainder = remainder;
    }
    buff_equation += '&= (' + converted + ')_{' + radix + '}';

    // 生成した数式と図形のdiv要素を出力
    $("#display_equation").html("\\[ \\begin{aligned} " + buff_equation + " \\end{aligned} \\]");
    renderMathInElement(document.getElementById("display_equation"));
}


/*******************************************************
* 級数和と積分
********************************************************/
// 小数点以下precision位で四捨五入
function round(number, precision) {
    var shift = function (number, precision, reverseShift) {
    if (reverseShift) {
        precision = -precision;
    }
    var numArray = ("" + number).split("e");
    return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
    };
    return shift(Math.round(shift(number, precision, false)), precision, true);
}
function series_sums_vs_integrals() {
    // 入力パラメータの取得
    var a = Number($("#para_a").val());
    var b = Number($("#para_b").val());
    var n = Number($("#para_n").val());
    var delta = (b - a) / n;

    // 入力値が不適切な場合、警告メッセージを表示して処理終了
    if ( a < 0 ) {
        alert("aは0以上の値を指定してください");
        exit;
    }
    if ( n < 1 ) {
        alert("nは1以上の整数を指定してください");
        exit;
    }
    if ( n > 50 ) {
        alert("nの値が大きいと処理に時間がかかります。ホントは無限大にしたいのですが、50以下の値で我慢してください(>_<)");
        exit;
    }

    // ローカル変数の定義
    var str_buff = ""; // 画面に出力する途中式（展開式）
    var x = 0.0;
    var x1 = 0.0;
    var x2 = 0.0;
    var y = 0.0;
    var y_sum = 0.0;
    var kai1 = [];
    var kai2 = [];
    var area = 0.0;
    var area_sum2 = 0.0;
    var genmitsu_kai = 0.0;

    // 厳密解（に近い近似解）の計算→できれば厳密解をプロットしたい
    for ( var i = 1; i <= 100*n; i++) {
        x = a + i*(delta/100);
        y = Math.sqrt(x);
        area = y*(delta/100);
        kai1.push({x,y});
    }
    genmitsu_kai = (2/3)*(b**(3/2)-a**(3/2));
    genmitsu_kai = round(genmitsu_kai, 2);
    // 厳密解をhtmlに表示
    $("#genmitsu-kai").html("$$ \\int_{a}^{b} \\sqrt{x} dx = \\int_{" + a + "}^{" + b + "} \\sqrt{x} dx \\fallingdotseq " + genmitsu_kai + " $$")
    renderMathInElement(document.getElementById("genmitsu-kai"));

    // 級数和
    for ( var i = 1; i <= n; i++ ) {
        x1 = a + (i-1)*delta;
        x2 = a + i*delta;
        y = Math.sqrt(x2);
        area = y*delta;
        area_sum2 += area;
        str_buff += round(area, 2).toString();
        if (i != n) {
            str_buff += " + ";
        }

        x = x1 + 0.5*delta;
        kai2.push({x,y});
        x = x2 + 0.5*delta;
        kai2.push({x,y});
    }

    $("#ans_sum").html(
        "$$ \\Delta = \\frac{" + b + " - " + a + "}{" + n + "} = " + (b-a)/n + " $$ "
        + "$$ \\sum_{k=1}^{" + n + "} f(x_k)\\Delta = " + str_buff + " = " + round(area_sum2, 2).toString() + " $$"
    );
    renderMathInElement(document.getElementById("ans_sum"));

    // 計算してグラフを書く関数を呼ぶ
    var ctx = document.getElementById('myChart').getContext('2d');
    myChart1 = new Chart(ctx, {
        data: {
            datasets: [
                {
                    // 厳密解の曲線
                    type: 'line',
                    label: 'f(x)',
                    data: kai1,
                    cubicInterpolationMode: 'monotone',
                    borderColor: "blue",
                    pointRadius: 0 // 点の半径
                },
                {
                    // 棒グラフ
                    type: 'bar',
                    label: '(式1)の右辺の和',
                    data: kai2,
                    borderWidth: 1,
                    backgroundColor: "rgba(153,255,51,1)",
                    // barThickness: 8
                    barPercentage: 1,
                    categoryPercentage: 1
                },
            ]
        },
        options: {
            scales: {
                x : {
                        type: 'linear',
                        min: a,
                        max: b,
                        offset: false,
                        grid: {
                            offset: false
                        }
                    },
                y : {
                        min: 0,
                        max: Math.ceil(Math.max.apply(null, kai2)),
                        axis: 'y'
                    }
            }
        }
    });
};

/*******************************************************
* 行列の積と成分表記
********************************************************/
function matrix_notation() {
    // 入力パラメータを取得して数値に変換
    var n = Number($("#para_n").val());
    
    // n < 1 または n > 5 の場合は警告メッセージを表示して処理終了
    if ( n < 1 | n > 5 ) {
      alert("nは1〜5の整数を設定してください");
      exit;
    }
    
    // ---------- 展開式の文字列を生成 ----------
    // A
    var str_A = "\\begin{pmatrix} ";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_A += "a_{" + i + "" + j + "} & "
      }
      // slice(0, -2)で展開式末尾の"& "を削除
      str_A = str_A.slice(0, -2);
      // 改行文字追加
      str_A += "\\\\ ";
    }
    str_A += "\\end{pmatrix} ";

    // B
    var str_B = "\\begin{pmatrix} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_B += "b_{" + i + "" + j + "} & "
      }
      str_B = str_B.slice(0, -2);
      str_B += "\\\\ \n";
    }
    str_B += "\\end{pmatrix} \n";

    // C
    var str_C = "\\begin{pmatrix} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_C += "c_{" + i + "" + j + "} & "
      }
      str_C = str_C.slice(0, -2);
      str_C += "\\\\ \n";
    }
    str_C += "\\end{pmatrix} \n";

    // AB（展開）
    var str_AB1 = "\\begin{pmatrix} ";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        for ( var k = 1; k <= n; k++ ) {
          str_AB1 += "a_{" + i + "" + k + "} b_{" + k + "" + j + "} + "
        }
        str_AB1 = str_AB1.slice(0, -2);
        str_AB1 += "& ";
      }
      str_AB1 = str_AB1.slice(0, -2);
      str_AB1 += "\\\\";
    }
    str_AB1 += "\\end{pmatrix}";

    // AB（シグマ表記）
    var str_AB2 = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_AB2 += "\\sum_{k=1}^" + n + " a_{" + i + "k} b_{k" + j + "} & "
      }
      str_AB2 = str_AB2.slice(0, -2);
      str_AB2 += "\\\\ \n";
    }
    str_AB2 += "\\end\{pmatrix\} \n";

    // ABC（展開）
    var str_ABC1 = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        for ( var l = 1; l <= n; l++ ) {
          str_ABC1 += "(\\sum_{k=1}^" + n + " a_{" + i + "k} b_{k" + l + "} ) c_{" + l + "" + j + "} + "
        }
        str_ABC1 = str_ABC1.slice(0, -2);
        str_ABC1 += "& ";
      }
      str_ABC1 = str_ABC1.slice(0, -2);
      str_ABC1 += "\\\\ \n";
    }
    str_ABC1 += "\\end\{pmatrix\} \n";

    // ABC（シグマ表記）
    var str_ABC2 = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_ABC2 += "\\sum_{l=1}^" + n + " (\\sum_{k=1}^" + n + " a_{" + i + "k} b_{kl}) c_{l" + j + "} & "
      }
      str_ABC2 = str_ABC2.slice(0, -2);
      str_ABC2 += "\\\\ \n";
    }
    str_ABC2 += "\\end\{pmatrix\} \n";

    // ABC（シグマ表記2）
    var str_ABC3 = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_ABC3 += "\\sum_{k,l=1}^" + n + " a_{" + i + "k} b_{kl} c_{l" + j + "} & "
      }
      str_ABC3 = str_ABC3.slice(0, -2);
      str_ABC3 += "\\\\ \n";
    }
    str_ABC3 += "\\end\{pmatrix\} \n";
    
    var f = "\\[ \\begin{aligned} ";
    f += "S &= " + str_A + str_B + str_C + " \\\\ ";
    f += " &= " + str_AB1 + str_C + "\\\\";
    f += " &= " + str_AB2 + str_C + "\\\\";
    f += " &= " + str_ABC1 + "\\\\";
    f += " &= " + str_ABC2 + "\\\\";    
    f += " &= " + str_ABC3 + "\\\\";
    f += " \\end{aligned} \\]";

    $("#result").html(f);
    renderMathInElement(document.getElementById("result"));
}

/*******************************************************
* ３つの音波を重ねて和音をつくる
********************************************************/
// var audioCtxes = new Array();
// window.AudioContext = window.AudioContext || window.webkitAudioContext; //クロスブラウザ対応

// 音を鳴らす処理
// function playSound(hz){

//     var audioCtx = new AudioContext();

//     //音の出力先
//     var audioDestination = audioCtx.destination;

//     //正弦波の音を作成
//     var osciillator = audioCtx.createOscillator();

//     //ヘルツ（周波数）指定
//     osciillator.frequency.value = hz;

//     // 音量
//     //var gainNode = audioCtx.createGain();
//     //gainNode.gain.value = 0.1; // 10 %

//     //出力先のスピーカーに接続
//     osciillator.connect(audioDestination);
//     //gainNode.connect(audioDestination);

//     //音を出す
//     osciillator.start();

//     audioCtxes.push(audioCtx);
// }
const AudioContextClass =
    window.AudioContext || window.webkitAudioContext;
const audioCtx = new AudioContextClass();
// 音を鳴らす処理
async function playSound(hz) {
    if (audioCtx.state === 'suspended') {
        await audioCtx.resume();
    }

    const oscillator = audioCtx.createOscillator();
    const gainNode = audioCtx.createGain();

    const now = audioCtx.currentTime;
    const duration = 1.5;

    oscillator.type = 'sine';
    oscillator.frequency.setValueAtTime(hz, now);

    // 音量を徐々に上げ下げして、クリック音も抑える
    gainNode.gain.setValueAtTime(0, now);
    gainNode.gain.linearRampToValueAtTime(0.12, now + 0.02);
    gainNode.gain.setValueAtTime(0.12, now + duration - 0.03);
    gainNode.gain.linearRampToValueAtTime(0, now + duration);

    oscillator.connect(gainNode);
    gainNode.connect(audioCtx.destination);

    oscillator.start(now);
    oscillator.stop(now + duration);

    oscillator.onended = () => {
        oscillator.disconnect();
        gainNode.disconnect();
    };
}

// Audioを解放
// function releaseAudio(){
//     // 再生中の場合は停止
//     if(audioCtxes.length==3){
//       // audioCtxを閉じる
//       audioCtxes[0].close();
//       audioCtxes[1].close();
//       audioCtxes[2].close();

//       // 配列を空にする
//       audioCtxes.length = 0;
//     }
// }

// パラメータ取得＆再生
function loadAndSound(){
    // 入力パラメータを取得して数値に変換
    var hz1 = Number($("#para_1").val());
    var hz2 = Number($("#para_2").val());
    var hz3 = Number($("#para_3").val());

    // 再生
    playSound(hz1);
    playSound(hz2);
    playSound(hz3);
}

function dispWaveFunc() {
    // 変数定義
    var hz1 = Number($("#para_1").val());
    var hz2 = Number($("#para_2").val());
    var hz3 = Number($("#para_3").val());

    var char_f1 = '';
    var char_f2 = '';
    var char_f3 = '';
    var char_F = '';

    // f1(t)の式を生成
    char_f1 = '\\cos(2\\pi \\times ' + hz1 + ' \\times t)';

    // f2(t)の式を生成
    char_f2 = '\\cos(2\\pi \\times ' + hz2 + ' \\times t)';

    // f3(t)の式を生成
    char_f3 = '\\cos(2\\pi \\times ' + hz3 + ' \\times t)';

    // 合成波の式を生成
    char_F = char_f1 + '+' + char_f2 + '+' + char_f3;

    // 数式を生成して出力(合成波)
    $("#equation1").html('$$ f_{1}(t) + f_{2}(t) + f_{3}(t) = ' + char_f1 + ' + ' + char_f2 + ' + ' + char_f3 + ' $$');
    renderMathInElement(document.getElementById("equation1"));

    // 数式を生成して出力(f1(t))
    $("#equation2").html('$$ f_{1}(t) = ' + char_f1 + ' $$');
    renderMathInElement(document.getElementById("equation2"));

    // 数式を生成して出力(f2(t))
    $("#equation3").html('$$ f_{2}(t) = ' + char_f2 + ' $$');
    renderMathInElement(document.getElementById("equation3"));

    // 数式を生成して出力(f3(t))
    $("#equation4").html('$$ f_{3}(t) = ' + char_f3 + ' $$');
    renderMathInElement(document.getElementById("equation4"));

    // グラフ作成用の変数定義
    var f1 = new Array();
    var f2 = new Array();
    var f3 = new Array();
    var F = new Array();
    var trange = 50/Math.max(hz1,hz2,hz3); // 50回の振動まで表示
    var dt = trange/1000;
    var t = 0;
    var x = 0;
    var y = 0;
    var i = 0;

    // グラフ出力用のデータ生成
    for(t=0;t<=trange;t+=dt){
        // f1(t)
        x = t;
        y = Math.cos(2*Math.PI*hz1*t);
        f1.push({x,y});

        // f2(t)
        x = t;
        y = Math.cos(2*Math.PI*hz2*t);
        f2.push({x,y});

        // f3(t)
        x = t;
        y = Math.cos(2*Math.PI*hz3*t);
        f3.push({x,y});

        // 合成波
        x = t;
        y = f1[i].y + f2[i].y + f3[i].y;
        F.push({x,y});

        i++;
    }

    // canvasのサイズを設定
    var w = $('.canvas_container').width();
    var h = $('.canvas_container').height();
    $('#canvas1').attr('width', w);
    $('#canvas1').attr('height', h);
    $('#canvas2').attr('width', w);
    $('#canvas2').attr('height', h);
    $('#canvas3').attr('width', w);
    $('#canvas3').attr('height', h);
    $('#canvas4').attr('width', w);
    $('#canvas4').attr('height', h);

    // 計算してグラフを書く関数を呼ぶ
    var ctx1 = document.getElementById('canvas1').getContext('2d');
    myChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'f1(t)+f2(t)+f3(t)',
                    borderWidth: 2,
                    pointRadius: 0, // 点の半径
                    borderColor: "blue",
                    backgroundColor: "rgba(0,0,128,0.5)",
                    data: F
                }
            ]
        },
        options: {
            scales: {
                x : {
                        type: 'linear',
                        min: 0,
                        max: trange
                    },
                y : {
                        min: -3,
                        max: 3
                    }
            }
        }
    });

    var ctx2 = document.getElementById('canvas2').getContext('2d');
    myChart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'f1(t)',
                    borderWidth: 2,
                    pointRadius: 0, // 点の半径
                    tension: 0,
                    borderColor: "green",
                    backgroundColor: "rgba(0,128,0,0.5)",
                    data: f1
                }
            ]
        },
        options: {
            scales: {
                x : {
                        type: 'linear',
                        min: 0,
                        max: trange
                    },
                y : {
                        min: -3,
                        max: 3
                    }
            }
        }
    });

    var ctx3 = document.getElementById('canvas3').getContext('2d');
    myChart3 = new Chart(ctx3, {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'f2(t)',
                    borderWidth: 2,
                    pointRadius: 0, // 点の半径
                    borderColor: "skyblue",
                    backgroundColor: "rgba(0,128,128,0.5)",
                    data: f2
                }
            ]
        },
        options: {
            scales: {
                x : {
                        type: 'linear',
                        min: 0,
                        max: trange
                    },
                y : {
                        min: -3,
                        max: 3
                    }
            }
        }
    });

    var ctx4 = document.getElementById('canvas4').getContext('2d');
    myChart4 = new Chart(ctx4, {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'f3(t)',
                    borderWidth: 2,
                    pointRadius: 0, // 点の半径
                    borderColor: "pink",
                    backgroundColor: "rgba(128,0,0,0.5)",
                    data: f3
                }
            ]
        },
        options: {
            scales: {
                x : {
                        type: 'linear',
                        min: 0,
                        max: trange
                    },
                y : {
                        min: -3,
                        max: 3
                    }
            }
        }
    });
}



/*******************************************************
* 円形を翼形に写す〜ジューコフスキー変換〜
********************************************************/
function joukowski() {
    // 入力パラメータを取得して数値に変換
    var a = new Number($("#para_a").val());
    var x1 = new Number($("#para_x1").val());
    var y1 = new Number($("#para_y1").val());

    // // n < 1 または n > 100000 の場合は警告メッセージを表示して処理終了
    // if ( n < 1 | n > 100000 ) {
    // alert("nは100000以下の自然数を設定してください");
    // exit;
    // }
    // プロット数
    var n = 300;
    // 変数
    var theta, x, y, y0, r_in, r_out, common_term;
    // プロットするデータを配列に格納
    var plot_data_inner_circle = [];
    var plot_data_outer_circle = [];
    var plot_data_jukovski = [];
    /*******************************
    * 0 <= theta < 2pi でデータを生成
    *******************************/
    for ( var i = 0; i < n; i++) {
        theta = i * (2*Math.PI / n);
        /*******************************
        * 変換前の内接円
        *******************************/
        y0 = a*y1 / (a - x1);
        r_in = Math.sqrt(a**2 + y0**2);
        // x座標とy座標を計算
        x = r_in * Math.cos(theta);
        y = r_in * Math.sin(theta) + y0;
        // 配列に格納（点線にするため、一定間隔でプロット対象から外す）
        if (i % 5 == 0) {
          plot_data_inner_circle.push({x,y});
        }
       
        /*******************************
        * 変換前の外接円
        *******************************/
        // 外接円の半径を算出
        r_out = Math.sqrt((a - x1)**2 + y1**2);

        // x座標とy座標を計算
        x = r_out * Math.cos(theta) + x1;
        y = r_out * Math.sin(theta) + y1;
        // 配列に格納
        plot_data_outer_circle.push({x,y});

        /*******************************
        * ジューコフスキー変換後
        *******************************/
        common_term = a**2 / (r_out**2 + x1**2 + y1**2 + 2*r_out*(x1*Math.cos(theta) + y1*Math.sin(theta))); // 共通部分

        // x座標とy座標を計算
        x = r_out * Math.cos(theta) + x1 + common_term*(r_out*Math.cos(theta) + x1);
        y = r_out * Math.sin(theta) + y1 - common_term*(r_out*Math.sin(theta) + y1);

        // 配列に格納
        plot_data_jukovski.push({x,y});
    }

    /*******************************
    * canvas にグラフを表示
    *******************************/
    // var w = $('.canvas-container').width();
    var h = $('.canvas-container').height();
    $('#canvas_1').attr('width', h);
    $('#canvas_1').attr('height', h);
    $('#canvas_2').attr('width', h);
    $('#canvas_2').attr('height', h);

    // canvas_1
    var ctx1 = document.getElementById('canvas_1').getContext('2d');
    myChart1 = new Chart(ctx1, {
    type: 'scatter',
        data: {
            datasets: [
                {
                    type: 'scatter',
                    data: plot_data_inner_circle,
                    // label: 'n step development',
                    fill: false,
                    borderColor: 'rgba(0,0,0,0)',
                    pointRadius: 0.5,
                    pointBorderColor: 'black'
                },
                {
                    type: 'scatter',
                    data: plot_data_outer_circle,
                    // label: 'n step development',
                    fill: false,
                    borderColor: 'rgba(0,0,0,0)',
                    pointRadius: 0.5,
                    pointBorderColor: 'black'
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                        ticks: {
                            min: -3*a,
                            max: 3*a
                        }
                },
                y: {
                    ticks: {
                        min: -3*a,
                        max: 3*a
                    }
                }
            },
            legend: {
                display: false
            }
        }
    });

    // canvas_2
    var ctx2 = document.getElementById('canvas_2').getContext('2d');
    myChart2 = new Chart(ctx2, {
        type: 'scatter',
        data: {
            datasets: [
                {
                    type: 'scatter',
                    data: plot_data_jukovski,
                    // label: 'n step development',
                    fill: false,
                    borderColor: 'rgba(0,0,0,0)',
                    pointRadius: 0.5,
                    pointBorderColor: 'black'
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    ticks: {
                        min: -3*a,
                        max: 3*a
                    }
                },
                y: {
                    ticks: {
                        min: -3*a,
                        max: 3*a
                    }
                }
            },
            legend: {
            display: false
            }
        }
    });
};



// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     host: window.location.hostname + ':6001' // .envのREVERB_PORTに合わせて
// });

// console.log("Echo is set up");

// window.Echo.channel('chat-channel')
//     .listen('.message.sent', (e) => {
//         const chatBox = document.getElementById('chat-box');
//         chatBox.innerHTML += `<p><strong>${e.message.user_id}:</strong> ${e.message.message}</p>`;
//     });
