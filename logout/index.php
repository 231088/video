<?php
session_start();
if (isset($_SESSION['username'])) {
    // セッション変数を全て解除
    $_SESSION = array();
}
header('Location: /video/index.php');