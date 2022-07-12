<?php

require_once './includes/ini.inc.php';

$blog = new PostManagement();
$rating = new RatingManagement(new RatingRepository(new DBConnector()));


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

        $blogs = $blog->getBlogs();
        foreach ($blogs as $post) { ?>
            <div id="blog">

                <h2><?php echo $post->getSubject() ?></h2>

                <p><?php echo $post->getText() ?></p>

                <p>Created: <?php echo $post->getCreated() ?></p>

                <p><?php $rating->Stars($post->getBnum());
                    echo ' Ratings: ' . $rating->getRatingCount($post->getBnum()); ?></p>

                <?php $comment = new CommentManagement(new CommentRepository(new DBConnector()));
                $comments = $comment->getComments($post->getBnum()); ?>
                <div id='comments'>
                    <p>Comments:</p>
                    <?php foreach ($comments as $comment) {
                        if ($comment->getBlogNum() == $post->getBnum()) { ?>
                            <p><?php echo $comment->getText() ?> <br />
                                Created: <?php echo $comment->getCreated() ?> <br />
                                From :<?php echo $comment->getUser() ?> </p>
                        <?php }
                    }
                    if ($loggedIn == true) { ?>
                        <a href="addComment.php?bnum=<?php echo $post->getBnum() ?>">Add Comment</a>
                    <?php } ?>
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