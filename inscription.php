<!-- HEADER  -->
<?php
include 'header.php';
?>
<!-- ------------- -->

<main id="inscription">
    <div class="container-form">
    <h2>Inscription</h2><hr>

<form method="post" action="inscription">
        <p>Nom</p>
        <input type="text" name="Nom" placeholder="Nom">
        <p>Prenom</p>
        <input type="text" name="Prenom" placeholder="Prenom">
        <p>Email</p>
        <input type="email" name="email" placeholder="Email">
        <p>Mot de Passe</p>
        <input type="password" name="password" placeholder="Mot de Passe">
        <p>Répetez votre Mot de Passe</p>
        <input type="password" name="repeatpassword" placeholder="Mot de Passe">
        <div class="container-valider">
        <input type="submit" name="submit" value="S'inscrire" class="valider">       
    </div>
    </form>
    <a href="./connection">Se Connecter</a>
</div>
    <?php 
addUser();

?>
</main>

<!-- FOOTER  -->
<?php
include 'footer.php';
?>
<!-- -------- -->