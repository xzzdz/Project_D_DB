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


// รับข้อมูลจากการส่ง POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $detailheal = $_POST['detailheal']; // เปลี่ยนชื่อเป็น detailheal

  // ตรวจสอบว่ามีการส่งข้อมูลหรือไม่
  if (empty($id) || empty($detailheal)) {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
    exit();
  }

  // สร้างคำสั่ง SQL สำหรับการบันทึกข้อมูล
  $sql = "UPDATE report SET detailheal = ? WHERE id = ?";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("si", $detailheal, $id); // เปลี่ยนใช้ $detailheal

    // ตรวจสอบว่าการอัปเดตสำเร็จหรือไม่
    if ($stmt->execute()) {
      echo json_encode(['status' => 'success', 'message' => 'บันทึกรายละเอียดการรักษาเรียบร้อย']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
    }

    $stmt->close();
  } else {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL']);
  }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
