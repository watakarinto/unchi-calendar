/* ---------- キャラクター作成画面 ---------- */

// プレビュー画像の座標プリセットを作成
let xy = [];
for(let i = 0; i <= 7; i++) {
  xy[i] = -256 * i;
}
// 形の選択肢の画像の座標プリセットを作成
let xy_min = [];
for(let i = 0; i <= 7; i++) {
  xy_min[i] = -128 * i;
}
// 左のプレビュー画像を格納
let preview = document.getElementById("unchi_character");

// 形を変更する関数
function click_shape(clicked, id) {
  let y = id.substr(12, 1); // idの"shape_button1"を取得し最後の数字だけを格納(切り分け作業)
  // どの色が選択されているかを調べる
  let j;
  for(let i = 0; i <= 7; i++) {
    color = document.getElementById("pallet_button" + i).checked;
    if(color) {
      j = i;
      break;
    } else {
      j = 1; // 標準色の茶色にする
    }
  }
  // プレビューに反映
  preview.style.backgroundPosition = xy[j] + "px " + xy[y] + "px";
}

// 色を変更する関数
function click_pallet(clicked, id) {
  let shape_content = document.getElementsByClassName("shape_content");
  let x = id.substr(13, 1); // idの"pallet_button1"を取得し最後の数字だけを格納(切り分け作業)
  let j;
  // 形の選択肢に反映
  for(let i = 0; i <= 7; i++) {
    shape_content[i].style.backgroundPosition = xy_min[x] + "px " + xy_min[i] + "px";
  }
  // どの形が選択されているかを調べる
  for(let i = 0; i <= 7; i++) {
    shape = document.getElementById("shape_button" + i).checked;
    if(shape) {
      j = i;
      break;
    } else {
      j = 0;
    }
  }
  // プレビューに反映
  preview.style.backgroundPosition = xy[x] + "px " + xy[j] + "px";
}


// 赤ちゃんの時のキャラクター表示
if(age < 0) {
  let adult_unchi = document.getElementsByClassName("shape_content");
  let baby_unchi = document.getElementById("shape7");
  let baby_check = document.getElementById("shape_button7");
  let tab_amount = document.getElementById("tab_amount");
  let amount_text = document.getElementsByClassName("amount_text");
  let guide_table = document.getElementById("character_guide_wrapper");
  // 子どものうんちを表示
  baby_unchi.style.display = "inline-block";
  baby_check.checked = true;
  // 大人のうんちを非表示
  for(i = 0; i < 7; i++) {
    adult_unchi[i].style.display = "none";
  }
  // プレビューを赤ちゃんキャラクターにする
  preview.style.backgroundPosition = xy[1] + "px " + xy[7] + "px";
  // キャラクターの説明を非表示
  guide_table.style.display = "none";

  
  // 「りょう」のタブを「かたさ」のタブに変更
  tab_amount.innerHTML = "かたさ";
  // 「かたさ」の選択肢に変更
  amount_text[0].innerHTML = "1.みずっぽい";
  amount_text[1].innerHTML = "2.ふつう";
  amount_text[2].innerHTML = "3.かたい";
}
 
 
