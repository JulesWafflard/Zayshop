<?php

include '../bdd.php';

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
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }

    return $product;
}

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

function getProductGenre($id)
{
    global $dbh;
    $requete = "SELECT Genre FROM genre WHERE id = $id";
    $getGenre = $dbh->prepare($requete);
    $getGenre->execute();
    $genre = $getGenre->fetch();

    return $genre['Genre'];
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

function getproductCategorie($id)
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

/*
        CREATE PRODUCT
*/

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


/*
        DELETE PRODUCT
*/

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
        EDIT PRODUCT
*/
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


/*
        USERS
*/


// Get User connected
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
                "cp" => $unuser['Codepostal'],
                "ville" => $unuser['Ville']
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

function EditUser($user){
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

function getPaysName($id){
    global $dbh;
    $requete = "SELECT Nom FROM pays WHERE id = $id";
    $getPays = $dbh->prepare($requete);
    $getPays->execute();
    $pays = $getPays->fetch();
    if(!empty($pays)){
        return $pays['Nom'];
    }else{
        return false;
    }
}

/*
        CONTACT
*/

function getContactList(){
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

function DeleteContact($id){
    global $dbh;

    if(getContactMessage($id)){
        $req = "DELETE FROM `contact` WHERE id=$id";
        $messDel = $dbh->query($req);

        if ($messDel) {
            return array("success" => true, "message" => '');
        }
    }
    
    return array("success" => false, "message" => '');
}

function isEmpty($val){
    return (empty($val)) ? '' : $val ;
}

function formatDate($date, $format){
    $date = new DateTime($date);
    $dateFormat = $date->format($format);

    return $dateFormat;
}