<section class="py-5">
    <div class="container px-5">
        <h1 class="fw-bolder fs-5 mb-4">Daftar Favorite</h1>
        <?php foreach ($favorite_data as $laptop) : ?>
            <div class="card border-0 shadow rounded-3 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="row gx-0">
                        <div class="col-lg-6 col-xl-5 py-lg-5">
                            <div class="p-4 p-md-5">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?php echo $laptop['merek']; ?></div>
                                <div class="h4 fw-bolder"><?php echo $laptop['nama']; ?></div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-warning">
                                    <?php 
                                    $stars = round($laptop['rating']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $stars) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }
                                    } ?>
                                    </span>
                                    <span class="ms-2"><?php echo number_format($laptop['rating'], 1); ?></span>
                                </div>
                                <div class="mb-3">
                                <h5 class="fw-bolder mb-1">Rp. <?php echo number_format($laptop['harga'], 0, ',', '.'); ?></h5>
                                    <p class="card-text mb-0"><?php echo strlen($laptop['review']) > 100 ? substr($laptop['review'], 0, 100) . '...' : $laptop['review']; ?></p>
                                </div>

                                
                               
                                
                                
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-danger me-2 favorite-btn <?php echo in_array($laptop['id'], array_column($favorite_data, 'id')) ? 'active' : ''; ?>" data-laptop-id="<?php echo $laptop['id']; ?>">
                                        <i class="bi-heart"></i> <!-- Heart icon -->
                                    </button>
                                    <a class="btn btn-outline-dark" href="#">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <!-- Foto dari database -->
                        <div class="col-lg-6 col-xl-7">
                            <div class="bg-featured-blog" style="background-image: url('uploads/<?php echo $laptop['gambar']; ?>')"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
