// import { getDocs } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
// // import { usersCollection } from "../../script.js";

// let currentStudent = {
//     std_id: "",
//     name: "",
//     grade: "",
//     section: "",
//     faculty: "",
//     general_info: {
//         dob: "",
//         roll_no: "",
//         gender: "",
//         father_name: "",
//         mother_name: ""
//     },
//     credentials: {
//         phone: "",
//         email: "",
//         password: ""
//     }
// };

// getDocs(usersCollection)
//     .then((snapshot) => {
//         let userData = [];
//         snapshot.docs.forEach((user) => {
//             userData.push({ id: user.id, ...user.data() });
//         });
//         currentStudent = userData[0];
//     })
//     .catch((err) => {
//         console.log(err);
//     })

// export default function mapStudentData() {
//     setTimeout(function () {
//         $(".stdName").html(currentStudent.name);
//         $(".stdId").html(currentStudent.std_id);
//         $(".stdFaculty").html(currentStudent.faculty);
//         $(".stdGrade").html(currentStudent.grade);
//         $(".stdSection").html(currentStudent.section);

//         $(".stdDob").html(currentStudent.general_info.dob);
//         $(".stdRollNo").html(currentStudent.general_info.roll_no);
//         $(".stdGender").html(currentStudent.general_info.gender);
//         $(".stdFatherName").html(currentStudent.general_info.father_name);
//         $(".stdMotherName").html(currentStudent.general_info.mother_name);

//         $(".stdPhone").html(currentStudent.credentials.phone);
//         $(".stdPassword").html(currentStudent.credentials.password);
//         $(".stdEmail").html(currentStudent.credentials.email);
//     }, 100);
// }
