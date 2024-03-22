<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $orderId = $_POST['orderId'];

    include_once __DIR__ . "/../../php/firebase/menu/menuOperations.php";
    include_once __DIR__ . "/../../php/firebase/menu/orderOperations.php";
    include_once __DIR__ . "/../../php/firebase/users/userOperations.php";

    $orderDetails = json_decode(getOrderWithId($orderId), true);
    $orderedFood = json_decode(getFoodWithId($orderDetails['foodId']), true);
    $orderedUser = json_decode(getUser($orderDetails['studentId']), true);

    date_default_timezone_set('Asia/Kathmandu');
    $todayDate = date('Y/m/d');

    $orderedDate = date('Y/m/d', $orderDetails['orderTime']);
    $orderedTime = date('H:i', $orderDetails['orderTime']);
?>

    <div data-key="<?php echo $orderId; ?>" class="modal fade" id="orderConfirmModal" tabindex="-1" aria-labelledby="orderConfirmModalLabel" aria-hidden="true">
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
                                <img style="aspect-ratio: 1/1;" src="../../assets/images/Default-Profile.png" class="card-img-top img-thumbnail" alt="...">
                                <div class="card-body">
                                    <div class="vstack gap-2">
                                        <p class="m-0">Name: <?php echo $orderedUser['name'] ?></p>
                                        <p class="m-0">Student Id: <?php echo $orderedUser['std_id'] ?></p>
                                        <p class="m-0">Grade: <?php echo $orderedUser['grade'] ?></p>
                                        <p class="m-0">Section: <?php echo $orderedUser['section'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <h4 class="text-center mb-3">Food Details</h4>
                            <div class="card">
                                <img style="aspect-ratio: 1/1;" src="<?php echo $orderedFood['imgUrl'] ?>" class="card-img-top img-thumbnail" alt="...">
                                <div class="card-body">
                                    <div class="vstack gap-2">
                                        <p class="m-0">Name: <?php echo $orderedFood['name'] ?></p>
                                        <p class="m-0">Price: Rs. <?php echo $orderedFood['price'] ?></p>
                                        <p class="m-0">Order Date: <?php echo $orderedDate ?></p>
                                        <p class="m-0">Order Time: <?php echo $orderedTime ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <?php if ($orderedDate == $todayDate) : ?>
                        <button type="button" id="orderConfirmButton" class="btn btn-outline-info" data-bs-dismiss="modal">
                            Confirm
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script type="module">
    import {
        confirmOrder
    } from '../../assets/js/orderOperations.js';

    $(document).ready(function() {
        $('#orderConfirmButton').click(function(e) {
            let orderId = $('#orderConfirmModal').data('key');
            confirmOrder(orderId);

            Swal.fire({
                icon: 'success',
                title: 'Order Bought Successfully',
                showConfirmButton: true,
                timer: 1500,
                timerProgressBar: true,
            }).then(() => {
                location.reload(true);
            });
        });
    });
</script>