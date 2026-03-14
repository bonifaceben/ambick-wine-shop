<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: *"); 
header("Access-Control-Allow-Methods: POST");
header('Content-Type: application/json');

// Uploads directory
$uploadDir = "uploads/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!empty($_FILES["image"])) {

    $filename = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $uploadDir . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo json_encode([
            "status" => "success",
            "url" => $targetFile
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Upload failed"
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "No file received"
    ]);
}
