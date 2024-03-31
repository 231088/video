<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<header>
    <h1>Video</h1>
    <?php
    echo '<a href="/video/index.php">ホーム</a>';
    echo '<a href="/video/upload">投稿</a>';
    if (isset($_SESSION['username'])) {
        $userid = $_SESSION['username'];
        echo '<p>ようこそ' . $userid . 'さん</p>';
        echo '<a href="/video/logout">ログアウト</a>';
    } else {
        echo '<a href="/video/login">ログイン</a>';
        echo '<a href="/video/register">新規登録</a>';
    } 
    ?>
</header>