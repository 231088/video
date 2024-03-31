<?php
    // データベースの接続情報
    $dbserver = '';
    $dbuser = '';
    $dbpassword = '';
    $dbname = '';
    // config.phpが存在していたら、その内容で変数を上書きして使用する
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/video/components/config.php')) {
        include $_SERVER['DOCUMENT_ROOT'] . '/video/components/config.php';
    }

    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $dsn = "mysql:host=$dbserver;dbname=$dbname;charset=utf8mb4";   
    try {
        $dbh = new PDO($dsn, $dbuser, $dbpassword, $opt);
    } catch (PDOException $e) {
        // エラーページにリダイレクト
        include $_SERVER['DOCUMENT_ROOT'] . '/video/components/server_error.php';
    }