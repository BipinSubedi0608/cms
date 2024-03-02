export function addFood(foodData) {
    $.ajax({
        url: "../../php/firebase/menu/menuOperations.php",
        type: "POST",
        data: { 'operation': 'add', ...foodData },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}

export function deleteFood(foodId) {
    $.ajax({
        url: "../../php/firebase/menu/menuOperations.php",
        type: "POST",
        data: { 'operation': 'delete', 'foodId': foodId },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
        },
    });
}