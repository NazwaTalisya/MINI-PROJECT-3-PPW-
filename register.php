<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];

    // Enkripsi password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Role default untuk user
    $role = 'user';

    // SQL untuk memasukkan data ke tabel
    $sql = "INSERT INTO pengguna (nama, no_telepon, email, password, alamat, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $nama, $no_telepon, $email, $hashed_password, $alamat, $role );

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
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

    <title>Registrasi</title>

    <!-- Font kustom untuk template ini -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Gaya kustom untuk template ini -->
    <link href="css/styles2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container mt-5 mb-5">
        <div class="card o-hidden border-0 shadow-lg my-5 col-md-6 m-auto">
            <div class="card-body p-0">
                <!-- Baris Bertingkat di dalam Tubuh Kartu -->
                    <div class="m-auto"> <!-- m-auto untuk mengatur margin otomatis -->
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Registrasi Pengguna</h1>
                            </div>
                            <form class="user" method="post" action="register.php">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleInputNama"
                                        name="nama" placeholder="Nama" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleInputNoTelepon"
                                        name="no_telepon" placeholder="No Telepon" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        name="email" placeholder="Alamat Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                                        name="password" placeholder="Kata Sandi" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleInputAlamat"
                                        name="alamat" placeholder="Alamat" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Daftar Akun
                                </button>
                            </form>
                            <hr>
                      
                            <div class="text-center">
                                <a class="small" href="login.php">Sudah punya akun? Masuk!</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>
