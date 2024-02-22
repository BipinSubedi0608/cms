import { loadContent } from "./loadPage.js";

let responseData = {};

function loginCall(formData) {
    $.ajax({
        url: '../../src/php/login.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            console.log(response);
            responseData = response;
            $('.loginBackgroundImage').hide();
            $('.navbar').show();
            loadContent('home');
        },
        error: function (error) {
            responseData = error;
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}

export function getUserData() {
    return responseData;
}

$(document).ready(() => {
    $('.navbar').hide();
    $("#loginForm").submit(function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        loginCall(formData);
    });

    $('.logoutBtn').click(function (e) {
        e.preventDefault();
        $('.navbar').hide();
        $('.loginBackgroundImage').show();
    });
});
