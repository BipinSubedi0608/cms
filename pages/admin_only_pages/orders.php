<?php
include_once __DIR__ . "/../../php/firebase/menu/menuOperations.php";
include_once __DIR__ . "/../../php/firebase/menu/orderOperations.php";
include_once __DIR__ . "/../../php/firebase/users/userOperations.php";

date_default_timezone_set('Asia/Kathmandu');
$timestamp_12am = strtotime(date('Y/m/d') . ' 00:00:00');
$renderOptions = (isset($_POST['renderOptions'])) ? "history" : "default";
$operator = ($renderOptions == "history" ? "LESS_THAN" : "GREATER_THAN_OR_EQUAL");
$ordersList = array();

if (isset($_POST['search'])) {
    $ordersList = json_decode($_POST['search'], true);
    $renderOptions = $_POST['searchRenderOption'];
} else {
    $ordersList = json_decode(getFilteredOrders("orderTime", $timestamp_12am, $operator), true);
}

// echo "<br>.................<br>";
// echo json_encode($ordersList);
// echo "<br>.................<br>";

function orderCardComponent($orderData, $orderedFoodData, $orderedUserData)
{
    global $renderOptions;
    $orderedTime = date('H:i', $orderData['orderTime']);
    $orderedDate = date('Y/m/d', $orderData['orderTime']);
    return "
    <div class='row justify-content-center my-4 mx-2'>
        <div data-key={$orderData['id']} class='orderCard card position-relative border-dark shadow-lg p-0 w-50'>
        "
        . ($orderData['isBought'] == 'true' ?
            "<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success'>
                <i class='fa-solid fa-check'></i>
             </span> " : "") .
        "
            <div class='hstack gap-3 p-0'>
                <img height='72' width='72' src={$orderedFoodData['imgUrl']} alt={$orderedFoodData['name']}>
                <div class='card-body p-2'>
                    <div class='hstack gap-3'>
                        <h5 class='card-title'>{$orderedFoodData['name']}</h5>
                        <p class='card-text text-dark ms-auto me-4'>Price: Rs. {$orderedFoodData['price']}</p>
                    </div>
                    <div class='hstack gap-3'>
                        <p class='card-text mb-0'><small class='text-muted'>Ordered by: {$orderedUserData['name']}</small></p>
                        "
        . ($renderOptions == 'history' ? "
                        <p class='card-text ms-auto me-4'><small class='text-muted'>Order date: {$orderedDate}</small></p>
                        " : "
                        <p class='card-text ms-auto me-4'><small class='text-muted'>Order time: {$orderedTime}</small></p>
                        ") .
        "
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
                <div class="hstack gap-3">
                    <button type='button' class='historyBtn btn btn-secondary'>
                        <?php
                        echo ($renderOptions == "history") ?
                            '<i class="fa-solid fa-arrow-left"></i>&#160;<span id="historyBtnText">Back</span>' :
                            '<i class="fa-solid fa-clock-rotate-left"></i>&#160;<span id="historyBtnText">History</span>';
                        ?>
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

            <div id="ordersContainer">
                <?php
                foreach ($ordersList as $order) {
                    $orderedFood = json_decode(getFoodWithId($order['foodId']), true);
                    $orderedUser = json_decode(getUser($order['studentId']), true);
                    echo orderCardComponent($order, $orderedFood, $orderedUser);
                }

                ?>
            </div>
        </div>
    </div>
</div>



<script type="module">
    import {
        showOrderConfirmModal,
        getOrderFromStdId,
        renderOrdersHistory,
        renderSearchedOrders,
    } from '../../assets/js/orderOperations.js';

    import {
        getUserIdFromClgId,
    } from '../../assets/js/userOperations.js';

    $(document).ready(() => {
        let currentOrderPage = ($('#historyBtnText').text());

        $('.orderCard').click(async function(e) {
            console.log($(this).data('key'));
            let orderConfirmModal = await showOrderConfirmModal($(this).data('key'));
            $('#orderPage').append(orderConfirmModal);
            $('#orderConfirmModal').modal('show');
        });

        $('.historyBtn').click(function(e) {
            e.preventDefault();
            if (currentOrderPage == "History") {
                $('#ordersContainer').empty();
                renderOrdersHistory();
            } else {
                location.reload(true);
            }
        });

        $('.orderSearchBtn').click(async function(e) {
            let clgId = $('.orderSearchInput').val();
            let stdId = await getUserIdFromClgId(clgId);

            if (stdId == null || stdId == "") {
                Swal.fire({
                    icon: 'error',
                    title: `Error 404`,
                    text: "User with id " + clgId + " not found",
                    showConfirmButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                });
            } else {
                if (currentOrderPage == "History") { //Current Page NOT History
                    $('#ordersContainer').empty();
                    let searchedOrders = await getOrderFromStdId(stdId);
                    renderSearchedOrders(searchedOrders, "default");
                } else {
                    $('#ordersContainer').empty();
                    let searchedOrders = await getOrderFromStdId(stdId, "true");
                    renderSearchedOrders(searchedOrders, "history");
                }
            }
        });
    });
</script>