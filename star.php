<?php
require_once './includes/ini.inc.php';
spl_autoload_register('myAutoLoader');


$rating = '';
$bnum = '';

if(isset($_GET['rating']) && isset($_GET['bnum'])){
    $rating = $_GET['rating'] ?? '';
    $bnum = $_GET['bnum'] ?? '';
    $blog = new BlogManagement();
    $blog = $blog->addRating($bnum, $rating);
    header ('Location: index.php');
    exit;
} else {
    header ('Location: index.php');
    exit;
}




