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


$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];

// ตรวจสอบ password (optional)
$password = isset($_POST['password']) && !empty($_POST['password']) 
    ? $_POST['password'] // ใช้ค่าที่ส่งมาโดยตรง (ไม่เข้ารหัส)
    : null;
$tel = isset($_POST['tel']) && !empty($_POST['tel']) 
    ? $_POST['tel'] 
    : null;



// เตรียม SQL Statement
if ($password !== null && $tel !== null) {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, password = ?, tel = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $email, $role, $password, $tel, $id);
} elseif ($password !== null) {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $role, $password, $id);
} elseif ($tel !== null) {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, tel = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $role, $tel, $id);
} else {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);
}

// ดำเนินการและตอบกลับ
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Update failed']);
}

$stmt->close();
$conn->close();

?>
