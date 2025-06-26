<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Include PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
try {
    $conn = new mysqli(
        'localhost',
        'u997284569_infinityeducUs',
        '@bidkH4N180912',
        'u997284569_infinityeducDB'
    );
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Email sending function (with tracking only to student)
    function sendReminderEmail($toEmail, $studentName, $roleNumber, $uniqid)
    {
        // === Send to Student (with tracking) ===
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'abid9111998@gmail.com';
            $mail->Password   = 'uhsz tuwc pswu ncyu'; // Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('infinityeducationcenter3@gmail.com', 'Infinity Education');
            $mail->addAddress($toEmail, $studentName); // Only student

            if (file_exists('logo.jpeg')) {
                $mail->addEmbeddedImage('logo.jpeg', 'footerImage');
                $imgTag = "<img src='cid:footerImage' alt='Logo' style='width:120px;'>";
            } else {
                $imgTag = "<p><i>Logo not found</i></p>";
            }

            $trackingUrl = "https://infinityeducationpoint.com/track_open.php?uniqid=" . urlencode($uniqid);
            $trackingImg = "<img src='$trackingUrl' width='1' height='1' style='display:none;'>";

            $mail->isHTML(true);
            $mail->Subject = 'Upcoming Fee Payment Reminder';
            $mail->Body = "
                Dear $studentName,<br><br>
                This is a reminder that your monthly institute fee is due. Please make the payment at the earliest to avoid late charges.<br><br>
                Thank you,<br>
                <b>Infinity Education</b><br><br>
                $imgTag<br>
                $trackingImg
            ";

            $mail->send();

            // === Send to Admin (without tracking) ===
            $adminMail = new PHPMailer(true);
            $adminMail->isSMTP();
            $adminMail->Host       = 'smtp.gmail.com';
            $adminMail->SMTPAuth   = true;
            $adminMail->Username   = 'abid9111998@gmail.com';
            $adminMail->Password   = 'uhsz tuwc pswu ncyu';
            $adminMail->SMTPSecure = 'tls';
            $adminMail->Port       = 587;

            $adminMail->setFrom('infinityeducationcenter3@gmail.com', 'Infinity Education');
            $adminMail->addAddress('infinityeducationcenter3@gmail.com', 'Admin');

            $adminMail->isHTML(true);
            $adminMail->Subject = "[Copy] Reminder sent to $studentName";
            $adminMail->Body = "
                <b>Reminder Email Summary</b><br><br>
                <b>Name:</b> $studentName<br>
                <b>Email:</b> $toEmail<br>
                <b>Role Number:</b> $roleNumber<br>
                <b>Sent On:</b> " . date('Y-m-d H:i:s') . "<br>
            ";

            $adminMail->send();

            return true;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Email send error to $toEmail: {$mail->ErrorInfo}</p>";
            return false;
        }
    }

    // Fetch students and last payment
    $sql = "
        SELECT s.student_id, s.first_name, s.last_name, s.role_number, s.email, MAX(r.pay_date) AS last_payment_date
        FROM students AS s
        LEFT JOIN receipt AS r ON r.role_number = s.role_number
        GROUP BY s.student_id, s.first_name, s.last_name, s.role_number, s.email
    ";

    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("SQL Query Failed: " . $conn->error);
    }

    $today = new DateTime();

    // Loop through students
    while ($row = $result->fetch_assoc()) {
        $email = trim($row['email']);
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $roleNumber = $row['role_number'];
        $lastPaymentDate = $row['last_payment_date'];

        if (!empty($email) && !empty($lastPaymentDate)) {
            $payDate = new DateTime($lastPaymentDate);
            $interval = $today->diff($payDate)->days;

            if ($interval >= 29) {
                $uniqid = uniqid('mail_', true);
                $mailSent = sendReminderEmail($email, $name, $roleNumber, $uniqid);

                if ($mailSent) {
                    $insertSql = "
                        INSERT INTO mail_send (username, rolenumber, mail_id, status, count, read_count, uniqid)
                        VALUES ('$name', '$roleNumber', '$email', 'sent', 1, 0, '$uniqid')
                    ";
                    if ($conn->query($insertSql)) {
                        echo "<p style='color:green;'>Reminder sent to <b>$name</b> ($email)</p>";
                    } else {
                        echo "<p style='color:red;'>DB Insert Error: {$conn->error}</p>";
                    }
                }
            } else {
                echo "<p>No reminder needed for $name. Last paid $interval days ago.</p>";
            }
        } else {
            echo "<p style='color:orange;'>Skipped $name - Missing email or payment date</p>";
        }
    }

    $conn->close();

} catch (Exception $e) {
    echo "<p style='color:red;'><strong>Fatal Error:</strong> " . $e->getMessage() . "</p>";
}
?>
