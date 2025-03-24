<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: image/png"); // ตั้งค่า Content-Type ให้ถูกต้อง

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root"; // หรือชื่อผู้ใช้ที่คุณตั้งไว้
$password = ""; // รหัสผ่าน ถ้าไม่มีให้เว้นว่าง
$dbname = "d_follow_up_db";// เปลี่ยนชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

// ตั้งค่า character set เพื่อรองรับภาษาไทย
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'เชื่อมต่อฐานข้อมูลล้มเหลว']));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $namec = $_POST['namec'];
    $telc = $_POST['telc'];
    $addressc = $_POST['addressc'];
    $rolec = $_POST['rolec'];
    $agec = $_POST['agec'];
    $buyc = $_POST['buyc'];
    $symptomc = $_POST['symptomc'];
    $wherec = $_POST['wherec'];
    $whenc = $_POST['whenc'];
    $hispillc = $_POST['hispillc'];
    $hisdefpillc = $_POST['hisdefpillc'];
    $diagnosec = $_POST['diagnosec'];
    $detail = $_POST['detail'];
    $healc = $_POST['healc'];

    // ตรวจสอบค่าของ completed_time
    $completed_time = isset($_POST['completed_time']) && !empty($_POST['completed_time']) ? $_POST['completed_time'] : null;

    // จัดการไฟล์ภาพ
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = "uploads/"; // โฟลเดอร์เก็บรูป
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . "_" . basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        // อัปโหลดไฟล์ไปยังเซิร์ฟเวอร์
        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            $imagePath = $filePath;
        } else {
            echo json_encode(['success' => false, 'message' => 'อัปโหลดรูปไม่สำเร็จ']);
            exit;
        }
    }

    // ใช้ prepared statement เพื่อป้องกัน SQL Injection
    if ($completed_time !== null) {
        $stmt = $conn->prepare("INSERT INTO report (username, date, status, detail, image, namec, telc, addressc, rolec, agec, buyc, symptomc, wherec, whenc, hispillc, hisdefpillc, diagnosec, healc, completed_time) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssssssss", $username, $date, $status, $detail, $imagePath, $namec, $telc, $addressc, $rolec, $agec, $buyc, $symptomc, $wherec, $whenc, $hispillc, $hisdefpillc, $diagnosec, $healc, $completed_time);
    } else {
        $stmt = $conn->prepare("INSERT INTO report (username, date, status, detail, image, namec, telc, addressc, rolec, agec, buyc, symptomc, wherec, whenc, hispillc, hisdefpillc, diagnosec, healc) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssss", $username, $date, $status, $detail, $imagePath, $namec, $telc, $addressc, $rolec, $agec, $buyc, $symptomc, $wherec, $whenc, $hispillc, $hisdefpillc, $diagnosec, $healc);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method ไม่ถูกต้อง']);
}
$stmt->close();
$conn->close();

?>
