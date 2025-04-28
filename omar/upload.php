<?php
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowedTypes = ['jpg', 'jpeg', 'png', 'mp4', 'pdf', 'docx'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            $type = in_array($fileType, ['jpg', 'jpeg', 'png']) ? 'image' : (in_array($fileType, ['mp4']) ? 'video' : 'document');
            $conn = new mysqli("localhost", "root", "", "media_db");
            $stmt = $conn->prepare("INSERT INTO media (name, type, path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fileName, $type, $targetFilePath);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type.";
    }
}
?>
