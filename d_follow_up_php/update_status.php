<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root"; // หรือชื่อผู้ใช้ที่คุณตั้งไว้
$password = ""; // รหัสผ่าน ถ้าไม่มีให้เว้นว่าง
$dbname = "d_follow_up_db"; // เปลี่ยนชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';
$assignedTo = $_POST['assigned_to'] ?? '';
$completed_time = $_POST['completed_time'] ?? '';

if (empty($id) || empty($status)) {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
    exit;
}

// อัปเดตสถานะและผู้รับผิดชอบ
$sql = "UPDATE report SET status = ?, assigned_to = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $status, $assignedTo, $id);

if ($stmt->execute()) {
    // ถ้าอัปเดตสำเร็จและมี completed_time ให้บันทึกลงในตาราง report
    if (!empty($completed_time)) {
        $insert_sql = "INSERT INTO report (id, completed_time) VALUES (?, ?) ON DUPLICATE KEY UPDATE completed_time = ?";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iss", $id, $completed_time, $completed_time);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
    
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตสถานะได้']);
}

$stmt->close();
$conn->close();

?>
