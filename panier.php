<?php
include 'header.php';
?>
<main id="panier">

    <section id="monpanier">

        <div class="container">

            <h1>Panier</h1>
            <hr class="panier">

            <?php
            if (isset($_POST['idUser'])) {
                if (isset($_POST)) {
                    $quantity = array(
                        'idProduit' => $_POST['idProduit'],
                        'idUser' => $_POST['idUser'],
                        'quantite' => $_POST['input-quantite'],
                        'taille' => $_POST['taille'],
                    );

                    $insertQuantity = insertPanierQuantity($quantity);
                    if ($insertQuantity) {
                        echo '<meta http-equiv="refresh" content="0;url=informationsperso.php">';
                    }
                }
            }
            ?>

            <form method="POST">
                <?php
                $id = 1;
                $products = getAllProductsCart($id);
                foreach ($products as $product) {
                ?>
                    <input type="hidden" name="idUser" value="<?php echo $product['idUser'] ?>">
                    <input type="hidden" name="idProduit" value="<?php echo $product['idProduit'] ?>">
                    <input type="hidden" name="taille" value="<?php echo $product['taille'] ?>">

                    <div class="card col-5 produits shadow p-3 mb-5 bg-body rounded">
                        <div class="row g-0">
                            <div class="col-md-2 liste">
                                <img src="<?php echo $product['produit']['images'][0]['url']; ?>" class="img-fluid rounded-circle image-produit" alt="...">
                            </div>
                            <div class="col-md-6 liste">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product['produit']['nom'] ?> / <?php echo $product['taille'] ?></h5>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="minus btn btn-plusminus" data-id="<?php echo $product['idPanier'] ?>" data-type="minus" data-field="">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </span>
                                        <!-- <input type="text" name="input-quantite[]" class="btn quantity btn-secondary inputquantity" value="<?php echo $product['quantite'] ?>"> -->
                                        <input type="text" id="<?php echo $product['idPanier'] ?>" name="input-quantite[]" class="btn quantity btn-secondary inputquantity" value="<?php echo $product['quantite'] ?>">
                                        <span class="input-group-btn">
                                            <button type="button" class="plus btn btn-plusminus" data-id="<?php echo $product['idPanier'] ?>" data-type="plus" data-field="">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 liste">
                                <div class="card-body">
                                    <p class="card-text">$<span class="product-price" data-unite="<?php echo $product['prix'] ?>" id="total-<?php echo $product['idPanier'] ?>"><?php echo $product['prixArticles'] ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <div class="row">
                    <div class="col-5 total">
                        <hr class="totalhr">
                        <div class="row">

                            <div class="col-6 totaltext">
                                <p>Total</p>

                            </div>
                            <div class="col-6 prixtext">
                                <p>$<span id="prix-total"></span></p>
                            </div>
                        </div>

                        <input type="submit" value="Commander" class="btn btn-addbuy">

            </form>
        </div>
        </div>

        </div>

    </section>

</main>

<script>
    $(document).ready(function() {

        prixtotal();

        // quantity +
        var quantitiy = 0;
        $('.plus').click(function(e) {
            e.preventDefault();
            var btnId = $(this).data('id');
            var qtyElm = $('#' + btnId);
            var quantity = parseInt(qtyElm.val());
            if (quantity < 99) {
                quantity++;
                qtyElm.val(quantity);
                var price = parseFloat($('#total-' + btnId).data("unite"));
                var total = parseFloat(price * quantity).toFixed(2);
                $('#total-' + btnId).html(total);
                prixtotal();
            }
        });

        // quantity -
        $('.minus').click(function(e) {
            e.preventDefault();
            var btnId = $(this).data('id');
            var qtyElm = $('#' + btnId);
            var quantity = parseInt(qtyElm.val());
            if (quantity > 0) {
                quantity--;
                qtyElm.val(quantity);
                var price = parseFloat($('#total-' + btnId).data("unite"));
                var total = parseFloat(price * quantity).toFixed(2);
                $('#total-' + btnId).html(total);
                prixtotal();
            }
        });

        function prixtotal() {
            var total = 0;
            $('.product-price').each(function() {
                total += parseFloat($(this).html())
            })
            $('#prix-total').html(parseFloat(total).toFixed(2));
        }
    });
</script>


<?php
include 'footer.php';
?>