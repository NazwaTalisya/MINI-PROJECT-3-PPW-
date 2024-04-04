<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Spark</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Laptop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Daftar Laptop</a></li>
                        <li><a class="dropdown-item" href="#!">Cari Laptop</a></li>
                        <li><a class="dropdown-item" href="#!">Rating & Review Tertinggi</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                    <button class="btn btn-outline-dark me-2 dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-person-fill me-1"></i>
                        <?php 
                        if(isset($_SESSION['user_id'])) {
                            $nama = explode(' ', $_SESSION['nama'])[0];  // Mengambil 1 kata pertama dari nama pengguna
                            echo $nama;
                        } else {
                            echo 'Profile';
                        }
                        ?>
                    </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="daftar_favorite.php">Daftar Favorite</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-dark me-2">
                        <i class="bi-person-fill me-1"></i>
                        Login
                    </a>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="cart.php" class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</nav>
