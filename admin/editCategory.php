<?php
include 'headerAdmin.php';
?>

<main id="editCategory" class="container">
    <h2>Edit Category</h2>
    <hr>
    <a class="back-button" href="categories.php">Back</a>

    <?php 
        if (isset($_POST) && !empty($_POST)){
            $editedCategory = editCategory($_GET['category_id'], $_POST['input-name']);

            if($editedCategory) : ?>
                <div class="alert alert-success" role="alert">
                    The category has been edited!
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Error while edit the category..
                </div>
            <?php endif; 
        }
    ?>

    <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
        <!-- Input name -->
        <div class="col-md-12">
            <label for="input-name" class="form-label">Name</label>
            <input type="text" class="form-control" name="input-name" id="input-name" value="<?php echo getproductCategorie($_GET['category_id']); ?>" required>
            <div class="invalid-feedback">
                Please choose a name.
            </div>
        </div>

        <div class="col-12">
            <button class="btn" type="submit">Edit Category</button>
        </div>
    </form>
</main>
<?php

include 'footerAdmin.php';
