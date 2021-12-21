<?php
include 'header.php';
?>

<main id="about">
    <section class="about-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <h2>About Us</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum explicabo culpa totam sapiente
                        expedita sunt! A cum rem vitae amet fuga, vero, temporibus quas eum id, et explicabo in. Ipsa?
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <img src="./img/about-hero.svg" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="services">
        <div class="container">

            <h2>Our Services</h2>
            <p class="texte-presentation">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda molestias neque tempore quae
                praesentium voluptates pariatur architecto est vitae commodi ducimus quidem iste.</p>
            <div class="row justify-content-between">
                <div class="col-lg-3 col-md-6">
                    <div class="col-lg-11 card-services">
                        <i class="fas fa-truck"></i>
                        <p>Dellivery Services</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="col-lg-11 card-services">
                        <i class="fas fa-exchange-alt"></i>
                        <p>Shipping & Return</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="col-lg-11 card-services">
                        <i class="fas fa-percent"></i>
                        <p>Promotion</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="col-lg-11 card-services">
                        <i class="fas fa-user"></i>
                        <p>24 Hours Service</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="ourbrands">
        <div>
            <h2>Our Brands</h2>
        </div>
        <div class="container-texte">
            <p>Reprehenderit in volupdate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
        </div>
        <div class="container-slider">

        
        <div uk-slider>

<div class="uk-position-relative">

    <div class="uk-slider-container uk-light">
        <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-4@l">
            <li>
                <img src="./img/brand_01.png" alt="">
            </li>
            <li>
                <img src="./img/brand_02.png" alt="">
            </li>
            <li>
                <img src="./img/brand_03.png" alt="">
            </li>
            <li>
                <img src="./img/brand_04.png" alt="">
            </li>
            <li>
                <img src="./img/brand_01.png" alt="">
            </li>
            <li>
                <img src="./img/brand_02.png" alt="">
            </li>
            <li>
                <img src="./img/brand_03.png" alt="">
            </li>
            <li>
                <img src="./img/brand_04.png" alt="">
            </li>
        </ul>
    </div>

    <div class="uk-hidden@s uk-light">
        <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
    </div>

    <div class="uk-visible@s">
        <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
    </div>

</div>
</div>

</div>
    </section>
</main>

<?php
include 'footer.php';
?>