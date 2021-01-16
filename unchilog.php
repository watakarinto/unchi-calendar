<?php
  session_start();
  // セッションが切れていたらlogin.phpに戻す
  if(!isset($_SESSION["logined"])){
    header("Location: http://localhost/unchi_calendar/login.php");
    exit;
  }

  // カレンダーの月の初期化
  $_SESSION["reduce_add_month"] = 0;



  /* -------------------- ログデータの取得 -------------------- */
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
    $sql = 'select timelog, max(result) as result from log';
    $sql .= ' where (user_id = :id) group by timelog';
    $sql .= ' order by timelog desc limit 0, 30;';
    // ステートメントハンドラを準備
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':id', $_SESSION["user_id"], PDO::PARAM_STR);
  
    // プリペアードステートメントを実行
    $stmh->execute();
    // 配列の初期化
    $date = array();
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
      array_push($date, [$row["timelog"], $row["result"]]);
    }
  } catch(PDOException $e) {
    die('トランザクションエラー：' . $e->getMessage());
  }

  // js用に配列を変換
  $json_array = json_encode($date);

  
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
      <h1>うんちログ</h1>
    </div>
  </div>
  <div class="unchilog_wrapper">
    <div class="container">
      <!-- 下記よりグラフの表示領域 -->
      <canvas id="line-chart" width="5" height="1"></canvas>
      <form action="unchilog.php" method="post" class="selecters">
        <input type="radio" name="selecter" id="one_week" checked="checked" onclick="log(7);">
        <label for="one_week">１週間</label>
        <input type="radio" name="selecter" id="one_month" onclick="log(30);">
        <label for="one_month">１ヶ月</label>
      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="link">
      <a class="footer_logo_a" href="http://localhost/unchi_calendar/calendar.php"><i class="footer_logo far fa-calendar-alt fa-lg"></i></a>
      <img class="gt" src="./img/gt.png" alt="だいなり"><p>うんちログ</p>
    </div>
    <div class="source">
      <a href="http://localhost/unchi_calendar/references.php">参考文献一覧</a>
    </div>
  </footer>

  <script>let date = <?php echo $json_array; ?>;</script>
  <script>let age = <?php echo($_SESSION["now_age"]); ?></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  <script type="text/javascript" src="js/unchilog.js"></script>
</body>
</html>