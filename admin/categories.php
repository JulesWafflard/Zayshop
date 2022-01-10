<?php
include 'headerAdmin.php';
?>

<main id="categoriesAdmin" class="container">
    <h2>Categories List</h2>
    <hr>

    <?php
        // Check if delete categories
        if(isset($_GET['delete']) && isset($_GET['category_id'])){
            $categoryDel = deleteCategory($_GET['category_id']);
            if($categoryDel['success']){
                ?>
                    <div class="alert alert-success" role="alert">
                        The category has been deleted!
                    </div>
                <?php
            }else{
                ?>
                <div class="alert alert-danger" role="alert">
                    Error while deleting the category<br>
                    <?php echo $categoryDel['message']; ?>
                </div>
                <?php
            }
        }
    ?>

    <div class="table-responsive table-list">
        <a href="addCategory.php" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Add category</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Product in category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $categories = getAllCategories(); 

                    forEach($categories as $cat){
                        echo "
                            <tr>
                                <td>".$cat['id']."</td>
                                <td>".$cat['nom']."</td>
                                <td>".getAllProductInCategorie($cat['id'])."</td>
                                <td>
                                    <a href='editCategory.php?category_id=".$cat['id']."'><i class='far fa-edit'></i></a>
                                    <a href='?delete&category_id=".$cat['id']."'><i class='far fa-trash-alt'></i></a>
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