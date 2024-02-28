<?php

//Session Life Time in seconds
$sessionLifeTime = 2 * 60;

ini_set('session.cookie_lifetime', $sessionLifeTime);
ini_set('session.gc-maxlifetime', $sessionLifeTime);
session_start();

function checkSession()
{
    global $sessionLifeTime;
    if (isset($_SESSION['currentUser'])) {
        $lastLoginTime = isset($_SESSION['currentUser']['lastLoginTime']) ? $_SESSION['currentUser']['lastLoginTime'] : 0;
        if ((time() - $lastLoginTime) < $sessionLifeTime) {
            return 'true';
        } else {
            return 'false';
        }
    } else {
        return 'false';
    }
}

function createSession($keyToStore, $dataToStore)
{
    $_SESSION[$keyToStore] = $dataToStore;
}

function getCurrentUserFromSession()
{
    return $_SESSION['currentUser'];
}

function destroySession()
{
    session_unset();
    session_destroy();
}

function refreshSession()
{
    $lastLoginTime = time();
    $_SESSION['currentUser']['lastLoginTime'] = $lastLoginTime;
}
