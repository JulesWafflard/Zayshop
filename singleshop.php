<?php
include 'header.php';
include 'functions.php';

/*$NAME = $_GET['5'];
// Bad:
echo $NAME;*/

$idProduit = 7;
?>

<main>

    <?php $product = getProduct($idProduit); ?>

    <section id="singleproduct">
        <div class="container">
            <div class="row single">

                <div class="col-lg-4 col-md-8 col-sm-12 imageproduit">

                    <img src="<?php echo $product['images'][3]['url']; ?>" alt="..." class="rounded-0">

                    <div class="uk-position-relative uk-visible-toggle uk-light slide" tabindex="-1" uk-slider>

                        <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                            <?php foreach ($product['images'] as $image) { ?>
                                <li>
                                    <div class="uk-panel">
                                        <img src="<?php echo $image['url']; ?>" alt="">
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                        <a class="uk-position-center-left fleche" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right fleche" href="#" uk-slidenav-next uk-slider-item="next"></a>

                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12 informations">
                    <div class="row">

                        <div class="col-lg-12 col-md-7 col-sm-12">
                            <h2>Active Wear</h2>

                            <p>$25.00</p>

                            <ul class="avis">
                                <li>
                                    <div class="stars">
                                        <?php echo getNumberAvis($product['id']); ?>
                                    </div>
                                </li>
                                <li>
                                    <p class="avis">Rating <?php echo $product['avis']['note']; ?> | <?php echo $product['avis']['nb_com']; ?> Comments</p>
                                </li>
                            </ul>

                            <p><span class="bold">Brand :</span> <?php echo $product['marque']; ?></p>

                            <p class="bold description">Description :</p>
                            <p class="description">
                                <?php echo $product['description']; ?>
                            </p>

                            <p><span class="bold">Available Color :</span> <?php echo $product['couleur']; ?></p>

                            <p class="bold description">Specification :</p>
                            <p class="description">
                                <?php echo $product['specification']; ?>
                            </p>

                            <?php
                            if (isset($_POST['addtocart'])) {
                                if (isset($_POST) && (isset($_POST['input-taille'])) /*Function if connected*/) {
                                    $panier = array(
                                        'idProduit' => $idProduit,
                                        'idUser' => 1,
                                        'taille' => $_POST['input-taille'],
                                        'quantite' => $_POST['input-quantite'],
                                        'submit' => $_POST['submit']
                                    );

                                    /*if ($_POST['submit'] == 'Buy') {
                                        header ('location : panier.php');
                                    }*/

                                    $createdCartSuccess = createCart($panier);
                                    if ($createdCartSuccess) {
                            ?>
                                        <div class="alert alert-success" role="alert">
                                            Le produit a été ajouté à votre panier
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Erreur lors de l'ajout à votre panier
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="col-lg-12 col-md-5 col-sm-12 formadd">
                            <form method="POST">
                                <div class="row">

                                    <input type="hidden" name="addtocart" value="true">

                                    <div class="col-lg-5 col-md-12 margin-form liste">
                                        <label for="taille" style="margin-right: 10px;">Sizes :</label>
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            <?php foreach ($product['taille'] as $taille) { ?>
                                                <input type="radio" class="btn-check" name="input-taille[]" value="<?php echo $taille; ?>" id="btn-check-<?php echo $taille; ?>" required>
                                                <label class="btn btn-taille" for="btn-check-<?php echo $taille; ?>"><?php echo $taille; ?></label>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 margin-form liste">
                                        <label class="quantitylabel" for="quantity">Quantity</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="minus btn btn-plusminus" data-type="minus" data-field="">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity" name="input-quantite" class="btn btn-secondary inputquantity" value="0" min="0" max="100">
                                            <span class="input-group-btn">
                                                <button type="button" class="plus btn btn-taille" data-type="plus" data-field="">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 margin-form">
                                        <input type="submit" name="submit" value="Buy" class="btn btn-addbuy">
                                    </div>

                                    <div class="col-lg-6 col-md-12 margin-form">
                                        <input type="submit" name="submit" value="Add To Cart" class="btn btn-addbuy">
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </section>

    <section id="avisproduit">
        <div class="container">
            <div class="ajouter">
                <h3 class="ajoutertitre">Ajouter un commentaire</h3>
                <hr class="hrvert">

                <?php
                if (isset($_POST['addcom'])) {
                    if (isset($_POST)) {
                        $avis = array(
                            'idProduit' => $idProduit,
                            'idUser' => 1,
                            'commentaire' => $_POST['input-commentaire'],
                            'note' => $_POST['input-note'],
                        );

                        $insertAvis = insertUserAvis($avis);
                        if ($insertAvis) {
                ?>
                            <div class="alert alert-success" role="alert">
                                Le commentaire a été ajouté au produit
                            </div>
                        <?php
                        echo("<meta http-equiv='refresh' content='1'>");
                        } else {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                Erreur lors de l'ajout du commentaire au produit
                            </div>
                <?php
                        }
                    }
                }
                ?>

                <form method="POST">

                    <input type="hidden" name="addcom" value="1">

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-floating">
                                <textarea class="form-control commentaire" name="input-commentaire" placeholder="Écrire votre commentaire..." id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Écrire votre commentaire...</label>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <ul class="avis">
                                <li>
                                    <p>Ajouter une note :</p>
                                </li>
                                <li>
                                    <div id="full-stars-example-two">
                                        <div class="rating-group">
                                            <input disabled checked class="rating__input rating__input--none" name="input-note" id="input-note-none" value="0" type="radio">
                                            <label aria-label="1 star" class="rating__label" for="input-note-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="input-note" id="input-note-1" value="1" type="radio">
                                            <label aria-label="2 stars" class="rating__label" for="input-note-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="input-note" id="input-note-2" value="2" type="radio">
                                            <label aria-label="3 stars" class="rating__label" for="input-note-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="input-note" id="input-note-3" value="3" type="radio">
                                            <label aria-label="4 stars" class="rating__label" for="input-note-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="input-note" id="input-note-4" value="4" type="radio">
                                            <label aria-label="5 stars" class="rating__label" for="input-note-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="input-note" id="input-note-5" value="5" type="radio">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <input type="submit" value="Ajouter un commentaire" class="btn btn-addbuy">
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>

            </div>

            <div class="voircommentaire">
                <div class="accordion accordion-flush" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Voir les commentaires
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body" style="margin-top: 20px;">
                                <div class="uk-slider-container-offset" uk-slider>

                                    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

                                        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-4@m uk-grid">

                                            <?php foreach ($product['commentaires'] as $commentaire) { ?>
                                                <li>
                                                    <div class="uk-card uk-card-default">
                                                        <div class="uk-card-body">
                                                            <h3 class="uk-card-title"><?php echo $commentaire['username']; ?> <?php echo $commentaire['usernickname']; ?></h3>
                                                            <p><?php echo $commentaire['commentaire']; ?></p>
                                                            <div class="stars">
                                                                <?php echo getUserStars($commentaire); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>

                                        </ul>

                                    </div>

                                    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="slideproduct">
        <div class="container">
            <div class="uk-slider-container-offset" uk-slider>

                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

                    <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-4@m uk-grid">

                        <?php
                        $products = getAllProducts();

                        foreach ($products as $product) {
                        ?>
                            <li>
                                <div class="uk-card uk-card-default">
                                    <div class="uk-card-media-top">
                                        <img src="<?php echo $product['images'][0]['url']; ?>" alt="">
                                    </div>
                                    <div class="uk-card-body">
                                        <p><?php echo $product['nom']; ?></p>
                                        <p>
                                            <?php
                                            echo implode("/", $product['taille']);
                                            ?>
                                        </p>
                                        <ul class="avis">
                                            <li>
                                                <div class="stars">
                                                    <?php echo getNumberAvis($product['id']); ?>
                                                </div>
                                            </li>
                                            <li>
                                                <p>$<?php echo $product['prix']; ?></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

            </div>

        </div>
    </section>

</main>

<script>
    $(document).ready(function() {
        var quantitiy = 0;
        $('.plus').click(function(e) {

            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
        });

        $('.minus').click(function(e) {
            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });
    });
</script>

<?php
include 'footer.php';
?>