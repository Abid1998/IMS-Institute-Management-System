<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                    <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']); ?></h5>
                </div>
                <div class="col-md-1">
                    <i class="bi bi-journal-plus fs-2" data-bs-toggle="modal" data-bs-target="#course-add"
                        title="Add New Course"></i>
                </div>
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-sm datatable" style="font-size:13px;">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Course Name</th>
                        <th>Course Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $srNo = 1;
                    foreach ($courseData['Data'] as $Data) { ?>
                        <tr>
                            <td><?php echo $srNo; ?></td>
                            <td><?php echo $Data->course_name; ?></td>
                            <td><?php echo $Data->description; ?></td>
                            <td>
                                <i class="bi bi-pencil-square fs-6" data-bs-toggle="modal"
                                    data-bs-target="#course-edit<?php echo $Data->id; ?>"></i>
                                    <?php if($_SESSION['UserRole']['role']=='admin'){ ?>
                                <i class="bi bi-trash3-fill fs-6" data-bs-toggle="modal"
                                    data-bs-target="#delete-btn<?php echo $Data->id; ?>"></i>
                                        <?php } ?>

                                <!-- Modal Edit  Course-->

                                <!-- Modal Edit Course -->
                                <div class="modal fade" id="course-edit<?php echo $Data->id; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Course</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form action="" method="post"
                                                        enctype="multipart/form-data">
                                                        <input type="hidden" value="<?php echo $Data->id; ?>" name="id"
                                                            id="id">
                                                        <label for="coursename" class="form-label">Course Name</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            value="<?php echo htmlspecialchars($Data->course_name); ?>"
                                                            id="coursename" name="coursename" required>
                                                        <label for="coursedescription" class="form-label">Course
                                                            Description</label>
                                                        <input type="text"
                                                            value="<?php echo htmlspecialchars(trim($Data->description)); ?>"
                                                            id="coursedescription" name="coursedescription"
                                                            class="form-control form-control-sm">
                                                
                                                    <input type="submit" value="Update" class="btn btn-sm btn-info text-white mx-auto mt-2 offset-md-4 float-end" name="CourseUpdateBtn"/>
                                                    
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- <div class="modal fade" id="course-edit<?php echo $Data->id; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Course</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" value="<?php echo $Data->id; ?>" name="id"
                                                            id="id">
                                                        <label for="coursename" class="form-label">Course Name</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            value="<?php echo $Data->course_name; ?>" id="coursename"
                                                            name="coursename" required>
                                                        <label for="coursedescription" class="form-label">Course
                                                            Description</label>
                                                        <input type="text" value=" <?php echo $Data->description; ?>"
                                                            id="coursedescription" name="coursedescription"
                                                            class="form-control form-control-sm">
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-sm btn-info text-white"
                                                        name="CourseUpdateBtn">Update</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- Modal Delete-->
                                <div class="modal fade" id="delete-btn<?php echo $Data->id; ?>" tabindex="-1"
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
                                                    <input type="hidden" value="<?php echo $Data->id; ?>" name="id" />
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
</section>


<!-- Modal Add New Course-->
<div class="modal fade" id="course-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="coursename" class="form-label">Course Name</label>
                        <input type="text" class="form-control form-control-sm" id="coursename" name="coursename"
                            required>
                        <label for="coursedescription" class="form-label">Course Description</label>
                        <textarea name="coursedescription" id="coursedescription" class="form-control"
                            rows="2"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-info text-white" name="submitBtn"
                        title="Add New Course">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>