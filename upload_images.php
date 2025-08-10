<?php
define("a328763fe27bba", "TRUE");

// auth.php
require_once('config.php');
header('Content-Type: application/json');

// Directory where files will be saved
$uploadDir = __DIR__ . '/uploaded_files/';

// Check if directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
// Check if the request method is POST and file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {

    $file = $_FILES['image'];
    $username = $_POST["username"] ?? null;
    $contact_id = $_POST["contact_id"] ?? null;


    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            'success' => false,
            'message' => 'File upload error code: ' . $file['error']
        ]);
        exit;
    }

    // Validate file type (basic check)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid file type. Allowed types: jpeg, png, gif, webp.'
        ]);
        exit;
    }

    // Create unique filename to avoid collisions
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid('msg_img_', true) . '.' . $fileExtension;

    $destination = $uploadDir . $newFileName;

    // Move uploaded file to destination
    if (move_uploaded_file($file['tmp_name'], $destination)) {

        // Return relative URL or filename for frontend to store/send in DB
        // Adjust the URL if needed based on your public access path to uploaded_files
        $fileUrl = 'uploaded_files/' . $newFileName;
        $results = mysql_insert("messages", [
            "belongs_to_username" => $username,
            "contact_id" => $contact_id,
            "is_from_me" => 1,
            "msg_type" => "image",
            "msg_body" => $fileUrl,
        ]);

        echo json_encode([
            'success' => true,
            'file' => $fileUrl
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to move uploaded file.'
        ]);
        exit;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No file uploaded.'
    ]);
    exit;
}
