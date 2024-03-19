<?php
include "../../php/firebase/users/userOperations.php";
include "../../pages/admin_only_pages/multiStepForm.html";
$userData = json_decode(getUserData(), true);
?>

<!-- Header Buttons and Search  -->
<div class="d-flex align-items-center justify-content-center">
  <button type="button" class="editProfileBtn btn btn-warning m-4 me-auto" data-bs-toggle="modal" data-bs-target="#multiLevelModal">Add User <i class="fa-solid fa-plus"></i></button>
  <div class="input-group" style="width: 30%;">
    <input id="search-input" type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-button">
    <button id="search-button" class="btn btn-primary" type="button">
      <i class="fas fa-search"></i>
    </button>
  </div>
  <button class="editProfileBtn btn btn-warning m-4 ms-auto">Sort By <i class="bi bi-sort-down"></i></button>
</div>

<!-- User Lists in Table Format -->
<div class="table-responsive">
  <table class="table table-striped">
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
    <tbody>
      <?php
      $index = 1;
      foreach ($userData as $userValue) : ?>
        <tr>
          <th><?php echo $index ?></th>
          <td><?php echo $userValue["name"] ?></td>
          <td><?php echo $userValue["student_id"] ?></td>
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