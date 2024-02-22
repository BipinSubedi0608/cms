import { getDocs } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
import { usersCollection } from "../../index.js";

let studentModel = {
    std_id: undefined,
    name: undefined,
    grade: undefined,
    section: undefined,
    faculty: undefined,
    general_info: {
        dob: undefined,
        roll_no: undefined,
        gender: undefined,
        father_name: undefined,
        mother_name: undefined
    },
    credentials: {
        phone: undefined,
        email: undefined,
        password: undefined
    }
};

getDocs(usersCollection)
    .then((snapshot) => {
        let userData = [];
        snapshot.docs.forEach((user) => {
            userData.push({ id: user.id, ...user.data() });
        });
        studentModel = userData[0];
    })
    .catch((err) => {
        console.log(err);
    })

function mapStudentData() {

    // console.log([...$(".stdName")]);
    setTimeout(function () {
        $(".stdName").html(studentModel.name);
        $(".stdId").html(studentModel.std_id);
        $(".stdFaculty").html(studentModel.faculty);
        $(".stdGrade").html(studentModel.grade);
        $(".stdSection").html(studentModel.section);

        $(".stdDob").html(studentModel.general_info.dob);
        $(".stdRollNo").html(studentModel.general_info.roll_no);
        $(".stdGender").html(studentModel.general_info.gender);
        $(".stdFatherName").html(studentModel.general_info.father_name);
        $(".stdMotherName").html(studentModel.general_info.mother_name);

        $(".stdPhone").html(studentModel.credentials.phone);
        $(".stdPassword").html(studentModel.credentials.password);
        $(".stdEmail").html(studentModel.credentials.email);
    }, 100);
}

$(document).ready(() => {
    $(".profileBtn").click(function (e) {
        e.preventDefault();
        mapStudentData();
    })
})