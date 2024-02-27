<?php

//Session Life Time in seconds
$sessionLifeTime = 5 * 60;
$lastLoginTime = isset($_SESSION['currentUser']['lastLoginTime']) ? $_SESSION['currentUser']['lastLoginTime'] : 0;

ini_set('session.cookie_lifetime', $sessionLifeTime);
ini_set('session.gc-maxlifetime', $sessionLifeTime);
session_start();

function checkSession()
{
    global $sessionLifeTime, $lastLoginTime;
    if (isset($_SESSION['currentUser'])) {
        if ((time() - $lastLoginTime) < $sessionLifeTime) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function destroySession()
{
    session_unset();
    session_destroy();
}

function refreshSession()
{
    global $lastLoginTime;
    $lastLoginTime = time();
    $_SESSION['currentUser']['lastLoginTime'] = $lastLoginTime;
}
