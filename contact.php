<?php
include 'header.php';
include 'functions.php';
?>
<main id="index">

    <section id="map">

        <h1>Contact Us</h1>
        <p>Proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet.</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d34937.77126565291!2d-43.418512956532595!3d-23.009785380944063!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9bdb085a079173%3A0xbd0152870ed422be!2sPraia%20da%20Reserva!5e0!3m2!1sfr!2sfr!4v1640007335949!5m2!1sfr!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

    </section>

    <section id="formcontact">

        <div class="container">
            <?php
            if (isset($_POST['addmessage'])) {
                if (isset($_POST)) {
                    $message = array(
                        'name' => $_POST['input-name'],
                        'email' => $_POST['input-email'],
                        'subject' => $_POST['input-subject'],
                        'contactmessage' => $_POST['input-message'],
                    );

                    $insertMessage = insertMessage($message);
                    if ($insertMessage) {
            ?>
                        <div class="alert alert-success" role="alert">
                            Le message a été envoyé
                        </div>
                    <?php
                        echo ("<meta http-equiv='refresh' content='1'>");
                    } else {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            Erreur lors de l'envoie du message
                        </div>
            <?php
                    }
                }
            }
            ?>

            <form method="POST">

                <input type="hidden" name="addmessage" value="1">

                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput">Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="input-name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput">Email</label>
                        <input type="text" class="form-control" placeholder="Email" name="input-email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Subject</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Subject" name="input-subject">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Message</label>
                    <textarea type="textarea" class="form-control" id="formGroupExampleInput2" placeholder="Message" name="input-message"></textarea>
                </div>
                <input type="submit" value="Let's Talk" class="btn btn-addbuy">
            </form>
        </div>

    </section>

</main>
<?php
include 'footer.php';
?>