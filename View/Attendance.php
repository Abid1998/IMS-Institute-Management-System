<?php
if (isset($_POST['attendanceBtn'])) {
    $studentId = mysqli_real_escape_string($con, $_POST['studentId']);
    $attendance = mysqli_real_escape_string($con, $_POST['attendance']);
    $date = isset($_POST['date']) ? date('d-m-Y', strtotime($_POST['date'])) : date('d-m-Y'); // Corrected date format for DB compatibility
 
    $create_by = $_SESSION['UserRole']['id'];
    $center_name = $_SESSION['UserRole']['center_name'];
    // Check if attendance is already marked
    $sql = "SELECT * FROM attendance WHERE studentId='$studentId' AND dateOfAttendance='$date' and attendance='P'";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<script>alert('Attendance already marked');</script>";
    } else {
       
        if($date =='01-01-1970'){
            $date=date('d-m-Y');
            $update = "UPDATE attendance SET attendance='$attendance' WHERE studentId='$studentId' AND dateOfAttendance='$date'";
        }
        else{
           
            $update = "UPDATE attendance SET attendance='$attendance' WHERE studentId='$studentId' AND dateOfAttendance='$date'";
        }
        // Update attendance
        if (mysqli_query($con, $update)) {
            echo "<script>alert('Attendance has been marked!'); 
            window.location.href='Attendance';</script>";
        } else {
            echo "<script>alert('Error marking attendance: " . mysqli_error($con) . "');</script>";
        }
    }
}


$Today = date('d-m-Y');
$checkTodayAttendance = "SELECT * FROM attendance WHERE dateOfAttendance='$Today'";
$result = mysqli_query($con, $checkTodayAttendance);

if ($result && mysqli_num_rows($result) > 0) {
} else {
    $sql = "SELECT role_number FROM students";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentId = $row['role_number']; // Assuming 'role_number' is the correct column name
            $dateOfAttendance = date('d-m-Y'); // Using 'd-m-Y' format
            $create_by = $_SESSION['UserRole']['id'];
            $center_name = $_SESSION['UserRole']['center_name'];
           
            $insert = "INSERT INTO attendance (studentId, attendance, dateOfAttendance, center_name, create_by) 
                       VALUES ('$studentId', 'A', '$dateOfAttendance', '$center_name', '$create_by')";

            if (!mysqli_query($con, $insert)) {
                echo "Error: " . $insert . "<br>" . mysqli_error($con);
            } else {
                //echo "Attendance marked for student ID: $studentId<br>";
            }
        }
    } else {
        echo "No students found.";
    }
}

