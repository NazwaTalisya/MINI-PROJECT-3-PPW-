<?php
session_start();
include 'config.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['laptop_id']) && isset($_SESSION['user_id'])) {
    $laptop_id = $_POST['laptop_id'];
    $pengguna_id = $_SESSION['user_id'];

    // Periksa apakah laptop sudah difavoritkan oleh pengguna
    $check_query = "SELECT * FROM favorite WHERE pengguna_id = ? AND laptop_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('ii', $pengguna_id, $laptop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['message'] = 'Laptop sudah ada dalam daftar favorit Anda.';
    } else {
        // Tambahkan laptop ke daftar favorit
        $insert_query = "INSERT INTO favorite (pengguna_id, laptop_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('ii', $pengguna_id, $laptop_id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Laptop berhasil ditambahkan ke daftar favorit Anda.';
        } else {
            $response['message'] = 'Terjadi kesalahan saat menambahkan laptop ke daftar favorit Anda.';
        }
    }
} else {
    $response['message'] = 'Aksi tidak valid.';
}

echo json_encode($response);
?>
