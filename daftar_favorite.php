<?php
session_start();

include 'config.php';

// Periksa apakah session login sudah ada
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query untuk mengambil data favorit
$sql = "SELECT laptop.*, rating.rating, rating.review 
        FROM favorite 
        JOIN laptop ON favorite.laptop_id = laptop.id 
        LEFT JOIN (
            SELECT laptop_id, AVG(rating) as rating, GROUP_CONCAT(review SEPARATOR ', ') as review 
            FROM rating 
            GROUP BY laptop_id
        ) as rating ON laptop.id = rating.laptop_id 
        WHERE favorite.pengguna_id = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$favorite_data = [];

while ($row = $result->fetch_assoc()) {
    $favorite_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Spark</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <?php include 'partials/navbar.php'; ?>

            
            <!-- Content section-->
            <?php include 'contentFavorite.php'; ?>
            
        </main>
        <!-- Footer-->
        <?php include 'partials/footer.php'; ?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
