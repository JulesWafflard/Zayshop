<?php

include 'bdd.php';

/*
        PRODUCT
*/

// Get Product
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
            'categorie' => getProductCategorie($product['idCategorie']),
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
            'categorie' => getProductCategorie($product['idCategorie']),
            'genre' => getProductGenre($product['idGenre']),
            'avis' => getProductAvis($product['id']),
            'commentaires' => getProductCommentaire($product['id']),
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }

    return $productsList;
}

// Avis Produit
function getProductAvis($id)
{
    global $dbh;
    $requete = "SELECT Note, `Nb-commentaire` FROM produitavis WHERE id = $id";
    $getAvis = $dbh->prepare($requete);
    $getAvis->execute();
    $avis = $getAvis->fetch();

    return array(
        'note' => (empty($avis['Note'])) ? 0 : $avis['Note'],
        'nb_com' => (empty($avis['Nb-commentaire'])) ? 0 : $avis['Nb-commentaire']
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

function getUserAvis($id)
{
    global $dbh;
    $avisList = [];
    $requete = "SELECT * FROM avis WHERE idUser = $id";
    $getAvis = $dbh->prepare($requete);
    $getAvis->execute();
    $avis = $getAvis->fetchAll();

    foreach ($avis as $av) {
        $avisList[] = array(
            "id" => $av['id'],
            "note" => $av['Note'],
            "commentaire" => $av['Commentaire'],
            "idProduit" => $av['idProduit'],

        );
    }
    return $avisList;
}

function getNumberAvis($id)
{
    $elm        = '<i class="fa fa-star"></i>';
    $elmGold    = '<i class="fa fa-star gold"></i>';
    $avis       = getProductAvis($id);
    $avisElm    = '';

    if ($avis) {
        $avis = $avis['note'];
        for ($i = 1; $i <= $avis; $i++) {
            $avisElm .= $elmGold;
        }
    }

    for ($i = 1; $i <= 5 - $avis; $i++) {
        $avisElm .= $elm;
    }

    return $avisElm;
}

// Commentaire Produit
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

// Tailles

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

function getTailles()
{
    global $dbh;
    $requete = "SELECT * FROM taille";
    $getTaille = $dbh->prepare($requete);
    $getTaille->execute();
    $tailles = $getTaille->fetchAll();

    foreach ($tailles as $taille) {
        $tailleList[$taille['id']] = $taille['libelle'];
    }

    return $tailleList;
}

function getTailleId($tailleName)
{
    $tailles = getTailles();
    foreach ($tailles as $tlleId => $tlleName) {
        if ($tailleName === $tlleName) {
            return $tlleId;
        }
    }

    return false;
}

function getTailleName($tailleId)
{
    $tailles = getTailles();
    foreach ($tailles as $tlleId => $tlleName) {
        if ($tailleId == $tlleId) {
            return $tlleName;
        }
    }

    return false;
}

function getTailleProduitId($idProduit, $idTaille)
{
    global $dbh;
    $requete = "SELECT id FROM tailleproduit WHERE idProduit = $idProduit AND idTaille = $idTaille";
    $getTaille = $dbh->prepare($requete);
    $getTaille->execute();
    $tailles = $getTaille->fetch();
    return (empty($tailles['id'])) ? false : $tailles['id'];
}

function getAllSizesInProduct($idTaille)
{
    global $dbh;
    $requete = "SELECT COUNT(*) FROM tailleproduit WHERE idTaille = $idTaille";
    $getCount = $dbh->prepare($requete);
    $getCount->execute();
    $count = $getCount->fetchColumn();
    return $count;
}

function createSize($sizeName)
{
    global $dbh;
    $req = "INSERT INTO `taille`(Libelle) VALUES ('$sizeName')";
    $sizeInsert = $dbh->prepare($req);
    $sizeInsert->execute();
    $sizeId = $dbh->lastInsertId();
    return array('id' => $sizeId, 'nom' => $sizeName);
}

function editSize($sizeId, $sizeName)
{
    global $dbh;
    $req = "UPDATE taille SET 
            Libelle = '$sizeName'
            WHERE id = $sizeId";
    $sizeUpd = $dbh->prepare($req);
    $sizeUpd->execute();
    if ($sizeUpd) {
        return true;
    }
    return false;
}

function deleteSize($idSize)
{
    global $dbh;
    if (getAllSizesInProduct($idSize) > 0) return array("success" => false, "message" => 'The size have products.');
    $req = "DELETE FROM `taille` WHERE id=$idSize";
    $sizeDel = $dbh->query($req);

    if ($sizeDel) {
        return array("success" => true, "message" => '');
    }
    return array("success" => false, "message" => '');
}

// Genre

function getProductGenre($id)
{
    global $dbh;
    $requete = "SELECT Genre FROM genre WHERE id = $id";
    $getGenre = $dbh->prepare($requete);
    $getGenre->execute();
    $genre = $getGenre->fetch();

    return $genre['Genre'];
}

function getGenre()
{
    global $dbh;
    $requete = "SELECT * FROM genre";
    $getGenre = $dbh->prepare($requete);
    $getGenre->execute();
    $genres = $getGenre->fetchAll();

    foreach ($genres as $genre) {
        $genreList[$genre['id']] = $genre['Genre'];
    }
    return $genreList;
}

// Categorie

function getAllCategories()
{
    global $dbh;
    $categorieList = [];
    $requete = "SELECT * FROM categorie";
    $getCategories = $dbh->prepare($requete);
    $getCategories->execute();
    $categories = $getCategories->fetchAll();
    foreach ($categories as $categorie) {
        $categorieList[] = array(
            "id" => $categorie['id'],
            "nom" => $categorie['Nom']
        );
    }
    return  $categorieList;
}

function getProductCategorie($id)
{
    global $dbh;
    $requete = "SELECT Nom FROM Categorie WHERE id = $id";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();
    $cat = $getCat->fetch();

    return $cat['Nom'];
}

function getAllProductInCategorie($idCat)
{
    global $dbh;
    $requete = "SELECT COUNT(*) FROM produit WHERE idCategorie = $idCat";
    $getCount = $dbh->prepare($requete);
    $getCount->execute();
    $count = $getCount->fetchColumn();
    return $count;
}

function createCategory($catName)
{
    global $dbh;
    $req = "INSERT INTO `categorie`(Nom) VALUES ('$catName')";
    $catInsert = $dbh->prepare($req);
    $catInsert->execute();
    $catId = $dbh->lastInsertId();
    return array('id' => $catId, 'nom' => $catName);
}

function editCategory($catId, $catName)
{
    global $dbh;
    $req = "UPDATE categorie SET 
            Nom = '$catName'
            WHERE id = $catId";
    $catUpd = $dbh->prepare($req);
    $catUpd->execute();
    if ($catUpd) {
        return true;
    }
    return false;
}

function deleteCategory($idCategory)
{
    global $dbh;
    if (getAllProductInCategorie($idCategory) > 0) return array("success" => false, "message" => 'The category have products.');
    $req = "DELETE FROM `categorie` WHERE id=$idCategory";
    $catDel = $dbh->query($req);

    if ($catDel) {
        return array("success" => true, "message" => '');
    }
    return array("success" => false, "message" => '');
}

// Images
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
            'id' => $img['idImage'],
            'url' => $img['URL'],
            'nom' => $img['Nom']
        );
    }
    return (empty($productsImg)) ? 0 : $productsImg;
}

