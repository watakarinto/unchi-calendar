<?php
  // セッションはサーバー側にデータを保存
  session_start();

  // アカウントを削除した後に表示
  if(isset($_SESSION["rm_user"])) {
    echo('<script type="text/javascript">window.confirm("アカウントを削除しました。");</script>');
    session_destroy();
  }
  // ログアウトボタンの判定(違うページから飛んできた場合の判定)
  if(isset($_POST["logout"])){
    session_destroy();
  }

  // カレンダーの月の初期化
  $_SESSION["reduce_add_month"] = 0;

  // エラーメッセージの初期化
  $error_msg1 = "";
  $error_msg2 = "";
  
  // ログイン・登録フォームの非表示
  $display_login = "no_display";
  $display_add = "no_display";

  // ログインの判定
  if(isset($_POST["user_name"]) && isset($_POST["pass"])) {
    $user_name = $_POST["user_name"];
    $pass = $_POST["pass"];

    // データベース接続の例外処理
    try {
      // PDOクラスのインスタンスを作成し、データベース接続を行う。
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
      $sql = 'select * from unchiuser';
      $sql .= ' where (user_name = binary :user_name)';
      $sql .= 'and (user_password = binary :pass);';
      // ステートメントハンドラを準備
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':user_name', $user_name, PDO::PARAM_STR);
      $stmh->bindValue(':pass', $pass, PDO::PARAM_STR);
      // プリペアードステートメントを実行
      $stmh->execute();
      // エラーが出た場合、例外処理でロールバックする
      // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
      $pdo->commit();
    } catch(PDOException $e) {
      die('トランザクションエラー：' . $e->getMessage());
    }

    // 一致している人がいるかどうか
    if($stmh->rowCount() == 1) {
      // 一致している場合user_idを取得する
      // データベース接続の例外処理
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
        $sql = 'select * from unchiuser where (user_name = binary :user_name);';
        // ステートメントハンドラを準備
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':user_name', $user_name, PDO::PARAM_STR);
        // プリペアードステートメントを実行
        $stmh->execute();
        while ($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
          $_SESSION["user_id"] = $row["id"];
          $_SESSION["user_age"] = $row["user_age"];
          $_SESSION["register_date"] = $row["register"];
        }
      } catch(PDOException $e) {
        die('トランザクションエラー：' . $e->getMessage());
      }

      // ログインを許可する
      $_SESSION["logined"] = TRUE;
      $_SESSION["user_name"] = $user_name;
      header("Location: ../unchi_calendar/calendar.php");
      exit;
    } else {
      $_SESSION["logined"] = FALSE;
      $error_msg1 = "ユーザー名またはパスワードが違います。";
      $display_login = "display";
    }
  }


  // 新規アカウントの登録
  if(isset($_POST["new_user_name"])) {
    $new_user_name = $_POST["new_user_name"];
    $new_pass = $_POST["new_pass"];
    $confirm_pass = $_POST["confirm_pass"];
    $user_age = $_POST["age"];
    $register_date = date("Y-m-d");
    // 空白文字を削除
    $new_user_name = str_replace(array(" ", "　"), "", $new_user_name);
    $new_pass = str_replace(array(" ", "　"), "", $new_pass);
    $confirm_pass = str_replace(array(" ", "　"), "", $confirm_pass);
    // 空でなければ実行
    if(!empty($new_user_name) && !empty($new_pass) && !empty($confirm_pass) && $user_age != "") {
      // データベース接続の例外処理
      try {
        // PDOクラスのインスタンスを作成し、データベース接続を行う。
        $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      } catch(PDOException $e) {
        die('接続エラー：' . $e->getMessage());
      }
      // トランザクションの例外処理
      try {
        $pdo->beginTransaction();
        // SQL文(プリペアードステートメント)を準備
        // プレースホルダは、「:フィールド名」を推奨
        $sql = 'select * from unchiuser';
        $sql .= ' where (user_name = :new_user_name);';
      
        // ステートメントハンドラを準備
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':new_user_name', $new_user_name, PDO::PARAM_STR);
      
        // プリペアードステートメントを実行
        $stmh->execute();
        // エラーが出た場合、例外処理でロールバックする
        // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
        $pdo->commit();
      } catch(PDOException $e) {
        die('トランザクションエラー：' . $e->getMessage());
      }
      // 一致している人がいるかどうか
      if($stmh->rowCount() >= 1) {
        $error_msg2 = "ユーザー名が既に使用されています。";
        $display_add = "display";
      } else if($new_pass != $confirm_pass) {
        $error_msg2 = "パスワードが違います。";
        $display_add = "display";
      } else {
        // ユーザーの登録
        try {
          $pdo->beginTransaction();
          // SQL文(プリペアードステートメント)を準備
          $sql = 'insert into unchiuser (user_name, user_password, user_age, register)';
          $sql .= ' values (:new_user_name, :new_pass, :user_age, :register);';
        
          // ステートメントハンドラを準備
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(':new_user_name', $new_user_name, PDO::PARAM_STR);
          $stmh->bindValue(':new_pass', $new_pass, PDO::PARAM_STR);
          $stmh->bindValue(':user_age', $user_age, PDO::PARAM_STR);
          $stmh->bindValue(':register', $register_date, PDO::PARAM_STR);
        
          // プリペアードステートメントを実行
          $stmh->execute();
          // エラーが出た場合、例外処理でロールバックする
          // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
          $pdo->commit();
        } catch(PDOException $e) {
          die('トランザクションエラー：' . $e->getMessage());
        }
        
        // ユーザーidの取得
        try {
          $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
          die('接続エラー：' . $e->getMessage());
        }
        // トランザクションの例外処理
        try {
          $pdo->beginTransaction();
          $sql = 'select id from unchiuser';
          $sql .= ' where (user_name = binary :user_name);';
          // ステートメントハンドラを準備
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(':user_name', $new_user_name, PDO::PARAM_STR);
        
          // プリペアードステートメントを実行
          $stmh->execute();
          while ($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION["user_id"] = $row["id"];
          }
        } catch(PDOException $e) {
          die('トランザクションエラー：' . $e->getMessage());
        }

        // 登録後ログイン状態にし、ページを遷移
        $_SESSION["logined"] = TRUE;
        $_SESSION["user_name"] = $new_user_name;
        $_SESSION["user_age"] = $user_age;
        $_SESSION["register_date"] = $register_date;
        header("Location: ../unchi_calendar/calendar.php");
        exit;
      }
    } else {
      $error_msg2 = "入力されていな箇所があります。";
      $display_add = "display";
    }
  }

  // 年齢のセレクタを用意する
  for($i = 1; $i <= 120; $i++) {
    $select_age .= '<option value="' . $i . '">' . $i . '</option>';
  }


