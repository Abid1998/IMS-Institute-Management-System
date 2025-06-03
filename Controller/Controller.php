<?php
date_default_timezone_set('Asia/Kolkata');
require_once ('Model/Model.php');
session_start();
// Start output buffering
ob_start();
class Controller extends Model
{
    function __construct()
    {
        parent::__construct();
        if (isset($_SERVER['PATH_INFO'])) {
            switch ($_SERVER['PATH_INFO']) {
                // Route: login
                case '/':
                     header('location:Login');
                    break;
                    
                case '/Login':
                    include 'View/Login.php';
                    if (isset($_POST['loginBtn'])) {
                        $email = mysqli_real_escape_string($this->connection, $_POST['email']);
                        $password = mysqli_real_escape_string($this->connection, $_POST['password']);
                        $remember = isset($_POST['remember']) ? true : false;
                        $loginEX = $this->LoginData($email, $password);
                        if ($loginEX['Data']) {
                            $_SESSION['UserRole'] = $loginEX['Data'];
                            if ($remember) {
                                setcookie('email', $email, time() + (86400 * 30), "/"); // 86400 = 1 day
                            }
                            $ids = $_SESSION['UserRole']['id'];
                            $dateTime = date('d-m-Y:h:i:sa');
                            $location = mysqli_real_escape_string($this->connection, $_POST['location']);
                            //print_r($location); exit;

                            $insert_data = [
                                'userid' => $ids,
                                'login' => $dateTime,
                                'location' => $location,
                            ];

                            $insertEx = $this->InsertData('login_logout', $insert_data);


                            echo "<script>alert('login successfully!');window.location.href='Dashboard';</script>";
                        } else {
                            echo "<script>alert('login failed!-Please check Username or Password!');</script>";
                        }
                    }
                    break;
                // Route: Logout
                case '/Logout':
                    $ids = $_SESSION['UserRole']['id'];
                    $dateTime = date('d-m-Y:h:i:sa');
                    $where = ['userid' => $ids];
                    $updateEx = ['logout' => $dateTime,];

                    $update_data = $this->updateData('login_logout', $updateEx, $where);

                    session_unset();
                    session_destroy();
                    echo "<script>alert('logout successfully!'); window.location.href='Login';</script>";
                    break;

                case '/Index':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        include 'View/header.php';
                        include 'View/index.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;

                // Route: Registration
                case '/Registration':
                    if ($_SESSION['UserRole']['role'] == 'admin') {
                        if (isset($_POST['RegistrationBtn'])) {
                            // Check if file is uploaded and there are no errors
                            if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
                                $path = 'uploads/';
                                $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                                $file_name = $_POST['firstName'] . '_' . date('YmdHis') . '.' . $extension;
                                $profile = $path . $file_name;
                                $insert_data = [
                                    'firstName' => $_POST['firstName'],
                                    'lastName' => $_POST['lastName'],
                                    'email' => $_POST['email'],
                                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT), // Hash the password
                                    'address' => $_POST['address'],
                                    'role' => $_POST['role'],
                                    'center_name' => $_POST['center_name'],
                                    'profile' => $profile // Save the path of the uploaded profile picture
                                ];
                                // Insert data into the database
                                $insertEX = $this->InsertData('users', $insert_data);
                                if ($insertEX['Code']) {
                                    if (!is_null($profile)) {
                                        move_uploaded_file($_FILES['profile']['tmp_name'], $path . $file_name);
                                    } else {
                                        echo "<script>alert('Something Wrong!');</script>";
                                    }
                                    echo "<script>alert('insert Successfully!'); 
                                        window.location.href='Login';</script>";
                                } else {
                                    echo "<script>alert('Something Wrong -" . $insertEX['Message'] . "');</script>";

                                }
                            }
                        }
                        include 'View/header.php';
                        include 'View/Registration.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;


                // Route: Students
                case '/Students':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        if ($_SESSION['UserRole']['role'] == 'admin') {
                            $where = [];
                            $selectData = $this->SelectData('students', $where);
                            $coursesData = $this->SelectData('courses', $where);
                        } else if ($_SESSION['UserRole']['role'] == 'user') {
                            //echo $_SESSION['UserRole']['id'];exit;
                            $where = ['createBy' => $_SESSION['UserRole']['id']];
                            $selectData = $this->SelectData('students', $where);
                            $coursesData = $this->SelectData('courses', []);
                        }

                        if (isset($_POST['submitBtn'])) {
                            if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
                                $path = 'uploads/';
                                $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                                $file_name = $_POST['firstName'] . '_' . date('YmdHis') . '.' . $extension;
                                $profile = $path . $file_name;
                                $enrollment_date = date('d-m-Y');
                                $createBy = $_SESSION['UserRole']['id'];
                                $insert_data = [
                                    'first_name' => $_POST['firstName'],
                                    'last_name' => $_POST['lastName'],
                                    'date_of_birth' => $_POST['dob'],
                                    'gender' => $_POST['gender'],
                                    'email' => $_POST['email'],
                                    'phone' => $_POST['phone'],
                                    'address' => $_POST['address'],
                                    'course_name' => $_POST['course_name'],
                                    'pincode' => $_POST['pinCode'],
                                    'center_name' => $_POST['center_name'],
                                    'instalment' => $_POST['instalment'],
                                    'total_amount' => $_POST['total_amount'],
                                    'enrollment_date' => $enrollment_date,
                                    'createBy' => $createBy,
                                    'status' => 'Active',
                                    'profile' => $profile // Save the path of the uploaded profile picture
                                ];
                                // Insert data into the database
                                $insertEX = $this->InsertData('students', $insert_data);
                               
                                if ($insertEX['Code']) {
                                    $lastInsertId = $this->connection->insert_id;
                                    if (!is_null($profile)) {
                                        move_uploaded_file($_FILES['profile']['tmp_name'], $path . $file_name);
                                    } else {
                                        echo "<script>alert('Something Wrong!');</script>";
                                    }
                                    echo "<script>alert('insert Successfully!'); 
                                    window.location.href='Students';</script>";

                                } else {
                                    echo "<script>alert('Something Wrong -" . $insertEX['Message'] . "');</script>";
                                }
                            }
                        }

                        if (isset($_POST['updateBtn'])) {
                            if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
                                $path = 'uploads/';
                                $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                                $file_name = $_POST['firstName'] . '_' . date('YmdHis') . '.' . $extension;
                                $profile = $path . $file_name;
                                $enrollment_date = date('Y-m-d');
                                $update_data = [
                                    'first_name' => $_POST['firstName'],
                                    'last_name' => $_POST['lastName'],
                                    'date_of_birth' => $_POST['dob'],
                                    'gender' => $_POST['gender'],
                                    'email' => $_POST['email'],
                                    'phone' => $_POST['phone'],
                                    'address' => $_POST['address'],
                                    'course_name' => $_POST['course_name'],
                                    'pincode' => $_POST['pinCode'],
                                    'center_name' => $_POST['center_name'],
                                    'instalment' => $_POST['instalment'],
                                    'total_amount' => $_POST['total_amount'],
                                    'status' => $_POST['status'],
                                    'profile' => $profile,
                                ];

                            } else {
                                $update_data = [
                                    'first_name' => $_POST['firstName'],
                                    'last_name' => $_POST['lastName'],
                                    'date_of_birth' => $_POST['dob'],
                                    'gender' => $_POST['gender'],
                                    'email' => $_POST['email'],
                                    'phone' => $_POST['phone'],
                                    'address' => $_POST['address'],
                                    'course_name' => $_POST['course_name'],
                                    'center_name' => $_POST['center_name'],
                                    'pincode' => $_POST['pinCode'],
                                    'status' => $_POST['status'],
                                ];
                            }

                            $where = ['student_id' => $_POST['id']];
                            $updateEx = $this->updateData('students', $update_data, $where);

                            if ($updateEx['Code']) {
                                if (!is_null($profile)) {
                                    move_uploaded_file($_FILES['profile']['tmp_name'], $path . $file_name);
                                }
                                echo "<script>alert('Student has been updated Successfully!'); 
                          window.location.href='Students';</script>";
                                exit; // Exit script after sending header
                            } else {
                                echo "<script>alert('Something Wrong - " . $updateEx['Message'] . "');</script>";
                            }
                        }
                        if (isset($_POST['deleteBtn'])) {
                            $student_id = $_POST['student_id']; // Sanitize input (consider type casting)
                            $where = ['student_id' => $student_id];
                            $deleteEx = $this->deleteData('students', $where);
                            ///print_r($response);exit;
                            if ($deleteEx['Code']) {
                                echo "<script>alert('Student has been deleted Successfully!'); 
                            window.location.href='Students';</script>";
                                exit; // Exit script after sending header
                            } else {
                                echo "<script>alert('Something Wrong - " . $deleteEx['Message'] . "');</script>";
                            }
                        }