function getImageProduitId($idProduit, $idImage)
{
    global $dbh;
    $requete = "SELECT id FROM imageproduit WHERE idProduit = $idProduit AND idImage = $idImage";
    $getImage = $dbh->prepare($requete);
    $getImage->execute();
    $image = $getImage->fetch();

    return $image['id'];
}

// recupère tout les produits de la table produit en fonction des filtre (genre , prix , catégorie) et créé une pagination en fonction du nombre de resultat
function getAllProductsByFiltre()
{ 
    global $dbh;
    $productsList = [];
    // Combien de resultat nous voulons par page
    $limit = 9;

    if (isset($_SESSION['genre']) || isset($_SESSION['categorie'])) { // si le $_POST de genre et de cat"gorie existe (SESSION sert a garder les resultat du $_post tant que la page n'est pas fermée)
        // ici la SESSION nous sert a garde les informations des filtres quand nous changeons de page de produit.
        $genrePOST = $_SESSION['genre'];
        $categoriePOST = $_SESSION['categorie'];
        $pmax = $_SESSION['pmax'];
        $pmin = $_SESSION['pmin'];

        if ($_SESSION['genre'] == 'all' and $_SESSION['categorie'] != 'all') { // compte les lignes de produits en fonction de la catégorie
            $total = 'SELECT COUNT(*) from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where categorie.Nom = "' . $categoriePOST . '" and produit.Prix between ' . $pmin . ' and  ' . $pmax . '';
        }
        if ($_SESSION['categorie'] === 'all'  and $_SESSION['genre'] != 'all') { // compte les lignes de produits en fonction du genre
            $total = 'SELECT COUNT(*) from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where genre.Genre = "' . $genrePOST . '" and produit.Prix between ' . $pmin . ' and  ' . $pmax . '';
        }
        if ($_SESSION['categorie'] == 'all' and $_SESSION['genre'] == 'all') { // compte toute les lignes de produit  
            $total = 'SELECT COUNT(*)  from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where produit.Prix between ' . $pmin . ' and  ' . $pmax . '';
        }
        if ($_SESSION['genre'] != 'all' and $_SESSION['categorie'] != 'all') { // compte les lignes de produits en fonction du genre et de la catégorie
            $total = 'SELECT COUNT(*) from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where genre.Genre = "' . $genrePOST . '" and categorie.Nom = "' . $categoriePOST . '" and produit.Prix between ' . $pmin . ' and  ' . $pmax . '';
        }
    } else { // si aucune des condition est remplis , compte toute les lignes produits

        $total = '
                                SELECT
                                COUNT(*)
                                FROM
                                produit
                            ';
    }


    $totals = $dbh->prepare($total);
    // $dbh->bindParam(':limit', $limit, PDO::PARAM_INT);
    // $dbh->bindParam(':offset', $offset, PDO::PARAM_INT);
    $totals->execute();
    $leTotal = $totals->fetchColumn();
    // Combien de page il y a
    global $pages;
    $pages = ceil($leTotal / $limit);


    // Sur quell epage somme nous actuellement
    global $page;
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));
    // calcul le offset 
    $offset = ($page - 1)  * $limit;



    if (isset($_SESSION['genre']) || isset($_SESSION['categorie'])) { // si nous avons des $_SESSION ($_POST sauvegarder) 
        $genrePOST =  $_SESSION['genre'];
        $categoriePOST = $_SESSION['categorie'];
        $pmax = $_SESSION['pmax'];
        $pmin = $_SESSION['pmin'];

        // filtre
        if ($_SESSION['genre'] === 'all' and $_SESSION['categorie'] != 'all') { // récupère les produit en fontion de la catégorie
            $requete = 'SELECT produit.* from produit 
        inner join categorie on produit.idCategorie = categorie.id
        inner JOIN genre on produit.idGenre = genre.id
        where categorie.Nom = "' . $categoriePOST . '" and produit.Prix between ' . $pmin . ' and  ' . $pmax . '
    LIMIT
    ' . $limit . '
    OFFSET
    ' . $offset . '';
        }
        if ($_SESSION['categorie'] === 'all'  and $_SESSION['genre'] != 'all') { // récupère les produit en fontion du genre
            $requete = 'SELECT produit.* from produit 
        inner join categorie on produit.idCategorie = categorie.id
        inner JOIN genre on produit.idGenre = genre.id
        where genre.Genre = "' . $genrePOST . '" and produit.Prix between ' . $pmin . ' and  ' . $pmax . '
        LIMIT
        ' . $limit . '
        OFFSET
        ' . $offset . '';
        }
        if ($_SESSION['categorie'] === 'all' and $_SESSION['genre'] == 'all') { // récupère les produit
            $requete = 'SELECT produit.*  from produit 
        inner join categorie on produit.idCategorie = categorie.id
        inner JOIN genre on produit.idGenre = genre.id
        where produit.Prix between ' . $pmin . ' and  ' . $pmax . '
        LIMIT
        ' . $limit . '
        OFFSET
        ' . $offset . '';
        }
        if ($_SESSION['genre'] != 'all' and $_SESSION['categorie'] != 'all') { // récupère les produit en fontion de la catégorie et du genre
            $requete = 'SELECT produit.* from produit 
        inner join categorie on produit.idCategorie = categorie.id
        inner JOIN genre on produit.idGenre = genre.id
        where genre.Genre = "' . $genrePOST . '" and categorie.Nom = "' . $categoriePOST . '" and produit.Prix between ' . $pmin . ' and  ' . $pmax . '
    LIMIT
    ' . $limit . '
    OFFSET
    ' . $offset . '';
        }
    } else { // si aucune de scondition n'est remplis récupère tout les prosuits
        $requete = 'SELECT produit.* from produit LIMIT
    ' . $limit . '
    OFFSET
    ' . $offset . '';
    }

    $getProducts = $dbh->prepare($requete);
    // $dbh->bindParam(':limit', $limit, PDO::PARAM_INT);
    // $dbh->bindParam(':offset', $offset, PDO::PARAM_INT);
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
            'categorie' => getProductCategorie($product['idCategorie']),
            'genre' => 'a faire',
            'avis' => getProductAvis($product['id']),
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }
    return $productsList;
}

