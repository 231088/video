<?php
include $_SERVER['DOCUMENT_ROOT'] . '/video/components/login_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video = $_FILES['video'];

    //mp4であれば
    if ($video['type'] === 'video/mp4') {
        // 拡張子以外もmp4であるか確認
        $ext = pathinfo($video['name'], PATHINFO_EXTENSION);
        if ($ext !== 'mp4') {
            echo '動画ファイルはmp4形式をアップロードしてください';
            return;
        }

        //uuidを生成
        $uuid = bin2hex(random_bytes(16));

        // ffmpegを使って動画のサムネイルを取得
        //動画を./tempに一時保存
        move_uploaded_file($video['tmp_name'], './temp/' . $uuid . '.mp4');
        //サムネイルを生成
        exec('ffmpeg -i ./temp/' . $uuid . '.mp4 -ss 00:00:01 -vframes 1 ./temp/' . $uuid . '.png');
        //サムネイルを読み込む
        $thumbnail = file_get_contents('./temp/' . $uuid . '.png');
        

        // 一時保存した動画を読み込む
        $video = file_get_contents('./temp/' . $uuid . '.mp4');

        // 一時ファイルを削除
        unlink('./temp/' . $uuid . '.mp4');
        unlink('./temp/' . $uuid . '.png');



        include $_SERVER['DOCUMENT_ROOT'] . '/video/components/opendb.php';

        $stmt = $dbh->prepare('INSERT INTO videos (title, description, video, thumbnail, created_at) VALUES (:title, :description, :video, :thumbnail, :created_at)');
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':video', $video);
        $stmt->bindParam(':thumbnail', $thumbnail);
        $createdAt = date('Y-m-d H:i:s');
        $stmt->bindParam(':created_at', $createdAt);
        $stmt->execute();

        $videoId = $dbh->lastInsertId();
        

        

        $stmt = $dbh->prepare('INSERT INTO user_videos (user_id, video_id) VALUES (:user_id, :video_id)');
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->bindParam(':video_id', $videoId);
        $stmt->execute();

        // データベースに保存した動画をIDから取得
        $stmt = $dbh->prepare('SELECT * FROM videos WHERE id = :id');
        $stmt->bindParam(':id', $videoId);
        $stmt->execute();
        $video = $stmt->fetch();


        header('Location: /video/watch/index.php?id=' . $videoId);

        


    } else {
        echo '動画ファイルはmp4形式をアップロードしてください';
    }
}