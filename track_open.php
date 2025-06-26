<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');

// DB connection
$conn = new mysqli('localhost', 'u997284569_infinityeducUs', '@bidkH4N180912', 'u997284569_infinityeducDB');
if ($conn->connect_error) {
    exit;
}

// Fetch uniqid
$uniqid = isset($_GET['uniqid']) ? $conn->real_escape_string($_GET['uniqid']) : '';

file_put_contents('log_open_tracking.txt', date('Y-m-d H:i:s') . ' => ' . json_encode($_GET) . PHP_EOL, FILE_APPEND);

if (!empty($uniqid)) {
    $update = "UPDATE mail_send 
               SET read_count = IFNULL(read_count, 0) + 1 
               WHERE uniqid = '$uniqid'";

    if (!$conn->query($update)) {
        error_log("Tracking Update Error: " . $conn->error);
    }
}

$conn->close();

// Prevent caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Output transparent 1x1 GIF
header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
?>