// Create Product
function createProduct($product)
{
    global $dbh;
    // Insert in product table
    $productReq  = "INSERT INTO produit
                    (Nom, Description, Marque, Prix, Couleur, Specification, idCategorie, idGenre)
                    VALUE ('$product->nom', '$product->description', '$product->marque', $product->prix, '$product->couleur', '$product->specification', $product->categorie, $product->genre)
                    ";
    $productInsert = $dbh->prepare($productReq);
    $productInsert->execute();

    $productId = $dbh->lastInsertId();
    // Insert in tailleProduit table
    $tailleReq = "";
    foreach ($product->taille as $taille) {
        $tailleReq .= "INSERT INTO tailleproduit
                        (idProduit, idTaille)
                        VALUE ($productId, $taille);\n";
    }

    $tailleInsert = $dbh->prepare($tailleReq);
    $tailleInsert->execute();

    if ($productInsert && $tailleInsert) {
        return array(
            'success' => true,
            'id' => $productId
        );
    } else {
        return array(
            'success' => false
        );
    }
}

function createProductImage($id, $images)
{
    global $dbh;
    $targetDir = "../img/products_img/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $fileNames = array_filter($images['name']);

    if (!empty($fileNames)) {
        foreach ($images['name'] as $key => $val) {
            $fileName = basename($images['name'][$key]);
            // Save IMG in product_file folder
            $newName = $id . "__" . $fileName;
            $targetFilePath = $targetDir . $newName;

            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($fileType, $allowTypes)) {
                move_uploaded_file($images["tmp_name"][$key], $targetFilePath);
            }

            // Add image in table image
            $addImgReq  = "INSERT INTO image (Nom, URL) VALUE ('" . $images["alt"][$key] . "', 'img/products_img/$newName');";
            $insertImg  = $dbh->prepare($addImgReq);

            if ($insertImg->execute()) {
                $imageId = $dbh->lastInsertId('image');

                // Add image in table imageproduit
                $addImgProdReq  = "INSERT INTO imageproduit (idProduit, idImage)
                                VALUE ($id, $imageId);\n";
                $insertImgProd  = $dbh->prepare($addImgProdReq);
                $insertImgProd->execute();
                if ($insertImgProd) {
                    $status = array(
                        'success' => true,
                        'msg'  => "Files are uploaded successfully."
                    );
                } else {
                    $status = array(
                        'success' => false,
                        'msg'  => "Sorry, there was an error uploading your file in imageproduit table."
                    );
                }
            } else {
                $status = array(
                    'success' => false,
                    'msg'  => "Sorry, there was an error uploading your file in image table."
                );
            }
        }
    }

    return $status;
}

