<section class="section">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                    <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']); ?></h5>
                </div>
                <div class="col-md-1">
                    <i class="bi bi-person-fill-add fs-1" data-bs-toggle="modal" data-bs-target="#student-add"></i>
                </div>
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-sm datatable" style="font-size:13px;">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Student Id</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $srNo = 1;
                    foreach ($selectData['Data'] as $Data) {

                        ?>

                        <tr>
                            <td><?php echo $srNo; ?></td>
                            <td><?php echo $Data->role_number; ?></td>
                            <td><?php echo $Data->first_name . ' ' . $Data->last_name; ?></td>
                            <td><?php echo $Data->date_of_birth; ?></td>
                            <td><?php echo $Data->gender; ?></td>
                            <td>
                                <i class="bi bi-pencil-square fs-6" data-bs-toggle="modal"
                                    data-bs-target="#edit-btn<?php echo $Data->student_id; ?>"></i>
                                <?php if ($_SESSION['UserRole']['role'] == 'admin') { ?>
                                    <i class="bi bi-trash3-fill fs-6" data-bs-toggle="modal"
                                        data-bs-target="#delete-btn<?php echo $Data->student_id; ?>"></i>
                                <?php } ?>

                                <!-- Modal Edit-->
                                <div class="modal fade" id="edit-btn<?php echo $Data->student_id; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Student</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form class="row g-3" action="" method="post"
                                                        enctype="multipart/form-data">
                                                        <div class="row p-3">
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="hidden"
                                                                            class="form-control form-control-sm" id="id"
                                                                            name="id"
                                                                            value="<?php echo $Data->student_id; ?>"
                                                                            required>
                                                                        <label for="firstName" class="form-label">First
                                                                            Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="firstName" name="firstName"
                                                                            value="<?php echo $Data->first_name; ?>"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="lastName" class="form-label">Last
                                                                            Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="lastName" name="lastName"
                                                                            value="<?php echo $Data->last_name; ?>"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="dob" class="form-label">Date of
                                                                            birth</label>
                                                                        <input type="date"
                                                                            class="form-control form-control-sm" id="dob"
                                                                            name="dob"
                                                                            value="<?php echo $Data->date_of_birth; ?>"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="Gender"
                                                                            class="form-label">Gender</label>
                                                                        <select id="Gender"
                                                                            class="form-select form-select-sm" name="gender"
                                                                            required>
                                                                            <option selected>
                                                                                <?php echo $Data->gender; ?>
                                                                            </option>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                            <option value="Other">Other</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="email" class="form-label">E-Mail</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm" id="email"
                                                                            name="email" value="<?php echo $Data->email; ?>"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="phone" class="form-label">Phone</label>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm" id="phone"
                                                                            name="phone" value="<?php echo $Data->phone; ?>"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="address"
                                                                            class="form-label">Address</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="address" name="address"
                                                                            value="<?php echo $Data->address; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="course_name" class="form-label">Course
                                                                            Name</label>
                                                                        <select id="courseList"
                                                                            class="form-select form-select-sm"
                                                                            name="course_name">
                                                                            <?php
                                                                            // Pre-selected course logic
                                                                            $selectedCourseId = !empty($Data->course_name) ? $Data->course_name : null;

                                                                            // Loop through courses
                                                                            foreach ($coursesData['Data'] as $course):

                                                                                $isSelected = $course->course_name === $selectedCourseId; // Check if current course is pre-selected
                                                                        
                                                                                // Option element with appropriate attributes
                                                                                echo "<option value='" . $course->course_name . "'" . ($isSelected ? " selected" : "") . ">" .
                                                                                    $course->course_name;
                                                                                "</option>";
                                                                            endforeach;
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="pinCode" class="form-label">Pin
                                                                            Code</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="pinCode" name="pinCode"
                                                                            value="<?php echo $Data->pincode; ?>" required>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="pinCode" class="form-label">Center
                                                                            Name</label>
                                                                        <select name="center_name" id="center_name"
                                                                            class="form-select form-control-sm" required>
                                                                            <option value="Adhartal">Adhartal</option>
                                                                            <option value="Rampur">Rampur</option>
                                                                            <option value="Belkhadu">Belkhadu</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="pinCode"
                                                                            class="form-label">Instalment</label>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm"
                                                                            id="instalment" name="instalment"
                                                                            value="<?php echo $Data->instalment; ?>"
                                                                            required>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="pinCode" class="form-label">Total
                                                                            Amount</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="total_amount" name="total_amount"
                                                                            value="<?php echo $Data->total_amount; ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <img src="./<?php echo $Data->profile; ?>" alt="img"
                                                                    class="pt-2 mt-4 border w-100" id="uploadimg">
                                                                <input type="file" class="form-control form-control-sm mt-2"
                                                                    name="profile" id="upload">

                                                                <select name="status" id="status"
                                                                    class="form-select form-select-sm my-3">
                                                                    <option value="<?php echo $Data->status; ?>">
                                                                        <?php echo $Data->status; ?></option>
                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Dropout">Dropout</option>
                                                                    <option value="Graduate">Graduate</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-sm btn-info text-white"
                                                                name="updateBtn">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete-->
                                <div class="modal fade" id="delete-btn<?php echo $Data->student_id; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h6 id="exampleModalLabel" style="font-size:13px;">
                                                    <strong>Are you sure you want
                                                        to be deleted?</strong>
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <input type="hidden" value="<?php echo $Data->student_id; ?>"
                                                        name="student_id" />
                                                    <div class="row">
                                                        <button type="button" class="btn btn-sm btn-info col-md-5 ms-3"
                                                            data-bs-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-sm btn-danger col-md-5 mx-2"
                                                            name="deleteBtn">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </td>
                        </tr>
                        <?php
                        $srNo++;
                    } ?>
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
        </div>
    </div>