?><!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/responsive.css">
  <script type="text/javascript" src="js/login.js"></script>
  <title>うんちカレンダー</title>
</head>
<body>
  <header>
    <img class="logo" src="./img/logo.png">
  </header>
  
  <div class="top_wrapper">
    <div class="container">
      <h1>うんちカレンダー</h1>
    </div>
  </div>
  <div class="acount_wrapper">
    <div class="container">
      <div class="button_title">
        <span class="button" id="button1">ログイン</span>
      </div>
      <form class="<?php echo($display_login); ?>" action="login.php" method="post" id="login_form">
        ユーザー名：<input class="form_text" type="text" name="user_name"><br>
        パスワード：<input class="form_text" type="password" name="pass"><br>
        <span class="error_msg"><?php echo($error_msg1); ?></span><br>
        <input class="submit" type="submit" name="submit_login" value="ログイン">
      </form>
      <div class="button_title">
        <span class="button" id="button2">登録</span>
      </div>
      <form class="<?php echo($display_add); ?>" action="login.php" method="post" id="add_form">
        <div class="add_form_in">
          年齢：
          <div class="div_age" id="div_age">
            <select name="age" id="select_age">
              <option value="" selected>---</option>
              <?php echo($select_age); ?>
            </select>
          歳
          </div>
          <div class="div_age_baby" id="div_age_baby">
            生後
            <select name="age" id="select_age_baby" disabled>
              <option value="" selected>---</option>
              <option value="-1">1</option>
              <option value="-2">2</option>
              <option value="-3">3</option>
              <option value="-4">4</option>
              <option value="-5">5</option>
              <option value="-6">6</option>
              <option value="-7">7</option>
              <option value="-8">8</option>
              <option value="-9">9</option>
              <option value="-10">10</option>
              <option value="-11">11</option>
              <option value="-12">12</option>
            </select>
            ヶ月
          </div>
          <br>
          ※1歳未満：<input type="checkbox" value="baby" onclick="baby_check(this.checked);"><br>
          
          ユーザー名：<input class="form_text" type="text" name="new_user_name"><br>
          パスワード：<input class="form_text" type="password" name="new_pass"><br>
          パスワードを確認：<input class="form_text" type="password" name="confirm_pass"><br>
        </div>
        <span class="error_msg"><?php echo($error_msg2); ?></span><br>
        <input class="submit" type="submit" value="登 録">
      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="source">
    </div>
  </footer>

</body>
</html>