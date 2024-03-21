<?php
include_once __DIR__ . "/../../php/firebase/menu/menuOperations.php";
include_once __DIR__ . "/../../php/firebase/menu/orderOperations.php";
include_once __DIR__ . "/../../php/firebase/users/userOperations.php";

date_default_timezone_set('Asia/Kathmandu');
$ordersList = json_decode(getAllOrders(), true);

function orderCardComponent($orderData, $orderedFoodData, $orderedUserData)
{
    $orderedTime = date('H:i', $orderData['orderTime']);
    return "
    <div class='row justify-content-center my-4 mx-2'>
        <div data-key={$orderData['id']} class='orderCard card position-relative border-dark shadow-lg p-0 w-50'>
            <div class='hstack gap-3 p-0'>
                <img height='72' width='72' src={$orderedFoodData['imgUrl']} alt={$orderedFoodData['name']}>
                <div class='card-body p-2'>
                    <div class='hstack gap-3'>
                        <h5 class='card-title'>{$orderedFoodData['name']}</h5>
                        <p class='card-text text-dark ms-auto me-4'>Price: Rs. {$orderedFoodData['price']}</p>
                    </div>
                    <div class='hstack gap-3'>
                        <p class='card-text mb-0'><small class='text-muted'>Ordered by: {$orderedUserData['name']}</small></p>
                        <p class='card-text ms-auto me-4'><small class='text-muted'>Order time: {$orderedTime}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ";
}
?>

<div id="orderPage">
    <div class="row w-100">
        <div class="col">
            <div class="row my-3 mx-2 mb-4">
                <div class="hstack gap-5">
                    <button type='button' class='historyBtn btn btn-secondary'>
                        <i class="fa-solid fa-clock-rotate-left"></i>&#160;History
                    </button>
                    <div class="input-group ms-auto" style="max-width: 40vw;">
                        <input type="text" class="orderSearchInput form-control" placeholder="Enter student id" aria-label="Enter student id">
                        <div class="input-group-append">
                            <button class="orderSearchBtn btn btn-secondary" type="button" style="border-radius: 0 0.375rem 0.375rem 0;">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            foreach ($ordersList as $order) {
                $orderedFood = json_decode(getFoodWithId($order['foodId']), true);
                $orderedUser = json_decode(getUser($order['studentId']), true);
                echo orderCardComponent($order, $orderedFood, $orderedUser);
            }

            ?>
        </div>

        <!-- <div class="col-4">
            <div class="aside-right bg-secondary" style="height: 100vh; width:30%; overflow: hidden; position: fixed; right: 0;">
                <div class="vstack m-5">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter student id" aria-label="Enter student id" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <
                </div>
            </div>
        </div> -->

    </div>
</div>



<script type="module">
    import {
        showOrderConfirmModal,
        getOrderFromReference
    } from '../../assets/js/orderOperations.js';

    import {
        getUserIdFromClgId,
    } from '../../assets/js/userOperations.js';

    $(document).ready(() => {
        $('.orderCard').click(async function(e) {
            let orderConfirmModal = await showOrderConfirmModal($(this).data('key'));
            $('#orderPage').append(orderConfirmModal);
            $('#orderConfirmModal').modal('show');
        });

        $('.orderSearchBtn').click(async function(e) {
            let clgId = $('.orderSearchInput').val();
            let stdId = await getUserIdFromClgId(clgId);
            console.log("StdId: " + stdId);
            getOrderFromReference("student", stdId);
        });
    });
</script>