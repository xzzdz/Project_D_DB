<?php
// รับชื่อไฟล์จากพารามิเตอร์ URL
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: image/png"); // ตั้งค่า Content-Type ให้ถูกต้อง

if (isset($_GET['filename'])) {
    $file = 'uploads/' . basename($_GET['filename']);

    // ตรวจสอบว่าไฟล์มีอยู่จริง
    if (file_exists($file)) {
        $mimeType = mime_content_type($file); // ตรวจสอบ MIME type ของไฟล์
        header("Content-Type: $mimeType");    // ตั้งค่า Content-Type ตามประเภทไฟล์
        readfile($file);                      // อ่านไฟล์และแสดงผล
        exit;
    } else {
        http_response_code(404);
        echo "File not found.";
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}
?>
