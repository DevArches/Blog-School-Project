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


$b = new PostManagement();
$b->isLoggedIn();
if (isset($_SESSION['username'])) {
    $b->isAdmin($_SESSION['username']);
};
