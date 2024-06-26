<?php
include_once __DIR__ . '/../../php/general/sessionManagement.php';
include_once __DIR__ . '/../../php/firebase/users/userOperations.php';

$currentUserId = getCurrentUserIdFromSession();
$currentUserName = json_decode(getUser($currentUserId), true)['name'];
$isAdmin = checkAdmin($currentUserId);
?>

<nav class="navbar sticky-top navbar-expand-lg navbarBackground">
    <div class="container-fluid mx-lg-5">
        <a class="navbar-brand logoHeader" href="https://plustwo.vac.edu.np/" target="_blank">
            <img src="../../assets/images/VASS-Logo.png" alt="VAC" width="70" height="70" class="navbarLogo rounded-circle">
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav justify-content-center flex-grow-1">
                <?php echo ($isAdmin == "true") ?
                    '
                    <li class="nav-item">
                        <a class="nav-link active mx-lg-5 navbarBtn" href="#" data-page="orders">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-5 navbarBtn" href="#" data-page="menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-5 navbarBtn" href="#" data-page="users">Users</a>
                    </li>
                    ' :

                    '
                    <li class="nav-item">
                        <a class="nav-link active mx-lg-5 navbarBtn" href="#" data-page="home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-5 navbarBtn" href="#" data-page="menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-5 navbarBtn" href="#" data-page="about">About</a>
                    </li>
                    ';
                ?>
            </ul>
        </div>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../assets/images/Default-Profile.png" alt="User Avatar" width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark position-absolute" aria-labelledby="navbarDropdown">
                    <li class="dropdown-item disabled d-lg-auto">
                        <?php echo $currentUserName; ?>
                    </li>

                    <?php echo ($isAdmin == "true") ? '' :
                        '<li>
                            <a class="dropdown-item profileBtn" href="#">
                                Profile 
                                <i class="fa-solid fa-user"></i>
                            </a>
                        </li>';
                    ?>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="logoutBtn dropdown-item" href="#">
                            Logout
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

<div class="offcanvas offcanvas-end bg-dark text-light" tabindex="-1" id="navbarNavOffcanvas" aria-labelledby="navbarNavOffcanvasLabel">
    <div class="offcanvas-header">
        <span class="offcanvas-title iconLogoHeader" id="navbarNavOffcanvasLabel">VAC</span>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <?php echo ($isAdmin == "true") ?
                '
                <li class="nav-item">
                    <a class="nav-link active navbarBtn" href="#" data-page="orders">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbarBtn " href="#" data-page="menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbarBtn" href="#" data-page="users">Users</a>
                </li>
                    ' :

                '
                <li class="nav-item">
                    <a class="nav-link active navbarBtn" href="#" data-page="home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbarBtn " href="#" data-page="menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbarBtn" href="#" data-page="about">About</a>
                </li>
                    ';
            ?>

        </ul>
    </div>
</div>