</section>


<!-- Modal Add-->
<div class="modal fade" id="student-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form class="row g-3" action="" method="post" enctype="multipart/form-data">
                        <div class="row p-3">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control form-control-sm" id="firstName"
                                            name="firstName" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" id="lastName"
                                            name="lastName" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dob" class="form-label">Date of birth</label>
                                        <input type="date" class="form-control form-control-sm" id="dob" name="dob"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Gender" class="form-label">Gender</label>
                                        <select id="Gender" class="form-select form-select-sm" name="gender" required>
                                            <option selected value="">Choose...</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">E-Mail</label>
                                        <input type="text" class="form-control form-control-sm" id="email" name="email"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="number" class="form-control form-control-sm" id="phone"
                                            name="phone" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control form-control-sm" id="address"
                                            name="address" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="course_name" class="form-label">Course Name</label>
                                        <select id="courseList" class="form-select form-select-sm" name="course_name"
                                            required>
                                            <?php foreach ($coursesData['Data'] as $course) { ?>
                                                <option value="<?php echo $course->course_name; ?>">
                                                    <?php echo $course->course_name; ?>
                                                </option>
                                            <?php }
                                            ; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pinCode" class="form-label">Pin Code</label>
                                        <input type="text" class="form-control form-control-sm" id="pinCode"
                                            name="pinCode" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="pinCode" class="form-label">Center Name</label>
                                        <select name="center_name" id="center_name" class="form-select form-control-sm"
                                            required>
                                            <option value="Adhartal">Adhartal</option>
                                            <option value="Rampur">Rampur</option>
                                            <option value="Belkhadu">Belkhadu</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="pinCode" class="form-label">Instalment</label>
                                        <input type="number" class="form-control form-control-sm" id="instalment"
                                            name="instalment" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="pinCode" class="form-label">Total Amount</label>
                                        <input type="text" class="form-control form-control-sm" id="total_amount"
                                            name="total_amount" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <img src="assets/img/userimg.jpg" alt="img" class="pt-2 mt-4 border w-100"
                                    id="uploadimg">
                                <input type="file" class="form-control form-control-sm mt-2" name="profile" id="upload"
                                    required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-info text-white"
                                name="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
