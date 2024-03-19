
var res;
var localId;
export function createEmailAndPassword(formObj) {
    $.ajax({
        type: "POST",
        url: "../../php/general/createUser.php",
        data: { ...formObj },
        success: function (response) {
            res = JSON.parse(response);
            console.log(res[0].localId);
            localId = res[0].localId;
        }
    });
}

export function addStudentData(formData) {
    $.ajax({
        type: "POST",
        url: "../../php/firebase/users/addStudentData.php",
        data: {localId,...formData },
        success: function (response) {
            console.log(response);
        }
    });
}