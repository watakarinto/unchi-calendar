/* ---------- ログインと登録ボタンの表示切り替え ---------- */
document.addEventListener("DOMContentLoaded", function() {
  let form1 = document.getElementById("login_form");
  let form2 = document.getElementById("add_form");
  let button1 = document.getElementById("button1");
  let button2 = document.getElementById("button2");
  
  if(button1 != null) {
    button1.addEventListener("click", function() {
      form1.style.display = "inline-block";
      form2.style.display = "none";
    });
    button2.addEventListener("click", function() {
      form1.style.display = "none";
      form2.style.display = "inline-block";
    });
  }
});


/* ---------- ログインページの年齢チェックボックス ---------- */
function baby_check(checked) {
  let div_age = document.getElementById("div_age");
  let select_age = document.getElementById("select_age");
  let div_age_baby = document.getElementById("div_age_baby");
  let select_age_baby = document.getElementById("select_age_baby");
  if(checked) {
    div_age.style.display = "none";
    select_age.disabled = true;
    div_age_baby.style.display = "inline-block";
    select_age_baby.disabled = false;
  } else {
    div_age.style.display = "inline-block";
    select_age.disabled = false;
    div_age_baby.style.display = "none";
    select_age_baby.disabled = true;
  }
}