<?php

include_once __DIR__ . "/sessionManagement.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['page'])) {
    $pageName = $_POST['page'];
    loadPage($pageName);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operation'])) {
    switch ($_GET['operation']) {
        case 'get':
            echo getCurrentPage();
            break;
        case 'delete':
            removeCurrentPage();
            break;
        default:
            echo "Invalid Operation";
            break;
    }
}

function loadPage($page)
{
    if ($page != 'login') $_SESSION['currentPage'] = $page;
    switch ($page) {
            //Global Pages
        case 'login':
            require __DIR__ . "/../../pages/global_pages/login.html";
            break;
        case 'menu':
            require __DIR__ . "/../../pages/global_pages/menu.php";
            break;

            //Student Only Pages
        case 'home':
            require __DIR__ . "/../../pages/student_only_pages/home.html";
            break;
        case 'about':
            require __DIR__ . "/../../pages/student_only_pages/about.html";
            break;
        case 'profile':
            require __DIR__ . "/../../pages/student_only_pages/profile.php";
            break;

            //Admin Only Pages
        case 'orders':
            require __DIR__ . "/../../pages/admin_only_pages/orders.php";
            break;
        case 'users':
            require __DIR__ . "/../../pages/admin_only_pages/usersList.php";
            break;

            //Error Page
        default:
            require __DIR__ . "/../../pages/global_pages/errorPage.html";
            break;
    }
}

function getCurrentPage()
{
    return $_SESSION['currentPage'];
}

function removeCurrentPage()
{
    $_SESSION['currentPage'] = null;
}
