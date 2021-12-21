<?php 

include './bdd.php';

function getAllProducts()
{
    global $dbh;
    $productsList = [];
    $requete = "SELECT * FROM produit";
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
            'categorie' => 'a faire',
            'genre' => 'a faire',
            'avis' => getProductAvis($product['id']),
            'taille' => getProductTaille($product['id']),
            'images' => getProductImage($product['id'])
        );
    }
    return $productsList;
}
function getProduct()
{
    global $dbh;
    $requete = "SELECT * FROM produit WHERE id = $id";
    $getProduct = $dbh->prepare($requete);
    $getProduct->execute();
    $product = array(
        'id' => $id,
        'nom' => $getProduct['Nom'],
        'description' => $getProduct['Description'],
        'marque' => $getProduct['Marque'],
        'prix' => $getProduct['Prix'],
        'couleur' => $getProduct['Couleur'],
        'specification' => $getProduct['Specification'],
        'avis' => getProductAvis($getProduct['id']),
        'taille' => getProductTaille($getProduct['id']),
        'images' => getProductImage($getProduct['id'])
    );
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
        'note' => $avis['Note'],
        'nb_com' => $avis['Nb-commentaire']
    );
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
function getNumberAvis($id){
    $elm        = '<i class="fa fa-star"></i>';
    $elmGold    = '<i class="fa fa-star gold"></i>';
    $avis       = getProductAvis($id)['note'];
    $avisElm    = '';
    for ($i = 1; $i <= $avis; $i++) {
        $avisElm .= $elmGold;
    }
    for ($i = 1; $i <= 5 - $avis; $i++){
        $avisElm .= $elm;
    }
    return $avisElm;
}
function getProductCategorie($id)
{
    global $dbh;
    $requete = "SELECT Nom FROM categorie WHERE id = $id";
    $getCategorie = $dbh->prepare($requete);
    $getCategorie->execute();
    $categorie = $getCategorie->fetch();
    return $categorie;
}

function getAllProductsByFiltre(){ // recupère tout les produits de la table produit en fonction des filtre (genre , prix , catégorie) et créé une pagination en fonction du nombre de resultat
        global $dbh;
        $productsList = [];
        // Combien de resultat nous voulons par page
        $limit = 9;
        
    if (isset($_SESSION['genre']) || isset($_SESSION['categorie'])){ // si le $_POST de genre et de cat"gorie existe (SESSION sert a garder les resultat du $_post tant que la page n'est pas fermée)
                                                                     // ici la SESSION nous sert a garde les informations des filtres quand nous changeons de page de produit.
            $genrePOST= $_SESSION['genre'];
            $categoriePOST = $_SESSION['categorie'];
            $pmax = $_SESSION['pmax'];
            $pmin = $_SESSION['pmin'];

                if ($_SESSION['genre'] == 'all' and $_SESSION['categorie'] != 'all'  ){ // compte les lignes de produits en fonction de la catégorie
                    $total= 'SELECT COUNT(*) from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where categorie.Nom = "'.$categoriePOST.'" and produit.Prix between '.$pmin.' and  '.$pmax.'';
    
                }
                if ($_SESSION['categorie'] === 'all'  and $_SESSION['genre'] != 'all' ){ // compte les lignes de produits en fonction du genre
                    $total= 'SELECT COUNT(*) from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where genre.Genre = "'.$genrePOST.'" and produit.Prix between '.$pmin.' and  '.$pmax.'';
                }
                if ($_SESSION['categorie'] == 'all' and $_SESSION['genre'] == 'all'){ // compte toute les lignes de produit  
                    $total='SELECT COUNT(*)  from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where produit.Prix between '.$pmin.' and  '.$pmax.'';
                }
                if   ($_SESSION['genre'] !='all' and $_SESSION['categorie'] != 'all'  ){ // compte les lignes de produits en fonction du genre et de la catégorie
                    $total= 'SELECT COUNT(*) from produit 
                    inner join categorie on produit.idCategorie = categorie.id
                    inner JOIN genre on produit.idGenre = genre.id
                    where genre.Genre = "'.$genrePOST.'" and categorie.Nom = "'.$categoriePOST.'" and produit.Prix between '.$pmin.' and  '.$pmax.'' ;
                }
    }
    else { // si aucune des condition est remplis , compte toute les lignes produits
        
        $total = '
                                 SELECT
                                 COUNT(*)
                                FROM
                                produit
                            '
                            ;
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
        global $page ;
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
        'default'   => 1,
        'min_range' => 1,
                        ),
        )));
        // calcul le offset 
        $offset = ($page - 1)  * $limit;



    if (isset($_SESSION['genre']) || isset($_SESSION['categorie'])){ // si nous avons des $_SESSION ($_POST sauvegarder) 
        $genrePOST=  $_SESSION['genre'];
        $categoriePOST = $_SESSION['categorie'];
        $pmax = $_SESSION['pmax'];
        $pmin = $_SESSION['pmin'];

        // filtre
        if ($_SESSION['genre'] ==='all' and $_SESSION['categorie'] != 'all'  ){ // récupère les produit en fontion de la catégorie
            $requete= 'SELECT produit.* from produit 
            inner join categorie on produit.idCategorie = categorie.id
            inner JOIN genre on produit.idGenre = genre.id
            where categorie.Nom = "'.$categoriePOST.'" and produit.Prix between '.$pmin.' and  '.$pmax.'
        LIMIT
        '.$limit.'
        OFFSET
        '.$offset .'';
        }
        if ($_SESSION['categorie'] === 'all'  and $_SESSION['genre'] != 'all' ){ // récupère les produit en fontion du genre
            $requete= 'SELECT produit.* from produit 
            inner join categorie on produit.idCategorie = categorie.id
            inner JOIN genre on produit.idGenre = genre.id
            where genre.Genre = "'.$genrePOST.'" and produit.Prix between '.$pmin.' and  '.$pmax.'
            LIMIT
            '.$limit.'
            OFFSET
            '.$offset .'';   
        }
        if ($_SESSION['categorie'] === 'all' and $_SESSION['genre'] == 'all'){ // récupère les produit
            $requete= 'SELECT produit.*  from produit 
            inner join categorie on produit.idCategorie = categorie.id
            inner JOIN genre on produit.idGenre = genre.id
            where produit.Prix between '.$pmin.' and  '.$pmax.'
            LIMIT
            '.$limit.'
            OFFSET
            '.$offset .'';       
        }
        if   ($_SESSION['genre'] !='all' and $_SESSION['categorie'] != 'all'  ){ // récupère les produit en fontion de la catégorie et du genre
            $requete = 'SELECT produit.* from produit 
            inner join categorie on produit.idCategorie = categorie.id
            inner JOIN genre on produit.idGenre = genre.id
            where genre.Genre = "'.$genrePOST.'" and categorie.Nom = "'.$categoriePOST.'" and produit.Prix between '.$pmin.' and  '.$pmax.'
        LIMIT
        '.$limit.'
        OFFSET
        '.$offset .'';
        }
    }
    else { // si aucune de scondition n'est remplis récupère tout les prosuits
        $requete = 'SELECT produit.* from produit LIMIT
        '.$limit.'
        OFFSET
        '.$offset .'' ;
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

function getAllCategories(){
    global $dbh;
    $categorieList = [];
    $requete = "SELECT * FROM categorie";
    $getCategories = $dbh->prepare($requete);
    $getCategories->execute();
    $categories = $getCategories->fetchAll();
    foreach ($categories as $categorie) {
    $categorieList [] = array(
        "id" => $categorie['id'],
        "nom" => $categorie['Nom']

    );
}
return  $categorieList ;
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
    var_dump($genreList);
    return $genreList;
}


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

function connexion(){
    global $dbh;
    
        
    if(isset($_POST['username']) && isset($_POST['password']))
{
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    
    
    if($username !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM users where 
              Email = '".$username."' and Mdp = '".$password."' ";
        $exec_requete = $dbh->prepare($requete);
        $exec_requete->execute();
        $count = $exec_requete->fetchColumn();
        
        $usernamesess = $_SESSION['username'];
        $passwordsess = $_SESSION['password'];

        $getusers = $dbh->prepare("SELECT * FROM users WHERE Email = '".$usernamesess."' and Mdp = '".$passwordsess."' ");
        $getusers->execute();
        $row_user = $getusers->fetchAll();

        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
            foreach ($row_user as $unuser){
                if($_SESSION['username'] !== ""){

                    echo "Bonjour ".$unuser['Prenom']." ".$unuser['Nom']." , vous êtes connecté";
                }
                
            }
           
        }
        else
        {
           echo 'votre mot de passe ou votre identifiant est incorrect';
        }
    }
    elseif($_SESSION['username'] != ""){
        echo "Vous etes deja connecté avec l'identifiant".$_SESSION['username'].".";
    }
    else
    {
       echo 'il faut remplir les champs !!!';
    }
}
else{
}
if (isset($_SESSION['username']) && $_SESSION['username'] != ""){
    var_dump($_SESSION['username']);
        echo "<div class='deconnexion'><a href='connexion.php?deconnexion=true'><span>Déconnexion</span></a></div>";
}


if(isset($_GET['deconnexion']))
{ 
   if($_GET['deconnexion']==true)
   {  
      session_unset();
   }
}
}

