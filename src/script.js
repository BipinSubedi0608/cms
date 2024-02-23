import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
import { getFirestore, collection, getDocs, onSnapshot, addDoc, doc, setDoc } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
import loadPageInRootContainer from "./assets/js/loadPage.js";
import { loginCall } from "./assets/js/login.js";
import mapStudentData from "./assets/js/profileDisplay.js";

//Firebase configuration json
const firebaseConfig = {
  apiKey: "AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs",
  authDomain: "cms-08-02-2024.firebaseapp.com",
  projectId: "cms-08-02-2024",
  storageBucket: "cms-08-02-2024.appspot.com",
  messagingSenderId: "686529005527",
  appId: "1:686529005527:web:fc7c0d88ca9739e3572d92",
  measurementId: "G-FHD42CTLG1"
};

//Initialization of firebase app
const app = initializeApp(firebaseConfig);

//Get reference to the firestore database
const db = getFirestore(app);

//Get collection reference of 'menu' collection
const menuCollection = collection(db, "menu");
const usersCollection = collection(db, "users");

export { db, menuCollection, usersCollection };


const defaultPage = 'home';

function loadLoginPage() {
  $('.navbar').hide();
  $('.loginBackgroundImage').show();
}

function loadMainPage() {
  $('.loginBackgroundImage').hide();
  $('.navbar').show();
  loadPageInRootContainer(defaultPage);
}

$(document).ready(function () {
  loadLoginPage();

  //Go to the main page after login
  $("#loginForm").submit(function (e) {
    e.preventDefault();
    let formData = $(this).serialize();
    loginCall(formData);
    loadMainPage();
  });

  //Go to login page after logout
  $('.logoutBtn').click(function (e) {
    e.preventDefault();
    loadLoginPage();
  });

  //Navigate to specific page on click of a navbar button
  $('.navbarBtn').click(function (e) {
    e.preventDefault();
    var page = $(this).data('page');
    [...$('.navbarBtn')].forEach((element) => {
      $(element).removeClass('active')
    });
    $(this).addClass('active');
    loadPageInRootContainer(page);
  });

  //Navigate to profile page on click of profile button
  $('.profileBtn').click(function (e) {
    e.preventDefault();
    [...$('.navbarBtn')].forEach((element) => {
      $(element).removeClass('active')
    });
    loadPageInRootContainer('profile');
    mapStudentData();
  });

});














// let user = [
//   {
//     std_id: 12438,
//     name: "Bipin Subedi",
//     faculty: "Science",
//     grade: "XII",
//     section: "E",

//     general_info: {
//       dob: "2006-09-25",
//       roll_no: 13,
//       gender: "Male",
//       father_name: "Buddhi Kanta Subedi",
//       mother_name: "Nirmala Subedi"
//     },

//     credentials: {
//       phone: "9808186701",
//       email: "bipinsubedi@example.com",
//       password: "Pass1234"
//     }
//   },

//   {
//     std_id: 12481,
//     name: "Zenithjung Karki",
//     faculty: "Science",
//     grade: "XII",
//     section: "E",

//     general_info: {
//       dob: "2007-04-26",
//       roll_no: 28,
//       gender: "Male",
//       father_name: "Dinesh Karki",
//       mother_name: "Tirtha Karki"
//     },

//     credentials: {
//       phone: "9804463437",
//       email: "zenithjungkarki@example.com",
//       password: "Pass1234"
//     }
//   },

//   {
//     std_id: 12469,
//     name: "Rakshak Sigdel",
//     faculty: "Science",
//     grade: "XII",
//     section: "E",

//     general_info: {
//       dob: "2005-10-10",
//       roll_no: 24,
//       gender: "Male",
//       father_name: "Ramesh Sigdel",
//       mother_name: "Kopila Sigdel"
//     },

//     credentials: {
//       phone: "9819322151",
//       email: "rakshaksigdel@example.com",
//       password: "Pass1234"
//     }
//   }
// ];