<?php
include_once __DIR__ . '/../../php/firebase/menu/menuOperations.php';
include_once __DIR__ . '/../../php/firebase/users/userOperations.php';
// include '../../php/general/sessionManagement.php';

$foods = json_decode(getEntireMenu(), true);
$currentUserId = getCurrentUserIdFromSession();
$isAdmin = checkAdmin($currentUserId);
?>

<div class='menuPage container'>

    <?php
    if ($isAdmin == 'true') {
        include __DIR__ . '/../admin_only_pages/foodInputModal.html';
        echo "
        <div class='d-flex justify-content-center p-3'>
            <button type='button' data-bs-toggle='modal' data-bs-target='#foodInputModal' 
            class='addBtn btn btn-success btn-lg fs-3 m-3 rounded-circle'>
                <i class='fa-solid fa-plus'></i>
            </button>
        </div>
        ";
    }
    ?>

    <h1 class='menuHeading row justify-content-center mt-4'>Our Menu</h1>
    <div class='foodContainer row justify-content-center' style='overflow-x: hidden;'>

        <?php
        foreach ($foods as $food) {
            echo "
            <div data-key={$food['id']} class='foodCard card col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 m-3' style='width: 15rem;'>
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

<script type="module">
    import {
        deleteFood
    } from '../../assets/js/foodOperations.js';

    $('.deleteBtn').click(function(e) {
        let foodId = $(this).closest('.foodCard').data('key');

        //Sweet alert

        deleteFood(foodId);
    });
</script>