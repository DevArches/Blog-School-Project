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

$post = new PostManagement(new PostRepository(new DBConnector()));
$rating = new RatingManagement(new RatingRepository(new DBConnector()));
$comment = new CommentManagement(new CommentRepository(new DBConnector()));
$b = new BlogManagement(new BlogRepository(new DBConnector()));
$b->isLoggedIn();
if (isset($_SESSION['username'])) {
    $b->isAdmin($_SESSION['username']);
};
