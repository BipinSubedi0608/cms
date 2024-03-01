<?php
include '../../php/firebase/users/userOperations.php';
include '../../php/firebase/users/sessionManagement.php';

$currentUserId = getCurrentUserIdFromSession();
$currentUser = json_decode(getUser($currentUserId), true);
?>

<div class="row w-100">
    <div class="col-4">
        <button class="editProfileBtn btn btn-warning m-4"><i class="fa-solid fa-pencil"></i> Update Password</button>

        <div class="card m-4" style="width: 70%;">
            <div class="card-body">
                <div class="text-center">
                    <img src="../assets/images/Default-Profile.png" alt="avatar" class="rounded-circle img-fluid border border-5" style="width: 150px;">
                    <h5 class="stdName my-3">
                        <?php echo $currentUser['name']; ?>
                    </h5>
                </div>
                <hr>
                <div class="vstack">
                    <p class="font-weight-bold text-dark">Student Id: <span class="stdId text-muted">
                            <?php echo $currentUser['std_id']; ?>
                        </span></p>
                    <p class="font-weight-bold text-dark">Faculty: <span class="stdFaculty text-muted">
                            <?php echo $currentUser['faculty']; ?>
                        </span></p>
                    <p class="font-weight-bold text-dark">Grade: <span class="stdGrade text-muted">
                            <?php echo $currentUser['grade']; ?>
                        </span></p>
                    <p class="font-weight-bold text-dark">Section: <span class="stdSection text-muted">
                            <?php echo $currentUser['section']; ?>
                        </span></p>
                </div>
            </div>
        </div>
    </div>


    <div class="col-8">
        <div class="card m-4" style="width: 80%;">
            <div class="card-header">
                <h4>General Information</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <tr>
                        <th scope="row">Date Of Birth</th>
                        <td class="stdDob user-select-all">
                            <?php echo $currentUser['general_info']['dob']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Roll No</th>
                        <td class="stdRollNo user-select-all">
                            <?php echo $currentUser['general_info']['roll_no']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Gender</th>
                        <td class="stdGender user-select-all">
                            <?php echo $currentUser['general_info']['gender']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Father's Name</th>
                        <td class="stdFatherName user-select-all">
                            <?php echo $currentUser['general_info']['father_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Mother's Name</th>
                        <td class="stdMotherName user-select-all">
                            <?php echo $currentUser['general_info']['mother_name']; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mx-4 mt-5" style="width: 80%;">
            <div class="card-header">
                <h4>Credentials</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th scope="row">Phone</th>
                        <td class="user-select-all">
                            <span class="stdPhone">
                                <?php echo $currentUser['credentials']['phone']; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td class="user-select-all">
                            <span class="stdEmail">
                                <?php echo $currentUser['credentials']['email']; ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>