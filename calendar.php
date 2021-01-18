<?php
  // セッションはサーバー側にデータを保存
  session_start();
  // セッションが切れていたらlogin.phpに戻す
  if(!isset($_SESSION["logined"])){
    header("Location: ../unchi_calendar/login.php");
    exit;
  }
  

  /* -------------------- 現在の年齢を計算 -------------------- */
  $today = new DateTime(date("Y-m-d"));
  $register = new DateTime($_SESSION["register_age"]);
  // 今日と登録日を比較
  $interval = $today -> diff($register);
  if($_SESSION["user_age"] > 0) {
    // 現在の年齢(登録日の年齢＋経過年数)を格納
    $_SESSION["now_age"] = $_SESSION["user_age"] + $interval -> format("%y");
  } else {
    $interval_y = $interval -> format("%y");
    if($interval_y <= 0) {
      $interval = $interval -> format("%m");
      // 現在の年齢(登録日の年齢＋経過年数)を格納
      $_SESSION["now_age"] = $_SESSION["user_age"] + (-1 * $interval);
    } else {
      // 現在の年齢を格納
      $_SESSION["now_age"] = $interval -> format("%y");
    }
  }


  /* -------------------- カレンダー作成 -------------------- */

  // 表示されている月の変更
  if(isset($_POST["prev"])) {
    $_SESSION["reduce_add_month"] += $_POST["prev"];
  }
  if(isset($_POST["next"])) {
    $_SESSION["reduce_add_month"] += $_POST["next"];
  }

  // 必要な値を取得
  $reduce_add_month = $_SESSION["reduce_add_month"];
  $year = date("Y", strtotime($reduce_add_month . " month"));
  $month = date("m", strtotime($reduce_add_month . " month"));
  $first_day = date("w", strtotime("first day of " . $reduce_add_month . " month")); // その月の最初の曜日
  $last_date = date("d", strtotime("last day of " . $reduce_add_month . " month"));  // その月の最後の日にち
  $today = date("Y-m-d");

  // 日にちを曜日に合わせて表示
  $display = FALSE; // 日にちを出力するかどうか
  $date_count = 1;  // 日にちのカウント
  // for文で月初から月末まで動かす
  for($i = 0; $i < 6; $i++) {
    $calendar_html .= '<tr>';
    // 列の出力
    for($j = 0; $j < 7; $j++) {
      // その月の最初の曜日が一致したら出力を始める
      // phpのdate関数では下記のようになっている
      // 0:日, 1:月, 2:火, 3:水, 4:木, 5:金, 6:土
      if($first_day == $j) {
        $display = TRUE;
      }
      if($date_count > $last_date) {
        $display = FALSE;
      }
      if($display == TRUE) {
        $date = sprintf($year . "-" . $month . "-" . "%02d", $date_count); // 出力例: 2020-12-01
        try {
          $pdo = new PDO('mysql:host=localhost;dbname=proj2020;charset=utf8', 'proj','proj2020');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
          die('接続エラー：' . $e->getMessage());
        }
        try {
          $pdo->beginTransaction();
          $sql = 'select katasa, iro, ryo, result from log';
          $sql .= ' where (timelog = binary :date) and (user_id = binary :user_id)';
          $sql .= ' order by id desc;';
          // ステートメントハンドラを準備
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(':date', $date, PDO::PARAM_STR);
          $stmh->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
          // プリペアードステートメントを実行
          $stmh->execute();
          $pdo->commit();
        } catch(PDOException $e) {
          die('トランザクションエラー：' . $e->getMessage());
        }
        // 一致している人がいるかどうか
        $same_day= 0;
        while ($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
          $unchi_data[$date_count][$same_day][0] = $row["katasa"];
          $unchi_data[$date_count][$same_day][1] = $row["iro"];
          $unchi_data[$date_count][$same_day][2] = $row["ryo"];
          $unchi_data[$date_count][$same_day][3] = $row["result"];
          $same_day++;
        }
        // 今日の日付に色をつける
        if($date == $today) {
          $calendar_td_css = "calendar_today";
        } else {
          $calendar_td_css = "";
        }
        // ウンチデータが格納されている場合
        if($unchi_data[$date_count][0][0]) {
          $calendar_html .= '<td><button class="button_td" type="submit" name="submit" value="' . $date_count . '"><span class="calendar_td_css ' . $calendar_td_css . '">' . $date_count . '</span><br><i class="fas fa-poo"></i></button></td>';
        } else {
          $calendar_html .= '<td><button class="button_td" type="submit" name="submit" value="' . $date_count . '" disabled><span class="calendar_td_css ' . $calendar_td_css . '">' . $date_count . '</span></button></td>';
        }
        $date_count++;
      } else {
        $calendar_html .= '<td>' . '' . '</td>';
      }
    }
    $calendar_html .= '</tr>';
  }
  

  $unchi_info = array(
    "shape" => array(1 => "コロコロ便", 2 => "硬い便", 3 => "やや硬い便", 4 => "普通便", 5 => "やや軟らかい便", 6 => "泥状便", 7 => "水様便"),
    "color" => array(1 => "黄褐色", 2 => "茶色", 3 => "こげ茶", 4 => "赤", 5 => "黒", 6 => "灰色", 7 => "緑", 8 => "白"),
    "amount" => array(1 => "すくない", 2 => "ふつう", 3 => "おおい"),
    "hardness" => array(1 => "みずっぽい", 2 => "ふつう", 3 => "かたい"),
    "score" => array(0 => "不可", 1 => "可", 2 => "良", 3 => "優", 4 => "秀"),
    "score_baby" => array(0 => "心配", 1 => "ちょっと心配", 2 => "心配なし")
  );

  // 日付をクリックしたときの処理
  if(isset($_POST["submit"])) {
    $_SESSION["popup"] = "popup"; // ポップアップの有効化
    $submit_date = $_POST["submit"]; // クリックしたマスの日付を格納
    $max_unchi = count($unchi_data[$submit_date]); // その日のうんちの最大数
  } else {
    $_SESSION["popup"] = "none"; // ポップアップの無効化
    $json_array  = "none";
    $submit_date = "none";
  }

  // 結果ページ用にセッションに渡す
  $_SESSION["unchi_info"] = $unchi_info;
  // js用に配列を変換
  $unchi_data = json_encode($unchi_data);
  $unchi_info = json_encode($unchi_info);

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
      <h1>うんちカレンダー</h1>
    </div>
  </div>

  <div class="popup" id="js_popup">
    <span id="<?php echo($_SESSION['popup']); ?>"></span>
    <div class="popup_inner">
      <div class="close_button" id="js_close_button"><i class="fas fa-times"></i></div>
      <div class="popup_inner_text">
        <p class="popup_date"><i class="far fa-calendar-alt"></i> ： <?php echo($year . "-" . $month . "-" . $submit_date); ?></p>
        <p class="unchi_data"></p>
        <p class="unchi_data none"></p>
        <p class="unchi_data"></p>
        <p class="unchi_data none"></p>
        <p class="unchi_data hardness"></p>
      </div>
      <div class="character_img_frame">
        <a href="#" class="character_img" id="popup_inner_img"></a><br>
        <div class="change_character">
          <button type="button" class="popup_arrow" value="-1" onclick="change_inner(this.value);"><i class="fas fa-caret-left fa-3x"></i></button>
          <p class="popup_count" id="count">1/<?php echo($max_unchi); ?></p>
          <button type="button" class="popup_arrow" value="1" onclick="change_inner(this.value);"><i class="fas fa-caret-right fa-3x"></i></button>
        </div>
      </div>
    </div>
  <div class="black_bg" id="js_black_bg"></div>
  </div>

  <div class="calendar_wrapper">
    <div class="container">
      <div class="calendar_top_buttons">
        <form action="calendar.php" method="post">
          <button type="submit" class="change_month prev_month" name="prev" value="-1"><i class="far fa-caret-square-left fa-2x"></i></button>
            <!-- 年/月を表示 -->
            <h2><?php echo($year . "/" . $month); ?></h2>
          <button type="submit" class="change_month next_month" name="next" value="1"><i class="far fa-caret-square-right fa-2x"></i></button>
        </form>
      </div>
      <form action="calendar.php" method="post">
        <div class="calendar">
          <table>
            <tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>
            <?php echo($calendar_html); ?>
          </table>
        </div>
      </form>
      <form class="calendar_bottom_buttons" name="calendar_form" action="character.php" method="post">
        <a href="../unchi_calendar/unchilog.php" class="button button_title">うんちログ</a><br>
        <input type=hidden name="from_calendar">
        <a href="javascript:calendar_form.submit()" class="button button_title">今日のうんち</a>
      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="source">
      <a href="../unchi_calendar/references.php">参考文献一覧</a>
    </div>
  </footer>

  <script>
    let age = <?php echo($_SESSION["now_age"]); ?>;
    let popup_php = "<?php echo $_SESSION["popup"]; ?>";
    let unchi_data = <?php echo $unchi_data; ?>;
    let unchi_info = <?php echo $unchi_info; ?>;
    let click_date = <?php echo $submit_date; ?>;
  </script>
  <script type="text/javascript" src="js/calendar.js"></script>
</body>
</html>