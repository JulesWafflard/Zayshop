<?php
include 'headerAdmin.php';
?>

<main id="contactAdmin" class="container">
    <h2>Contact Messages List</h2>
    <hr>

    <?php
        // Check if delete contact message
        if(isset($_GET['delete']) && isset($_GET['contact_id'])){
            $messDel = DeleteContact($_GET['contact_id']);
            if($messDel['success']){
                ?>
                    <div class="alert alert-success" role="alert">
                        The size has been deleted!
                    </div>
                <?php
            }else{
                ?>
                <div class="alert alert-danger" role="alert">
                    Error while deleting the size<br>
                    <?php echo $messDel['message']; ?>
                </div>
                <?php
            }
        }
    ?>

    <div class="table-responsive table-list">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $messages = getContactList(); 

                    forEach($messages as $message) : ?>
                        <td><?= $message['id'] ?></td>
                        <td><?= $message['nom'] ?></td>
                        <td><?= $message['sujet'] ?></td>
                        <td>
                            <a href='#' class="show-contact-message" data-id="<?= $message['id'] ?>"><i class='fas fa-chevron-circle-down'></i></a>
                            <a href='?delete&contact_id=<?= $message['id'] ?>'><i class='far fa-trash-alt'></i></a>
                        </td>
                        <tr>
                        <!-- Message content -->
                        <td colspan="4" class="hidden contact-container" data-id="<?= $message['id'] ?>">
                            <div>
                                <p class="contact-from">From : <?= $message['nom'] ?> <'<?= $message['email'] ?>'></p>
                                <p class="contact-date">Date : <?= formatDate($message['date'], 'F d, Y \a\t  g:i A'); ?> </p>
                                <p class="contact-subject"><?= $message['sujet'] ?></p>
                                <p class="contact-message"><?= $message['message'] ?></p>
                                <a class="contact-answer" href="mailto:<?= $message['email'] ?>?subject=RE:<?= $message['sujet'] ?>">Répondre</a>
                            </div>
                        </td>

                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<script>
    $(function() {
        $('.show-contact-message').click(function(){
            let id = $(this).data('id');
            let containerElm = $(`.contact-container[data-id=${id}]`);
            let hasClass = containerElm.hasClass('hidden');
            let icon = (hasClass) ? '<i class="fas fa-chevron-circle-up"></i>' : '<i class="fas fa-chevron-circle-down"></i>';
            
            if(hasClass){
                containerElm.removeClass('hidden');
                $(this).html(icon);
            }else{
                containerElm.addClass('hidden');
                $(this).html(icon);

            }
        })
    });
</script>

<?php
include 'footerAdmin.php';
?>