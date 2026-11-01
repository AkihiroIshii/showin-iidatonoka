import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import $ from 'jquery';

$(function () {
    $('#display-button').on('click', function () {
        switch (window.pageConfig?.jsAction) {
            case 'matrix_notation':
                matrix_notation();
                break;

        }
    });
});

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
