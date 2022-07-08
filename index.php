<?php

require_once './includes/ini.inc.php';


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
    <button>
        <a href="./includes/demoDb.inc.php">Reset Database</a>
    </button>
    <?php if ($loggedIn == true) { ?>
        <p><?php echo ucfirst(strtolower($_SESSION['username'])) . ' is logged in' ?></p>
        <button>
            <a href="logout.php">Logout</a>
        </button>
        <br /><br />
        <button>
            <a href="newBlog.php">Add Blog</a>
        </button>
    <?php } else { ?>
        <button>
            <a href="login.php">Login</a>
        </button>
    <?php } ?>
    <div id="main">
        <h1>Blog</h1>
        <?php
        $blog = new BlogManagement();
        $blogs = $blog->getBlogs();
        foreach ($blogs as $post) { ?>
            <div id="blog">

                <h2><?php echo $post->getSubject() ?></h2>

                <p><?php echo $post->getText() ?></p>

                <p>Created: <?php echo $post->getCreated() ?></p>

                <p><?php $blog->getStars($post->getBnum()) ?></p>

                <?php $comment = new CommentManagement();
                $comments = $comment->getComments($post->getBnum()); ?>
                <div id='comments'>
                    <p>Comments:</p>
                    <?php foreach ($comments as $comment) {
                        if ($comment->getBlogNum() == $post->getBnum()) { ?>
                            <p><?php echo $comment->getText() ?> <br />
                            Created: <?php echo $comment->getCreated() ?> <br />
                            From :<?php echo $comment->getUser() ?> </p>
                    <?php }
                    } ?>
                </div>

                <?php if ($admin == true) { ?>
                    <a href="editBlog.php?bnum=<?php echo $post->getBnum() ?>">Edit</a>
                    <a href="deleteBlog.php?bnum=<?php echo $post->getBnum() ?>">Delete</a>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>

</html>