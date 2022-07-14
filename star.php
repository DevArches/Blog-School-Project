<?php
require_once './includes/ini.inc.php';

if($loggedIn == false) {
    header('Location: index.php');
    exit;
} else if(isset($_GET['rating']) && isset($_GET['bnum'])){
    $newRating = $_GET['rating'] ?? '';
    $bnum = $_GET['bnum'] ?? '';
    $user = $_SESSION['username'] ?? '';
    if ($newRating >= 1 && $newRating <= 5 && $bnum >= 1) {
    $rating->newRating($bnum, $newRating, $user);
    header ('Location: index.php#b' . $bnum);
    }
    exit;
} else {
    header ('Location: index.php#b' . $bnum);
    exit;
}



