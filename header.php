<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/scss/style.css" rel="stylesheet">

    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/css/uikit.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <title>ZayShop</title>
</head>

<header>

    <div class="infobar">
        <div class="container">
            <ul class="contact">
                <li><a href="mailto:info@company.com"><i class="fab fa-mailchimp"></i> info@company.com</a></li>
                <li><a href="tel:010-020-0340"><i class="fas fa-phone-alt"></i> 010-020-0340</a></li>
            </ul>
            <ul class="social">
                <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                <li><a href=""><i class="fab fa-instagram"></i></a></li>
                <li><a href=""><i class="fab fa-twitter"></i></a></li>
                <li><a href=""><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>


    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container">
            <h1 class="zay"><a class="navbar-brand" href="#">Zay</a></h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>

                    <li class="icon">
                        <div>
                            <ul>
                                <li>
                                    <a href=""><i class="fas fa-search"></i></a>
                                </li>
                                <li>
                                    <a href=""><i class="fas fa-cart-plus"></i></a>
                                </li>
                                <li>
                                    <a href=""><i class="fas fa-user"></i></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="icon">
                <ul>
                    <li>
                        <a href=""><i class="fas fa-search"></i></a>
                    </li>
                    <li>
                        <a href=""><i class="fas fa-cart-plus"></i></a>
                    </li>
                    <li>
                        <a href=""><i class="fas fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        (function($){
            $('.navbar-light .navbar-toggler-icon').css('background-image', 'url(img/hamburger-solid.svg)');
            let burger_manger = false;
            $('.navbar-toggler').click(function(){
                if(burger_manger){
                    $('.navbar-light .navbar-toggler-icon').css('background-image', 'url(img/hamburger-solid.svg)');
                    burger_manger = false;
                }else{
                    $('.navbar-light .navbar-toggler-icon').css('background-image', 'url(img/hamburger-open.svg)');
                    burger_manger = true;
                }
                
            }) 
        })(jQuery)
           
    </script>
</header>

<body>