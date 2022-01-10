<?php
include 'header.php';
$leUser = getUnUser()[0];
?>
<main id="form-informations">

    <section id="forminfos">

        <div class="container">
            <?php
            if (isset($_POST['idUser']) && !isset($_POST['deconnexion'])) {
                if (isset($_POST)) {
                    $user = array(
                        'idUser' => $_POST['idUser'],
                        'nom' => $_POST['input-nom'],
                        'prenom' => $_POST['input-prenom'],
                        'email' => $_POST['input-email'],
                        'adresse' => $_POST['input-adresse'],
                        'complementadresse' => $_POST['input-c-adresse'],
                        'cp' => (empty($_POST['input-cp'])) ? "null" : $_POST['input-cp'],
                        'ville' => $_POST['input-ville'],
                        'pays' => (empty($_POST['input-pays'])) ? "null" : $_POST['input-pays'],
                        'telephone' => $_POST['input-telephone']
                    );
                    $updateUser = updateUser($user);
                    if ($updateUser) {
                        $_SESSION['username'] = $_POST['input-email'];
            ?>
                        <div class="alert alert-success" role="alert">
                            Les informations personnelles ont bien été enregistrées
                        </div>
                    <?php
                        echo ("<meta http-equiv='refresh' content='1'>");
                    } else {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            Erreur lors de l'enregistrement des informations
                        </div>
            <?php
                    }
                }
            }

            if (isset($_POST['deconnexion'])) {
                deconnexion();
            }
            ?>

            <h1>Informations personnelles</h1>
            <hr class="hr-infos">

            <form method="POST">

                <input type="hidden" name="idUser" value="<?php echo $leUser['id']; ?>">

                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput">Nom</label>
                        <input type="text" class="form-control" value="<?php echo $leUser['nom']; ?>" name="input-nom">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput">Prenom</label>
                        <input type="text" class="form-control" value="<?php echo $leUser['prenom']; ?>" name="input-prenom">
                    </div>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Email</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $leUser['email']; ?>" name="input-email">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Adresse</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $leUser['adresse']; ?>" name="input-adresse">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Complément d'adresse</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $leUser['comp-add']; ?>" name="input-c-adresse">
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="formGroupExampleInput">Code postal</label>
                        <input type="text" class="form-control" value="<?php echo $leUser['cp']; ?>" name="input-cp">
                    </div>
                    <div class="col-6">
                        <label for="formGroupExampleInput">Ville</label>
                        <input type="text" class="form-control" value="<?php echo $leUser['ville']; ?>" name="input-ville">
                    </div>
                    <div class="col-6">
                        <label for="formGroupExampleInput">Pays</label>
                        <select class="form-select" id="input-pays" name="input-pays">
                            <option value="<?= $leUser['pays']; ?>"><?= getPaysName($leUser['pays']); ?></option>
                            <?php foreach (getPays() as $paysId => $paysName) : ?>
                                <?php if ($leUser['pays'] != $paysId) : ?>
                                    <option value="<?= $paysId; ?>"><?= $paysName; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="formGroupExampleInput">Téléphone</label>
                        <input type="text" class="form-control" value="<?php echo $leUser['tel']; ?>" name="input-telephone">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-addbuyG">Enregistrer mes informations <i class="far fa-save"></i></button>
                    </div>
                    <div class="col-lg-6">
                        <button type="submit" name="deconnexion" class="btn btn-addbuyD">Déconnexion <i class="fas fa-drumstick-bite"></i></button>
                    </div>
                </div>

            </form>
        </div>

    </section>

</main>
<?php
include 'footer.php';
?>