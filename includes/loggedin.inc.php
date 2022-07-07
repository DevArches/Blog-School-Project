<?php
$loggedIn = false;
if (isset($_SESSION['username'])) {
    $loggedIn = true;
    if ($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'ryan') {
        $admin = true;
    } else {
        $admin = false;
    }
} else {
    $loggedIn = false;
    $admin = false;
}
