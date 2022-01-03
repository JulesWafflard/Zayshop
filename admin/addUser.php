<?php
include 'headerAdmin.php';
?>

<main id="addUser" class="container">
    <h2>Add User</h2>
    <hr>
    <a class="back-button" href="users.php">Back</a>

    <?php
    if (isset($_POST) && !empty($_POST)) :
        $user = (object) array(
            'nom' => $_POST['input-lastName'],
            'prenom' => $_POST['input-firstName'],
            'email' => $_POST['input-email'],
            'phone' => $_POST['input-phone'],
            'password' => $_POST['input-password'],
            'adresse' => (!empty($_POST['input-adresse'])) ? "'" . $_POST['input-adresse'] . "'" : 'NULL',
            'complement_adresse' => (!empty($_POST['input-cAdresse'])) ? "'" . $_POST['input-cAdresse'] . "'" : 'NULL',
            'ville' => (!empty($_POST['input-ville'])) ? "'" . $_POST['input-ville'] . "'" : 'NULL',
            'cp' => (!empty($_POST['input-codePostal'])) ? "'" . $_POST['input-codePostal'] . "'" : 'NULL',
            'pays' =>  $_POST['input-pays'],
            'admin' => $_POST['input-admin'],
        );
        $createdUser = CreateUser($user); 
    ?>
        <?php if($createdUser) : ?>
            <div class="alert alert-success" role="alert">
                The user has been created!
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                Error while creating the user..
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
        <!-- Input LastName -->
        <div class="col-md-6">
            <label for="input-lastName" class="form-label">Last name</label>
            <input type="text" class="form-control" name="input-lastName" id="input-lastName" required>
            <div class="invalid-feedback">
                Please choose a last name.
            </div>
        </div>

        <!-- Input FirstName -->
        <div class="col-md-6">
            <label for="input-firstName" class="form-label">First name</label>
            <input type="text" class="form-control" name="input-firstName" id="input-firstName" required>
            <div class="invalid-feedback">
                Please choose a first name.
            </div>
        </div>

        <!-- Input Email -->
        <div class="col-md-4">
            <label for="input-email" class="form-label">Email</label>
            <input type="text" class="form-control" name="input-email" id="input-email" required>
            <div class="invalid-feedback">
                Please choose an email.
            </div>
        </div>

        <!-- Input Phone -->
        <div class="col-md-4">
            <label for="input-phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="input-phone" id="input-phone" required>
            <div class="invalid-feedback">
                Please enter a number phone.
            </div>
        </div>

        <!-- Input Password -->
        <div class="col-md-4">
            <label for="input-password" class="form-label">Password</label>
            <input type="text" class="form-control" name="input-password" id="input-password" required>
            <div class="invalid-feedback">
                Please enter a password.
            </div>
        </div>

        <!-- Input Adresse -->
        <div class="col-md-12">
            <label for="input-adresse" class="form-label">Address</label>
            <input type="text" class="form-control" name="input-adresse" id="input-adresse">
        </div>

        <!-- Input cAdresse -->
        <div class="col-md-12">
            <label for="input-cAdresse" class="form-label">Complément d'adresse</label>
            <input type="text" class="form-control" name="input-cAdresse" id="input-cAdresse">
        </div>

        <!-- Input Ville -->
        <div class="col-md-4">
            <label for="input-ville" class="form-label">City</label>
            <input type="text" class="form-control" name="input-ville" id="input-ville">
        </div>

        <!-- Input Code Postal -->
        <div class="col-md-4">
            <label for="input-codePostal" class="form-label">Code Postal</label>
            <input type="text" class="form-control" name="input-codePostal" id="input-codePostal">
        </div>

        <!-- Input Pays -->
        <div class="col-md-4">
            <label for="input-pays" class="form-label">Country</label>
            <select class="form-select" id="input-pays" name="input-pays">
                <?php foreach (getPays() as $paysId => $paysName) : ?>
                    <option value="<?= $paysId; ?>"><?= $paysName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input Admin -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4" for="size-text">Administrator</label>
                <div class="col-md-6">
                    <input type="radio" class="form-check-input" name="input-admin" value="1" /><label for="input-admin">Yes</label>
                    <input type="radio" class="form-check-input" name="input-admin" value="0" checked /><label for="input-admin">No</label>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <button class="btn" type="submit">Add User</button>
        </div>
    </form>
</main>
<?php

include 'footerAdmin.php';
