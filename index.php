<?php

require_once './includes/ini.inc.php';

// function averageRating($rating, $bnum){
//     $all = str_split($rating);
//     $sum = 0;
//     $stars = 5;
//     foreach ($all as $value) {
//         $sum += (int) $value;
//     }
//     $average = $sum / count($all);
//     round($average);
//     $num = 0;
//     $average = (int) $average;
//     for ($i = 0; $i < $stars; $i++) {
//             if ($i < $average) {
//                 $num = $i + 1;
//                 echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star checked" id="starA"></span></a>';
//             } else {
//                 $num = $i + 1;
//                 echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star" id="starA"></span></a>';
//             }
//         }
//     echo " Ratings: " . count($all);
// }



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
                <p><?php $blog->averageRating($post->getRating(), $post->getBnum()) ?></p>
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