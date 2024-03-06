<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['page'])) {
    $pageName = $_POST['page'];
    loadPage($pageName);
}

function loadPage($page)
{
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
            require __DIR__ . "/../../pages/admin_only_pages/orders.html";
            break;
        case 'users':
            require __DIR__ . "/../../pages/admin_only_pages/usersList.html";
            break;

            //Error Page
        default:
            require __DIR__ . "/../../pages/global_pages/errorPage.html";
            break;
    }
}
