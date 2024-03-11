<?php
include_once __DIR__ . "/../../php/firebase/menu/menuOperations.php";
include_once __DIR__ . "/../../php/firebase/menu/orderOperations.php";
include_once __DIR__ . "/../../php/firebase/users/userOperations.php";

date_default_timezone_set('Asia/Kathmandu');
$orders = json_decode(getAllOrders(), true);
?>

<div id="orderPage">
    <div class="row w-100 justify-content-center">
        <div class="row">
            <h1 class="mt-3 mb-5 text-center"><i>Orders</i></h1>
        </div>


        <?php foreach ($orders as $order) :
            $orderedFood = json_decode(getFoodWithId($order['foodId']), true);
            $orderedUser = json_decode(getUser($order['studentId']), true);
            $orderedTime = date('H:i', $order['orderTime']);
        ?>
            <div data-key="<?php echo $order['id']; ?>" class="orderCard card row border-dark shadow-lg mb-3 p-0" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img style="aspect-ratio: 1/1;" src="<?php echo $orderedFood['imgUrl']; ?>" class="img-fluid rounded-start" alt="<?php echo $orderedFood['name']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $orderedFood['name']; ?></h3>
                            <p class="card-text text-dark">Price: Rs. <?php echo $orderedFood['price']; ?></p>
                            <p class="card-text mb-0"><small class="text-muted">Ordered by: <?php echo $orderedUser['name']; ?></small></p>
                            <p class="card-text"><small class="text-muted">Order time: <?php echo $orderedTime; ?></small></p>
                            <?php if ($order['isBought'] == 'true') echo "Bought"; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


    </div>
</div>



<script type="module">
    import {
        showOrderConfirmModal
    } from '../../assets/js/orderOperations.js';

    $(document).ready(() => {
        $('.orderCard').click(async function(e) {
            let orderConfirmModal = await showOrderConfirmModal($(this).data('key'));
            $('#orderPage').append(orderConfirmModal);
            $('#orderConfirmModal').modal('show');
        });
    });
</script>