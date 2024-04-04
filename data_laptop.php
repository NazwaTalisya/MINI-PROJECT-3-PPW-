<?php
session_start();
include 'config.php';

// Cek apakah Admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginAdmin.php");
    exit();
}

// Query untuk mengambil data pelanggan
$query = "SELECT * FROM laptop";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Laptop</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800">Data Laptop</h1>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="text-right">
                                <a href="tambah_laptop.php" class="btn btn-success btn-xl">Tambah</a>
                            </div>
                        </div>
                        <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Laptop</th>
                    <th>Nama Laptop</th>
                    <th>Merek</th>
                    <th>Spesifikasi</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Action</th> 
                </tr>
            </thead>
            
            <tbody>
                <?php
                $query = "SELECT * FROM laptop";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['merek']; ?></td>
                        <td><?php echo $row['spesifikasi']; ?></td>
                        <td>Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></td>

                        <td><img src="uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>" width="100"></td>
                        <td>
                            <a href="edit_laptop.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="hapus_laptop.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
    $(document).ready(function() {
        var currentLocation = window.location.href;

        // Dashboard
        if (currentLocation.includes("dashboard.php")) {
            $(".nav-item:eq(0)").addClass("active");
        }
        
        // Data Laptop
        if (currentLocation.includes("data_laptop.php")) {
            $(".nav-item:eq(1)").addClass("active");
        }
    });
</script>

</body>

</html>
