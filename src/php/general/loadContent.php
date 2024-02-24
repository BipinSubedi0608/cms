<?php
if (isset($_POST['page'])) {
    $page = $_POST['page'];
    ob_start();

    // Include the loadbackground.php file
    require 'loadbackground.php';

    // Get the background style
    $bgStyle = loadBackground($page);

    // Output the background style
    echo '<style>
    body {
        ' . $bgStyle . '
        background-size: cover; 
        background-position: center;
        width: 100%;
        height: 100vh;
        margin: 0; /* Remove default body margin */
    }
</style>';

    switch ($page) {
        case 'home':
            require "../../pages/home/home.html";
            break;
        case 'about':
            require "../../pages/about/about.html";
            break;
        case 'menu':
            require "../../pages/menu/menu.php";
            break;
        case 'profile':
            require "../../pages/profile/profile.php";
            break;
        default:
            echo "<h2>Page not found</h2>";
            break;
    }

    $output = ob_get_clean();
    echo trim($output);
}
