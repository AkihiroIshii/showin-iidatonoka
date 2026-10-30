<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 {{ $unitname }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto p-6">
        <div class="mx-auto px-6">

            <div class="relative">
                <!-- 単元一覧画面へ -->
                <a href="{{route('workbook.unitbasedlist')}}" class="text-blue-600 font-bold">単元一覧画面へ</a>

                <form method="GET" action="{{ url()->current() }}" class="inline-block">
                    <!-- 和訳のみなど絞る場合はチェックボックスを表示 -->
                    @isset($subject)
                        <div class="flex gap-4">
                        @if ($subject == "eng")
                            <label class="px-6">
                                <input type="checkbox" name="ja" value="1"
                                    {{ request('ja') ? 'checked' : '' }}>
                                和訳
                            </label>

                            <label>
                                <input type="checkbox" name="en" value="1"
                                    {{ request('en') ? 'checked' : '' }}>
                                英訳
                            </label>
                        @elseif ($subject == "kanji")
                            <label class="px-6">
                                <input type="checkbox" name="r" value="1"
                                    {{ request('r') ? 'checked' : '' }}>
                                読み
                            </label>

                            <label>
                                <input type="checkbox" name="w" value="1"
                                    {{ request('w') ? 'checked' : '' }}>
                                書き
                            </label>
                        @elseif ($subject == "science")
                            <label class="px-6">
                                <input type="checkbox" name="term" value="1"
                                    {{ request('term') ? 'checked' : '' }}>
                                用語
                            </label>

                            <label>
                                <input type="checkbox" name="calc" value="1"
                                    {{ request('calc') ? 'checked' : '' }}>
                                計算
                            </label>
                        @elseif ($subject == "unite")
                            <label class="px-6">
                                <input type="checkbox" name="unite" value="1"
                                    {{ request('unite') ? 'checked' : '' }}>
                                結合
                            </label>

                            <label>
                                <input type="checkbox" name="separate" value="1"
                                    {{ request('separate') ? 'checked' : '' }}>
                                分解
                            </label>
                        @elseif ($subject == "custom")
                            <label class="px-6">
                                <input type="checkbox" name="flag1" value="1"
                                    {{ request('flag1') ? 'checked' : '' }}>
                                {{ $flags['flag1']}}
                            </label>

                            <label>
                                <input type="checkbox" name="flag2" value="1"
                                    {{ request('flag2') ? 'checked' : '' }}>
                                {{ $flags['flag2'] }}
                            </label>
                        @endif
                        </div>
                    @endisset

                    <button type="submit" class="absolute left-1/2 -translate-x-1/2 top-0 inline-block p-2 rounded shadow bg-blue-200 font-bold">
                        次の問題
                    </button>
                </form>
            </div>

            <div class="text-center mt-4 mb-4">
                <div class="inline-block text-center leading-[2] font-klee text-lg">
                    {{ $question['q'] }}
                </div>
            </div>
            <button id="display_button" type="button">表示</button></div>
            ---------- 表示ここから ----------
            <div id="result" class="horizontal-scroll"></div>
            ---------- 表示ここまで ----------
            <div>
                <details class="text-center">
                    <summary class="text-red-400 font-bold">答え</summary>
                    <div class="inline-block items-center text-center m-4 p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200 font-klee text-lg">
                        {!! $question['a'] !!}
                    </div>
                    ＜解説＞
                    <div class="inline-block leading-[3] font-klee text-lg">
                        <p class="m-4">{{ $question['e'] }}</p>
                    </div>

                </details>                    
            </div>
        </div>
    </div>


<script type="text/javascript">
    function a() {
        // 入力パラメータを取得して数値に変換
        var n = Number($("#para_n").val());
        
        // n < 1 または n > 5 の場合は警告メッセージを表示して処理終了
        if ( n < 1 | n > 5 ) {
            alert("nは1〜5の整数を設定してください");
            exit;
        }
        
        // ---------- 展開式の文字列を生成 ----------
        // A
        var str_A = "\\begin\{pmatrix\} \n";
        for ( var i = 1; i <= n; i++ ) {
            for ( var j = 1; j <= n; j++ ) {
                str_A += "a_{" + i + "" + j + "} & "
            }
            // slice(0, -2)で展開式末尾の"& "を削除
            str_A = str_A.slice(0, -2);
            // 改行文字追加
            str_A += "\\\\ \n";
        }
        str_A += "\\end\{pmatrix\} \n";
        
        // B
        var str_B = "\\begin\{pmatrix\} \n";
        for ( var i = 1; i <= n; i++ ) {
            for ( var j = 1; j <= n; j++ ) {
                str_B += "b_{" + i + "" + j + "} & "
            }
            str_B = str_B.slice(0, -2);
            str_B += "\\\\ \n";
        }
        str_B += "\\end\{pmatrix\} \n";

        // C
        var str_C = "\\begin\{pmatrix\} \n";
        for ( var i = 1; i <= n; i++ ) {
            for ( var j = 1; j <= n; j++ ) {
                str_C += "c_{" + i + "" + j + "} & "
            }
            str_C = str_C.slice(0, -2);
            str_C += "\\\\ \n";
        }
        str_C += "\\end\{pmatrix\} \n";

        // AB（展開）
        var str_AB1 = "\\begin\{pmatrix\} \n";
        for ( var i = 1; i <= n; i++ ) {
            for ( var j = 1; j <= n; j++ ) {
                for ( var k = 1; k <= n; k++ ) {
                str_AB1 += "a_{" + i + "" + k + "} b_{" + k + "" + j + "} + "
                }
                str_AB1 = str_AB1.slice(0, -2);
                str_AB1 += "& ";
            }
            str_AB1 = str_AB1.slice(0, -2);
            str_AB1 += "\\\\ \n";
        }
        str_AB1 += "\\end\{pmatrix\} \n";

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
        
        $("#result").html("\\begin\{align\} \n");
        $("#result").append("S &= " + str_A + str_B + str_C + "\\\\");
        $("#result").append(" &= " + str_AB1 + str_C + "\\\\");
        $("#result").append(" &= " + str_AB2 + str_C + "\\\\");
        $("#result").append(" &= " + str_ABC1 + "\\\\");
        $("#result").append(" &= " + str_ABC2 + "\\\\");    
        $("#result").append(" &= " + str_ABC3 + "\\\\");
        $("#result").append("\\end\{align\}");
    /*
        // mathJaxを適用する数式を生成
        $("#result").html("\\begin\{align\} \n");
        $("#result").append("\\boldsymbol{S}_{t+" + n + "} = \\boldsymbol{P}^{" + n + "} \\boldsymbol{S}_t" + "\n");
        
        $("#result").append(" = \\begin\{pmatrix\} \n");
        $("#result").append(P_oo + " & " + P_3o + " & " + P_2o + " & " + P_1o + "\\\\ \n");
        $("#result").append(P_o3 + " & " + P_33 + " & " + P_23 + " & " + P_13 + "\\\\ \n");
        $("#result").append(P_o2 + " & " + P_32 + " & " + P_22 + " & " + P_12 + "\\\\ \n");
        $("#result").append(P_o1 + " & " + P_31 + " & " + P_22 + " & " + P_11);
        $("#result").append("\\end\{pmatrix\}^{" + n + "}");
        $("#result").append("\\left( \\begin{array}{c} " + so + " \\\\ " + s3 + " \\\\ " + s2 + " \\\\ " + s1 + " \\end{array} \\right) \\\\")
        
        $("#result").append(" = \\begin\{pmatrix\} \n");
        $("#result").append(Pn_oo + " & " + Pn_3o + " & " + Pn_2o + " & " + Pn_1o + "\\\\ \n");
        $("#result").append(Pn_o3 + " & " + Pn_33 + " & " + Pn_23 + " & " + Pn_13 + "\\\\ \n");
        $("#result").append(Pn_o2 + " & " + Pn_32 + " & " + Pn_22 + " & " + Pn_12 + "\\\\ \n");
        $("#result").append(Pn_o1 + " & " + Pn_31 + " & " + Pn_22 + " & " + Pn_11);
        $("#result").append("\\end\{pmatrix\}");
        $("#result").append("\\left( \\begin{array}{c} " + so + " \\\\ " + s3 + " \\\\ " + s2 + " \\\\ " + s1 + " \\end{array} \\right) \\\\")
        
        $("#result").append(" = \\left( \\begin{array}{c} " + sno + " \\\\ " + sn3 + " \\\\ " + sn2 + " \\\\ " + sn1 + " \\end{array} \\right) \\\\");
        $("#result").append("\\end\{align\}");
    */  
        // id=result の要素をMathJaxで変換
        MathJax.Hub.Queue(["Typeset",MathJax.Hub,"result"]);

    };


    let button = document.getElementById("display_button");
    button.addEventListener("click",a);
</script>

{{-- <script type="text/javascript">
$(function() {
  
  // 表示ボタン押下時
  $(document.getElementById('display_button')).on('click', function() {

    // 入力パラメータを取得して数値に変換
    var n = Number($("#para_n").val());
    
    // n < 1 または n > 5 の場合は警告メッセージを表示して処理終了
    if ( n < 1 | n > 5 ) {
      alert("nは1〜5の整数を設定してください");
      exit;
    }
    
    // ---------- 展開式の文字列を生成 ----------
    // A
    var str_A = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_A += "a_{" + i + "" + j + "} & "
      }
      // slice(0, -2)で展開式末尾の"& "を削除
      str_A = str_A.slice(0, -2);
      // 改行文字追加
      str_A += "\\\\ \n";
    }
    str_A += "\\end\{pmatrix\} \n";
    
    // B
    var str_B = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_B += "b_{" + i + "" + j + "} & "
      }
      str_B = str_B.slice(0, -2);
      str_B += "\\\\ \n";
    }
    str_B += "\\end\{pmatrix\} \n";

    // C
    var str_C = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        str_C += "c_{" + i + "" + j + "} & "
      }
      str_C = str_C.slice(0, -2);
      str_C += "\\\\ \n";
    }
    str_C += "\\end\{pmatrix\} \n";

    // AB（展開）
    var str_AB1 = "\\begin\{pmatrix\} \n";
    for ( var i = 1; i <= n; i++ ) {
      for ( var j = 1; j <= n; j++ ) {
        for ( var k = 1; k <= n; k++ ) {
          str_AB1 += "a_{" + i + "" + k + "} b_{" + k + "" + j + "} + "
        }
        str_AB1 = str_AB1.slice(0, -2);
        str_AB1 += "& ";
      }
      str_AB1 = str_AB1.slice(0, -2);
      str_AB1 += "\\\\ \n";
    }
    str_AB1 += "\\end\{pmatrix\} \n";

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
    
    $("#result").html("\\begin\{align\} \n");
    $("#result").append("S &= " + str_A + str_B + str_C + "\\\\");
    $("#result").append(" &= " + str_AB1 + str_C + "\\\\");
    $("#result").append(" &= " + str_AB2 + str_C + "\\\\");
    $("#result").append(" &= " + str_ABC1 + "\\\\");
    $("#result").append(" &= " + str_ABC2 + "\\\\");    
    $("#result").append(" &= " + str_ABC3 + "\\\\");
    $("#result").append("\\end\{align\}");
/*
    // mathJaxを適用する数式を生成
    $("#result").html("\\begin\{align\} \n");
    $("#result").append("\\boldsymbol{S}_{t+" + n + "} = \\boldsymbol{P}^{" + n + "} \\boldsymbol{S}_t" + "\n");
    
    $("#result").append(" = \\begin\{pmatrix\} \n");
    $("#result").append(P_oo + " & " + P_3o + " & " + P_2o + " & " + P_1o + "\\\\ \n");
    $("#result").append(P_o3 + " & " + P_33 + " & " + P_23 + " & " + P_13 + "\\\\ \n");
    $("#result").append(P_o2 + " & " + P_32 + " & " + P_22 + " & " + P_12 + "\\\\ \n");
    $("#result").append(P_o1 + " & " + P_31 + " & " + P_22 + " & " + P_11);
    $("#result").append("\\end\{pmatrix\}^{" + n + "}");
    $("#result").append("\\left( \\begin{array}{c} " + so + " \\\\ " + s3 + " \\\\ " + s2 + " \\\\ " + s1 + " \\end{array} \\right) \\\\")
    
    $("#result").append(" = \\begin\{pmatrix\} \n");
    $("#result").append(Pn_oo + " & " + Pn_3o + " & " + Pn_2o + " & " + Pn_1o + "\\\\ \n");
    $("#result").append(Pn_o3 + " & " + Pn_33 + " & " + Pn_23 + " & " + Pn_13 + "\\\\ \n");
    $("#result").append(Pn_o2 + " & " + Pn_32 + " & " + Pn_22 + " & " + Pn_12 + "\\\\ \n");
    $("#result").append(Pn_o1 + " & " + Pn_31 + " & " + Pn_22 + " & " + Pn_11);
    $("#result").append("\\end\{pmatrix\}");
    $("#result").append("\\left( \\begin{array}{c} " + so + " \\\\ " + s3 + " \\\\ " + s2 + " \\\\ " + s1 + " \\end{array} \\right) \\\\")
    
    $("#result").append(" = \\left( \\begin{array}{c} " + sno + " \\\\ " + sn3 + " \\\\ " + sn2 + " \\\\ " + sn1 + " \\end{array} \\right) \\\\");
    $("#result").append("\\end\{align\}");
*/  
    // id=result の要素をMathJaxで変換
    MathJax.Hub.Queue(["Typeset",MathJax.Hub,"result"]);

  });
});
</script> --}}
</x-app-layout>