<?php
    $file_dir = 'C:\wab\web\image\\';

    $file_path = $file_dir . $_FILES["uploadfile"]["name"];
    if(move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $file_path)){
        $img_dir = "/image/";
        $img_path = $img_dir.$_FILES["uploadfile"]["name"];
        $size = getimagesize($file_path);
?>
        ファイルアップロード完了しました。<br>
        <img src="<?=$img_path?>" <?=$size[3]?>><br>
        <?php
    } else {
        ?>
        失敗<br>
        <?php
    }
    ?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>