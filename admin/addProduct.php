<?php
include 'headerAdmin.php';

?>
<main id="addProduct" class="container">
    <h2>Add Product</h2>
    <hr>
    <a class="back-button" href="index.php">Back</a>

    <?php
    // Check if form is submit, and if is create Product
        if (isset($_POST) && isset($_FILES['input-images'])) {
            $images = array_merge($_POST['input-images'], $_FILES['input-images']);
            $product = (object) array(
                'nom' => $_POST['input-name'],
                'description' => $_POST['input-description'],
                'marque' => $_POST['input-brand'],
                'prix' => $_POST['input-price'],
                'couleur' => $_POST['input-color'],
                'genre' => $_POST['input-genre'],
                'specification' => $_POST['input-specification'],
                'taille' => $_POST['input-size'],
                'categorie' => $_POST['input-categorie'],
                'images' => $images
            );

            $createdProduct = createProduct($product);
            createProductImage($createdProduct['id'], $product->images);
        ?>
        <?php if($createdProduct['success']) : ?>
            <div class="alert alert-success" role="alert">
                The product has been created!
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                Error while creating the product..
            </div>
        <?php endif; ?>
    <?php } ?>

    <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
        <!-- Input name -->
        <div class="col-md-12">
            <label for="input-name" class="form-label">Name</label>
            <input type="text" class="form-control" name="input-name" id="input-name" required>
            <div class="invalid-feedback">
                Please choose a name.
            </div>
        </div>

        <!-- Input description -->
        <div class="col-md-12">
            <label for="input-description" class="form-label">Description</label>
            <textarea class="form-control" name="input-description" id="input-description" rows="3" required></textarea>
            <div class="invalid-feedback">
                Please enter a description.
            </div>
        </div>

        <!-- Input brand -->
        <div class="col-md-3">
            <label for="input-brand" class="form-label">Marque</label>
            <input type="text" class="form-control" name="input-brand" id="input-brand" required>
            <div class="invalid-feedback">
                Please choose a brand.
            </div>
        </div>

        <!-- Input price -->
        <div class="form-outline col-md-3">
            <label for="input-price" class="form-label">Price</label>
            <input type="number" class="form-control" name="input-price" id="input-price" step=".01" required>
            <div class="invalid-feedback">
                Please choose a price.
            </div>
        </div>

        <!-- Input Color -->
        <div class="form-outline col-md-3">
            <label for="input-color" class="form-label">Color</label>
            <input type="text" class="form-control" name="input-color" id="input-color" required>
            <div class="invalid-feedback">
                Please choose a color.
            </div>
        </div>

        <!-- Input Genre -->
        <div class="form-outline col-md-3">
            <label for="input-genre" class="form-label">Genre</label><br>
            <select class="form-select" id="input-genre" name="input-genre" required>
                <?php foreach (getGenre() as $genreId => $genreName) : ?>
                    <option value="<?= $genreId; ?>"><?= $genreName; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Please select a genre.
            </div>
        </div>

        <!-- Input specification -->
        <div class="col-md-12">
            <label for="input-specification" class="form-label">Specification</label>
            <textarea class="form-control" name="input-specification" id="input-specification" rows="3" required></textarea>
            <div class="invalid-feedback">
                Please enter a specification.
            </div>
        </div>

        <!-- Input size -->
        <div class="col-md-6">

            <div class="form-group form-size">
                <label class="control-label col-md-4" for="size-text">Size</label>
                <div class="col-md-6">
                    <?php foreach (getTailles() as $tailleId => $tailleName) : ?>
                        <input type="checkbox" class="form-check-input" name="input-size[]" value="<?= $tailleId; ?>" required /> <?= $tailleName; ?><br>
                    <?php endforeach; ?>
                    <div class="invalid-feedback">Please choose a size</div>
                </div>
            </div>

        </div>

        <!-- Input categorie -->
        <div class="col-md-6">
            <label for="input-categorie" class="form-label">Categorie</label><br>
            <select class="form-select" id="input-categorie" name="input-categorie" required>
                <?php foreach (getAllCategories() as $cat) : ?>
                    <option value="<?= $cat['id']; ?>"><?= $cat['nom']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Please choose a categorie.
            </div>
        </div>

        <!-- Input image -->
        <div class="col-md-12 input-image">
            <div class="row" for="input-images">
                <div class="col-sm-2 imgUp">
                    <div class="imagePreview">
                        <input type="text" class="form-control" name="input-images[alt][]" placeholder="Image name"  required>
                    </div>
                    <label class="btn">
                        Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="input-images[]" required>
                    </label>
                </div><!-- col-2 -->
                <i class="fa fa-plus imgAdd"></i>
            </div><!-- row -->
            <div class="invalid-feedback">
                Please choose images.
            </div>
            

        </div>

        <div class="col-12">
            <button class="btn" type="submit">Add Product</button>
        </div>
    </form>
</main>

<script>
    // Add Images

    $(".imgAdd").click(function() {
        $(this).closest(".row").find('.imgAdd').before(
            
            `<div class="col-sm-2 imgUp">
                <div class="imagePreview">
                    <input type="text" class="form-control" name="input-images[alt][]" placeholder="Image name"  required>
                </div>
                <label class="btn">
                    Upload
                    <input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;" name="input-images[]" required>
                </label>
                <i class="fa fa-times del"></i>
            </div>
            `
        )
    });

    $(document).on("click", "i.del", function() {
        $(this).parent().remove();
    });
    $(function() {
        $(document).on("change", ".uploadFile", function() {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                }
            }

        });
    });
</script>
<?php

include 'footerAdmin.php';
