import { getDocs } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
import { menuCollection } from "../../index.js";
import { getUserData } from "./login.js";

function menuBox({ id, imgUrl = "../src/assets/images/Default-Food-Item.jpg", name, quantity, price }) {
    let menuBoxModel = `
        <div data-key=${id} class="foodCard card col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 m-3" style="width: 15rem;">
            <img class="foodImage card-img-top py-2" src="${imgUrl}" alt="Card image cap">
            <div class="card-body">
                <div class="foodName card-title h3">${name}</div>
                <div class="foodDetailsContainer hstack gap-2">
                    <div class="card-text">Quantity: <span class="foodQuantity">${quantity}</span></div>
                    <vr class="vr"></vr>
                    <div class="card-text ">Price: Rs. <span class="foodPrice">${price}</span></div>
                </div>
                <div class="text-center">
                    <button type="button" class="buyBtn btn mt-3">
                        <i class="fa-solid fa-cart-plus fa-lg"></i>&#160;&#160; Buy Now
                    </button>
                </div>
            </div>
        </div>
    `;
    return menuBoxModel;
}

function adminMenuBox({ id, imgUrl = "../src/assets/images/Default-Food-Item.jpg", name, quantity, price }) {
    let menuBoxModel = `
        <div data-key=${id} class="foodCard card col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 m-3" style="width: 15rem;">
            <img class="foodImage card-img-top py-2" src="${imgUrl}"
            alt="Card image cap">
            <div class="card-body">
                <div class="foodName card-title h3">${name}</div>
                <div class="foodDetailsContainer hstack gap-2">
                    <div class="card-text">Quantity: <span class="foodQuantity">${quantity}</span></div>
                    <vr class="vr"></vr>
                    <div class="card-text ">Price: Rs. <span class="foodPrice">${price}</span></div>
                </div>
                <div class="text-center hstack gap-3">
                    <button type="button" class="editBtn btn btn-warning mt-3">
                        <i class="fa-solid fa-pencil"></i>&#160;Edit
                    </button>
                    <button type="button" class="deleteBtn btn btn-outline-danger mt-3">
                        <i class="fa-solid fa-trash"></i>&#160;Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    return menuBoxModel;
}

function addBtn() {
    let addBtnModel = `
        <div class="d-flex justify-content-center p-3">
            <button type="button" class="addBtn btn btn-success btn-lg fs-3 m-3 rounded-circle">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    `;
    return addBtnModel;
}

function displayMenu() {
    let currentUser = JSON.parse(getUserData());
    getDocs(menuCollection)
        .then((snapshot) => {
            // console.log(snapshot);
            snapshot.docs.forEach((food) => {
                let foodData = { id: food.id, ...food.data() };
                // console.log(foodData);
                if (currentUser.isAdmin) {
                    $(".foodContainer").append(adminMenuBox(foodData));
                } else {
                    $(".foodContainer").append(menuBox(foodData));
                }
            });
            if (currentUser.isAdmin) {
                $(".menuPage").append(addBtn());
            }
        })
        .catch((err) => {
            console.log(err);
        })
}

$(document).ready(() => {
    $(".navbarBtn").click(function (e) {
        e.preventDefault();
        if ($(this).data("page") == "menu") {
            displayMenu();
        }
    })
})