                        include 'View/header.php';
                        include 'View/Students.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;

                case '/Attendance':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        include 'Config.php';
                        include 'View/header.php';
                        include 'View/Attendance.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;
                case '/Dashboard':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        include 'Config.php';
                        include 'View/header.php';
                        include 'View/Dashboard.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;



                case '/Invoice':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        $where = [];
                        $selectData = $this->SelectData('students', $where);
                        $coursesData = $this->SelectData('courses', $where);
                        $JsonRetunt = json_encode($selectData);
                        include 'View/header.php';
                        include 'View/Invoice.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;
                case '/AJAXAPI':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        try {
                            $where = ['role_number' => $this->htmlValidation($_REQUEST['role_number'])];
                            $selectData = $this->SelectData('students', $where);
                            echo $JsonRetunt = json_encode($selectData);
                        } catch (Exception $ex) {
                            echo $ex . "Failed";
                        }
                    }
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        try {
                            // Assuming htmlValidation is a method within the current class
                            $amount = $this->htmlValidation($_POST['amount']);
                            $comment = $this->htmlValidation($_POST['comment']);
                            $payment_mode = $this->htmlValidation($_POST['payment_mode']);
                            $role_number = $this->htmlValidation($_POST['role_number']);
                            $pay_date = $this->htmlValidation($_POST['pay_date']);

                            $insert_data = [
                                'amount' => $amount,
                                'comment' => $comment,
                                'payment_mode' => $payment_mode,
                                'role_number' => $role_number,
                                'pay_date' => $pay_date
                            ];

                            $insert_instalment_data = [
                                'total_pay' => $amount,
                                'role_number' => $role_number
                            ];
                            $insertEX = $this->InsertData('receipt', $insert_data);
                            $insert_instalment_Ex = $this->InsertData('instalment', $insert_instalment_data);

                            if (!empty($insertEX)) {
                                echo json_encode($insertEX);
                            }
                        } catch (Exception $ex) {
                            error_log($ex->getMessage());
                            echo json_encode(['error' => 'An error occurred while processing your request.']);
                        }
                    }
                    break;

                case '/InvoiceAPI':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        try {
                            $where = ['role_number' => $this->htmlValidation($_REQUEST['role_number'])];
                            $InvoiceData = $this->SelectData('receipt', $where);
                            echo $JsonRetunt = json_encode($InvoiceData);

                        } catch (Exception $ex) {
                            echo $ex . "Failed";
                        }
                    }
                    break;

                case '/Invoice-List':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        $where = ['center_name' => $_SESSION['UserRole']['center_name']];
                        $selectData = $this->getInvoicedata($where);
                        include 'View/header.php';
                        include 'View/Invoice-List.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;
                case '/Invoice-Create':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        $receiptId = $_GET['receiptId'];
                        $where = ['role_number' => $receiptId];
                        $selectData = $this->SelectData('students', $where);
                        $ReceiptData = $this->SelectData('receipt', $where);
                        $InstalmentData = $this->SelectData('instalment', $where);
                    }
                    require 'assets/fpdf/fpdf.php';
                    include 'View/Invoice-Create.php';
                    break;


                case '/Course':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        $where = [];
                        $courseData = $this->SelectData('courses', $where);
                        try {
                            if (isset($_POST['submitBtn'])) {
                                $course_name = $this->htmlValidation($_POST['coursename']);
                                $coursedescription = $this->htmlValidation($_POST['coursedescription']);
                                $insert_course_data = [
                                    'course_name' => $course_name,
                                    'description' => $coursedescription
                                ];
                                $courseEx = $this->InsertData('courses', $insert_course_data);
                                echo "<script>alert('insert Successfully!'); 
                                window.location.href='Course';</script>";
                            }
                        } catch (Exception $ex) {
                            echo $ex . "Failed";
                        }

                        try {
                            if (isset($_POST['CourseUpdateBtn'])) {
                                $where = ['id' => $_POST['id']];
                                $course_name = $this->htmlValidation($_POST['coursename']);
                                $coursedescription = $this->htmlValidation($_POST['coursedescription']);
                                $update_data = [
                                    'course_name' => $course_name,
                                    'description' => $coursedescription,
                                ];
                                $updateEx = $this->updateData('courses', $update_data, $where);
                                if ($updateEx['Code']) {
                                    echo "<script>alert('updated Successfully!'); 
                                    window.location.href='Course';</script>";
                                }

                            }
                        } catch (Exception $ex) {
                            echo $ex . 'Failed';
                        }

                        try {
                            if (isset($_POST['deleteBtn'])) {
                                $id = $this->htmlValidation($_POST['id']);
                                $where = ['id' => $id];
                                $deleteEx = $this->deleteData('courses', $where);
                                if ($deleteEx['Code']) {
                                    echo "<script>alert('Deleted Successfully!'); 
                                    window.location.href='Course';</script>";
                                }
                            }
                        } catch (Exception $ex) {
                            echo $ex . 'Failed';
                        }
                        include 'View/header.php';
                        include 'View/Course.php';
                        include 'View/footer.php';
                    } else {
                        header('location:Login');
                    }
                    break;

                case '/users-profile':
                    if ($_SESSION['UserRole']['role'] == 'admin' || $_SESSION['UserRole']['role'] == 'user') {
                        $where = ['id' => $_SESSION['UserRole']['id']];
                        $userData = $this->SelectData('users', $where);
                        if (isset($_POST['ProfileUpdate'])) {
                            if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
                                $path = 'uploads/';
                                $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                                $file_name = $_POST['firstName'] . '_' . date('YmdHis') . '.' . $extension;
                                $profile = $path . $file_name;


                                $update_data = [
                                    'profile' => $profile,
                                    'firstName' => $_POST['firstName'],
                                    'lastName' => $_POST['lastName'],
                                    'center_name' => $_POST['center_name'],
                                    'role' => $_POST['role'],
                                    'address' => $_POST['address'],
                                    'email' => $_POST['email'],
                                ];
                            } else {
                                $update_data = [
                                    'firstName' => $_POST['firstName'],
                                    'lastName' => $_POST['lastName'],
                                    'center_name' => $_POST['center_name'],
                                    'role' => $_POST['role'],
                                    'address' => $_POST['address'],
                                    'email' => $_POST['email'],
                                ];
                            }

                            $where = ['id' => $_POST['id']];
                            $updateEx = $this->updateData('users', $update_data, $where);

                            if ($updateEx['Code']) {
                                if (!is_null($profile)) {
                                    move_uploaded_file($_FILES['profile']['tmp_name'], $path . $file_name);
                                }
                                echo "<script>alert('User has been updated Successfully!'); 
                          window.location.href='users-profile';</script>";
                                exit;
                            } else {
                                echo "<script>alert('Something Wrong - " . $updateEx['Message'] . "');</script>";
                            }
                        }


                        if (isset($_POST['passchangebtn'])) {
                            $userId = $_SESSION['UserRole']['id']; // Prevent potential injection
                            $userData = $this->SelectData('users', ['id' => $userId]);

                            if ($_POST['newpassword'] != $_POST['renewpassword']) {
                                echo "<script>alert('Passwords do not match!');window.location.href='users-profile';</script>";
                                exit;
                            }

                            // Access the first element inside 'Data'
                            if (isset($userData['Data'][0]->password)) {
                                $hashedPassword = $userData['Data'][0]->password;
                                if (isset($_POST['password']) && password_verify($_POST['password'], $hashedPassword)) {
                                    // Password matches, proceed with password change logic
                                    $newHashedPassword = password_hash($_POST['renewpassword'], PASSWORD_DEFAULT);
                                    $update_data = [
                                        'password' => $newHashedPassword
                                    ];

                                    // Define the where clause
                                    $where = ['id' => $userId];

                                    $updateEx = $this->updateData('users', $update_data, $where);

                                    if ($updateEx['Data']) {
                                        echo "<script>alert('Password updated successfully!');window.location.href='users-profile';</script>";
                                    }
                                } else {
                                    // Password doesn't match, inform the user securely
                                    echo "<script>alert('Incorrect password. Please try again.');</script>";
                                }
                            } else {
                                echo "<script>alert('Password key does not exist.');</script>";
                            }
                        }
                        include 'View/header.php';
                        include 'View/users-profile.php';
                        include 'View/footer.php';
                    }

                    break;
                case '/Login-History':
                    if ($_SESSION['UserRole']['role'] == 'admin') {
                        $where = [];
                        $selectData = $this->SelectData('login_logout', $where);
                        include 'View/header.php';
                        include 'View/Login-History.php';
                        include 'View/footer.php';
                    }
                    break;

                case '/Users';
                    $where = [];
                    $userData = $this->SelectData('users', $where);
                    if ($_SESSION['UserRole']['role'] == 'admin') {
                        if (isset($_POST['RegistratioUpdatenBtn'])) {
                            if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
                                $path = 'uploads/';
                                $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                                $file_name = $_POST['firstName'] . '_' . date('YmdHis') . '.' . $extension;
                                $profile = $path . $file_name;
                                if ($profile != '') {
                                    $update_data = [
                                        'firstName' => $_POST['firstName'],
                                        'lastName' => $_POST['lastName'],
                                        'email' => $_POST['email'],
                                        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                                        'address' => $_POST['address'],
                                        'role' => $_POST['role'],
                                        'center_name' => $_POST['center_name'],
                                        'profile' => $profile
                                    ];
                                } else {
                                    $update_data = [
                                        'firstName' => $_POST['firstName'],
                                        'lastName' => $_POST['lastName'],
                                        'email' => $_POST['email'],
                                        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                                        'address' => $_POST['address'],
                                        'center_name' => $_POST['center_name'],
                                        'role' => $_POST['role'],
                                    ];
                                }
                                $where = ['id' => $_POST['id']];
                                $updateEx = $this->updateData('users', $update_data, $where);
                                if ($updateEx['Code']) {
                                    if (!is_null($profile)) {
                                        move_uploaded_file($_FILES['profile']['tmp_name'], $path . $file_name);
                                    } else {
                                        echo "<script>alert('Something Wrong!');</script>";
                                    }
                                    echo "<script>alert('insert Successfully!'); 
                                        window.location.href='Users';</script>";
                                } else {
                                    echo "<script>alert('Something Wrong -" . $updateEx['Message'] . "');</script>";
                                }
                            }
                        }

                        if (isset($_POST['deleteuserBtn'])) {
                            $where = ['id' => $_POST['id']];
                            $deleteEx = $this->deleteData('users', $where);
                            if ($deleteEx['Data']) {
                                echo "<script>alert('Deleted Successfully!'); 
                                window.location.href='Users';</script>";
                            }
                        }
                        include 'View/header.php';
                        include 'View/Users.php';
                        include 'View/footer.php';
                    }
                    break;
                default:
                    break;

            }
        }
    }
}

$obj = new Controller;
// Flush the output buffer
ob_end_flush();
?>