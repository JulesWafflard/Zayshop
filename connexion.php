<!-- HEADER  -->
<?php
include 'header.php';
?>
<!-- ------------- -->

<main id="connexion">

    <section class="section-connexion">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-10 justify-content-center">
                    <div class="container-form">
                        <form method="POST">
                            <h2>Connexion</h2>
                            <hr>
                            <div class="container_input">
                                <label>Email</label>
                                <input type="mail" placeholder="Entrer votre Email" name="username" required>
                            </div>
                            <div class="container_input">
                                <label>Mot de passe</label>
                                <input type="password" placeholder="Entrer le mot de passe" name="password" required>
                            </div>
                            <div class="container_oublie">
                                <a href="./mot-de-passe" class="oublie">Mot de pass oublié ?</a>
                            </div>
                            <input type="submit" id='submit' value='Se Connecter'>
                            <a href="./inscription" class="inscription">S'inscrire</a>
                            <?php connexion(); ?>
                        </form>
                        
                    </div>

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