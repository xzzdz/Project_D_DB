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
    die(json_encode([
        "status" => "Error",
        "message" => "Connection failed: " . $conn->connect_error
    ], JSON_UNESCAPED_UNICODE));
}

$conn->set_charset("utf8mb4");

// รับข้อมูลจาก Flutter
$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($id) {
    // ลบผู้ใช้โดยใช้ id ที่ส่งมา
    $sql = "DELETE FROM users WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "User deleted successfully."
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                "status" => "Error",
                "message" => "No user found with the given ID."
            ], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode([
            "status" => "Error",
            "message" => "Error: " . $conn->error
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode([
        "status" => "Error",
        "message" => "ID is required."
    ], JSON_UNESCAPED_UNICODE);
}

$conn->close();

?>
