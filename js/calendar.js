/* ---------- ポップアップの内容を表示 ---------- */
function make_inner(counter) {
  // 画像の座標を格納
  let xy = [];
  for(let i = 0; i <= 7; i++) {
    xy[i+1] = -256 * i;
  }
  // キャラ画像のidを取得
  let preview = document.getElementById("popup_inner_img");
  let y = unchi_data[click_date][counter][0]; // 形のデータ
  let x = unchi_data[click_date][counter][1]; // 色のデータ
  // プレビューに反映
  preview.style.backgroundPosition = xy[x] + "px " + xy[y] + "px";

  // ポップアップのテキストの出力
  let popup_contents = document.getElementsByClassName("unchi_data");
  let shape = unchi_info["shape"][unchi_data[click_date][counter][0]];
  let color = unchi_info["color"][unchi_data[click_date][counter][1]];
  let amount;
  let score;
  if(age > 0) {
    amount = unchi_info["amount"][unchi_data[click_date][counter][2]];
    score = unchi_info["score"][unchi_data[click_date][counter][3]];
  } else {
    amount = unchi_info["hardness"][unchi_data[click_date][counter][2]];
    score = unchi_info["score_baby"][unchi_data[click_date][counter][3]];
  }
  popup_contents[0].innerHTML = "ひょうか： " + score;
  popup_contents[1].innerHTML = "かたち： " + shape;
  popup_contents[2].innerHTML = "いろ： " + color;
  popup_contents[3].innerHTML = "りょう： " + amount;
  popup_contents[4].innerHTML = "かたさ： " + amount;

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


/* ---------- ポップアップの内容切り替え ---------- */
let change_counter = 0;
function change_inner(counter) {
  let count = document.getElementById("count");
  change_counter += Number(counter);
  if(change_counter >= unchi_data[click_date].length) {
    change_counter--;
  } else if(change_counter < 0) {
    change_counter = 0;
  }
  make_inner(change_counter);
  count.innerHTML = (change_counter + 1) + "/" + unchi_data[click_date].length;
}


/* ---------- カレンダー：ポップアップの枠を作成 ---------- */
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
    // クリックされたら表示にする(スマホ向け)
    elem.addEventListener("touchstart", function() {
      popup.classList.remove("is_show");
    });
  }
  // ポップアップの内容(一番新しいの)を表示
  make_inner(0);
}