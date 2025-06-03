<section class="section">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                    <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']); ?></h5>
                </div>
                <div class="col-md-1">
                    <a href="Registration"><i class="bi bi-person-fill-add fs-1" data-bs-toggle="modal"
                            data-bs-target="#student-add"></i></a>
                </div>
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-sm datatable" style="font-size:11px;">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>User Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Center Name</th>
                        <th>Profile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $srNo = 1;
                    foreach ($userData['Data'] as $Data) {

                        ?>

                        <tr>
                            <td><?php echo $srNo; ?></td>
                            <td><?php echo $Data->id; ?></td>
                            <td><?php echo $Data->firstName . ' ' . $Data->lastName; ?></td>
                            <td><?php echo $Data->email; ?></td>
                            <td><?php echo $Data->address; ?></td>
                            <td><?php echo $Data->role; ?></td>
                            <td><?php echo $Data->center_name; ?></td>
                            <td><img src='./<?php echo $Data->profile; ?>' style="width:40px;" /></td>
                            <td>

                                <i class="bi bi-pencil-square fs-6" data-bs-toggle="modal"
                                    data-bs-target="#edit-btn<?php echo $Data->id; ?>"></i>
                                <?php if ($_SESSION['UserRole']['role'] == 'admin') { ?>
                                    <i class="bi bi-trash3-fill fs-6" data-bs-toggle="modal"
                                        data-bs-target="#delete-btn<?php echo $Data->id; ?>"></i>
                                <?php } ?>
                                <!-- Modal Edit-->
                                <div class="modal fade" id="edit-btn<?php echo $Data->id; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Users</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Multi Columns Form -->
                                                    <form class="row g-3" method="post" enctype="multipart/form-data"
                                                        action="">
                                                        <div class="col-md-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $Data->id; ?>">
                                                                    <label for="fname" class="form-label">First Name</label>
                                                                    <input type="text" id="fname"
                                                                        value="<?php echo $Data->firstName; ?>"
                                                                        class="form-control form-control-sm"
                                                                        name="firstName" required />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="lname" class="form-label">Last Name</label>
                                                                    <input type="text" id="lname"
                                                                        value="<?php echo $Data->lastName; ?>"
                                                                        class="form-control form-control-sm" name="lastName"
                                                                        required />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="Email" class="form-label">Email</label>
                                                                    <input type="email" class="form-control form-control-sm"
                                                                        value="<?php echo $Data->email; ?>" id="Email"
                                                                        name="email" required />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="Password"
                                                                        class="form-label">Password</label>
                                                                    <input type="password"
                                                                        class="form-control form-control-sm" id="Password"
                                                                        name="password" required />
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="Address" class="form-label">Address</label>
                                                                    <input type="text" value="<?php echo $Data->address; ?>"
                                                                        class="form-control form-control-sm" id="Address"
                                                                        placeholder="1234 Main St" name="address"
                                                                        required />
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label for="inputState" class="form-label">Role</label>
                                                                    <select id="inputState"
                                                                        class="form-select form-select-sm" name="role"
                                                                        required>
                                                                        <option selected value="<?php echo $Data->role; ?>">
                                                                            <?php echo $Data->role; ?>
                                                                        </option>
                                                                        <option value="user">User</option>
                                                                        <option value="admin">Admin</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label for="pinCode" class="form-label">Center
                                                                        Name</label>
                                                                    <select name="center_name" id="center_name"
                                                                        class="form-select form-control-sm" required>
                                                                        <option value="<?php echo $Data->center_name; ?>"
                                                                            selected><?php echo $Data->center_name; ?>
                                                                        </option>
                                                                        <option value="Adhartal">Adhartal</option>
                                                                        <option value="Rampur">Rampur</option>
                                                                        <option value="Belkhadu">Belkhadu</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img src="assets/img/userimg.jpg" alt="img"
                                                                class="pt-2 mt-4 border w-100" id="uploadimg">
                                                            <input type="file" class="form-control form-control-sm mt-2"
                                                                name="profile" id="upload" required>
                                                        </div>

                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                                name="RegistratioUpdatenBtn">Update</button>
                                                        </div>
                                                    </form><!-- End Multi Columns Form -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Edit-->
                                <div class="modal fade" id="delete-btn<?php echo $Data->id; ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Users</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Multi Columns Form -->
                                                    <form class="row g-3" method="post" enctype="multipart/form-data"
                                                        action="">
                                                        <input type="hidden" name="id" value="<?php echo $Data->id; ?>" />
                                                        <input type="submit" value="Delete" name="deleteuserBtn"
                                                            class="btn btn-sm btn-primary" />
                                                    </form><!-- End Multi Columns Form -->
                                                </div>
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

        </div>
    </div>
</section>