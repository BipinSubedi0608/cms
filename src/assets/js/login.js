let responseData = {};

export function loginCall(formData) {
    $.ajax({
        url: '../../src/php/general/login.php',
        type: 'POST',
        data: { 'operation': 'login', ...formData },
        success: function (response) {
            responseData = JSON.parse(response);
            console.log(responseData);
            if (responseData.status != undefined && responseData.status != 200) {
                alert(`Error ${responseData.status}: ${responseData.message}`)
            } else {
                alert("Login Sucessful!!");
                location.reload(true);
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

export function logoutCall() {
    $.ajax({
        url: '../../src/php/general/login.php',
        type: 'POST',
        data: { 'operation': 'logout' },
        success: function (response) {
            console.log(response);
            location.reload(true);
        },
        error: function (error) {
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}