// Edit Product
function updateProduct($product)
{
    global $dbh;
    // Update product in product table
    $productReq = "UPDATE produit SET 
                  Nom = '$product->nom', Description = '$product->description', Marque = '$product->marque', Prix = $product->prix, Couleur = '$product->couleur', Specification = '$product->specification', idCategorie = $product->categorie, idGenre = $product->genre
                  WHERE id = $product->id
                ";

    $productUpd = $dbh->prepare($productReq);
    $productUpd->execute();

    // Update product size in tailleProduit table
    $tailleReq = "";
    foreach ($product->taille as $taille) {
        if ($taille->checked) {
            if ($taille->id) {
                $tailleReq .= "UPDATE tailleproduit SET
                        idProduit = $product->id, idTaille = $taille->idTaille
                        WHERE id = $taille->id;\n";
            } else {
                $tailleReq .= "INSERT INTO tailleproduit
                                (idProduit, idTaille)
                                VALUE ($product->id, $taille->idTaille);\n";
            }
        } else {
            $tailleReq .= "DELETE FROM tailleproduit
                            WHERE id = $taille->id;\n";
        }
    }

    $tailleInsert = $dbh->prepare($tailleReq);
    $tailleInsert->execute();

    if ($productUpd && $tailleInsert) {
        return array(
            'success' => true
        );
    } else {
        return array(
            'success' => false
        );
    }
}

