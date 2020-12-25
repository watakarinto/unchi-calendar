/* ---------- カレンダー：ポップアップを作成 ---------- */
if(popup_php == "popup") {
  // クリックしたときのポップアップ
  let popup = document.getElementById("js_popup");
  // ポップアップを表示する
  popup.classList.add("is_show");
  let blackBg = document.getElementById("js_black_bg");
  let closebutton = document.getElementById("js_close_button");
  closePopUp(blackBg);
  closePopUp(closebutton);
  // クリックされたら表示にする
  function closePopUp(elem) {
    if(!elem) return;
    elem.addEventListener("click", function() {
      popup.classList.remove("is_show");
    });
  }

  // ポップアップのキャラ画面を表示
  // 画像の座標を格納
  let xy = [];
  for(let i = 0; i <= 7; i++) {
    xy[i+1] = -256 * i;
  }
  // キャラ画像のidを取得
  let preview = document.getElementById("popup_inner_img");
  let y = unchi_data[click_date][0][0]; // 形のデータ
  let x = unchi_data[click_date][0][1]; // 色のデータ
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


}