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
    $requete = "INSERT INTO panier (Taille, Quantite, idUser, idProduit)
    VALUES ('".$panier['taille'][0]."', ".$panier['quantite'].", ".$panier['idUser'].", ".$panier['idProduit'].")";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();

    if ($getCat) {
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
    VALUES (".$avis['note'].", '".$avis['commentaire']."', ".$avis['idUser'].", ".$avis['idProduit'].")";
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
    VALUES ('".$message['name']."', '".$message['email']."', '".$message['subject']."', '".$message['contactmessage']."')";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();

    if ($getCat) {
        return true;
    } else {
        return false;
    }

    return false;

}

