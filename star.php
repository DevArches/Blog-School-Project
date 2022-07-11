<?php
require_once './includes/ini.inc.php';



$rating = '';
$bnum = '';

if(isset($_GET['rating']) && isset($_GET['bnum'])){
    $rating = $_GET['rating'] ?? '';
    $bnum = $_GET['bnum'] ?? '';
    if ($rating >= 1 && $rating <= 5 && $bnum >= 1) {
    $blog = new BlogManagement();
    $blog = $blog->addRating($bnum, $rating);
    }
    header ('Location: index.php');
    exit;
} else {
    header ('Location: index.php');
    exit;
}