function getUnUser(){
    global $dbh;
    $leUser =[];
    if (isset($_SESSION['username'])){
        $requete ='SELECT * FROM users WHERE Email = "'.$_SESSION['username'].'"';
        $getLeUser = $dbh->prepare($requete);
        $getLeUser->execute();
        $row_user = $getLeUser->fetchAll();
        foreach ($row_user as $unuser){
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

function changePassword(){
    global $dbh;
    $row_user =getUnUser();
    foreach($row_user as $Unuser){

        if (isset($_POST['password']) && isset($_POST['confirmpassword'])){
            if ($_POST['password']== "" || $_POST['confirmpassword']== ""){
            echo 'VEUILLEZ REMPLIR LES CHAMPS';
            }
            elseif($_POST['password'] == $Unuser['password'] || $_POST['confirmpassword'] == $Unuser['password'] ){

                echo 'Votre mot de passe est similaire au précédent';
            }
            elseif($_POST['password'] != $Unuser['password'] || $_POST['confirmpassword'] != $Unuser['password'] ){

                if ($_POST['password'] == $_POST['confirmpassword']){

                    $requete='UPDATE users SET `Mdp`= "'.$_POST['password'].'" WHERE Email = "'.$_SESSION['username'].'"';
                    $changepassword = $dbh->prepare($requete);
                    $changepassword->execute(); 
                    echo 'Votre mot de passe à été modifier' ;                            
                }
            }
            else{
                echo 'Vous ne savez pas écrire .';
            }
        }
    }
}

function getPays(){
    global $dbh;
    $requete = "SELECT * FROM pays";
    $getPays = $dbh->prepare($requete);
    $getPays->execute();
    $pays = $getPays->fetchAll();
    foreach ($pays as $pay) {
        $paysList[$pay['id']] = $pay['Nom'];
    }
    var_dump($paysList);
    return $paysList;

}

function getUserPay($id){
    global $dbh;
    $requete = "SELECT Nom FROM pays WHERE id = $id";
    $getPays = $dbh->prepare($requete);
    $getPays->execute();
    $pays = $getPays->fetch();
    return $pays[0];
}
?>