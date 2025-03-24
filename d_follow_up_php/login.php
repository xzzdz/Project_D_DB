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
$email = $_POST['email'];
$password = $_POST['password'];

// ตรวจสอบข้อมูลการเข้าสู่ระบบ
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);
$data = mysqli_fetch_assoc($result);///เพิ่ม

if ($result->num_rows > 0) {
    // หากล็อกอินสำเร็จ
    echo json_encode([
        "status" => "success",
        'name' => $data['name'], // ส่ง name กลับไปด้วย
        'role' => $data['role'], // ส่ง role กลับไปด้วย
        'email' => $data['email'], // ส่ง email กลับไปด้วย
        'id' => $data['id'], // ส่ง email กลับไปด้วย
        'tel' => $data['tel'],
        'email' => $data['email']
    ], JSON_UNESCAPED_UNICODE); // เพิ่ม JSON_UNESCAPED_UNICODE เพื่อให้ส่งภาษาไทยได้);
} else {
    // หากล็อกอินล้มเหลว
    echo json_encode([
        "status" => "Error", 
        "message" => "Please check your email and password."
    ], JSON_UNESCAPED_UNICODE); // เพิ่ม JSON_UNESCAPED_UNICODE เพื่อให้ส่งภาษาไทยได้);
}

$conn->close();
?>
