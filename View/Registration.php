<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']); ?></h5>

            <!-- Multi Columns Form -->
            <form class="row g-3" method="post" enctype="multipart/form-data" action="">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" id="fname" class="form-control form-control-sm" name="firstName"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" id="lname" class="form-control form-control-sm" name="lastName"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" id="Email" name="email" required />
                        </div>
                        <div class="col-md-6">
                            <label for="Password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-sm" id="Password" name="password"
                                required />
                        </div>
                        <div class="col-4">
                            <label for="Address" class="form-label">Address</label>
                            <input type="text" class="form-control form-control-sm" id="Address"
                                placeholder="1234 Main St" name="address" required />
                        </div>

                        <div class="col-md-4">
                            <label for="inputState" class="form-label">Role</label>
                            <select id="inputState" class="form-select form-select-sm" name="role" required>
                                <option selected>Choose...</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                        <label for="pinCode" class="form-label">Center
                        Name</label>
                    <select name="center_name" id="center_name" class="form-select form-control-sm" required>
                        <option value="Adhartal">Adhartal</option>
                        <option value="Rampur">Rampur</option>
                        <option value="Belkhadu">Belkhadu</option>
                    </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <img src="assets/img/userimg.jpg" alt="img" class="pt-2 mt-4 border w-100" id="uploadimg">
                    <input type="file" class="form-control form-control-sm mt-2" name="profile" id="upload" required>
                </div>

                <div class="text-center">
                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                    <button type="submit" class="btn btn-primary btn-sm" name="RegistrationBtn">Submit</button>
                </div>
            </form><!-- End Multi Columns Form -->

        </div>
    </div>

</section>