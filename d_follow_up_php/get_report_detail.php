<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root"; // หรือชื่อผู้ใช้ที่คุณตั้งไว้
$password = ""; // รหัสผ่าน ถ้าไม่มีให้เว้นว่าง
$dbname = "d_follow_up_db";// เปลี่ยนชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");

$id = $_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID ไม่ครบถ้วน']);
    exit;
}


// $sql = "SELECT * FROM report WHERE id = ?";
// แก้ไข SQL query ให้ทำการ JOIN กับตาราง users
$sql = "
   SELECT report.*, 
           users.name AS report_user_name, 
           users.tel AS report_user_tel,
           assigned_to_user.name AS assigned_to_name,
           assigned_to_user.tel AS assigned_to_tel
    FROM report
    LEFT JOIN users ON report.username = users.name
    LEFT JOIN users AS assigned_to_user ON report.assigned_to = assigned_to_user.name
    WHERE report.id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'report' => $report], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ข้อผิดพลาดในการดึงข้อมูล']);
}

$stmt->close();
$conn->close();
?>
