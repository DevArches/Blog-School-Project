<?php

session_start();

require_once 'PDOConnect.inc.php';
require_once 'loggedin.inc.php';

function myAutoLoader($class)
{
    $file = './Classes/' . $class . '.inc.php';
    if (file_exists($file)) {
        include_once $file;
    } else {
        echo 'File not found';
    }
}
spl_autoload_register('myAutoLoader');


$b = new BlogManagement();
$b->isLoggedIn();
if (isset($_SESSION['username'])) {
    $b->isAdmin($_SESSION['username']);
};