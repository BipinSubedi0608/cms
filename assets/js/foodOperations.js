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
            location.reload(true);
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
            location.reload(true);
        },
    });
}

export function editFood(foodId, newFoodData) {
    $.ajax({
        url: "../../php/firebase/menu/menuOperations.php",
        type: "POST",
        data: { 'operation': 'edit', 'foodId': foodId, ...newFoodData },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
            location.reload(true);
        },
        error: function (error) {
            console.log("error: " + error.responseText);
            location.reload(true);
        },
    });
}
