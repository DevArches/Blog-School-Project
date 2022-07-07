<?php
require_once './includes/ini.inc.php';

if(isset($_POST['login'])){
    $blog = new BlogManagement();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $blog->login($username, $password);
    if($result){
        $_SESSION['username'] = $username;
        header('Location: ./index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.css'>
    <title>Vorlage</title>
</head>

<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="text" name="username" id="username" placeholder="Enter Username" required>
        <input type="password" name="password" id="password" placeholder="Enter Password" required>
        <input type="submit" name="login" value="Login">
    </form>
</body>

</html>