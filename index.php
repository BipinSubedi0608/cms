<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rosarivo&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>


  <!-- BootStrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Jquery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- Sweet Alert CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- External CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- External Javascript -->
  <script src="assets/js/profileDisplay.js" type="module" defer></script>
  <script src="assets/js/loadPage.js" type="module" defer></script>
  <script src="assets/js/login.js" type="module" defer></script>

  <script src="assets/js/script.js" type="module" defer></script>

  <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">

  <title>VAC Canteen</title>
</head>

<body>
  <?php
  require_once "php/firebase/users/sessionManagement.php";
  require_once "php/firebase/users/userOperations.php";
  require_once "php/general/loadContent.php";

  $loginStatus = json_decode(checkSession(), true);

  if ($loginStatus['isLoggedIn'] == 'true') {
    $isAdmin = checkAdmin(getCurrentUserIdFromSession());
    $defaultPage = ($isAdmin == 'true') ? 'orders' : 'home';
  }

  $sessionExpiredAlert = "
    <script>
      Swal.fire({
        icon: 'info',
        title: 'Session Expired',
        text: 'Please re-login',
        showConfirmButton: true,
        allowOutsideClick: false,
      }).then((value) => {
        if (value.isConfirmed) {
          Swal.close();
          // location.reload(true);
        }
      });
    </script>
  ";


  //Conditional Rendering for Login Status
  if ($loginStatus['isLoggedIn'] == 'true') {
    refreshSession();
    require "pages/global_pages/navbar.php";
  } else {

    loadPage('login');
    if ($loginStatus['message'] == 'Session Expired') {
      echo $sessionExpiredAlert;
    }
  }
  ?>

  <div id="root">
    <?php if ($loginStatus['isLoggedIn'] == 'true') loadPage($defaultPage) ?>
  </div>
</body>

</html>