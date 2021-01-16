<?php
  // セッションはサーバー側にデータを保存
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
  $error_msg2 = "";
  $error_msg3 = "";

  $change_setting = "";

  /* -------------------- ユーザー名の変更の部分 -------------------- */
  if(isset($_POST["change_user_name"])) {
    $change_user_name = $_POST["change_user_name"];
    // 空白文字を削除
    $change_user_name = str_replace(array(" ", "　"), "", $change_user_name);
    if(!empty($change_user_name)) {
      try {
        // PDOクラスのインスタンスを作成し、データベース接続を行う。
        $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      } catch(PDOException $e) {
        die('接続エラー：' . $e->getMessage());
      }
      // 同じユーザー名がいないか検索する
      try {
        $pdo->beginTransaction();
        // SQL文(プリペアードステートメント)を準備
        $sql = 'select * from  unchiuser';
        $sql .= ' where user_name = :change_user_name;';
        // ステートメントハンドラを準備
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(":change_user_name", $change_user_name, PDO::PARAM_STR);
        // プリペアードステートメントを実行
        $stmh->execute();
        // エラーが出た場合、例外処理でロールバックする
        // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
        $pdo->commit();
      } catch(PDOException $e) {
        die('トランザクションエラー：' . $e->getMessage());
      }
      if($stmh->rowCount() == 1) {
        $error_msg1 = "ユーザー名が既に使用されています。";
      } else {
        // ユーザー名の変更
        try {
          $pdo->beginTransaction();
          // SQL文(プリペアードステートメント)を準備
          $sql = 'update unchiuser set user_name = :change_user_name';
          $sql .= ' where user_name = :user_name;';
          // ステートメントハンドラを準備
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(":change_user_name", $change_user_name, PDO::PARAM_STR);
          $stmh->bindValue(":user_name", $_SESSION["user_name"], PDO::PARAM_STR);
          // プリペアードステートメントを実行
          $stmh->execute();
          // エラーが出た場合、例外処理でロールバックする
          // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
          $pdo->commit();
          // セッションのユーザ名を更新
          $_SESSION["user_name"] = $change_user_name;
          $error_msg1 = "ユーザー名を変更しました。";
          $change_setting = "change_setting";
        } catch(PDOException $e) {
          die('トランザクションエラー：' . $e->getMessage());
        }
      }
    } else {
      $error_msg1 = "入力されていません。";
    }
  }

  /* -------------------- アカウント削除の部分 -------------------- */
  if(isset($_POST["pass"]) && isset($_POST["rm"])) {
    $pass = $_POST["pass"];
    try {
      // PDOクラスのインスタンスを作成し、データベース接続を行う。
      $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch(PDOException $e) {
      die('接続エラー：' . $e->getMessage());
    }
    // パスワードの確認
    try {
      $pdo->beginTransaction();
      // SQL文(プリペアードステートメント)を準備
      $sql = 'select * from unchiuser';
      $sql .= ' where (user_name = :user_name)';
      $sql .= 'and (user_password = :pass);';
      // ステートメントハンドラを準備
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(":user_name", $_SESSION["user_name"], PDO::PARAM_STR);
      $stmh->bindValue(":pass", $pass, PDO::PARAM_STR);
      // プリペアードステートメントを実行
      $stmh->execute();
      // エラーが出た場合、例外処理でロールバックする
      // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
      $pdo->commit();
    } catch(PDOException $e) {
      die('トランザクションエラー：' . $e->getMessage());
    }
    // パスワードが一致したとき
    if($stmh->rowCount() == 1) {
      try {
        $pdo->beginTransaction();
        // SQL文(プリペアードステートメント)を準備
        $sql = 'delete from unchiuser';
        $sql .= ' where (user_name = :user_name)';
        $sql .= 'and (user_password = :pass);';
        // ステートメントハンドラを準備
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(":user_name", $_SESSION["user_name"], PDO::PARAM_STR);
        $stmh->bindValue(":pass", $pass, PDO::PARAM_STR);
        // プリペアードステートメントを実行
        $stmh->execute();
        // エラーが出た場合、例外処理でロールバックする
        // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
        $pdo->commit();
        // 削除完了後ログアウトさせる
        $_SESSION["rm_user"] = TRUE;
        header("Location: http://localhost/unchi_calendar/login.php");
        exit;
      } catch(PDOException $e) {
        die('トランザクションエラー：' . $e->getMessage());
      }
    } else {
      $error_msg2 = "パスワードが違います。";
    }
  }

  /* -------------------- パスワードを変更する部分 -------------------- */
  if(isset($_POST["pass"]) && isset($_POST["change_pass"]) && isset($_POST["confirm_pass"])) {
    $pass = $_POST["pass"];
    $change_pass = $_POST["change_pass"];
    $confirm_pass = $_POST["confirm_pass"];
    // 空白文字を削除
    $pass = str_replace(array(" ", "　"), "", $pass);
    $change_pass = str_replace(array(" ", "　"), "", $change_pass);
    $confirm_pass = str_replace(array(" ", "　"), "", $confirm_pass);
    if(!empty($pass) && !empty($change_pass) && !empty($confirm_pass)) {
      try {
        // PDOクラスのインスタンスを作成し、データベース接続を行う。
        $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      } catch(PDOException $e) {
        die('接続エラー：' . $e->getMessage());
      }
      // 現在のパスワードの確認
      try {
        $pdo->beginTransaction();
        // SQL文(プリペアードステートメント)を準備
        $sql = 'select * from unchiuser';
        $sql .= ' where (user_name = :user_name)';
        $sql .= 'and (user_password = :pass);';
        // ステートメントハンドラを準備
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(":user_name", $_SESSION["user_name"], PDO::PARAM_STR);
        $stmh->bindValue(":pass", $pass, PDO::PARAM_STR);
        // プリペアードステートメントを実行
        $stmh->execute();
        // エラーが出た場合、例外処理でロールバックする
        // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
        $pdo->commit();
      } catch(PDOException $e) {
        die('トランザクションエラー：' . $e->getMessage());
      }
      // 現在のパスワードが正しいとき
      if($stmh->rowCount() == 1) {
        // 確認のパスワードが一致したとき変更
        if($change_pass === $confirm_pass) {
          try {
            // PDOクラスのインスタンスを作成し、データベース接続を行う。
            $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          } catch(PDOException $e) {
            die('接続エラー：' . $e->getMessage());
          }
          try {
            $pdo->beginTransaction();
            // SQL文(プリペアードステートメント)を準備
            $sql = 'update unchiuser set user_password = :change_pass';
            $sql .= ' where (user_name = :user_name)';
            $sql .= 'and (user_password = :pass);';
            // ステートメントハンドラを準備
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(":change_pass", $change_pass, PDO::PARAM_STR);
            $stmh->bindValue(":user_name", $_SESSION["user_name"], PDO::PARAM_STR);
            $stmh->bindValue(":pass", $pass, PDO::PARAM_STR);
            // プリペアードステートメントを実行
            $stmh->execute();
            // エラーが出た場合、例外処理でロールバックする
            // そうじゃない場合、正常にSQLが実行された場合は、トランザクションを終了
            $pdo->commit();
            $error_msg3 = "パスワードを変更しました。";
            $change_setting = "change_setting";
          } catch(PDOException $e) {
            die('トランザクションエラー：' . $e->getMessage());
          }
        } else {
          $error_msg3 = "パスワードが違います。";
        }
      } else {
        $error_msg3 = "パスワードが違います。";
      }
    } else {
      $error_msg3 = "入力されていません。";
    }
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
      <h1>アカウント設定</h1>
    </div>
  </div>
  
  <div class="setting_wrapper">
    <div class="container">
      <div class="row">
        <div class="section-name">
          <h2>アカウント</h2>
        </div>
        <div class="row_content">
          <h3>ユーザー名を変更</h3>
          現在のユーザー名：<?php echo($_SESSION["user_name"]); ?>
          <form action="account.php" method="post">
            新しいユーザー名：<input class="form_text" type="text" name="change_user_name">
            <input class="button_setting" type="submit" value="変 更">
          </form>
          <span class="error_msg <?php echo($change_setting); ?>"><?php echo($error_msg1); ?></span>
          <h3>アカウントを削除</h3>
          現在のアカウント：<?php echo($_SESSION["user_name"]); ?>
          <form action="account.php" method="post">
            パスワード：<input class="form_text" type="password" name="pass">
            <input class="button_setting" type="submit" name="rm" value="削 除">
          </form>
          <span class="error_msg <?php echo($change_setting); ?>"><?php echo($error_msg2); ?></span>
        </div>
      </div>
      <div class="row">
        <div class="section-name">
          <h2>セキュリティ</h2>
        </div>
        <div class="row_content">
          <h3>パスワードを変更</h3>
          <form action="account.php" method="post">
            現在のパスワード：<input class="form_text" type="password" name="pass"><br>
            新しいパスワード：<input class="form_text" type="password" name="change_pass"><br>
            パスワードを確認：<input class="form_text" type="password" name="confirm_pass">
            <input class="button_setting" type="submit" value="変 更">
          </form>
          <span class="error_msg <?php echo($change_setting); ?>"><?php echo($error_msg3); ?></span>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="link">
      <a class="footer_logo_a" href="http://localhost/unchi_calendar/calendar.php"><i class="footer_logo far fa-calendar-alt fa-lg"></i></a>
      <img class="gt" src="./img/gt.png" alt="だいなり"><p>アカウント設定</p>
    </div>
    <div class="source">
      <a href="http://localhost/unchi_calendar/references.php">参考文献一覧</a>
    </div>
  </footer>

</body>
</html>