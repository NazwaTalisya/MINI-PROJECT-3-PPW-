<?php
include 'config.php';

// Ambil data rating dengan join ke tabel pengguna
$sql_rating = "
    SELECT r.*, p.nama AS nama_pengguna
    FROM rating r
    JOIN pengguna p ON r.pengguna_id = p.id
";
$result_rating = $conn->query($sql_rating);

$favorite_data = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT laptop_id FROM favorite WHERE pengguna_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $favorite_data[$row['laptop_id']] = true;
    }
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Query database berdasarkan keyword dan pengurutan
$sql_search_sort = "SELECT * FROM laptop ";

if (!empty($keyword)) {
    $sql_search_sort .= "WHERE nama LIKE '%$keyword%' OR merek LIKE '%$keyword%' ";
}

switch ($sort) {
    case 'rating_low':
        $sql_search_sort .= "LEFT JOIN (SELECT laptop_id, AVG(rating) as avg_rating FROM rating GROUP BY laptop_id) as r ON laptop.id = r.laptop_id ORDER BY r.avg_rating ASC";
        break;
    case 'rating_high':
        $sql_search_sort .= "LEFT JOIN (SELECT laptop_id, AVG(rating) as avg_rating FROM rating GROUP BY laptop_id) as r ON laptop.id = r.laptop_id ORDER BY r.avg_rating DESC";
        break;
    case 'price_low':
        $sql_search_sort .= "ORDER BY harga ASC";
        break;
    case 'price_high':
        $sql_search_sort .= "ORDER BY harga DESC";
        break;
    case 'newest':
        $sql_search_sort .= "ORDER BY id DESC";
        break;
    default:
        $sql_search_sort .= "ORDER BY id DESC";
        break;
}

$result_search_sort = $conn->query($sql_search_sort);

$laptop_data = [];
while($row = $result_search_sort->fetch_assoc()) {
    $laptop_data[] = $row;
}

$rating_data = [];
while($row = $result_rating->fetch_assoc()) {
    if(!isset($rating_data[$row['laptop_id']])) {
        $rating_data[$row['laptop_id']] = [];
    }
    $rating_data[$row['laptop_id']][] = $row;
}


?>


<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center">
                    <h2 class="fw-bolder">Rating & Review Laptop</h2>
                    <p class="lead fw-normal text-muted mb-5">
                        Lihat rating dan review dari berbagai laptop terbaru.
                    </p>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-between">
            <!-- Fitur Search -->
            <div class="col-md-4">
                <form class="d-flex" action="" method="get">
                    <input class="form-control me-2" type="text" name="keyword" placeholder="Search by name or brand" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit">Search</button>
                </form>
            </div>

            <!-- Fitur Sort -->
            <div class="col-md-4 text-end">
    <form action="" method="get">
        <select class="form-select" name="sort" aria-label="Default select example" onchange="this.form.submit()">
            <option value="">Sorting</option>
            <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest</option>
            <option value="rating_low" <?php echo $sort == 'rating_low' ? 'selected' : ''; ?>>Rating: Low to High</option>
            <option value="rating_high" <?php echo $sort == 'rating_high' ? 'selected' : ''; ?>>Rating: High to Low</option>
            <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
            <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
        </select>
    </form>
</div>
        </div>
    </div>

    <div class="container px-5 my-5">
        <div class="row gx-5">
            <?php foreach ($laptop_data as $laptop) : ?>
                <?php 
                    $total_rating = 0;
                    $total_reviews = 0;
                    $reviews_text = '';
                    
                    // Inisialisasi $rating_data jika belum ada
                    if (!isset($rating_data[$laptop['id']])) {
                        $rating_data[$laptop['id']] = [];
                    }
                    
                    if (!empty($rating_data[$laptop['id']])) {
                        foreach($rating_data[$laptop['id']] as $rating) {
                            $total_rating += $rating['rating'];
                            $total_reviews++;
                            $reviews_text .= '"' . $rating['review'] . '", ';
                        }
                        $avg_rating = number_format($total_rating / $total_reviews, 1);
                        $reviews_text = rtrim($reviews_text, ', ');

                        // Batasi panjang reviews_text menjadi 100 karakter
                        if (strlen($reviews_text) > 100) {
                            $reviews_text = substr($reviews_text, 0, 100) . '... <a href="#">Read More</a>';
                        }
                    } else {
                        $avg_rating = '0.0';
                        $reviews_text = 'No reviews';
                    }
                ?>

                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top "  style="height: 20rem;" src="uploads/<?php echo $laptop['gambar']; ?>" alt="<?php echo $laptop['nama']; ?>">
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">
                                <?php echo $laptop['merek']; ?>
                            </div>
                            <a class="text-decoration-none link-dark" href="detail_laptop.php?id=<?php echo $laptop['id']; ?>">
                                <h4 class="card-title mb-3 fw-bolder"><?php echo $laptop['nama']; ?></h4>
                            </a>
                            <div class="d-flex align-items-center mb-2">
                            <span class="text-warning">
                            <?php 
                            $stars = round($avg_rating);
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $stars) {
                                    echo '<i class="bi bi-star-fill"></i>';
                                } else {
                                    echo '<i class="bi bi-star"></i>';
                                }
                            } ?>
                            </span>
                            <span class="ms-2"><?php echo number_format($avg_rating, 1); ?> (<?php echo $total_reviews ?> ulasan)</span>
                        </div>
                        <h5 class="fw-bolder mb-1">Rp. <?php echo number_format($laptop['harga'], 0, ',', '.'); ?></h5>
                            <p class="card-text mb-0"><?php echo $reviews_text; ?></p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                            <div class="d-flex align-items-end justify-content-between">
                               
                            </div>
                        </div>
                        <hr>
                        <div class="row d-flex justify-content-center">
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="d-flex justify-content-center align-items-center">
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
                                

                                    <a class="btn btn-outline-dark me-2" href="detail_laptop.php?id=<?php echo $laptop['id']; ?>">View More</a>
                                    <a class="btn btn-outline-dark" href="#">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const favoriteBtns = document.querySelectorAll('.favorite-btn');

    favoriteBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission

            const laptopId = this.getAttribute('data-laptop-id');

            fetch('add_favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `laptop_id=${laptopId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    });
});

</script>
