<?php
include 'headerAdmin.php';
?>

<main id="editSize" class="container">
    <h2>Edit Size</h2>
    <hr>
    <a class="back-button" href="sizes.php">Back</a>

    <?php 
        if (isset($_POST) && !empty($_POST)){
            $editedSize = editSize($_GET['size_id'], $_POST['input-name']);

            if($editedSize) : ?>
                <div class="alert alert-success" role="alert">
                    The size has been edited!
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Error while edit the size..
                </div>
            <?php endif; 
        }
    ?>

    <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
        <!-- Input name -->
        <div class="col-md-12">
            <label for="input-name" class="form-label">Name</label>
            <input type="text" class="form-control" name="input-name" id="input-name" value="<?php echo getTailleName($_GET['size_id']); ?>" required>
            <div class="invalid-feedback">
                Please choose a name.
            </div>
        </div>

        <div class="col-12">
            <button class="btn" type="submit">Edit Size</button>
        </div>
    </form>
</main>
<?php

include 'footerAdmin.php';
