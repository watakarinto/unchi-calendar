<?php
  session_start();
  // セッションが切れていたらlogin.phpに戻す
  if(!isset($_SESSION["logined"])){
    header("Location: ../unchi_calendar/login.php");
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
  $result_date = date("Y-m-d", strtotime("-10 day"));


  // コメントの取得
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // echo('接続しました → ');
  } catch(PDOException $e) {
    die('接続エラー：' . $e->getMessage());
  }
  // トランザクションの例外処理
  try {
    $pdo->beginTransaction();
    // SQL文(プリペアードステートメント)を準備
    // プレースホルダは、「:フィールド名」を推奨
    $sql = 'select comment from comment;';
    // ステートメントハンドラを準備
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':date', $date, PDO::PARAM_STR);
    // プリペアードステートメントを実行
    $stmh->execute();
    // エラーが出た場合、例外処理でロールバックする
    // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
    $pdo->commit();
  } catch(PDOException $e) {
    die('トランザクションエラー：' . $e->getMessage());
  }
  // 一致している人がいるかどうか
  $counter = 1;
  while ($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
    $comment_data[$counter] = $row["comment"];
    $counter++;
  }

  
  // 評価の計算
  if($age > 0) {
    $score_text = "score";
    // 大人の評価
    // 茶色
    if($color == 2) {
      // 普通便
      if($shape == 4) {
        if($amount == 2) {
          $score = 4;
          $comment = 1;
        } else {
          $score = 3;
          $comment = 2;
        }
      // やや硬い便
      } else if($shape == 3) {
        $score = 3;
        $comment = 3;
      // やや柔らかい便
      } else if($shape == 5) {
        $score = 3;
        $comment = 4;
      // 硬い便
      } else if($shape == 2) {
        $score = 2;
        $comment = 17;
      // 泥状便
      } else if($shape == 6) {
        $score = 2;
        $comment = 20;
      // コロコロ便
      } else if($shape == 1) {
        $score = 1;
        $comment = 23;
      // 水様便
      } else if($shape == 7) {
        $score = 1;
        $comment = 26;
      }
    // 黄褐色
    } else if($color == 1) {
      // 普通便
      if($shape == 4) {
        $score = 3;
        $comment = 5;
      // やや硬い便
      } else if($shape == 3) {
        $score = 3;
        $comment = 6;
      // やや柔らかい便
      } else if($shape == 5) {
        $score = 3;
        $comment = 7;
      // 硬い便
      } else if($shape == 2) {
        $score = 2;
        $comment = 17;
      // 泥状便
      } else if($shape == 6) {
        $score = 2;
        $comment = 20;
      // コロコロ便
      } else if($shape == 1) {
        $score = 1;
        $comment = 23;
      // 水様便
      } else if($shape == 7) {
        $score = 1;
        $comment = 26;
      }
    // こげ茶色
    } else if($color == 3) {
      // 普通便
      if($shape == 4) {
        $score = 3;
        $comment = 8;
      // やや硬い便
      } else if($shape == 3) {
        $score = 3;
        $comment = 9;
      // やや柔らかい便
      } else if($shape == 5) {
        $score = 3;
        $comment = 10;
      // 硬い便
      } else if($shape == 2) {
        $score = 2;
        $comment = 17;
      // 泥状便
      } else if($shape == 6) {
        $score = 2;
        $comment = 20;
      // コロコロ便
      } else if($shape == 1) {
        $score = 1;
        $comment = 23;
      // 水様便
      } else if($shape == 7) {
        $score = 1;
        $comment = 26;
      }
    // 緑色
    } else if($color == 7) {
      // 普通便
      if($shape == 4) {
        $score = 3;
        $comment = 11;
      // やや硬い便
      } else if($shape == 3) {
        $score = 3;
        $comment = 12;
      // やや柔らかい便
      } else if($shape == 5) {
        $score = 3;
        $comment = 13;
      // 硬い便
      } else if($shape == 2) {
        $score = 2;
        $comment = 18;
      // 泥状便
      } else if($shape == 6) {
        $score = 2;
        $comment = 21;
      // コロコロ便
      } else if($shape == 1) {
        $score = 1;
        $comment = 24;
      // 水様便
      } else if($shape == 7) {
        $score = 1;
        $comment = 27;
      }
    // 白色
    } else if($color == 8) {
      // 普通便
      if($shape == 4) {
        $score = 3;
        $comment = 14;
      // やや硬い便
      } else if($shape == 3) {
        $score = 3;
        $comment = 15;
      // やや柔らかい便
      } else if($shape == 5) {
        $score = 3;
        $comment = 16;
      // 硬い便
      } else if($shape == 2) {
        $score = 2;
        $comment = 19;
      // 泥状便
      } else if($shape == 6) {
        $score = 2;
        $comment = 22;
      // コロコロ便
      } else if($shape == 1) {
        $score = 1;
        $comment = 25;
      // 水様便
      } else if($shape == 7) {
        $score = 1;
        $comment = 28;
      }
    // 赤色
    } else if($color == 4) {
      $score = 0;
      $comment = 29;
    // 黒色
    } else if($color == 5) {
      $score = 0;
      $comment = 30;
    // 灰色
    } else if($color == 6) {
      $score = 0;
      $comment = 31;
    }
  // 1歳未満の評価
  } else {
    $score_text = "score_baby";
    // 乳児のamountは「みずっぽい」,「ふつう」,「かたい」
    // scoreは「心配」,「ちょっと心配」,「心配なし」
    if($age >= -4 && $age <= 0) {
      // 黄色系or緑色
      if($color <= 3 || $color == 7) {
        if($amount <= 2) {
          $score = 2;
          $comment = 32;
        } else if($amount == 3) {
          $score = 1;
          $comment = 33;
        }
      // 赤色
      } else if($color == 4) {
        $score = 0;
        $comment = 34;
      // 黒色
      } else if($color == 5) {
        $score = 0;
        $comment = 35;
      // 白系
      } else if($color == 6 || $color == 8) {
        $score = 0;
        $comment = 36;
      }
    } else if($age >= -8 && $age <= -5) {
      // 黄色系or緑色
      if($color <= 3 || $color == 7) {
        if($amount <= 2) {
          $score = 2;
          $comment = 37;
        } else if($amount == 3) {
          $score = 1;
          $comment = 38;
        }
      // 赤色
      } else if($color == 4) {
        $score = 0;
        $comment = 39;
      // 黒色
      } else if($color == 5) {
        $score = 0;
        $comment = 40;
      // 白系
      } else if($color == 6 || $color == 8) {
        $score = 0;
        $comment = 41;
      }
    } else if($age >= -12 && $age <= -9) {
      // 黄色系or緑色
      if($color <= 3 || $color == 7) {
        if($amount == 2) {
          $score = 2;
          $comment = 42;
        } else if($amount == 3) {
          $score = 1;
          $comment = 43;
        } else {
          $score = 1;
          $comment = 44;
        }
      // 赤色
      } else if($color == 4) {
        $score = 0;
        $comment = 45;
      // 黒色
      } else if($color == 5) {
        $score = 0;
        $comment = 46;
      // 白系
      } else if($color == 6 || $color == 8) {
        $score = 0;
        $comment = 47;
      }
    }
  }

  

  if(!empty($_SESSION["from_character"])) {
    // 評価結果をすべてデータベースに追加する
    try {
      $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
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
    $_SESSION["from_character"] = FALSE;
  }

  
?><!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/responsive.css">
  <title>うんちカレンダー</title>
</head>
<body>
  <header>
    <div class="header_left">
      <a href="../unchi_calendar/calendar.php"><img class="logo" src="./img/logo.png"></a>
    </div>
    <div class="header_right">
      <form action="login.php" method="post" name="form_logout">
        <input type="hidden" name="logout">
        <a href="javascript:form_logout.submit()">ログアウト</a>
      </form>
      <a href="../unchi_calendar/account.php"><?php echo($_SESSION["user_name"]); ?></a>
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
      <div class="result_texts_frame">
        <h3 class="popup_date"><i class="far fa-calendar-alt"></i> ： <?php echo($result_date); ?></h3>
        <p>ひょうか： <?php echo($unchi_info[$score_text][$score]); ?></p>
        <p class="none">かたち： <?php echo($unchi_info["shape"][$shape]); ?></p>
        <p>いろ： <?php echo($unchi_info["color"][$color]); ?></p>
        <p class="none">りょう： <?php echo($unchi_info["amount"][$amount]); ?></p>
        <p class="hardness">かたさ：<?php echo($unchi_info["hardness"][$amount]); ?></p>
      </div>
      <a href="#" class="character_img" id="character_img"></a>
      <div class="comment_frame">
        <div class="comment comment_left"><p>コメント： </p></div>
        <p class="comment comment_right"><?php echo($comment_data[$comment]); ?></p>
      </div>
      <div>
        <a class="button" href="../unchi_calendar/calendar.php">カレンダーに戻る</a>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="link">
      <a class="footer_logo_a" href="../unchi_calendar/calendar.php"><i class="footer_logo far fa-calendar-alt fa-lg"></i></a>
      <img class="gt" src="./img/gt.png" alt="だいなり"><p>今日のうんち</p><img class="gt" src="./img/gt.png" alt="だいなり"><p>結果発表</p>
    </div>
    <div class="source">
      <a href="../unchi_calendar/references.php">参考文献一覧</a>
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