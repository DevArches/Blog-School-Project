<?php

require_once './includes/ini.inc.php';


$res = '';
$bnum = $_GET['bnum'];
if ($admin == true) {
    $postManagement->deleteBlog($bnum);
    header('Location: index.php');
    exit;
} else {
    $res = 'You are not allowed to delete this blog';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.css'>
    <title>Delete</title>
</head>

<body>
    <p>
        <?php echo $res ?>
    </p>
</body>

</html>