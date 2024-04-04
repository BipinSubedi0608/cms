<?php
include "../../php/firebase/users/userOperations.php";
include "../../pages/admin_only_pages/multiStepForm.html";
// Check if generateData parameter is set
if (isset($_POST['generateData'])) {
    // Decode JSON data received
    $userDataFromSearchField = isset($_POST['userDataFromSearchField']) ? $_POST['userDataFromSearchField'] : "";
    // if JSON data is not empty
    if (!empty($userDataFromSearchField)) {
        $userData = json_decode($userDataFromSearchField, true);
    } else {
        echo "JSON data is empty";
    }
} else {
    if (isset($_POST['direction'])) {
        // Decode JSON data received
        $direction = isset($_POST['direction']) ? $_POST['direction'] : "";
        // if JSON data is not empty
        if (!empty($direction)) {
            $userData = json_decode(sortedUserData($direction), true);
        } else {
            echo "JSON data is empty.";
        }
    } else {
        // Handle case where generateData parameter is not set
        $userData = json_decode(sortedUserData("Ascending"), true);
    }
}
?>

<!-- Header Buttons and Search  -->
<div id="userPage">
    <div class="d-flex align-items-center justify-content-center">
        <button type="button" class="editProfileBtn btn btn-warning m-4 me-auto" data-bs-toggle="modal" data-bs-target="#multiLevelModal">Add User <i class="fa-solid fa-plus"></i></button>
        <div class="input-group" style="width: 30%;">
            <input id="search-input" type="search" class="form-control searchInputValue" placeholder="Search" aria-label="Search" aria-describedby="search-button">
            <button id="search-button" class="btn btn-primary SearchBtn" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <button class="editProfileBtn btn btn-warning m-4 ms-auto sortByBtn">Sort By Name
            <?php
            $isSorted = isset($_POST['isSorted']) ? $_POST['isSorted'] : "false";
            if ($isSorted == "true") {
                $iconClass = 'bi bi-sort-up';
            } else {
                $iconClass = 'bi bi-sort-down';
            }
            ?>
            <i id="btnIcon" class="<?php echo $iconClass; ?>"></i>
        </button>
    </div>

    <!-- User Lists in Table Format -->
    <div class="table-responsive userTable">
        <table class="table table-striped myTable">
            <thead>
                <tr class="table-primary">
                    <th scope="col">S.N</th>
                    <th scope="col">Name</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Section</th>
                    <th scope="col">Faculty</th>

                </tr>
            </thead>
            <tbody id="tBody">
                <?php
                $index = 1;
                foreach ($userData as $userValue) : ?>
                    <tr data-bs-toggle="modal" data-bs-target="#userDetails">
                        <th><?php echo $index ?></th>
                        <td><?php echo $userValue["name"] ?></td>
                        <td><?php echo $userValue["std_id"] ?></td>
                        <td><?php echo $userValue["grade"] ?></td>
                        <td><?php echo $userValue["section"] ?></td>
                        <td><?php echo $userValue["faculty"] ?></td>
                    </tr>
                <?php
                    $index++;
                endforeach;
                ?>

            </tbody>
        </table>
    </div>
</div>

<script type="module">
    import {
        getSearchedUserList,
        generateUserSeachedData,
        sortUserData,
        showUserDetailsModal
    } from "../../assets/js/userOperations.js";
    $(document).ready(function() {
        // Event handler for search button click
        $(".SearchBtn").click(async function(e) {
            e.preventDefault();
            // Get the value from the input field
            let toSearch = $(".searchInputValue").val();

            // Define the filter field based on the input value
            let filterField = (!toSearch || isNaN(toSearch.charAt(0))) ? 'name' : 'std_id';

            // Check if the search value is not empty
            if (toSearch !== "") {
                let userDataFromSearchField = await getSearchedUserList(toSearch, filterField);
                if (userDataFromSearchField === "No user found") {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: "Oops! Data Not Found"
                    });
                } else {
                    // Clear existing table data and display the searched user list
                    $(".userTable tbody").empty();
                    generateUserSeachedData(userDataFromSearchField);
                }
            }
        });

        $(".sortByBtn").click(function(e) {
            e.preventDefault();
            let sortDirection = "";
            let isSorted = "";
            if ($('#btnIcon').hasClass('bi bi-sort-down')) {
                sortDirection = "Descending";
                isSorted = "true";
            } else {
                sortDirection = "Ascending";
                isSorted = "false";
            }
            $(".userTable tbody").empty(); // Empty the table tbody
            sortUserData(sortDirection, isSorted);
        });

        $('.table tbody tr').click(async function() {
            var stdId = $(this).find('td:eq(1)').text();
            console.log(stdId);
            let orderConfirmModal = await showUserDetailsModal(stdId);

            // console.log(orderConfirmModal);
            $('#userPage').append(orderConfirmModal);
            $('#userDetails').modal('show');
        });
      
    });
</script>