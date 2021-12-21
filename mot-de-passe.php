<!-- HEADER  -->
<?php
include 'header.php';
?>
<!-- ------------- -->

<main id="mdp">

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10 justify-content-center ">
                    <div class="container-form">
                        
                        <?php if (isset($_SESSION['username'])){ ?>
                            <h2>Changer de mot de passe</h2>
                        <hr>
                        <form action="" method="POST">
                            <div>
                                <p>Nouveau Mot de Passe</p>
                                <input type="password" name='password' placeholder="Nouveau mot de passe">
                            </div>
                            <div>
                                <p>Confirmer votre nouveau mot de passe</p>
                                <input type="password" name="confirmpassword" placeholder=" Confirmer">
                            </div>
                            <input type="submit" value="confirmer">
                            <?php changePassword() ?>
                        </form>
                        <?php }
                    else { ?>
                        <h2>vous n'etes pas connecté</h2><hr>
                        <div class="liens_connect col-8 ">
                        <a href="./connexion">Se connecter </a> 
                        <a href="./inscription"> S'inscrire</a>
                        </div>
              <?php } ?>
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