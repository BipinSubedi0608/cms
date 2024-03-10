<?php
include_once __DIR__ . "/../../php/firebase/menu/menuOperations.php";
include_once __DIR__ . "/../../php/firebase/menu/orderOperations.php";
include_once __DIR__ . "/../../php/firebase/users/userOperations.php";

date_default_timezone_set('Asia/Kathmandu');

$orders = json_decode(getAllOrders(), true);
?>

<div class="row w-100 justify-content-center">
    <div class="row">
        <h1 class="mt-3 mb-5 text-center"><i>Orders</i></h1>
    </div>


    <?php foreach ($orders as $order) :
        $orderedFood = json_decode(getFoodWithId($order['foodId']), true);
        $orderedUser = json_decode(getUser($order['studentId']), true);
        $orderedDate = date('Y/m/d', $order['orderTime']);
        $orderedTime = date('H:i', $order['orderTime']);
    ?>
        <div data-key="<?php echo $order['id']; ?>" class="orderCard card row border-dark shadow-lg mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?php echo $orderedFood['imgUrl']; ?>" class="img-fluid rounded-start" alt="<?php echo $orderedFood['name']; ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $orderedFood['name']; ?></h3>
                        <p class="card-text text-dark">Price: Rs. <?php echo $orderedFood['price']; ?></p>
                        <p class="card-text mb-0"><small class="text-muted">Ordered by: <?php echo $orderedUser['name']; ?></small></p>
                        <p class="card-text"><small class="text-muted">Order time: <?php echo $orderedTime; ?></small></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


</div>



<div class="modal fade" id="orderConfirmModal" tabindex="-1" aria-labelledby="orderConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderConfirmModalTitle">Confirm Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body d-flex justify-content-center">
                <div class="container row justify-content-between p-0">
                    <div class="col">
                        <h4 class="text-center mb-3">Student Details</h4>
                        <div class="card">
                            <img src="../../assets/images/Default-Profile.png" class="card-img-top img-thumbnail" alt="...">
                            <div class="card-body">
                                <div class="vstack gap-2">
                                    <p class="m-0">Name: Bipin Subedi</p>
                                    <p class="m-0">Student Id: 12438</p>
                                    <p class="m-0">Grade: XII</p>
                                    <p class="m-0">Section: E</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <h4 class="text-center mb-3">Food Details</h4>
                        <div class="card">
                            <img src="../../assets/images/Default-Food-Item.jpg" class="card-img-top img-thumbnail" alt="...">
                            <div class="card-body">
                                <div class="vstack gap-2">
                                    <p class="m-0">Name: Chowmein</p>
                                    <p class="m-0">Price: Rs. 40</p>
                                    <p class="m-0">Order Date: 2024/03/10</p>
                                    <p class="m-0">Order Time: 9:43AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="button" id="orderConfirmButton" class="btn btn-outline-info" data-bs-dismiss="modal">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        $('.orderCard').click(function(e) {
            $('#orderConfirmModal').modal('show');
        });
    });
</script>