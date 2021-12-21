<?php
include 'headerAdmin.php';
?>

<main id="indexAdmin" class="container">
    <h2>Products List</h2>
    <hr>

    <?php
        // Check if delete product
        if(isset($_GET['delete']) && isset($_GET['product_id'])){
            $productDel = deleteProduct($_GET['product_id']);
            if($productDel){
                ?>
                    <div class="alert alert-success" role="alert">
                        The product has been deleted!
                    </div>
                <?php
            }else{
                ?>
                <div class="alert alert-danger" role="alert">
                    Error while deleting the product
                </div>
                <?php
            }
        }
    ?>

    <div class="table-responsive table-list">
        <a href="addProduct.php" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Add product</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Categories</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Avis</th>
                    <th scope="col">Review</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $products = getAllProducts(false); 

                    forEach($products as $product){
                        echo "
                            <tr>
                                <td>".$product['id']."</td>
                                <td>".$product['nom']."</td>
                                <td>".$product['prix']."</td>
                                <td>".$product['categorie']."</td>
                                <td>".$product['genre']."</td>
                                <td>".getNumberAvis($product['id'])."</td>
                                <td>".$product['avis']['nb_com']."</td>
                                <td>
                                    <a href='editProduct.php?product_id=".$product['id']."'><i class='far fa-edit'></i></a>
                                    <a href='?delete&product_id=".$product['id']."'><i class='far fa-trash-alt'></i></a>
                                </td>
                            </tr>
                            ";
                    }
                
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php
include 'footerAdmin.php';
?>