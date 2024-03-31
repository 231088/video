<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動画サイト</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div>
        <h2>動画一覧</h2>
        <div>
            <?php
            include 'components/opendb.php';

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if (!is_numeric($page) || $page < 1) {
                    $page = 1;
                }else{
                    $page = 1;
                }
            } else {
                $page = 1;
            }

            $stmt = $dbh->prepare('SELECT COUNT(*) AS count FROM videos WHERE visibility = "public"');
            $stmt->execute();
            $count = $stmt->fetch()['count'];

            $allpage = ceil($count / 30);
            
            $stmt = $dbh->prepare('SELECT * FROM videos WHERE visibility = "public" ORDER BY created_at DESC LIMIT 30 OFFSET :offset');
            $offset = ($page - 1) * 30;
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $videos = $stmt->fetchAll();

            include 'components/sanitizer.php';

            $title = $s($video['title']);
            $description = $s($video['description']);

            foreach ($videos as $video) {
                echo '<a href="watch/index.php?id=' . $video['id'] . '">';
                echo '<h3>' . $title . '</h3>';
                echo '<p>' . $description . '</p>';
                // サムネイル
                echo '<img style="width:108px; height:72px;object-fit: contain;" src="data:image/png;base64,' . base64_encode($video['thumbnail']) . '">';
                echo '</a>';
            }
            ?>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
</body>

</html>