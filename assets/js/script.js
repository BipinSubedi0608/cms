import loadPageInRootContainer from "./loadPage.js";
import { loginCall, logoutCall } from "./login.js";

$(document).ready(function () {

  $("#loginForm").submit(function (e) {
    e.preventDefault();
    let formData = {};
    $(this).serializeArray().forEach(function (item) {
      formData[item.name] = item.value;
    });
    loginCall(formData);
  });

  $('#homePageOrderBtn').click(function (e) {
    loadPageInRootContainer('menu');
    $('.active').removeClass("active");
    $('.navbarBtn[data-page="menu"]').addClass("active");
  });

  $('.logoutBtn').click(function (e) {
    e.preventDefault();
    logoutCall();
    loadPageInRootContainer('login');
  });

  $('.navbarBtn').click(function (e) {
    e.preventDefault();
    var page = $(this).data('page');
    $('.active').removeClass("active");
    $(this).addClass('active');
    loadPageInRootContainer(page);
  });

  $('.profileBtn').click(function (e) {
    e.preventDefault();
    $('.active').removeClass("active");
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