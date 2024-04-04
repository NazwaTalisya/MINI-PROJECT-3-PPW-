<?php
session_start();
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $laptop_id = $_POST['laptop_id']; 
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Query untuk tambah rating
    $sql = "INSERT INTO rating (pengguna_id, laptop_id, rating, review) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iids", $user_id, $laptop_id, $rating, $review);

    if ($stmt->execute()) {
        header("Location: detail_laptop.php?id=$laptop_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
