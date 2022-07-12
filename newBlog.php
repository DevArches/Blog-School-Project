<?php

require_once './includes/ini.inc.php';


$subject = '';
$text = '';
$rating = '';

if (isset($_POST['submit']) && $admin == true) {
    $subject = $_POST['subject'];
    $text = $_POST['text'];
    $rating = $_POST['rating'];
    $PostManagement = new PostManagement();
    $PostManagement->newBlog($subject, $text, $rating);
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
    <title>New Blog</title>
</head>

<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

        <label for="subject">Subject:</label><br />
        <input type="text" id="subject" name="subject" value="<?= $subject ?>" />
        <br /><br />
        <label for="text">Text:</label><br />
        <textarea id="text" name="text" rows="10" cols="50"><?= $text ?></textarea>
        <br /><br />
        <label for="rating">Rating:</label><br />
        <input type="range" min="1" max="5" class="slider" name="rating" id="rating" value="<?= $rating ?>">
        <input type="submit" name="submit" value="Save" />
        <br /><br />
    </form>
    <button>
        <a href="index.php">Back</a>
    </button>
</body>

</html>