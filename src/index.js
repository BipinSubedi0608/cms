import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
import { getFirestore, collection, getDocs, onSnapshot, addDoc, doc, setDoc } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";

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

let user = [
  {
    std_id: 12438,
    name: "Bipin Subedi",
    faculty: "Science",
    grade: "XII",
    section: "E",

    general_info: {
      dob: "2006-09-25",
      roll_no: 13,
      gender: "Male",
      father_name: "Buddhi Kanta Subedi",
      mother_name: "Nirmala Subedi"
    },

    credentials: {
      phone: "9808186701",
      email: "bipinsubedi@example.com",
      password: "Pass1234"
    }
  },

  {
    std_id: 12481,
    name: "Zenithjung Karki",
    faculty: "Science",
    grade: "XII",
    section: "E",

    general_info: {
      dob: "2007-04-26",
      roll_no: 28,
      gender: "Male",
      father_name: "Dinesh Karki",
      mother_name: "Tirtha Karki"
    },

    credentials: {
      phone: "9804463437",
      email: "zenithjungkarki@example.com",
      password: "Pass1234"
    }
  },

  {
    std_id: 12469,
    name: "Rakshak Sigdel",
    faculty: "Science",
    grade: "XII",
    section: "E",

    general_info: {
      dob: "2005-10-10",
      roll_no: 24,
      gender: "Male",
      father_name: "Ramesh Sigdel",
      mother_name: "Kopila Sigdel"
    },

    credentials: {
      phone: "9819322151",
      email: "rakshaksigdel@example.com",
      password: "Pass1234"
    }
  }
];

$(document).ready(() => {
  // let userRef = doc(db, 'users', 'jC7damLin8fmVqQUlutd2gDNbvm1');
  // setDoc(userRef, user[0]);
});

export { db, menuCollection, usersCollection };