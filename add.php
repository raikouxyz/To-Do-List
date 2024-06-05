<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $deadline = $_POST['deadline'];

    $sql = "INSERT INTO tasks (content, deadline) VALUES ('$content', '$deadline')";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

