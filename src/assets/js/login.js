import loadPageInRootContainer from "./loadPage.js";

let responseData = {};

export function loginCall(formData) {
    $.ajax({
        url: '../../src/php/general/login.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            responseData = JSON.parse(response);
            console.log(responseData);
            if (responseData.status != undefined && responseData.status != 200) {
                alert(`Error ${responseData.status}: ${responseData.message}`)
            } else {
                alert("Login Sucessful!!");
                loadPageInRootContainer('home');
            }
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
