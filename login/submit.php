<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ユーザーIDとパスワードを取得
    $id = $_POST['id'];
    $password = $_POST['password'];

    include $_SERVER['DOCUMENT_ROOT'] . '/video/components/opendb.php';
    
    // ユーザーIDが登録されているか確認
    $stmt = $dbh->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $id);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user === false) {
        echo 'ユーザーIDが登録されていません';
        return;
    }

    // パスワードが一致しているか確認
    if (!password_verify($password, $user['password'])) {
        echo 'パスワードが一致しません';
        return;
    }

    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('Location: /video/index.php');
}