import foods from "../Models/foods.js" ;

$(document).ready(function () {

    $(".foodContainerDiv").hover(
        function() {
            var img = $(this).find('img');
            var btn = $(this).find('button');
            img.addClass('scale-110');
            btn.addClass('scale-110');
        },
        function() {
            var img = $(this).find('img');
            img.removeClass('scale-110');
            var btn = $(this).find('button');
            btn.removeClass('scale-110');
        }
    );

    var foodImg = document.getElementsByClassName("foodImg");
    var foodName = document.getElementsByClassName("foodName");
    var foodQuantity = document.getElementsByClassName("foodQuantity");
    var foodPrice = document.getElementsByClassName("foodPrice");

    for (let i = 0; i < 5; i++)
    {
        foodImg[i].src = foods[i+1].imgSrc;
        foodName[i].innerHTML = foods[i+1].name;
        foodQuantity[i].innerHTML = foods[i+1].quantity;
        foodPrice[i].innerHTML = foods[i+1].price;
    }
});