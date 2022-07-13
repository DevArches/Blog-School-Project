<?php

require_once './includes/ini.inc.php';

$showPosts = './includes/showPosts.inc.php';

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
    <title>Blog Main</title>
</head>

<body>
    <?php if ($admin == true) { ?>
        <button>
            <a href="./includes/demoDb.inc.php">Reset Database</a>
        </button>
    <?php }; ?>
    <?php if ($loggedIn == true) { ?>
        <p><?php echo ucfirst(strtolower($_SESSION['username'])) . ' is logged in' ?></p>
        <button>
            <a href="logout.php">Logout</a>
        </button>
    <?php } else { ?>
        <button>
            <a href="login.php">Login</a>
        </button>
    <?php }
    if ($admin == true) { ?>
        <br /><br />
        <button>
            <a href="newBlog.php">Add Blog</a>
        </button>
    <?php } ?>
    <div id="main">
        <h1>Blog</h1>
        <?php
        $blogs = $post->getBlogs();
        foreach ($blogs as $post) { 
            if ($post->getHidden() == false){
                include $showPosts;
            } else if($post->getHidden() == true && $admin == true){
                include $showPosts;
            }} ?>
    </div>
</body>

</html>