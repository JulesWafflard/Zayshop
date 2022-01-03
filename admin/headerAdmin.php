<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../css/scss/style.css" rel="stylesheet">

    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/css/uikit.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.min.js"></script>

    <title>ZayShop</title>
</head>
<?php 
include 'functions.php'; 
session_start();

if (!isset($_SESSION['username'])){
    header("Location: http://localhost/Zayshop");
    die();
}
?>
<header>

    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container">
            <h1 class="zay"><a class="navbar-brand" href="#">Zay</a></h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sizes.php">Sizes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                    <li class="icon">
                        <div>
                            <ul>
                                <li>
                                    <a href=""><i class="fas fa-sign-out-alt"></i></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="icon">
                <ul>
                    <li>
                        <a href="../deconnexion.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        (function($) {
            $('.navbar-light .navbar-toggler-icon').css('background-image', 'url(../img/hamburger-solid.svg)');
            let burger_manger = false;
            $('.navbar-toggler').click(function() {
                if (burger_manger) {
                    $('.navbar-light .navbar-toggler-icon').css('background-image', 'url(../img/hamburger-solid.svg)');
                    burger_manger = false;
                } else {
                    $('.navbar-light .navbar-toggler-icon').css('background-image', 'url(../img/hamburger-open.svg)');
                    burger_manger = true;
                }

            })
        })(jQuery)
    </script>
</header>

<body>