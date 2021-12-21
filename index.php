<?php
include 'header.php';
?>
<main id="index">

    <section id="slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="diapositive row">
                        <div class="col-md-5 col-xs-12 text">
                            <h2 class="">Proident occaecat</h2>
                            <h3>Aliquip ex ea commodo consequat</h3>
                            <p>You are permitted to use this Zay CSS template for your
                                commercial websites. You are not permitted to re-distribute
                                the template ZIP file in any kind of template collection websites.
                            </p>
                        </div>
                        <div class="col-md-5 col-xs-12 ">
                            <img style="width: 100%;" src="img/banner_img_02.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="diapositive row">
                        <div class="col-md-5 col-xs-12  text">
                            <h2 class="">Proident occaecat</h2>
                            <h3>Aliquip ex ea commodo consequat</h3>
                            <p>You are permitted to use this Zay CSS template for your
                                commercial websites. You are not permitted to re-distribute
                                the template ZIP file in any kind of template collection websites.
                            </p>
                        </div>
                        <div class="col-md-5 col-xs-12 ">
                            <img style="width: 100%;" src="img/banner_img_01.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="diapositive row">
                        <div class="col-md-5 col-xs-12  text">
                            <h2 class="">Proident occaecat</h2>
                            <h3>Aliquip ex ea commodo consequat</h3>
                            <p>You are permitted to use this Zay CSS template for your
                                commercial websites. You are not permitted to re-distribute
                                the template ZIP file in any kind of template collection websites.
                            </p>
                        </div>
                        <div class="col-md-5 col-xs-12 ">
                            <img style="width: 100%;" src="img/banner_img_03.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span aria-hidden="true"><i style="color: #5AAC6E; font-size: 50px;" class="fas fa-chevron-left"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span aria-hidden="true"><i style="color: #5AAC6E; font-size: 50px;" class="fas fa-chevron-right"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section id="categorie">
        <div class="container-fluid">
            <h2 class="center">Categories of The Month</h2>
            <p class="center">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="row categorie">
                <div class="col-lg-3 col-md-6 col-xs-12 center">
                    <img src="img/category_img_01" alt="..." class="rounded-circle">
                    <h3>Watches</h3>
                    <button type="button" class="btn btn-success">Go Shop</button>
                </div>
                <div class="col-lg-3 col-md-6 col-xs-12 center">
                    <img src="img/category_img_02" alt="..." class="rounded-circle">
                    <h3>Shoes</h3>
                    <button type="button" class="btn btn-success">Go Shop</button>
                </div>
                <div class="col-lg-3 col-md-6 col-xs-12 center">
                    <img src="img/category_img_03" alt="..." class="rounded-circle">
                    <h3>Accessories</h3>
                    <button type="button" class="btn btn-success">Go Shop</button>
                </div>
            </div>
        </div>
    </section>

    <section id="featuredproduct">
        <div class="container-fluid">
            <h2 class="center">Featured Product</h2>
            <p class="center">Reprehenderit in volupdate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>

            <div class="row product">

                <?php $products = getLimit3Products();

                //var_dump($products);

                foreach ($products as $product) { ?>

                    <div class="col-xl-3 col-lg-6 col-xs-12">
                        <div class="card">
                            <img src="<?php echo $product['images'][0]['url']; ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="stars">
                                            <?php echo getNumberAvis($product['id']); ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <p class="prix">$<?php echo $product['prix']; ?></p>
                                    </div>
                                </div>
                                <h5 class="card-title"><?php echo $product['nom']; ?></h5>
                                <p class="card-text"><?php echo $product['description']; ?></p>
                                <p class="reviews">Reviews (<?php echo $product['avis']['nb_com']; ?>)</p>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </section>

</main>
<?php
include 'footer.php';
?>