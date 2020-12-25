<?php
  session_start();
  // セッションが切れていたらlogin.phpに戻す
  if(!isset($_SESSION["logined"])){
    header("Location: http://localhost/unchi_calendar/login.php");
    exit;
  }

  // カレンダーの月の初期化
  $_SESSION["reduce_add_month"] = 0;

  // 送信されてきたキャラ情報を格納
  $result_date = date("Y-m-d");
  $shape = $_SESSION["shape"];
  $color = $_SESSION["color"];
  $amount = $_SESSION["amount"];
  // うんち配列を取得
  $unchi_info = $_SESSION["unchi_info"];
  // 年齢の取得
  $age = $_SESSION["now_age"];



  // デバッグ用の日付
  $result_date = date("Y-m-d", strtotime("0 day"));



  // 評価の計算
  // 大人の評価
  if($age > 0) {
    if($shape == 4 && $color == 2 && $amount == 2) {
      $score = 4;
    } else {
      if($shape >= 3 && $shape <= 5 && ($color <= 3 || $color == 7 || $color == 8) && $amount >= 2) {
        $score = 3;
      } else if(($shape == 2 || $shape == 6) && ($color <= 3 || $color == 7 || $color == 8) && $amount >= 2) {
        $score = 2;
      } else if(($shape == 1 || $shape == 7) && ($color <= 3 || $color == 7 || $color == 8)) {
        $score = 1;
      } else if($color >= 4 || $color <= 6) {
        $score = 0;
      }
    }
  // 1歳未満の評価
  } else {
    // 乳児のamountは「みずっぽい」,「ふつう」,「かたい」
    // scoreは「心配」,「ちょっと心配」,「心配なし」
    if($age >= -4 && $age <= 0) {
      if($color <= 3 || $color == 7) {
        if($amount <= 2) {
          $score = -3;
        } else if($amount == 3) {
          $score = -2;
        }
      } else if(($color >= 4 && $color <= 6) || $color == 8) {
        $score = -1;
      }
    } else if($age >= -8 && $age <= -5) {
      if($color <= 3 || $color == 7) {
        if($amount <= 2) {
          $score = -3;
        } else if($amount == 3) {
          $score = -2;
        }
      } else if(($color >= 4 && $color <= 6) || $color == 8) {
        $score = -1;
      }
    } else if($age >= -12 && $age <= -9) {
      if($color <= 3 || $color == 7) {
        if($amount == 2) {
          $score = -3;
        } else {
          $score = -2;
        }
      } else if(($color >= 4 && $color <= 6) || $color == 8) {
        $score = -1;
      }
    }
  }

  try {
    $pdo = new PDO('mysql:host=localhost;dbname=sampledb;charset=utf8', 'sample','password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch(PDOException $e) {
    die('接続エラー：' . $e->getMessage());
  }
  // データベースに登録
  try {
    $pdo->beginTransaction();
    // SQL文(プリペアードステートメント)を準備
    $sql = 'insert into log (timelog, user_id, katasa, iro, ryo, result)';
    $sql .= ' values (:date, :id, :shape, :color, :amount, :result);';
    // ステートメントハンドラを準備
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':date', $result_date, PDO::PARAM_STR);
    $stmh->bindValue(':id', $_SESSION["user_id"], PDO::PARAM_STR);
    $stmh->bindValue(':shape', $shape, PDO::PARAM_STR);
    $stmh->bindValue(':color', $color, PDO::PARAM_STR);
    $stmh->bindValue(':amount', $amount, PDO::PARAM_STR);
    $stmh->bindValue(':result', $score, PDO::PARAM_STR);
    $stmh->execute();
    $pdo->commit();
  } catch(PDOException $e) {
    die('トランザクションエラー：' . $e->getMessage());
  }


  
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
      <h1>結果発表！</h1>
    </div>
  </div>
  <div class="result_wrapper">
    <div class="container">
      <h2>～今日のうんちの評価～</h2>
      <!-- <h3>--- 下記よりデバッグ用の表示 ---</h3>
      <h3>登録年齢</h3>
      <p><?php echo($_SESSION["now_age"]); ?></p>
      <h3>---------------</h3> -->
      <div class="result_texts_frame">
        <h3 class="result_texts popup_date"><i class="far fa-calendar-alt"></i> ： <?php echo($result_date); ?></h3>
        <p class="result_texts unchi_data">ひょうか： <?php echo($unchi_info["score"][$score]); ?></p>
        <p class="result_texts unchi_data none">かたち： <?php echo($unchi_info["shape"][$shape]); ?></p>
        <p class="result_texts unchi_data">いろ： <?php echo($unchi_info["color"][$color]); ?></p>
        <p class="result_texts unchi_data none">りょう： <?php echo($unchi_info["amount"][$amount]); ?></p>
        <p class="unchi_data hardness">かたさ：<?php echo($unchi_info["hardness"][$amount]); ?></p>
      </div>
      <a href="#" class="character_img" id="character_img"></a>
      <div>
        <p class="result_texts unchi_data">コメント：<?php  ?></p>
      </div>
      <a class="button" href="http://localhost/unchi_calendar/calendar.php">カレンダーに戻る</a>
    </div>
  </div>

  <footer class="footer">
    <div class="link">
      <a class="footer_logo_a" href="http://localhost/unchi_calendar/calendar.php"><i class="footer_logo far fa-calendar-alt fa-lg"></i></a>
      <img class="gt" src="./img/gt.png" alt="だいなり"><p>今日のうんち</p><img class="gt" src="./img/gt.png" alt="だいなり"><p>結果発表</p>
    </div>
    <div class="source">
    </div>
  </footer>

  <script>
    let age = <?php echo($age); ?>;
    let unchi_data = new Array();
    unchi_data[0] = <?php echo($_SESSION["shape"]); ?>;
    unchi_data[1] = <?php echo($_SESSION["color"]); ?>;
  </script>
  <script type="text/javascript" src="js/result.js"></script>
</body>
</html>