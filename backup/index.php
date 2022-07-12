<?php

require_once './includes/ini.inc.php';



function averageRating($rating, $bnum)
{
    global $admin;
    $all = str_split($rating);
    $sum = 0;
    foreach ($all as $value) {
        $sum += (int) $value;
    }
    $average = $sum / count($all);
    round($average);
    $num = 0;
    $average = (int) $average;
    if ($admin == true) {
        for ($i = 0; $i < 5; $i++) {
            if ($i < $average) {
                $num = $i + 1;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star checked" id="starA"></span></a>';
            } else {
                $num = $i + 1;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star" id="starA"></span></a>';
            }
        }
    } else {
        for ($i = 0; $i < 5; $i++) {
            if ($i < $average) {
                $num = $i + 1;
                echo '<span class="fa fa-star checked" id="star"></span>';
            } else {
                $num = $i + 1;
                echo '<span class="fa fa-star" id="star"></span>';
            }
        }
    }

    echo " Ratings: " . count($all);
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
        <p>
            <?php
            $PostManagement = new PostManagement();
            $blogs = $PostManagement->getAllBlogs();
            foreach ($blogs as $blog) { ?>
        <div id="blog">
            <h2><?php echo $blog['subject'] ?></h2>
            <p><?php echo $blog['text'] ?></p>
            <p><?php echo date('l jS \of F Y h:i:sa', $blog['created']) ?></p>
            <p><?php
                $rating = $blog['rating'];
                $average = averageRating($rating, $blog['bnum']);
                echo $average;
                ?></p>
            <?php if (($loggedIn == true) && ($admin == true)) { ?>
                <button>
                    <a href="editBlog.php?bnum=<?php echo $blog['bnum'] ?>">Edit</a>
                </button>
                <button>
                    <a href="deleteBlog.php?bnum=<?php echo $blog['bnum'] ?>">Delete</a>
                </button>
            <?php } ?>
        </div>
    <?php } ?>
    </p>
    </div>

</body>

</html>