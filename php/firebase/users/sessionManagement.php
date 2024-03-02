<?php

//Session Life Time in seconds
$sessionLifeTime = 24 * 60 * 60;

ini_set('session.cookie_lifetime', $sessionLifeTime);
ini_set('session.gc-maxlifetime', $sessionLifeTime);
session_start();

function checkSession()
{
    global $sessionLifeTime;
    if (isset($_SESSION['currentUser'])) {
        $lastLoginTime = isset($_SESSION['currentUser']['lastLoginTime']) ? $_SESSION['currentUser']['lastLoginTime'] : 0;
        if ((time() - $lastLoginTime) < $sessionLifeTime) {
            return json_encode([
                'isLoggedIn' => 'true'
            ]);
        } else {
            return json_encode([
                'isLoggedIn' => 'false',
                'message' => 'Session Expired',
            ]);
        }
    } else {
        return json_encode([
            'isLoggedIn' => 'false',
            'message' => 'Not Logged In',
        ]);
    }
}

function createSession($keyToStore, $dataToStore)
{
    $_SESSION[$keyToStore] = $dataToStore;
}

function getCurrentUserIdFromSession()
{
    return $_SESSION['currentUser']['id'];
}

function destroySession()
{
    session_unset();
    session_destroy();
}

function refreshSession()
{
    if (isset($_SESSION['currentUser'])) {
        $_SESSION['currentUser']['lastLoginTime'] = time();
    }
}
