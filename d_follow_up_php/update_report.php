<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root"; // หรือชื่อผู้ใช้ที่คุณตั้งไว้
$password = ""; // รหัสผ่าน ถ้าไม่มีให้เว้นว่าง
$dbname = "d_follow_up_db";// เปลี่ยนชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// กำหนดให้รองรับ UTF-8
$conn->set_charset("utf8mb4");

// รับข้อมูลจาก Flutter
$data = json_decode(file_get_contents("php://input"), true);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $hispillc = isset($_POST['hispillc']) ? $_POST['hispillc'] : null;
    $hisdefpillc = isset($_POST['hisdefpillc']) ? $_POST['hisdefpillc'] : null;
    $detailheal = isset($_POST['detailheal']) ? $_POST['detailheal'] : null;
    $completed_time = isset($_POST['completed_time']) ? $_POST['completed_time'] : null;

    if (!$id) {
        echo json_encode(["status" => "error", "message" => "ไม่พบ ID รายการ"]);
        exit;
    }

    $updates = [];
    if ($hispillc !== null) {
        $updates[] = "hispillc='$hispillc'";
    }
    if ($hisdefpillc !== null) {
        $updates[] = "hisdefpillc='$hisdefpillc'";
    }
    if ($detailheal !== null) {
        $updates[] = "detailheal='$detailheal'";
    }
    if ($completed_time !== null) {
        $updates[] = "completed_time='$completed_time'";
    }

    if (empty($updates)) {
        echo json_encode(["status" => "error", "message" => "ไม่มีข้อมูลที่ต้องอัปเดต"]);
        exit;
    }

    $updateQuery = "UPDATE report SET " . implode(", ", $updates) . " WHERE id='$id'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "อัปเดตสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "อัปเดตไม่สำเร็จ"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
