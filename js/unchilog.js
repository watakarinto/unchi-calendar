/* ---------- うんちグラフの作成 ---------- */

// デバッグ用(consoleに表示)
// for(let i = 0; i < date.length; i++) {
//   console.log(date[i][0] + " 評価：" + date[i][1]);
// }

// dateの中身のイメージ
// 降順に注意。必要であれば昇順にして。
// date[
//   ["2020-12-21", 1], ["2020-12-17", 4], ["2020-12-13", 2], ["2020-12-05", 3]
// ];
/*var datelist = new Array(date.length);
var datalist = new Array(date.length);

for(let i = date.length-1; i >= 0; i--){
  datelist[i] = date[i][0];
  datalist[i] = date[i][1];
}*/


// 読み込み時に実行
log(7);

function log(num) {
  selecter = num; // 1週間か1ヶ月の切り替え変数
  var datelist = [];
  var datalist = [];
  let value;
  let max = 4;

  // 年齢により最大値を調整
  if(age < 0) {
    max = 2;
  }

  for(let i = selecter - 1; i >= 0; i--){
    let dt = new Date();
    dt.setDate(dt.getDate() - i); // i日引いた日付に設定
    let y = dt.getFullYear();                      // 年を取得
    let m = ("0" + (dt.getMonth() + 1)).slice(-2); // 月を取得
    let d = ("0" + dt.getDate()).slice(-2);        // 日を取得
    let date_js = y + "-" + m + "-" + d; // 年月日を合わせる
    // ラベルに日付を格納
    datelist.push(date_js);
    // ラベルの日付と一致したらデータリストに格納
    for(let j = 0; j < date.length; j++) {
      if(date[j][0] == date_js) {
        value = (date[j][1]);
        break;
      } else {
        value = null;
      }
    }
    datalist.push(value);
  }
  
  
  var context = document.getElementById('line-chart').getContext('2d');
  var line_chart = new Chart(context, {
    type:'line', // グラフのタイプを指定
    data:{
      labels:datelist/*['12月1日','12月2日','12月3日','12月4日',]*/, // グラフ下部のラベル
      datasets:[
        {label:'評価',  // データのラベル
          data: datalist, // グラフ化するデータの数値
          fill:false, // グラフの下部を塗りつぶさない
          borderColor:'rgb(54, 162, 235)', // 線の色
          pointStyle: "circle",            // 点のスタイル 円
          pointRadius: 6,                  // 点の半径
          backgroundColor: "yellow" }      // 点の塗りつぶし色
      ]
    },
    options:{
      maintainAspectRatio: false,
      scales:{
        yAxes:[{
          ticks:{
            min:0, // グラフの最小値
            max:max, // グラフの最大値
            stepSize: 1 // Y軸のメモリ間隔 
          }
        }]
      },
      elements:{
        line:{
          tension: 0 // 線グラフのベジェ曲線を無効にする
        }
      }
    }
  });
}

