<?php

session_start();

require_once 'PDOConnect.inc.php';
require_once 'loggedin.inc.php';

function myAutoLoader($class)
{
    $dirs = array(
        "./Classes/",
        "./Classes/Models/",
        "./Classes/Managers/",
        "./Classes/Repos/",
    );
    foreach ($dirs as $dir) {
        if (file_exists($dir . $class . '.inc.php')) {
            include_once $dir . $class . '.inc.php';
        }
    } 
}
spl_autoload_register('myAutoLoader');

$db = new DBConnector();
$post = new PostManagement(new PostRepository($db));
$rating = new RatingManagement(new RatingRepository($db));
$comment = new CommentManagement(new CommentRepository($db));
$blogManagement = new BlogManagement(new BlogRepository($db));

$blogManagement->isLoggedIn();
if (isset($_SESSION['username'])) {
    $blogManagement->isAdmin($_SESSION['username']);
};