function updateProductImage($idProduit, $images)
{
    global $dbh;

    foreach ($images as $img) {
        $file = "../" . $img['url'];
        $reqEdit = "";
        switch ($img['action']) {
            case 0: // Delete IMG
                if (file_exists($file) && !empty($img['url'])) {
                    unlink($file);
                    $req = "DELETE FROM `imageproduit` WHERE idProduit = $idProduit and idImage = " . $img['idImage'] . ";
                        DELETE FROM image WHERE id = " . $img['idImage'] . ";";
                    $dbh->query($req);
                }
                break;
            case 1: // Update Image name
                $reqEdit .= "UPDATE image SET Nom = '" . $img['alt'] . "' WHERE id = " . $img['idImage'] . ";";
                $dbh->query($reqEdit);
                break;
            case 2: // Edit IMG
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                $targetDir = "img/products_img/";
                $fileName = basename($img['url']);
                // Save IMG in product_file folder
                $targetFilePath = $targetDir . $fileName;
                $reqEdit .= "UPDATE image SET URL = '" . $targetFilePath . "', Nom = '" . $img['alt'] . "' WHERE id = " . $img['idImage'] . ";
                        UPDATE imageproduit SET idImage = " . $img['idImage'] . " WHERE id = " . $img['idImgProd'];
                $dbh->query($reqEdit);
                if (file_exists($file)) {
                    unlink($file);

                    $targetFilePath = '../' . $targetDir . $fileName;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        move_uploaded_file($img["tmp_name"], $targetFilePath);
                    }
                }
                break;
            case 3: // Add IMG
                $imgs = array(
                    "name" => array($img['url']),
                    "tmp_name" => array($img['tmp_name']),
                    "alt" => array($img['alt'])
                );
                createProductImage($idProduit, $imgs);
                break;
        }
    }
}

// Delete Product
function deleteProduct($id)
{
    global $dbh;
    $product = getProduct($id);

    // Delete image in folder
    $req = '';
    if ($product) {
        // Vérifie si il y'a des produits
        if ($product['avis']['note'] === 0) {
            $req .= "DELETE FROM `avis` WHERE idProduit = $id;";
        }

        // Vérifie si il y'a des produit dans le panier et supprimer les produits dans les paniers

        // Supprimer les images du dossier products_img
        foreach ($product['images'] as $image) {
            unlink("../" . $image['url']);
            $req .= "DELETE FROM `imageproduit` WHERE idProduit = $id;
                     DELETE FROM image WHERE id = " . $image['id'] . ";";
        }

        $req .= "DELETE FROM `tailleproduit` WHERE idProduit = $id;
            DELETE FROM `produit` WHERE id = $id;";
        $productDel = $dbh->query($req);

        if ($productDel) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/*
        END PRODUCT
*/

/*
        PANIER
*/

function createCart($panier)
{

    /*Verifier si produit existe déjà*/
    global $dbh;

    $delete = "DELETE FROM panier WHERE idUser = " . $panier['idUser'] . " AND idProduit = " . $panier['idProduit'] . " AND Taille = '" . $panier['taille'][0] . "'";
    $getDel = $dbh->prepare($delete);
    $getDel->execute();
    $requete = "INSERT INTO panier (Taille, Quantite, idUser, idProduit)
    VALUES (" . $panier['taille'] . ", " . $panier['quantite'] . ", " . $panier['idUser'] . ", " . $panier['idProduit'] . ")";
    $getCart = $dbh->prepare($requete);
    $getCart->execute();

    if ($getCart) {
        return $getCart;
    } else {
        return false;
    }

    return false;
}

function getAllProductsCart($id)
{
    global $dbh;
    $productsList = [];
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

/*
        END PANIER
*/

/*
        USER
*/

// Get User Connected
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
                "pays" => $unuser['idPays'],
                "admin" => $unuser['admin']
            );
        }
    }
    return $leUser;
}

