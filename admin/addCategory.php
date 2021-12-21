<?php
include 'headerAdmin.php';
?>

<main id="addCategory" class="container">
    <h2>Add Category</h2>
    <hr>
    <a class="back-button" href="categories.php">Back</a>

    <?php 
        if (isset($_POST) && !empty($_POST)){
            $createdCategory = createCategory($_POST['input-name']);

            if(!empty($createdCategory['id'])) : ?>
                <div class="alert alert-success" role="alert">
                    The category has been created!
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Error while creating the category..
                </div>
            <?php endif; 
        }
    ?>

    <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
        <!-- Input name -->
        <div class="col-md-12">
            <label for="input-name" class="form-label">Name</label>
            <input type="text" class="form-control" name="input-name" id="input-name" required>
            <div class="invalid-feedback">
                Please choose a name.
            </div>
        </div>

        <div class="col-12">
            <button class="btn" type="submit">Add Category</button>
        </div>
    </form>
</main>
<?php

include 'footerAdmin.php';
