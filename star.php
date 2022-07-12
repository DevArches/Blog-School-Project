<?php
require_once './includes/ini.inc.php';



if(isset($_GET['rating']) && isset($_GET['bnum'])){
    $newRating = $_GET['rating'] ?? '';
    $bnum = $_GET['bnum'] ?? '';
    $user = $_SESSION['username'] ?? '';
    if ($newRating >= 1 && $newRating <= 5 && $bnum >= 1) {
    $r = new RatingManagement(new RatingRepository(new DBConnector()));
    $r->newRating($bnum, $newRating, $user);
    header ('Location: index.php');
    }
    exit;
} else {
    header ('Location: index.php');
    exit;
}




