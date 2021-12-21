<?php

include 'bdd.php';

function getLimit3Products()
{
    global $dbh;
    $productsList = [];
    $requete = "SELECT * FROM Produit ORDER BY produit.id DESC LIMIT 3";
    $getProducts = $dbh->prepare($requete);
    $getProducts->execute();
    $products = $getProducts->fetchAll();

    foreach ($products as $product) {
        $productsList[] = array(
            'id' => $product['id'],
            'nom' => $product['Nom'],
            'description' => $product['Description'],
            'marque' => $product['Marque'],
            'prix' => $product['Prix'],
            'couleur' => $product['Couleur'],
            'specification' => $product['Specification'],
            'avis' => getProductAvis($product['id']),
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }

    return $productsList;
}

function getProduct($id)
{
    global $dbh;
    $product = array();
    $requete = "SELECT * FROM produit WHERE id = $id";
    $getProduct = $dbh->prepare($requete);
    $getProduct->execute();
    $product = $getProduct->fetch();
    if ($getProduct->rowCount() > 0) {
        $product = array(
            'id' => $id,
            'nom' => $product['Nom'],
            'description' => $product['Description'],
            'marque' => $product['Marque'],
            'prix' => $product['Prix'],
            'couleur' => $product['Couleur'],
            'specification' => $product['Specification'],
            'categorie' => getproductCategorie($product['idCategorie']),
            'genre' => getProductGenre($product['idGenre']),
            'avis' => getProductAvis($product['id']),
            'commentaires' => getProductCommentaire($product['id']),
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }
    return $product;
}

function getAllProducts($asc = false)
{
    global $dbh;
    $asc = ($asc) ? 'ORDER BY id ASC' : 'ORDER BY id DESC';
    $productsList = [];
    $requete = "SELECT * FROM produit " . $asc;
    $getProducts = $dbh->prepare($requete);
    $getProducts->execute();
    $products = $getProducts->fetchAll();
    foreach ($products as $product) {
        $productsList[] = array(
            'id' => $product['id'],
            'nom' => $product['Nom'],
            'description' => $product['Description'],
            'marque' => $product['Marque'],
            'prix' => $product['Prix'],
            'couleur' => $product['Couleur'],
            'specification' => $product['Specification'],
            'categorie' => getproductCategorie($product['idCategorie']),
            'genre' => getProductGenre($product['idGenre']),
            'avis' => getProductAvis($product['id']),
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }
    return $productsList;
}

function getProductAvis($id)
{
    global $dbh;
    $productsAvis = [];
    $requete = "SELECT Note, `Nb-commentaire` FROM produitavis WHERE id = $id";
    $getAvis = $dbh->prepare($requete);
    $getAvis->execute();
    $avis = $getAvis->fetch();

    return array(
        'note' => $avis['Note'],
        'nb_com' => $avis['Nb-commentaire']
    );
}

function getProductCommentaire($id)
{
    global $dbh;
    $productcommentaire = [];
    $requete = "SELECT * FROM avis INNER JOIN users ON avis.idUser = users.id WHERE idProduit = $id";
    $getAvis = $dbh->prepare($requete);
    $getAvis->execute();
    $commentaires = $getAvis->fetchAll();

    foreach ($commentaires as $commentaire) {
        $productcommentaire[] = array(
            'note' => $commentaire['Note'],
            'commentaire' => $commentaire['Commentaire'],
            'username' => $commentaire['Nom'],
            'usernickname' => $commentaire['Prenom']
        );
    }

    return $productcommentaire;
}

function getUserStars($com)
{
    $elm        = '<i class="fa fa-star"></i>';
    $elmGold    = '<i class="fa fa-star gold"></i>';
    $avisElm    = '';
    for ($i = 1; $i <= $com['note']; $i++) {
        $avisElm .= $elmGold;
    }
    for ($i = 1; $i <= 5 - $com['note']; $i++) {
        $avisElm .= $elm;
    }
    return $avisElm;
}

function getProductTaille($id)
{
    global $dbh;
    $productsTaille = [];
    $requete = "SELECT * FROM produittaille WHERE idProduit = $id";
    $getTaille = $dbh->prepare($requete);
    $getTaille->execute();
    $tailles = $getTaille->fetchAll();

    foreach ($tailles as $taille) {
        $productsTaille[] = $taille['libelle'];
    }

    return $productsTaille;
}

function getProductImage($id)
{
    global $dbh;
    $productsImg = [];
    $requete = "SELECT * FROM produitimage WHERE idProduit = $id";
    $getImg = $dbh->prepare($requete);
    $getImg->execute();
    $imgs = $getImg->fetchAll();
    foreach ($imgs as $img) {
        $productsImg[] = array(
            'url' => $img['URL'],
            'nom' => $img['Nom']
        );
    }
    return (empty($productsImg)) ? 0 : $productsImg;
}

function getNumberAvis($id)
{
    $elm        = '<i class="fa fa-star"></i>';
    $elmGold    = '<i class="fa fa-star gold"></i>';
    $avis       = getProductAvis($id)['note'];
    $avisElm    = '';
    for ($i = 1; $i <= $avis; $i++) {
        $avisElm .= $elmGold;
    }
    for ($i = 1; $i <= 5 - $avis; $i++) {
        $avisElm .= $elm;
    }
    return $avisElm;
}

function getProductGenre($id)
{
    global $dbh;
    $requete = "SELECT Genre FROM genre WHERE id = $id";
    $getGenre = $dbh->prepare($requete);
    $getGenre->execute();
    $genre = $getGenre->fetch();
    return $genre['Genre'];
}
function getproductCategorie($id)
{
    global $dbh;
    $requete = "SELECT Nom FROM Categorie WHERE id = $id";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();
    $cat = $getCat->fetch();
    return $cat['Nom'];
}

function createCart($panier)
{

    /*Verifier si produit existe déjà*/
    global $dbh;

    $delete = "DELETE FROM panier WHERE idUser = " . $panier['idUser'] . " AND idProduit = " . $panier['idProduit'] . " AND Taille = '" . $panier['taille'][0] . "'";
    $getDel = $dbh->prepare($delete);
    $getDel->execute();
    $requete = "INSERT INTO panier (Taille, Quantite, idUser, idProduit)
    VALUES ('" . $panier['taille'][0] . "', " . $panier['quantite'] . ", " . $panier['idUser'] . ", " . $panier['idProduit'] . ")";
    $getCart = $dbh->prepare($requete);
    $getCart->execute();

    if ($getCart) {
        return true;
    } else {
        return false;
    }

    return false;
}

function insertUserAvis($avis)
{

    /*Verifier si produit existe déjà*/
    global $dbh;
    $requete = "INSERT INTO avis (Note, Commentaire, idUser, idProduit)
    VALUES (" . $avis['note'] . ", '" . $avis['commentaire'] . "', " . $avis['idUser'] . ", " . $avis['idProduit'] . ")";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();

    if ($getCat) {
        return true;
    } else {
        return false;
    }

    return false;
}

function insertMessage($message)
{
    global $dbh;
    $requete = "INSERT INTO contact (nom, email, sujet, message)
    VALUES ('" . $message['name'] . "', '" . $message['email'] . "', '" . $message['subject'] . "', '" . $message['contactmessage'] . "')";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();

    if ($getCat) {
        return true;
    } else {
        return false;
    }

    return false;
}

function getAllProductsCart($id)
{
    global $dbh;
    $requete = "SELECT * FROM produitprixpanier WHERE idUser = $id";
    $getProducts = $dbh->prepare($requete);
    $getProducts->execute();
    $products = $getProducts->fetchAll();
    foreach ($products as $product) {
        $productsList[] = array(
            'idUser' => $id,
            'idPanier' => $product['id'],
            'idProduit' => $product['idProduit'],
            'quantite' => $product['Quantite'],
            'taille' => $product['Taille'],
            'prix' => $product['Prix'],
            'prixArticles' => $product['prixArticles'],
            'produit' => getProduct($product['idProduit'])
        );
    }
    return $productsList;
}

function insertPanierQuantity($quantity)
{
    global $dbh;
    $quantityPanier = "";
    $deletePanierQty = "";
    foreach ($quantity['quantite'] as $qty) {
        $quantityPanier .= "UPDATE panier
                            SET  Quantite = " . $qty . "
                            WHERE idUser = " . $quantity['idUser'] . " AND idProduit = " . $quantity['idProduit'] . " AND Taille = '" . $quantity['taille'] . "';";
        if ($qty == 0) {
            $deletePanierQty .= "DELETE FROM panier 
                            WHERE idUser = " . $quantity['idUser'] . " AND idProduit = " . $quantity['idProduit'] . " AND Taille = '" . $quantity['taille'] . "';";
        }
    }
    $getDel = $dbh->prepare($deletePanierQty);
    $getDel->execute();
    $getCat = $dbh->prepare($quantityPanier);
    $getCat->execute();

    if ($getCat) {
        return true;
    } else {
        return false;
    }

    return false;
}

function getUserPanierNumber($idUser)
{
    global $dbh;
    $requete = "SELECT COUNT(*) as numberproduct FROM panier WHERE idUser = $idUser";
    $getProducts = $dbh->prepare($requete);
    $getProducts->execute();
    $productsNumber = $getProducts->fetchColumn();
    return $productsNumber;
}

function getUnUser()
{
    global $dbh;
    $leUser = [];
    if (isset($_SESSION['username'])) {
        $requete = 'SELECT * FROM users WHERE Email = "' . $_SESSION['username'] . '"';
        $getLeUser = $dbh->prepare($requete);
        $getLeUser->execute();
        $row_user = $getLeUser->fetchAll();
        foreach ($row_user as $unuser) {
            $leUser[] = array(
                "id" => $unuser['id'],
                "nom" => $unuser['Nom'],
                "prenom" => $unuser['Prenom'],
                "email" => $unuser['Email'],
                "password" => $unuser['Mdp'],
                "tel" => $unuser['Telephone'],
                "adresse" => $unuser['Adresse'],
                "comp-add" => $unuser['Complementadresse'],
                "cp" => $unuser['Codepostal'],
                "ville" => $unuser['Ville'],
                "pays" => getUserPays($unuser['idPays'])
            );
        }
    }
    return $leUser;
}

function getUserPays($id)
{
    global $dbh;
    $requete = "SELECT Nom FROM pays WHERE id = $id";
    $getPays = $dbh->prepare($requete);
    $getPays->execute();
    $pays = $getPays->fetch();
    return $pays['Nom'];
}

function updateUser($user)
{
    global $dbh;
    $requete = "UPDATE users
                SET  Nom= '".$user['nom']."', Prenom= '".$user['prenom']."', Telephone= '".$user['telephone']."', Email= '".$user['email']."', Adresse= '".$user['adresse']."', Complementadresse= '".$user['complementadresse']."', Codepostal=".$user['cp'].", Ville= '".$user['ville']."', idPays=".$user['pays']."
                WHERE id = ". $user['idUser'] . ""; 
    $getCat = $dbh->prepare($requete);
    $getCat->execute();

    if ($getCat) {
        return true;
    } else {
        return false;
    }

    return false;
}