// Get User by id
function getUser($id)
{
    global $dbh;
    $user = [];
    $requete = "SELECT * FROM users WHERE id=$id ";
    $getUsers = $dbh->prepare($requete);
    $getUsers->execute();
    $user = $getUsers->fetch();

    if ($getUsers->rowCount() > 0) {
        $user = array(
            "id" => $user['id'],
            "nom" => isEmpty($user['Nom']),
            "prenom" => isEmpty($user['Prenom']),
            "email" => isEmpty($user['Email']),
            "password" => isEmpty($user['Mdp']),
            "tel" => isEmpty($user['Telephone']),
            "adresse" => isEmpty($user['Adresse']),
            "comp_adr" => isEmpty($user['Complementadresse']),
            "cp" => isEmpty($user['Codepostal']),
            "ville" => isEmpty($user['Ville']),
            "pays" => $user['idPays'],
            "avis" => getUserAvis($user['id']),
            "admin" => $user['admin']
        );
    }

    return $user;
}

function getAllUsers()
{
    global $dbh;
    $usersList = [];
    $requete = "SELECT * FROM users ";
    $getUsers = $dbh->prepare($requete);
    $getUsers->execute();
    $users = $getUsers->fetchAll();

    foreach ($users as $user) {
        $usersList[] = array(
            "id" => $user['id'],
            "nom" => $user['Nom'],
            "prenom" => $user['Prenom'],
            "email" => $user['Email'],
            "password" => $user['Mdp'],
            "tel" => $user['Telephone'],
            "adresse" => $user['Adresse'],
            "cp" => $user['Codepostal'],
            "ville" => $user['Ville'],
            "pays" => $user['idPays'],
            "avis" => getUserAvis($user['id']),
            "admin" => $user['admin']
        );
    }

    return $usersList;
}

// Inscript 
function addUser(){

    global $dbh;
    // Permet de faire le message d'erreur.
    /* Verifie si le formulaire est rempli */
    if((!empty($_POST['Nom'])) AND (!empty($_POST['email'])) AND (!empty($_POST['password'])) AND (!empty($_POST['repeatpassword'])) AND (($_POST['password']) == ($_POST['repeatpassword']))) {

        /*Verifie si le pseudo est deja inscrit */
        $email = $_POST['email'];
        $reponse = $dbh->prepare('SELECT Email FROM users WHERE Email = "'.$email.'"'); 
        $reponse->execute();
        $count = $reponse->fetchColumn(); 
        if($count == 1) 
        { 
            // Pseudo déjà utilisé 
            echo '<div class="inscription-erreur"> <p>Cet email est déja utilisé !<p></div>';
        } 
        else 
        { 
    
            // Ajoute l'inscrit
            $ajou = $dbh->prepare('INSERT INTO users (`id`, `Nom`, `Prenom`, `Telephone`, `Email`, `Mdp`, `Adresse`, `Complementadresse`, `Codepostal`, `Ville`, `admin`, `idPays`) VALUES(NULL,"'.$_POST['Nom'].'","'.$_POST['Prenom'].'","","'.$_POST['email'].'","'.$_POST['password'].'","", "",NULL,"","0",NULL)');
            $ajou->execute();
            echo '<div class="inscription-terminee"> <p>Félicitation vous êtes inscrit !<p></div>';
        }
    }
}

