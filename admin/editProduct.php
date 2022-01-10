<?php
include 'headerAdmin.php';
?>
<main id="editProduct" class="container">
    <h2>Edit Product</h2>
    <hr>
    <a class="back-button" href="index.php">Back</a>
    
    <?php if (isset($_GET['product_id'])) : ?>
        <?php $product = getProduct($_GET['product_id']);?>   
        <?php if (isset($_POST) && isset($_FILES['input-images'])) :
            $productId = $_GET['product_id'];

            // Get All product taille
            $taille = [];
            $getProductTaille = getProductTaille($productId);
            foreach (getTailles() as $tailleId => $tailleName) {
                $idTaille = getTailleId($tailleName);
                $taille[] = (object) array(
                    'id' => getTailleProduitId($productId, $idTaille),
                    'idProduit' => $productId,
                    'idTaille' => getTailleId($tailleName),
                    'checked' => (in_array($idTaille, $_POST['input-size'])) ? true : false
                );
            }

            $images = array_merge($_POST['input-images'], $_FILES['input-images']);
            $newProduct = (object) array(
                'id' => $productId,
                'nom' => $_POST['input-name'],
                'description' => $_POST['input-description'],
                'marque' => $_POST['input-brand'],
                'prix' => $_POST['input-price'],
                'couleur' => $_POST['input-color'],
                'genre' => $_POST['input-genre'],
                'specification' => $_POST['input-specification'],
                'taille' => $taille,
                'categorie' => $_POST['input-categorie'],
                'images' => $images
            );

            // Images
            $images = [];
            foreach ($_POST['input-images']['action'] as $i => $img) {
                // Action list : 0 = delete / 1 = nothing / 2 = add
                $del = ($_POST['input-images']['action'][$i] == 0) ? true : false;// Si delete
                $images[] = array(
                    'action' => $img,
                    'alt' => $_POST['input-images']['alt'][$i],
                    'url' => (isset($product['images'][$i])) ? $product['images'][$i]['url'] : (($del) ? getImageProduitId($productId, $product['images'][$i]['id']) : $_FILES['input-images']['name'][$i]),
                    'tmp_name' => (isset($_FILES['input-images']['tmp_name'][$i])) ? $_FILES['input-images']['tmp_name'][$i] : '',
                    'idImage' => (isset($product['images'][$i])) ? $product['images'][$i]['id'] : '',
                    'idImgProd' => (isset($product['images'][$i])) ? getImageProduitId($productId, $product['images'][$i]['id']) : '',
                );
            }

            updateProductImage($productId, $images);
            $updateProduct = updateProduct($newProduct);

            if($updateProduct) :
        ?>
                <div class="alert alert-success" role="alert">
                    The product has been edited!
                </div>
                <?php echo ("<meta http-equiv='refresh' content='1'>"); ?>
            <?php else : ?>
                <div class="alert alert-danger" role="alert">
                    Error while edit the product..
                </div>
            <?php endif; ?>
        <?php endif; ?>    
         
        <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
            <!-- Input name -->
            <div class="col-md-12">
                <label for="input-name" class="form-label">Name</label>
                <input type="text" class="form-control" name="input-name" id="input-name" required value="<?php echo $product['nom']; ?>">
                <div class="invalid-feedback">
                    Please choose a name.
                </div>
            </div>

            <!-- Input description -->
            <div class="col-md-12">
                <label for="input-description" class="form-label">Description</label>
                <textarea class="form-control" name="input-description" id="input-description" rows="3" required><?php echo $product['description']; ?></textarea>
                <div class="invalid-feedback">
                    Please enter a description.
                </div>
            </div>

            <!-- Input brand -->
            <div class="col-md-3">
                <label for="input-brand" class="form-label">Marque</label>
                <input type="text" class="form-control" name="input-brand" id="input-brand" required value="<?php echo $product['marque']; ?>">
                <div class="invalid-feedback">
                    Please choose a brand.
                </div>
            </div>

            <!-- Input price -->
            <div class="form-outline col-md-3">
                <label for="input-price" class="form-label">Price</label>
                <input type="number" class="form-control" name="input-price" id="input-price" step=".01" required value="<?php echo floatval($product['prix']); ?>">
                <div class="invalid-feedback">
                    Please choose a price.
                </div>
            </div>

            <!-- Input Color -->
            <div class="form-outline col-md-3">
                <label for="input-color" class="form-label">Color</label>
                <input type="text" class="form-control" name="input-color" id="input-color" required value="<?php echo $product['couleur']; ?>">
                <div class="invalid-feedback">
                    Please choose a color.
                </div>
            </div>

            <!-- Input Genre -->
            <div class="form-outline col-md-3">
                <label for="input-genre" class="form-label">Genre</label><br>
                <select class="form-select" id="input-genre" name="input-genre" required>
                    <?php
                    function getGenreId($genreName)
                    {
                        foreach (getGenre() as $grId => $grName) {
                            if ($grName === $genreName) {
                                return $grId;
                            }
                        }
                        return false;
                    }
                    ?>

                    <option value="<?= getGenreId($product['genre']); ?>"><?= $product['genre']; ?></option>
                    <?php foreach (getGenre() as $genreId => $genreName) : ?>
                        <?php if ($product['genre'] != $genreName) : ?>
                            <option value="<?= $genreId; ?>"><?= $genreName; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Please select a genre.
                </div>
            </div>

            <!-- Input specification -->
            <div class="col-md-12">
                <label for="input-specification" class="form-label">Specification</label>
                <textarea class="form-control" name="input-specification" id="input-specification" rows="3" required><?php echo $product['specification']; ?></textarea>
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
                            <?php // Si le produit à la taille
                            if (in_array($tailleName, $product['taille'])) : ?>
                                <input type="checkbox" class="form-check-input" name="input-size[]" value="<?= $tailleId; ?>" required checked /> <?= $tailleName; ?><br>
                            <?php else : ?>
                                <input type="checkbox" class="form-check-input" name="input-size[]" value="<?= $tailleId; ?>" required /> <?= $tailleName; ?><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="invalid-feedback">Please choose a size</div>
                    </div>
                </div>

            </div>

            <!-- Input categorie -->
            <div class="col-md-6">
                <label for="input-categorie" class="form-label">Categorie</label><br>
                <select class="form-select" id="input-categorie" name="input-categorie" required>
                    <?php
                    function getCategorieId($catName)
                    {
                        foreach (getAllCategories() as $cat) {
                            if ($cat['nom'] === $catName) {
                                return $cat['id'];
                            }
                        }

                        return false;
                    }
                    ?>

                    <option value="<?= getCategorieId($product['categorie']); ?>"><?= $product['categorie']; ?></option>
                    <?php foreach (getAllCategories() as $cat) : ?>
                        <?php if ($product['categorie'] != $cat['nom']) : ?>
                            <option value="<?= $cat['id']; ?>"><?= $cat['nom']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Please choose a categorie.
                </div>
            </div>

            <!-- Input image -->
            <div class="col-md-12 input-image">
                <div class="row" for="input-images">
                    <?php foreach ($product['images'] as $i => $image) : ?>
                        <div class="col-sm-2 imgUp">
                            <div class="imagePreview" style="background-image: url(../<?php echo $image['url']; ?>);">
                                <input type="text" class="form-control" name="input-images[alt][]" value="<?php echo $image['nom']; ?>" required>
                            </div>
                            <label class="btn">
                                Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="input-images[]">
                                <input type="hidden" name="input-images[action][]" class="img-status" value=1>
                            </label>
                            <?php if ($i != 0) : ?>
                                <i class="fa fa-times del"></i>
                            <?php endif; ?>
                        </div><!-- col-2 -->
                    <?php endforeach; ?>
                    <i class="fa fa-plus imgAdd"></i>
                </div><!-- row -->



            </div>

            <div class="col-12">
                <button class="btn" type="submit">Edit product</button>
            </div>
        </form>
    <?php else : ?>
        <div class="empty-page">
            <h2>Erreur lors du chargement de la page..</h2>
        </div>
    <?php endif; ?>
</main>
<script>
    // Images Input 
    $(".imgAdd").click(function() {
        $(this).closest(".row").find('.imgAdd').before(

            `<div class="col-sm-2 imgUp">
                <div class="imagePreview">
                    <input type="text" class="form-control" name="input-images[alt][]" placeholder="Image name"  required>
                </div>
                <label class="btn">
                    Upload
                    <input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;" name="input-images[]" required>
                    <input type="hidden" name="input-images[action][]" class="img-status" value=3>
                    <div class="invalid-feedback">
                        Please choose images.
                    </div>
                </label>
                <i class="fa fa-times del"></i>
            </div>
            `
        )
    });

    $(document).on("click", "i.del", function() {
        $(this).parent().css('display', 'none');

        // Remove required input
        $(this).parent().children('.btn').children('.img').removeAttr('required');
        $(this).parent().children('.imagePreview').children('.form-control').removeAttr('required');
        $(this).parent().children('.btn').children('.img-status').val(0);
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
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                    let imgStatus = uploadFile.parent().children('.img-status').val();
                    if (imgStatus != 3) {
                        uploadFile.parent().children('.img-status').val(2);
                    }
                }
            }

        });
    });
</script>
<?php

include 'footerAdmin.php';
