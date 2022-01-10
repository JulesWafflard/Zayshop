<?php
include 'headerAdmin.php';
?>

<main id="sizesAdmin" class="container">
    <h2>Sizes List</h2>
    <hr>

    <?php
        // Check if delete sizes
        if(isset($_GET['delete']) && isset($_GET['size_id'])){
            $sizeDel = deleteSize($_GET['size_id']);
            if($sizeDel['success']){
                ?>
                    <div class="alert alert-success" role="alert">
                        The size has been deleted!
                    </div>
                <?php
            }else{
                ?>
                <div class="alert alert-danger" role="alert">
                    Error while deleting the size<br>
                    <?php echo $sizeDel['message']; ?>
                </div>
                <?php
            }
        }
    ?>

    <div class="table-responsive table-list">
        <a href="addSize.php" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Add Size</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Product with size</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $tailles = getTailles(); 

                    forEach($tailles as $id => $name){
                        echo "
                            <tr>
                                <td>".$id."</td>
                                <td>".$name."</td>
                                <td>".getAllSizesInProduct($id)."</td>
                                <td>
                                    <a href='editSize.php?size_id=".$id."'><i class='far fa-edit'></i></a>
                                    <a href='?delete&size_id=".$id."'><i class='far fa-trash-alt'></i></a>
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