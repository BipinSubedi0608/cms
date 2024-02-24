import loadPageInRootContainer from "./assets/js/loadPage.js";
import { loginCall } from "./assets/js/login.js";

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