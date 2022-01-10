<?php
include 'headerAdmin.php';
?>

<main id="usersAdmin" class="container">
    <h2>Users List</h2>
    <hr>

    <?php
        // Check if delete product
        if(isset($_GET['delete']) && isset($_GET['user_id'])){
            $userDel = DeleteUser($_GET['user_id']);
            if($userDel){
                ?>
                    <div class="alert alert-success" role="alert">
                        The user has been deleted!
                    </div>
                <?php
            }else{
                ?>
                <div class="alert alert-danger" role="alert">
                    Error while deleting the user
                </div>
                <?php
            }
        }
    ?>

    <div class="table-responsive table-list">
        <a href="addUser.php" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Add User</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Administrator</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $users = getAllUsers(); 

                    forEach($users as $user){
                        echo "
                            <tr>
                                <td>".$user['id']."</td>
                                <td>".$user['nom']."</td>
                                <td>".$user['prenom']."</td>
                                <td>".$user['email']."</td>
                                <td>".$user['admin']."</td>
                                <td>
                                    <a href='editUser.php?user_id=".$user['id']."'><i class='far fa-edit'></i></a>
                                    <a href='?delete&user_id=".$user['id']."'><i class='far fa-trash-alt'></i></a>
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