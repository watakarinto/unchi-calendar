<?php
  session_start();
  // セッションが切れていたらlogin.phpに戻す
  if(!isset($_SESSION["logined"])){
    header("Location: http://localhost/unchi_calendar/login.php");
    exit;
  }

  // カレンダーの月の初期化
  $_SESSION["reduce_add_month"] = 0;
  // エラーメッセージの初期化
  $error_msg1 = "";

  // キャラ情報が選択されているかを判定
  if(isset($_POST["submit"])) {
    if(isset($_POST["shapes"]) && isset($_POST["color_pallet"]) && isset($_POST["amounts"])) {
      // 送信されてきたキャラ情報を格納
      $_SESSION["shape"] = $_POST["shapes"];
      $_SESSION["color"] = $_POST["color_pallet"];
      $_SESSION["amount"] = $_POST["amounts"];
      header("Location: http://localhost/unchi_calendar/result.php");
      exit;
    } else {
      $error_msg1 = "キャラクター情報を全て選択してください。";
    }
  }


?><!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet">
  <title>うんちカレンダー</title>
</head>
<body>
  <header>
    <div class="header_left">
      <a href="http://localhost/unchi_calendar/calendar.php"><img class="logo" src="./img/logo.png"></a>
    </div>
    <div class="header_right">
      <form action="login.php" method="post" name="form_logout">
        <input type="hidden" name="logout">
        <a href="javascript:form_logout.submit()">ログアウト</a>
      </form>
      <a href="http://localhost/unchi_calendar/account.php"><?php echo($_SESSION["user_name"]); ?></a>
    </div>
  </header>
  
  <div class="top_wrapper">
    <div class="container">
      <h1>キャラクター作成</h1>
    </div>
  </div>
  <div class="character_wrapper">
    <div class="container">
      <h2>今日のうんちキャラクターを作ろう！</h2>
      <form action="character.php" method="post">
        <div class="character_form_inner">
          <div class="character_frame">
            <a href="#" class="unchi_character" id="unchi_character"></a>
          </div>
          <div class="tabs">
            <input id="shape" type="radio" name="tab_item" checked>
            <label class="tab_item" for="shape">かたち</label>
            <input id="color" type="radio" name="tab_item">
            <label class="tab_item" for="color">いろ</label>
            <input id="amount" type="radio" name="tab_item">
            <label class="tab_item" id="tab_amount" for="amount">りょう</label>
            <!-- 形の選択 -->
            <div class="tab_content" id="shape_content">
              <div class="shapes">
                <input type="radio" name="shapes" id="shape_button0" value="1" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape0" for="shape_button0"></label>
                <input type="radio" name="shapes" id="shape_button1" value="2" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape1" for="shape_button1"></label>
                <input type="radio" name="shapes" id="shape_button2" value="3" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape2" for="shape_button2"></label>
                <input type="radio" name="shapes" id="shape_button3" value="4" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape3" for="shape_button3"></label>
                <input type="radio" name="shapes" id="shape_button4" value="5" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape4" for="shape_button4"></label>
                <input type="radio" name="shapes" id="shape_button5" value="6" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape5" for="shape_button5"></label>
                <input type="radio" name="shapes" id="shape_button6" value="7" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape6" for="shape_button6"></label>
                <input type="radio" name="shapes" id="shape_button7" value="8" onclick="click_shape(this.checked, id);"><label class="shape_content" id="shape7" for="shape_button7"></label>
              </div>
            </div>
            <!-- 色の選択 -->
            <div class="tab_content" id="color_content">
              <div class="color_pallets">
                <input type="radio" name="color_pallet" id="pallet_button0" value="1" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color0" for="pallet_button0"></label>
                <input type="radio" name="color_pallet" id="pallet_button1" value="2" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color1" for="pallet_button1"></label>
                <input type="radio" name="color_pallet" id="pallet_button2" value="3" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color2" for="pallet_button2"></label>
                <input type="radio" name="color_pallet" id="pallet_button3" value="4" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color3" for="pallet_button3"></label>
                <input type="radio" name="color_pallet" id="pallet_button4" value="5" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color4" for="pallet_button4"></label>
                <input type="radio" name="color_pallet" id="pallet_button5" value="6" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color5" for="pallet_button5"></label>
                <input type="radio" name="color_pallet" id="pallet_button6" value="7" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color6" for="pallet_button6"></label>
                <input type="radio" name="color_pallet" id="pallet_button7" value="8" onclick="click_pallet(this.checked, id);"><label class="color_content" id="color7" for="pallet_button7"></label>
              </div>
            </div>
            <!-- 量の選択 -->
            <div class="tab_content" id="amount_content">
              <div class="amounts">
                  <!-- <input type="radio" name="amounts" id="amount_button0" value="1"><label class="amount_content" id="amount0" for="amount_button0"></label>
                  <input type="radio" name="amounts" id="amount_button1" value="2"><label class="amount_content" id="amount1" for="amount_button1"></label>
                  <input type="radio" name="amounts" id="amount_button2" value="3"><label class="amount_content" id="amount2" for="amount_button2"></label> -->
                  <input type="radio" name="amounts" id="amount_button0" value="1"><label class="amount_content" for="amount_button0"><p class="amount_text">1.すくない</p></label>
                  <input type="radio" name="amounts" id="amount_button1" value="2"><label class="amount_content" for="amount_button1"><p class="amount_text">2.ふつう</p></label>
                  <input type="radio" name="amounts" id="amount_button2" value="3"><label class="amount_content" for="amount_button2"><p class="amount_text">3.おおい</p></label>
                </div>
            </div>
          </div>
        </div>
        <p class="error_msg"><?php echo($error_msg1); ?></p>
        <br>
        <button class="submit" type="submit" name="submit">完 了</button>
      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="link">
      <a class="footer_logo_a" href="http://localhost/unchi_calendar/calendar.php"><i class="footer_logo far fa-calendar-alt fa-lg"></i></a>
      <img class="gt" src="./img/gt.png" alt="だいなり"><p>今日のうんち</p>
    </div>
    <div class="source">
    </div>
  </footer>

  <script>let age = <?php echo($_SESSION["now_age"]); ?></script>
  <script type="text/javascript" src="js/character.js"></script>
</body>
</html>