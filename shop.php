<!-- HEADER  -->
<?php
include 'header.php';
?>
<!-- -------- -->


<main id="shop">
    <?php
    
    if (isset($_POST['genre'])){
        $_SESSION["genre"]= $_POST['genre'];
    }
    if (isset($_POST['categorie'])){
        $_SESSION["categorie"]= $_POST['categorie'];
    }
    if (isset($_POST['pmax'])){
        $_SESSION["pmax"]= $_POST['pmax'];
    }
    if (isset( $_POST['pmin'])){
        $_SESSION["pmin"]= $_POST['pmin'];
    }
?>

<script src="js/double_curseur.js"></script>


    <section id="recherche_produit" class="container">
        <div class="row">

            <div class="recherche col-lg-3 col-md-3 col-sm-12">



                <form method="post" action="shop.php">
                    <ul uk-accordion="multiple: true">
                        <li>
                            <h4 class="uk-accordion-title">GENRE</h4>
                            <div class="uk-accordion-content">
                                <select id="genre" name="genre">
                                    <option value="all">ALL</option>
                                    <?php 
                                $row = getGenre();
                            foreach ($row as $genre ){ ?>
                                    <option value="<?php echo $genre; ?>"><?php echo $genre; ?> </option>

                                    <?php  } ?>
                                </select>
                            </div>
                        </li>
                        <li class="prix">
                            <h4 class="uk-accordion-title">PRIX</h4>
                            <div class="uk-accordion-content">
                                <div id="doubleRange" class="doubleRange">
                                    <div class="barre">
                                        <div class="barreMilieu" style="width:50%; left:25%;"></div>
                                        <div class="t1 thumb" style="left:25%"></div>
                                        <div class="t2 thumb" style="left:75%;"></div>
                                    </div>
                                    <div class="label">de <span class="labelMin"></span> à <span
                                            class="labelMax"></span>
                                    </div>
                                    <input type="hidden" name="pmin" value="" class="inputMin" />
                                    <input type="hidden" name="pmax" value="" class="inputMax" />
                                </div>

                                <script type="text/javascript">
                                    setDoubleRange({
                                        element: '#doubleRange',
                                        minValue: 0,
                                        maxValue: 900,
                                        maxInfinite: false,
                                        stepValue: 10,
                                        defaultMinValue: 0,
                                        defaultMaxValue: 900,
                                        unite: '€'
                                    });
                                </script>
                            </div>
                        </li>
                        <li>
                            <h4 class="uk-accordion-title">CATEGORIE</h4>
                            <div class="uk-accordion-content">
                                <select id="categorie" name="categorie">
                                    <option value="all">ALL</option>
                                    <?php $row = getAllCategories();
                                
                            foreach ($row as $categorie ){ ?>
                                    <option value="<?php echo $categorie['nom']; ?>"><?php echo $categorie['nom']; ?>
                                    </option>
                                    <?php  } ?>
                                </select>


                            </div>
                        </li>

                    </ul>
                    <div class="btn-submit">
                        <input type="submit" value="Filtrer">
                    </div>
                    <div class="btn-submit">
                    <input type="submit" value="Tout voir" name="reset">
                    <?php if (isset($_POST['reset'])) {
                        unset ($_SESSION["genre"]);
                        unset ($_SESSION["categorie"]);
                        unset ($_SESSION["pmin"]);
                        unset ($_SESSION["pmax"]);
                    } ?>
                    </div>
                </form>

            </div>


            <div class="affichage col-lg-9 col-md-9 col-sm-12">
                

                <?php

                                $rowFiltre = getAllProductsByFiltre();
                                
                                foreach ($rowFiltre as $unproduit ){ ?>
                <div class="card_container"
                    onclick="window.location='singleshop.php?idProduit=<?php echo $unproduit['id']; ?>'">
                    <div class="card">
                        <!-- IMAGE DU PRODUIT  -->
                        <?php ?>
                        <div class="img-card-hover">
                            <img class="card-img-top" src="<?php echo $unproduit['images'][0]['url'];?>"
                                alt="<?php echo $unproduit['images'][0]['nom'];?>">
                            <div class="card_hover">
                                <div class="icon_hover">
                                    <a href="">
                                        <i class="far fa-heart"></i>
                                    </a>
                                </div>
                                <div class="icon_hover">
                                    <a href="singleshop.php?idProduit=<?php echo $unproduit['id']; ?>">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <!-- FIN IMAGE DU PRODUIT  -->

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $unproduit['nom']; ?> </h5>


                            <!-- TAILLE PRODUIT  -->
                            <?php 
                    $res_taille= $dbh->prepare("SELECT * FROM produittaille where idProduit =".$unproduit['id']);
                                
                             $res_taille->execute();
                            $row_tailles =  $res_taille->fetchAll();?>
                            <ul class="taille_produit">
                                <?php foreach ($row_tailles as $unetailleproduit) {?>
                                <li class="une_taille_produit"><?php echo $unetailleproduit['libelle']; ?> /</li>
                                <?php }?>
                            </ul>
                            <!-- FIN TAILLE PRODUIT  -->

                            <!-- AVIS PRODUIT  -->
                            <p class="stars"><?php echo getNumberAvis($unproduit['id']); ?></p>

                            <!-- FIN AVIS PRODUIT  -->

                            <p class="card-text">$<?php echo $unproduit['prix']; ?></p>
                        </div>

                    </div>

                </div>

                <?php  } ?>
               
            </div>
            <div class="container_pagination">

            
            <?php
             // Affichage de la pagination
             for ($i=0 ; $i < $pages ; $i++){
                $y = $i + 1  ;
                if (isset($_GET['page'])){
                        if ( $_GET['page']== $page and $page == $y){
                            echo '<a id="'.$y.'" href="/TP_zayshop/Zayshop/shop.php?page='.($y). '"><div class="pagination active">'.($y).'</div></a>' ;
                        }
                        else{
                            echo '<a id="'.$y.'" class=" " href="/TP_zayshop/Zayshop/shop.php?page='.($y). '"><div class="pagination">'.($y).'</div></a>' ;

                        }
                }
                else{
                    if ($i ==0){
                        echo '<a id="'.$y.'" href="/TP_zayshop/Zayshop/shop.php?page='.($y). '"><div class="pagination active">'.($y).'</div></a>' ;

                    }
                    else{
                        echo '<a id="'.$y.'" class=" " href="/TP_zayshop/Zayshop/shop.php?page='.($y). '"><div class="pagination">'.($y).'</div></a>' ;

                    }
                }   
            }

             ?>
             </div>


        </div>


    </section>
    <section id="ourbrands">
        <div>
            <h2>Our Brands</h2>
        </div>
        <div class="container-texte">
            <p>Reprehenderit in volupdate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
        </div>
        <div class="container-slider">

        
        <div uk-slider>

<div class="uk-position-relative">

    <div class="uk-slider-container uk-light">
        <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-4@l">
            <li>
                <img src="./img/brand_01.png" alt="">
            </li>
            <li>
                <img src="./img/brand_02.png" alt="">
            </li>
            <li>
                <img src="./img/brand_03.png" alt="">
            </li>
            <li>
                <img src="./img/brand_04.png" alt="">
            </li>
            <li>
                <img src="./img/brand_01.png" alt="">
            </li>
            <li>
                <img src="./img/brand_02.png" alt="">
            </li>
            <li>
                <img src="./img/brand_03.png" alt="">
            </li>
            <li>
                <img src="./img/brand_04.png" alt="">
            </li>
        </ul>
    </div>

    <div class="uk-hidden@s uk-light">
        <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
    </div>

    <div class="uk-visible@s">
        <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
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