$firstDayOfMonth = date("Y-m-01");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
$id=$_SESSION['UserRole']['id'];
$fetchingStudents = mysqli_query($con, "SELECT * FROM students where createBy=$id" ) or die(mysqli_error($con));
$totalNumberOfStudents = mysqli_num_rows($fetchingStudents);
$studentsNamesArray = [];
$studentsIDsArray = [];
while ($students = mysqli_fetch_assoc($fetchingStudents)) {
    $studentsNamesArray[] = $students['first_name'];
    $studentsIDsArray[] = $students['role_number'];
}
$counter = 0;
?>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                    <h5 class="card-title"></i><i
                            class="bi bi-table fs-4 mt-5 mx-3"></i><?php echo basename($_SERVER['PHP_SELF']); ?> </h5>
                </div>
            </div>


            <form method="POST" id="formData" action="">
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2 col-sm-12">
                        <label>Student Id</label>
                        <input type='text' class='form-control form-control-sm' name='studentId' id="studentId"
                            required>
                    </div>

                    <div class="col-md-3 col-lg-2 col-sm-12">
                        <label>Date (optional)</label>
                        <input type='Date' class='form-control form-control-sm' name='date' id="date">
                    </div>

                    <div class="col-md-2 col-lg-2 col-sm-12">
                        <label>Select</label>
                        <select class="form-select form-select-sm" required name="attendance" id="attendance">
                            <option value="">--Select--</option>
                            <option value="A">A</option>
                            <option value="P">P</option>
                            <option value="H">H</option>
                            <option value="L">L</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2 col-sm-12 mt-3">
                        <input type='submit' class='btn btn-sm mt-2' name="attendanceBtn"
                            style="background-color:#344ECE; color:white;">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0 table-bordered table-sm "
                            style="font-size:13px; font-weight:700;">
                            <?php
                            for ($i = 1; $i <= $totalNumberOfStudents + 2; $i++) {
                                if ($i == 1) {
                                    echo "<tr>";
                                    echo "<td rowspan='2' style='background-color:#344ECE; color:#fff;' class='pt-3'>Names</td>";
                                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                        echo "<td style='background-color:#344ECE; color:#fff;'>$j</td>";
                                    }
                                    echo "</tr>";
                                } else if ($i == 2) {
                                    echo "<tr >";
                                    for ($j = 0; $j < $totalDaysInMonth; $j++) {
                                        echo "<td style='background-color:#344ECE; color:#fff;'>" . date("D", strtotime("+$j days", strtotime($firstDayOfMonth))) . "</td>";
                                    }
                                    echo "</tr>";
                                } else {
                                    echo "<tr>";
                                    echo "<td style='background-color:#344ECE; color:#fff;'>" . htmlspecialchars($studentsNamesArray[$counter]) . "</td>";
                                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                        $dateOfAttendance = date("Y-m-$j");

                                        $formattedDate = date("d-m-Y", strtotime($dateOfAttendance));
                                        $fetchingStudentsAttendance = mysqli_query($con, "SELECT * FROM `attendance` LEFT JOIN `students` ON `students`.`role_number` = `attendance`.`studentId` WHERE studentId = '" . $studentsIDsArray[$counter] . "' AND dateOfAttendance = '" . $formattedDate . "'") or die(mysqli_error($con));

                                        $isAttendanceAdded = mysqli_num_rows($fetchingStudentsAttendance);
                                        if ($isAttendanceAdded > 0) {
                                            $studentAttendance = mysqli_fetch_assoc($fetchingStudentsAttendance);
                                            if ($studentAttendance['attendance'] == "P") {
                                                echo "<td class='text-center' style='background-color:#80F0B2;'>P</td>";
                                            }
                                            if ($studentAttendance['attendance'] == "H") {
                                                echo "<td class='text-center' style='background-color:#344ECE;'>H</td>";
                                            }
                                            if ($studentAttendance['attendance'] == "L") {
                                                echo "<td class='text-center' style='background-color:gold;'>L</td>";
                                            }
                                        } else {
                                            echo "<td class='text-center' style='background-color:#D90166;'>A</td>";
                                        }
                                    }
                                    echo "</tr>";
                                    $counter++;
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row float-end">
                <div class="float-end">
                    <span style="font-size:10px; line-height: 0; font-weight:700; margin-top:5px;">Present : <i
                            class="bi bi-box-fill" style="color:#80F0B2;  line-height: 0;"></i></span>
                    <span style="font-size:10px; line-height: 0; font-weight:700;">Absend : <i class="bi bi-box-fill"
                            style="color:red;  line-height: 0;"></i></span>
                    <span style="font-size:10px; line-height: 0; font-weight:700;">Holiday : <i class="bi bi-box-fill"
                            style="color:#344ECE; line-height: 0;"></i></span>
                    <span style="font-size:10px; line-height: 0; font-weight:700;">Leave : <i class="bi bi-box-fill"
                            style="color:gold; ; line-height: 0;"></i></span>
                </div>
            </div>
        </div>
    </div>


</section>


<!-- Modal Add-->
<div class="modal fade" id="Attendance-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Attendance</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="student_id">Student Id</label>
                        <input type="text" class="form-control form-control-sm" id="studentId" name="studentId">

                        <div class="text-center my-2">
                            <button type="submit" class="btn btn-sm btn-info text-white"
                                name="AttendanceBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>