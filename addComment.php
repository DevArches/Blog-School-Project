<?php

require_once './includes/ini.inc.php';

$bnum = '';
$text = '';
$user = '';

if (isset($_GET['bnum'])) {
    $bnum = $_GET['bnum'] ?? '';
    $user = $_SESSION['username'] ?? '';
}

if (isset($_POST['submit'])) {
    $blogNum = $_POST['bnum'] ?? '';
    $text = $_POST['text'] ?? '';
    $user = $_POST['user'] ?? '';
    $comment->addComment($blogNum, $text, $user);
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Add Comment</title>
</head>

<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="bnum" value="<?= $bnum ?>">
        <input type="hidden" name="user" value="<?= $user ?>">
        <textarea name="text" id="" cols="30" rows="10"></textarea>
        <input type="submit" name="submit" value="Add Comment">
    </form>
    <br />
    <button>
        <a href="index.php">Back to Blog</a>
    </button>
</body>


</html>