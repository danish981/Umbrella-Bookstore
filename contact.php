<?php

$title = "Contact";
require_once "./template/header.php";

require("./functions/functions.php");

$invalidEmail = $invalidName = $invalidMessage = "";

// email handler code is not written yet
if (isset($_POST["submit"])) {
    $name = validateField($_POST['name']);

    if (!preg_match("/^[a-zA-Z-' ", $name)) {
        $invalidName = "Only letters and white spaces are allowed";
    }

    $email = validateField($_POST['email']);
    $mailRegEx = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$";
    if (!preg_match($mailRegEx, $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $invalidEmail = "Your Email is invalid format.";
    }

    $message = validateField($_POST['email']);
    if (!preg_match("/^[a-zA-Z-' ", $message)) {
        $invalidMessage = "Message can only have letters and blank spaces";
    }

    // do some validations and write email code
    // todo : use php mail() function to send an email
    // todo : read documentation before sending an email




}

?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center">
            <!-- ==============================form starts====================================== -->
            <form class="form-horizontal" action="contact.php" autocomplete="off">
                <fieldset>

                    <legend class="big-font-4 text-center text-info">Contact Us</legend>
                    <p class="lead text-info">We would love to hear from you! Write something and send us an email</p>

                    <div class="form-group">
                        <label for="inputName" class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name" id="inputName"
                                   placeholder="Your Full Name" required>
                          <span class="text-warning"><?php echo $invalidName; ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="email" id="inputEmail"
                                   placeholder="Your Email" required>
                            <span class="text-warning"><?php echo $invalidEmail; ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Your Message</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="message" rows="4" id="textArea"
                                      placeholder="Your message" required></textarea>
                            <span class="text-warning"><?php echo $invalidMessage; ?></span>
                            <span class="help-block">Tell us about our book catalog and their quality, we would be happy with your kind message</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>

                </fieldset>
            </form>
            <!-- ===================================form ends====================================== -->
        </div>
        <div class="col-md-3"></div>
    </div>

<?php require_once "./template/footer.php"; ?>