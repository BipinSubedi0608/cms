export function placeOrder(foodId) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/menu/orderOperations.php",
        data: { 'operation': 'create', 'foodId': foodId },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}

export async function getOrder(orderId) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/menu/orderOperations.php",
        data: { 'operation': 'get', 'orderId': orderId },
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
            'operation': 'reference',
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
        data: { 'operation': 'confirm', 'orderId': orderId },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}