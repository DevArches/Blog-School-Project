<?php
require_once './includes/ini.inc.php';
spl_autoload_register('myAutoLoader');

$subject = '';
$text = '';
$rating = '';
$created = '';
$sql = '';

if (isset($_GET['bnum'])) {
    $bnum = $_GET['bnum'] ?? '';
    if (is_numeric($bnum)) {
        $blog = new BlogManagement($bnum);
        $blog = $blog->getBlog($bnum);
        $subject = $blog->getSubject();
        $text = $blog->getText();
    }
}

if (isset($_POST['submit']) && $admin == true) {
    $subject = $_POST['subject'] ?? '';
    $text = $_POST['text'] ?? '';
    $bnum = $_POST['bnum'] ?? '';
    $blogManagement = new BlogManagement();
    $blogManagement->editBlog($bnum, $subject, $text);
    header('Location: index.php');
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
    <style>
        .checked {
            color: orange;
        }
    </style>
    <title>Edit Blog</title>
</head>

<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="bnum" value="<?= $bnum ?>">
        <label for="subject">Subject:</label><br />
        <input type="text" id="subject" name="subject" value="<?= $subject ?>" />
        <br /><br />
        <label for="text">Text:</label><br />
        <textarea id="text" name="text" rows="10" cols="50"><?= $text ?></textarea>
        <br /><br />
        <input type="submit" name="submit" value="Save" />
    </form>
    <button>
        <a href="index.php">Back</a>
    </button>

</body>

</html>