// Back Office
function CreateUser($user)
{
    global $dbh;

    if (UserExist($user->email)) return array('success' => false, 'message' => 'Email already use.');

    $userAddReq = "INSERT INTO users
                  (`Nom`, `Prenom`, `Telephone`, `Email`, `Mdp`, `Adresse`, `Complementadresse`, `Codepostal`, `Ville`, `admin`, `idPays`)
                  VALUE('$user->nom', '$user->prenom', '$user->phone', '$user->email', '$user->password', $user->adresse, $user->complement_adresse, $user->cp, $user->ville, $user->admin, $user->pays) ";

    $userInsert = $dbh->prepare($userAddReq);
    $userInsert->execute();

    if ($userInsert) {
        return array('success' => true);
    }

    return array('success' => false, 'message' => '');
}

function EditUser($user)
{
    global $dbh;
    $userEditReq = "UPDATE users SET
                    `Nom` = '$user->nom', `Prenom` = '$user->prenom', `Telephone` = '$user->phone', `Email` = '$user->email', 
                    `Mdp` = '$user->password', `Adresse` = $user->adresse, `Complementadresse` = $user->complement_adresse, 
                    `Codepostal` = $user->cp, `Ville` = $user->ville, `admin` = '$user->admin', `idPays` = '$user->pays'
                   WHERE id = $user->id;";

    $userEdit = $dbh->prepare($userEditReq);
    $userEdit->execute();

    if ($userEdit) {
        return array('success' => true);
    }

    return array('success' => false, 'message' => '');
}

function DeleteUser($userId)
{
    global $dbh;
    $user = getUser($userId);

    if (!$user) return false;
    if (!empty($user['avis'])) return false;

    $req = "DELETE FROM users WHERE id=$userId";
    $userDel = $dbh->query($req);

    if ($userDel) {
        return true;
    }

    return false;
}

function UserExist($email)
{
    global $dbh;
    $reponse = $dbh->prepare('SELECT Email FROM users WHERE Email = "' . $email . '"');
    $reponse->execute();
    $count = $reponse->fetchColumn();
    return ($count == 1);
}

function getPays()
{
    global $dbh;
    $requete = "SELECT * FROM pays";
    $getPays = $dbh->prepare($requete);
    $getPays->execute();
    $pays = $getPays->fetchAll();
    foreach ($pays as $pay) {
        $paysList[$pay['id']] = $pay['Nom'];
    }

    return $paysList;
}

