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
 

?><!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
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
      <h1>参考文献一覧</h1>
    </div>
  </div>
  
  <div class="references_wrapper">
    <div class="container">
      <div class="references_left">
        <p>・おおたわ史絵『今日のうんこ』(2012) 文芸社</p>
        <p>・辨野義巳『ウンコミュニケーションBOOK』(2006) ぱる出版</p>
        <p>・古川元宣、古川宣明『赤ちゃんのうんちとおしっこ　便・尿でみる病気と排せつのしつけ』(1989) 池田書店</p>
        <p>・吉原秀則 編集『うんち・おしっこ・おちんちん百科』(1999) 大日本印刷</p>
        <p>・辨野義巳、加藤篤『元気のしるし　朝うんち』(2010) 図書印刷</p>
      </div>
      <div class="references_right">
        <a href="#"></a>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="link">
      <a class="footer_logo_a" href="http://localhost/unchi_calendar/calendar.php"><i class="footer_logo far fa-calendar-alt fa-lg"></i></a>
      <img class="gt" src="./img/gt.png" alt="だいなり"><p>参考文献一覧</p>
    </div>
    <div class="source">
    </div>
  </footer>

</body>