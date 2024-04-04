<?php
include 'config.php';

// Ambil data laptop berdasarkan ID
$laptop_id = $_GET['id'];  // Anda harus mendapatkan ID dari URL atau dari variabel lainnya
$sql = "SELECT * FROM laptop WHERE id = $laptop_id";
$result = $conn->query($sql);
$laptop = $result->fetch_assoc();

// Ambil data rating berdasarkan laptop ID
$sql_rating = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_review FROM rating WHERE laptop_id = $laptop_id";
$result_rating = $conn->query($sql_rating);
$rating = $result_rating->fetch_assoc();

?>

<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-9">
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h2 class="fw-bolder mb-1"><?php echo $laptop['nama']; ?></h2>
                        <!-- Rating -->
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-warning">
                                <?php
                                $stars = round($rating['avg_rating']);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $stars) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                            </span>
                            <span class="ms-2"><?php echo number_format($rating['avg_rating'], 1); ?> (<?php echo $rating['total_review']; ?> ulasan)</span>
                        </div>
                        <!-- Post meta content-->
                        <!-- Post categories-->
                        <a class="badge bg-primary text-decoration-none link-light" href="#">
                            <?php echo $laptop['merek']; ?>
                        </a>
                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4 text-center">
                        <img class="img-fluid rounded" src="uploads/<?php echo $laptop['gambar']; ?>" alt="Gambar Laptop" />
                    </figure>

                    <h4 class="fw-bolder mb-1">Rp. <?php echo number_format($laptop['harga'], 0, ',', '.'); ?></h4>
                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4"><?php echo $laptop['spesifikasi']; ?></p>
                        <div class="d-flex align-items-center">
                        <?php 
                                     if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
                                    ?>
                                    <form method="post" class="favorite-form">
                                    <input type="hidden" name="laptop_id" value="<?php echo $laptop['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger me-2 favorite-btn <?php echo isset($favorite_data[$laptop['id']]) ? 'active' : ''; ?>" data-laptop-id="<?php echo $laptop['id']; ?>" name="add_favorite">
                                        <i class="bi-heart"></i> <!-- Heart icon -->
                                    </button>
                                </form>
                                    <?php 
                                    } ?>
                                    <a class="btn btn-outline-dark">Add to cart</a>
                                </div>
                    </section>
                    
                </article>
                <!-- Comments section-->
                <section>
                    <div class="card bg-light">
                        <div class="card-body">
                            <!-- Comment form-->
                            <?php
                                // Check apakah user sudah login sebagai user
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
                                ?>
                                    <form class="mb-4" action="proses_tambah_review.php" method="post">
                                    <input type="hidden" name="laptop_id" value="<?php echo $laptop['id']; ?>">
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Rating</label>
                                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" step="0.1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="review" class="form-label">Review</label>
                                            <textarea class="form-control" id="review" name="review" rows="3" placeholder="Tulis review Anda..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                <?php
                                }
                                ?>

                            <!-- Comment with nested comments-->
                            <div class="d-flex mb-4">

    <div class="ms-3">
    <?php
    // Ambil data nama pengguna dari tabel pengguna
    $query = "SELECT rating.review, pengguna.nama, rating.rating as rating 
              FROM rating 
              JOIN pengguna ON rating.pengguna_id = pengguna.id 
              WHERE rating.laptop_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $laptop['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_rating = 0;
    $total_reviews = 0;

    while ($reviewer = $result->fetch_assoc()) {
        echo '<div class="fw-bold d-flex align-items-center mb-2  mt-3">';
        echo '<span class="me-2">' . $reviewer['nama'] . '</span>';
        
        echo '<span class="text-warning">';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $reviewer['rating']) {
                echo '<i class="bi bi-star-fill"></i>';
            } else {
                echo '<i class="bi bi-star"></i>';
            }
        }
        echo '</span>';
        
        echo '<span class="ms-2">' . number_format($reviewer['rating'], 1) . '</span>';
        echo '</div>';
        
        echo '<div>' . $reviewer['review'] . '</div>';
        
        $total_rating += $reviewer['rating'];
        $total_reviews++;
    }


    if ($total_reviews == 0) {
        echo '<div class="fw-bold d-flex align-items-center mb-2">';
        echo '<span class="me-2">Belum ada ulasan untuk produk ini.</span>';
        echo '</div>';
    } else {
      
    }
    ?>
</div>

</div>

                            </div>
                            <!-- Single comment-->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
