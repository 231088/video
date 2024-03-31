<?php
include $_SERVER['DOCUMENT_ROOT'] . '/video/components/login_check.php';
?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動画サイト</title>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/video/components/header.php'; ?>
    <form action="submit.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title">
        </div>
        <div>
            <label for="description">説明</label>
            <input type="text" id="description" name="description">
        </div>
        <div>
            <label for="video">動画ファイル(.mp4のみ)</label>
            <input type="file" id="video" name="video" accept="video/mp4">
        </div>
        <button type="submit">アップロード</button>
    </form>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/video/components/footer.php'; ?>
</body>

</html>