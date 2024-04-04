<?php
session_start();
include 'config.php';

// Cek apakah Admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginAdmin.php");
    exit();
}

// Hapus data laptop
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data laptop berdasarkan ID untuk menampilkan informasi yang akan dihapus
    $sql = "SELECT * FROM laptop WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $laptop = $result->fetch_assoc();
    $stmt->close();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "DELETE FROM laptop WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: data_laptop.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hapus Data Laptop</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include 'partials/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Hapus Data Laptop</h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <p>Anda yakin ingin menghapus data laptop berikut?</p>
                            <ul>
                                <li>ID Laptop: <?php echo $laptop['id']; ?></li>
                                <li>Nama Laptop: <?php echo $laptop['nama']; ?></li>
                                <li>Merek: <?php echo $laptop['merek']; ?></li>
                                <li>Spesifikasi: <?php echo $laptop['spesifikasi']; ?></li>
                                <li>Harga: Rp. <?php echo number_format($laptop['harga'], 0, ',', '.'); ?></li>
                            </ul>

                            <!-- Form Hapus Data Laptop -->
                            <form method="POST" action="">
                                <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>

                            </form>
                        </div>
                    </div>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'partials/footer_admin.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
