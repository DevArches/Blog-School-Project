<?php

require_once './includes/ini.inc.php';


$subject = '';
$text = '';
$rating = '';
$bnum = '';
$hidden = '';


if (isset($_POST['submit']) && $admin == true) {
    $subject = $_POST['subject'];
    $text = $_POST['text'];
    $hidden = $_POST['hidden'];
    $postManagement->newBlog($hidden, $subject, $text);
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
        <!-- input for hidden true or false with radio -->
        <label for="hidden">Hidden:</label><br />
        <input type="radio" id="hidden" name="hidden" value="0" checked />No<br />
        <input type="radio" id="hidden" name="hidden" value="1" />Yes<br />
        <br /><br />
        <input type="submit" name="submit" value="Save" />
        <br /><br />
    </form>
    <button>
        <a href="index.php">Back</a>
    </button>
</body>

</html>