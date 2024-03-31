<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ユーザーIDとパスワードを取得
        $id = $_POST['id'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        // パスワードが一致しているか確認
        if ($password !== $password_confirm) {
            echo 'パスワードが一致しません';
            return;
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/video/components/opendb.php';
        
        // ユーザーIDが既に登録されていないか確認
        $stmt = $dbh->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user !== false) {
            echo 'ユーザーIDが既に登録されています';
            return;
        }

        // CREATE TABLE users (
        //     id INT PRIMARY KEY AUTO_INCREMENT,
        //     username VARCHAR(255) NOT NULL UNIQUE,
        //     password VARCHAR(255) NOT NULL,
        //     created_at DATETIME NOT NULL
        //   );

        // パスワードをハッシュ化
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $dbh->prepare('INSERT INTO users (username, password, created_at) VALUES (:username, :password, :created_at)');
        $stmt->bindParam(':username', $id);
        $stmt->bindParam(':password', $hash);
        $created_at = date('Y-m-d H:i:s');
        $stmt->bindParam(':created_at', $created_at);
        $stmt->execute();

        $stmt = $dbh->prepare('SELECT * FROM users WHERE id = :id');
        $lastId = $dbh->lastInsertId();
        $stmt->bindParam(':id', $lastId);
        $stmt->execute();
        $user = $stmt->fetch();
        
        if ($user === false) {
            echo '登録に失敗しました';
            return;
        }

        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: /video/index.php');
    }