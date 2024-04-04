import loader from '../../pages/global_pages/loadingComponent.js';
import {logoutCall} from './login.js';
export async function createNewUser(email, password) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: '../../php/firebase/users/userOperations.php',
            data: {
                'operation': 'createUser',
                'email': email,
                'password': password
            },
            success: function (response) {
                resolve(response);
            },
            error: function (err) {
                console.log(err);
                reject(err);
            }
        });
    });
}

export function updateUserData(userId, userData) {
    $.ajax({
        type: "POST",
        url: '../../php/firebase/users/userOperations.php',
        data: {
            'operation': 'updateUser',
            'userId': userId,
            'userData': userData
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

export function getUserDetails(stdId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: '../../php/firebase/users/userOperations.php',
            data: { 'operation': 'getUser', 'stdId': stdId },
            dataType: "application/json",
            success: function (response) {
                console.log(response);
                reject(response);
            },
            error: function (error) {
                console.log("error: " + error.responseText);
                resolve(error.responseText);
            },
        });
    });
}

export function getUserIdFromClgId(clgId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: '../../php/firebase/users/userOperations.php',
            data: { 'operation': 'tradeId', 'clgId': clgId },
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

export function updatePassword(oldPass, newPass) {
    $.ajax({
        type: 'POST',
        url: '../../php/firebase/users/userOperations.php',
        data: {
            'operation': 'changePass',
            'oldPass': oldPass,
            'newPass': newPass,
        },
        dataType: "application/json",
        success: function (response) {
            response = JSON.stringify(response)
            console.log(response);
        },
        error: function (error) {
            console.log("Error: " + error.responseText);
            error = JSON.parse(error.responseText);

            if (error.status == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Password Changed Successfully',
                    text: "Please re-login with your new password",
                    showConfirmButton: true,
                    allowOutsideClick: true,
                    timer: 2500,
                    timerProgressBar: true,
                }).then(() => {
                    Swal.close();
                    logoutCall();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: `Error ${error.status}`,
                    text: error.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                    timer: 3000,
                    timerProgressBar: true,
                }).then((value) => {
                    if (value.isConfirmed) {
                        Swal.close();
                    }
                });
            }
        }
    });
}

export function getSearchedUserList(toSearch, filterField) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "POST",
            url: "../../php/firebase/users/userOperations.php",
            data: { "operation": "getSearchedUsers", "toSearch": toSearch, "filterField": filterField },  //'searchTerm' is the keyword that user entered in
            dataType: "application/json",
            success: function (response) {
                console.log("Sucess:-" + response);
                reject(response);
            },
            error: function (err) {
                // console.log("Error:- " + err.responseText);
                resolve(err.responseText);
            }
        });
    })

}

export function generateUserSeachedData(userDataFromSearchField) {
    console.log(userDataFromSearchField);
    $('body').append(loader);
    $('body').css("pointer-events", "none");
    $.ajax({
        type: "POST",
        url: "../../pages/admin_only_pages/usersList.php",
        data: { "generateData": "true", "userDataFromSearchField": userDataFromSearchField },
        dataType: "application/json",
        success: function (response) {
            console.log(response);
            $('body').css("pointer-events", "all");
        },
        error: function (error) {
            $('#root').html(error.responseText);
            $('body .loader').remove();
            $('body').css("pointer-events", "all");
        },
    });
}

export function sortUserData(direction, isSorted) {
    console.log(direction);
    $('body').append(loader);
    $('body').css("pointer-events", "none");
    $.ajax({
        type: "POST",
        url: "../../pages/admin_only_pages/usersList.php",
        data: { "isSorted": isSorted, "direction": direction },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('body').css("pointer-events", "all");
        },
        error: function (error) {
            $('#root').html(error.responseText);
            $('body .loader').remove();
            $('body').css("pointer-events", "all");
        }
    });
}

export async function showUserDetailsModal(stdId) {
    console.log(stdId);
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "../../pages/admin_only_pages/userDetails.php",
            data: { "stdId": stdId },
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