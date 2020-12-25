// 結果画面のキャラを表示
// 画像の座標を格納
let xy = [];
for(let i = 0; i <= 7; i++) {
  xy[i+1] = -256 * i;
}
// キャラ画像のidを取得
let preview = document.getElementById("character_img");
let y = unchi_data[0]; // 形のデータ
let x = unchi_data[1]; // 色のデータ
// プレビューに反映
preview.style.backgroundPosition = xy[x] + "px " + xy[y] + "px";



// 赤ちゃんの場合
if(age < 0) {
  let none = document.getElementsByClassName("none");
  let hardness = document.getElementsByClassName("hardness");
  // 「かたさ」を表示
  hardness[0].style.display = "block";
  // 「かたち」「りょう」を非表示
  none[0].style.display = "none";
  none[1].style.display = "none";
}