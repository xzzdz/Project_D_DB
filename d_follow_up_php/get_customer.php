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

// ตั้งค่าการเข้ารหัสเป็น utf8mb4 เพื่อรองรับภาษาไทย
$conn->set_charset("utf8mb4");

$namec = $_POST['namec'];

$sql = "SELECT * FROM report WHERE namec = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $namec);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "telc" => $row['telc']]);
} else {
    echo json_encode(["success" => false]);
}

$stmt->close();
$conn->close();
?>