<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動画サイト</title>
</head>

<body>
    <?php include '../components/header.php'; ?>
    
    <?php 
    include '../components/opendb.php';
    
    if (isset($_GET['id'])) {
        $stmt = $dbh->prepare('SELECT * FROM videos WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $video = $stmt->fetch();
        if ($video === false) {
            echo '動画が見つかりません';
            return;
        }
        
        echo '<h1>' . $video['title'] . '</h1>';
        echo '<p>' . $video['description'] . '</p>';

        $width = 1080;
        $height = 720;

        echo '<video width="' . $width . '" height="' . $height . '"src="data:video/mp4;base64,' . base64_encode($video['video']) . '" controls></video>';
    } else {
        echo '動画が見つかりません';
    }


    ?>


    <?php include '../components/footer.php'; ?>
</body>

</html>