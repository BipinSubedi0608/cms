import loadPageInRootContainer from "./loadPage.js";

let responseData = {};

export function loginCall(formData) {
    $.ajax({
        url: '../../src/php/login.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            console.log(response);
            responseData = response;
            loadPageInRootContainer('home');
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
