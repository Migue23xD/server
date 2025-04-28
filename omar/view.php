<?php
$conn = new mysqli("localhost", "root", "", "media_db");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM media");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        if ($row['type'] === 'image') {
            echo "<img src='{$row['path']}' alt='{$row['name']}' width='200'>";
        } elseif ($row['type'] === 'video') {
            echo "<video controls width='200'><source src='{$row['path']}' type='video/mp4'></video>";
        } else {
            echo "<a href='{$row['path']}' download>{$row['name']}</a>";
        }
        echo "</div>";
    }
} else {
    echo "<p>No hay archivos cargados.</p>";
}

$conn->close();
?>