function getPaysName($id)
{
    global $dbh;
    $requete = "SELECT Nom FROM pays WHERE id = $id";
    $getPays = $dbh->prepare($requete);
    $getPays->execute();
    $pays = $getPays->fetch();
    if (!empty($pays)) {
        return $pays['Nom'];
    } else {
        return false;
    }
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

function updateUser($user) // A remplacer par Edit User
{
    global $dbh;
    $requete = "UPDATE users
                SET  Nom= '" . $user['nom'] . "', Prenom= '" . $user['prenom'] . "', Telephone= '" . $user['telephone'] . "', Email= '" . $user['email'] . "', Adresse= '" . $user['adresse'] . "', Complementadresse= '" . $user['complementadresse'] . "', Codepostal=" . $user['cp'] . ", Ville= '" . $user['ville'] . "', idPays=" . $user['pays'] . "
                WHERE id = " . $user['idUser'] . "";
    $getCat = $dbh->prepare($requete);
    $getCat->execute();
    if ($getCat) {
        return true;
    } else {
        return false;
    }

    return false;
}

/*
        END USER
*/

/*
        CONTACT
*/
function getContactList()
{
    global $dbh;
    $contactList = [];
    $requete = "SELECT * FROM contact ";
    $getContact = $dbh->prepare($requete);
    $getContact->execute();
    $contacts = $getContact->fetchAll();

    foreach ($contacts as $contact) {
        $contactList[] = array(
            "id" => $contact['id'],
            "nom" => $contact['nom'],
            "email" => $contact['email'],
            "sujet" => $contact['sujet'],
            "message" => $contact['message'],
            "date" => $contact['date'],
        );
    }

    return $contactList;
}

function getContactMessage($id)
{
    global $dbh;
    $contactMsg = array();
    $requete = "SELECT * FROM produit WHERE id = $id";
    $getMsg = $dbh->prepare($requete);
    $getMsg->execute();
    $contactMsg = $getMsg->fetch();

    if ($getMsg->rowCount() > 0) {
        $contactMsg = array(
            'id' => $id,
            'nom' => $contactMsg['nom'],
            'email' => $contactMsg['email'],
            'sujet' => $contactMsg['sujet'],
            'message' => $contactMsg['message'],
        );

        return $contactMsg;
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

function DeleteContact($id)
{
    global $dbh;

    if (getContactMessage($id)) {
        $req = "DELETE FROM `contact` WHERE id=$id";
        $messDel = $dbh->query($req);

        if ($messDel) {
            return array("success" => true, "message" => '');
        }
    }

    return array("success" => false, "message" => '');
}

/*
        CONNEXION
*/

function connexion()
{
    global $dbh;


    if (isset($_POST['username']) && isset($_POST['password'])) {

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS
        $username = $_POST['username'];
        $password = $_POST['password'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];


        if ($username !== "" && $password !== "") {
            $requete = "SELECT count(*) FROM users where 
              Email = '" . $username . "' and Mdp = '" . $password . "' ";
            $exec_requete = $dbh->prepare($requete);
            $exec_requete->execute();
            $count = $exec_requete->fetchColumn();

            $usernamesess = $_SESSION['username'];
            $passwordsess = $_SESSION['password'];

            $getusers = $dbh->prepare("SELECT * FROM users WHERE Email = '" . $usernamesess . "' and Mdp = '" . $passwordsess . "' ");
            $getusers->execute();
            $row_user = $getusers->fetchAll();

            if ($count != 0) // nom d'utilisateur et mot de passe correctes
            {
                foreach ($row_user as $unuser) {
                    if ($_SESSION['username'] !== "") {

                        echo "Bonjour " . $unuser['Prenom'] . " " . $unuser['Nom'] . " , vous êtes connecté";
                        // header('location:profil.php');
                        // exit();
                        echo '<meta http-equiv="refresh" content="0;url=profil.php">';
                    }
                }
            } else {
                echo 'votre mot de passe ou votre identifiant est incorrect';
            }
        } elseif ($_SESSION['username'] != "") {
            echo "Vous etes deja connecté avec l'identifiant" . $_SESSION['username'] . ".";
        } else {
            echo 'il faut remplir les champs !!!';
        }
    } else {
    }
    if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
        echo "<div class='deconnexion'><a href='connexion.php?deconnexion=true'><span>Déconnexion</span></a></div>";
    }


    // if (isset($_GET['deconnexion'])) {
    //     if ($_GET['deconnexion'] == true) {
    //         session_unset();
    //     }
    // }
}

function changePassword()
{
    global $dbh;
    $row_user = getUnUser();
    foreach ($row_user as $Unuser) {

        if (isset($_POST['password']) && isset($_POST['confirmpassword'])) {
            if ($_POST['password'] == "" || $_POST['confirmpassword'] == "") {
                echo 'VEUILLEZ REMPLIR LES CHAMPS';
            } elseif ($_POST['password'] == $Unuser['password'] || $_POST['confirmpassword'] == $Unuser['password']) {

                echo 'Votre mot de passe est similaire au précédent';
            } elseif ($_POST['password'] != $Unuser['password'] || $_POST['confirmpassword'] != $Unuser['password']) {

                if ($_POST['password'] == $_POST['confirmpassword']) {

                    $requete = 'UPDATE users SET `Mdp`= "' . $_POST['password'] . '" WHERE Email = "' . $_SESSION['username'] . '"';
                    $changepassword = $dbh->prepare($requete);
                    $changepassword->execute();
                    echo 'Votre mot de passe à été modifier';
                }
            } else {
                echo 'Vous ne savez pas écrire incapable.';
            }
        }
    }
}

function deconnexion(){
    session_unset();
    echo '<meta http-equiv="refresh" content="0;url=connexion.php">';
}
/*
        FUNCTION
*/
function isEmpty($val)
{
    return (empty($val)) ? '' : $val;
}

function formatDate($date, $format)
{
    $date = new DateTime($date);
    $dateFormat = $date->format($format);

    return $dateFormat;
}