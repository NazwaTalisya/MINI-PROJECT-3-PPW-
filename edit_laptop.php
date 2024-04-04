<?php
session_start();
include 'config.php';

// Cek apakah Admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginAdmin.php");
    exit();
}

// Ambil data laptop berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM laptop WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $laptop = $result->fetch_assoc();
    $stmt->close();
}

// Update data laptop
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $merek = $_POST['merek'];
    $spesifikasi = $_POST['spesifikasi'];
    $harga = $_POST['harga'];

    $gambar = $_FILES['gambar']['name'];

    if ($gambar) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gambar);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi gambar
        $valid_extensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $valid_extensions)) {
            echo "Format gambar tidak valid. Hanya JPG, JPEG, PNG yang diizinkan.";
            exit();
        }

        // Upload gambar
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $sql = "UPDATE laptop SET nama = ?, merek = ?, spesifikasi = ?, harga = ?, gambar = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nama, $merek, $spesifikasi, $harga, $gambar, $id);

            if ($stmt->execute()) {
                header("Location: data_laptop.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Maaf, ada masalah saat mengunggah gambar.";
        }
    } else {
        $sql = "UPDATE laptop SET nama = ?, merek = ?, spesifikasi = ?, harga = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $merek, $spesifikasi, $harga, $id);

        if ($stmt->execute()) {
            header("Location: data_laptop.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
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

    <title>Edit Data Laptop</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Edit Data Laptop</h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Form Edit Data Laptop -->
                            <form method="POST" action="" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $laptop['id']; ?>">
                                
                                <div class="form-group">
                                    <label for="nama">Nama Laptop:</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $laptop['nama']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="merek">Merek:</label>
                                    <input type="text" class="form-control" id="merek" name="merek" value="<?php echo $laptop['merek']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi:</label>
                                    <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="3" required><?php echo $laptop['spesifikasi']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga:</label>
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $laptop['harga']; ?>" required>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <img src="uploads/<?php echo $laptop['gambar']; ?>" alt="<?php echo $laptop['nama']; ?>" width="300">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gambar">Gambar:</label>
                                        <input type="file" class="form-control-file" id="gambar" name="gambar">
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Update</button>
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
