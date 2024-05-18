<?php
include_once '../../php/firebase/users/userOperations.php';

$stdId = isset($_POST['stdId']) ? $_POST['stdId'] : "";
$currentUserId = getUserIdFromClgId($stdId);
// echo "$currentUserId";
$currentUser = json_decode(getUser($currentUserId), true);
// echo $currentUser['name'];
?>

<!-- Modal -->
<div class="modal fade" id="userDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body">


        <div class="container-fluid mx-0">
          <div class="row w-100 justify-content-end" style="padding: inherit;">
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-5 col-sm-12 col-12">

              <div class="profile-card card my-4 rounded">
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


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<script>
   $('#userDetails').on('hidden.bs.modal', function (e) {
    location.reload(true);
   });
</script>