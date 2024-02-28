<?php
include '../../php/firebase/menu/menuOperations.php';
include '../../php/firebase/users/userOperations.php';
include '../../php/firebase/users/sessionManagement.php';

$foods = json_decode(getEntireMenu(), true);
$currentUserId = getCurrentUserFromSession()['id'];
$isAdmin = checkAdmin($currentUserId);
?>

<div class='menuPage container'>

    <?php
    if ($isAdmin == 'true') {
        include 'addFoodModel.html';
    }
    ?>

    <h1 class='menuHeading row justify-content-center mt-4'>Our Menu</h1>
    <div class='foodContainer row justify-content-center' style='overflow-x: hidden;'>

        <?php
        foreach ($foods as $food) {
            echo "
            <div key={$food['id']} class='foodCard card col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 m-3' style='width: 15rem;'>
                <img class='foodImage card-img-top py-2' src='{$food['imgUrl']}' alt='Card image cap'>
                <div class='card-body'>
                    <div class='foodName card-title h3'>{$food['name']}</div>
                    <div class='foodDetailsContainer hstack gap-2'>
                        <div class='card-text'>Quantity: <span class='foodQuantity'>{$food['quantity']}</span></div>
                        <vr class='vr'></vr>
                        <div class='card-text '>Price: Rs. <span class='foodPrice'>{$food['price']}</span></div>
                    </div>" . ($isAdmin == 'true' ? "

                    <div class='text-center hstack gap-3'>
                        <button type='button' class='editBtn btn btn-warning mt-3'>
                            <i class='fa-solid fa-pencil'></i>&#160;Edit
                        </button>
                        <button type='button' class='deleteBtn btn btn-outline-danger mt-3'>
                            <i class='fa-solid fa-trash'></i>&#160;Delete
                        </button>
                    </div>
                        " : "

                    <div class='text-center'>
                        <button type='button' class='buyBtn btn mt-3'>
                            <i class='fa-solid fa-cart-plus fa-lg'></i>&#160;&#160; Buy Now
                        </button>
                    </div>
                    ") . "

                </div >
            </div >";
        }



        ?>
    </div>
</div>