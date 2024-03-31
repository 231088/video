<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動画サイト</title>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/video/components/header.php'; ?>
    <form action="submit.php" method="post">
        <div>
            <label for="id">ID</label>
            <input type="text" id="id" name="id">
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password">
        </div>
        <input type="submit" value="ログイン">
    </form>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/video/components/footer.php'; ?>
</body>

</html>