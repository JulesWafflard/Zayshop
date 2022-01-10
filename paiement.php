<!-- HEADER  -->
<?php
include 'header.php';
?>
<!-- ------------- -->

<main id="paiement">
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <h2>Informations Paiement</h2><hr>
                <div class="col-9  container_form">
                    <form action="https://www.paypal.com/">
                        <div class="num_cb">
                            <p>Numéro de carte bancaire</p>
                            <input type="text" placeholder="Nuéro de carte bancaire">
                        </div>
                        <div class="container_2">
                            <div class="mois_annee">
                                <div class="mois">
                                    <p>Mois</p>
                                    <input type="text" placeholder="MM">
                                </div>
                                <div class="annee">
                                    <p>Année</p>
                                    <input type="text" placeholder="YYYY">
                                </div>

                            </div>
                            <div class="code_verif">
                                <p>Code de vérification</p>
                                <input type="text" placeholder="CVV">
                            </div>
                        </div>
                        <div class="container_btn">
                        <input type="submit" value="Paiement" id="btn_paiement">
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</main>

<!-- FOOTER  -->
<?php
include 'footer.php';
?>
<!-- -------- -->