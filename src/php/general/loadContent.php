<?php

if (isset($_POST['page'])) {
    $pageName = $_POST['page'];
    ob_start();

    // Include the loadbackground.php file
    require 'loadbackground.php';

    // Get the background style
    $bgStyle = loadBackground($pageName);

    // Output the background style
    echo '<style>
    body {
        ' . $bgStyle . '
        background-size: cover; 
        background-position: center;
        width: 100%;
        height: 100vh;
        margin: 0;
    }
</style>';

    loadPage($pageName);

    $output = ob_get_clean();
    echo trim($output);
}

function loadPage($page)
{
    switch ($page) {
        case 'login':
            require __DIR__ . "/../../pages/login/login.html";
            break;
        case 'home':
            require __DIR__ . "/../../pages/home/home.html";
            break;
        case 'about':
            require __DIR__ . "/../../pages/about/about.html";
            break;
        case 'menu':
            require __DIR__ . "/../../pages/menu/menu.php";
            break;
        case 'profile':
            require __DIR__ . "/../../pages/profile/profile.php";
            break;
        default:
            echo "<h2>Page not found</h2>";
            break;
    }
}
