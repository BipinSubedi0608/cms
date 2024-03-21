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
            error = JSON.stringify(error)
            console.log(error);
        }
    });
}