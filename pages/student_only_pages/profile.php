<?php
include_once '../../php/firebase/users/userOperations.php';
include_once '../../php/general/sessionManagement.php';

$currentUserId = getCurrentUserIdFromSession();
$currentUser = json_decode(getUser($currentUserId), true);
?>

<style>
    .profile-card {
        max-width: 400px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .profile-picture {
        margin-top: -75px;
        border: 3px solid #0d6efd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>



<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="updatePasswordForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Update Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body justify-content-center">
                    Enter old password: <input id="oldPassInput"><br><br>
                    Enter new password: <input id="newPassInput">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updatePasswordSubmit" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        $('.editProfileBtn').click(() => {
            $('#updatePasswordModal').modal('show');
        });


        $('#updatePasswordForm').submit(function(e) {
            e.preventDefault();
            let oldPass = $('#oldPassInput').val();
            let newPass = $('#newPassInput').val();
            $.ajax({
                url: '../../php/firebase/users/userOperations.php',
                type: 'POST',
                data: {
                    'operation': 'changePass',
                    'userId': "<?php echo $currentUserId; ?>",
                    'oldPass': oldPass,
                    'newPass': newPass,
                },
                dataType: "application/json",
                success: function(response) {
                    response = JSON.stringify(response)
                    console.log(response);
                },
                error: function(error) {
                    error = JSON.stringify(error)
                    console.log(error);
                }
            });
        });
    });
</script>







<div class="container-fluid mx-0">
    <div class="row w-100 justify-content-end" style="padding: inherit;">
        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-5 col-sm-12 col-12">
            <div class="text-center mt-3">
                <button class="editProfileBtn btn btn-primary shadow"><i class="fa-solid fa-pencil"></i> Update Password</button>
            </div>

            <div class="profile-card card my-4 rounded">
                <div class="card-top p-5 bg-primary"></div>
                <div class="card-bottom p-3">
                    <img src="../assets/images/Default-Profile.png" alt="avatar" class="profile-picture rounded-circle d-block img-fluid mx-auto" style="width: 150px;">
                    <div class="username text-center p-3">
                        <h3 class="stdName my-2">
                            <?php echo $currentUser['name']; ?>
                        </h3>
                    </div>
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


        <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="card m-4 shadow-lg">
                <div class="card-header bg-primary">
                    <h4 class="text-white">General Information</h4>
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

            <div class="card mx-4 mt-5 shadow-lg">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Credentials</h4>
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
</div>