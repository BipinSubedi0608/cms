import loader from '../../pages/global_pages/loadingComponent.js';

export function placeOrder(foodId) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/menu/orderOperations.php",
        data: { 'orderOperation': 'create', 'foodId': foodId },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}

// export async function getOldOrders() {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             type: "POST",
//             url: "../../php/firebase/menu/orderOperations.php",
//             data: { 'orderOperation': 'getOld' },
//             dataType: "application/json",
//             success: function (response) {
//                 console.log(response);
//                 resolve(response);
//             },
//             error: function (error) {
//                 console.log("error: " + error.responseText);
//                 reject(error.responseText);
//             },
//         });
//     })
// }

export async function getOrder(orderId) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/menu/orderOperations.php",
        data: { 'orderOperation': 'get', 'orderId': orderId },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}

export async function getOrderFromReference(referenceBy, referenceId) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/menu/orderOperations.php",
        data: {
            'orderOperation': 'reference',
            'referenceBy': referenceBy,
            'referenceId': referenceId,
        },
        dataType: "application/json",
        success: function (response) {
            console.log("Success: " + response);
        },
        error: function (error) {
            console.log(error.responseText);
        },
    });
}

export async function showOrderConfirmModal(orderId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "../../pages/admin_only_pages/orderConfirmModal.php",
            data: { 'orderId': orderId },
            dataType: "application/json",
            success: function (response) {
                // console.log(response);
                reject(response);
            },
            error: function (error) {
                // console.log("error: " + error.responseText);
                resolve(error.responseText);
            },
        });
    });
}

export function confirmOrder(orderId) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/menu/orderOperations.php",
        data: { 'orderOperation': 'confirm', 'orderId': orderId },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}

export function renderOrdersHistory() {
    $('body').append(loader);
    $('body').css("pointer-events", "none");
    $.ajax({
        type: "POST",
        url: "../../pages/admin_only_pages/orders.php",
        data: { 'renderOptions': 'history' },
        dataType: "application/json",
        success: function (response) {
            // console.log(response);
            $('#root').html(response);
            $('body').css("pointer-events", "all");
        },
        error: function (error) {
            // console.log("error: " + error.responseText);
            $('#root').html(error.responseText);
            $('body .loader').remove();
            $('body').css("pointer-events", "all");
        },
    });
}