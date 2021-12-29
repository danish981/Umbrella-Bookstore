<?php

$title = "Admin Section";
require_once "./template/header.php";

// todo : instead of creating a huge error array,
// todo : try creating a tiny session array and give the error before every field, if occur

?>

<!-- autocomplete of ON by default -->
<form class="form-horizontal text-center" method="post" action="admin_verify.php">

    <div class="form-group">
        <label for="name" class="control-label col-md-4">Admin Username</label>
        <div class="col-md-4">
            <input id="name" type="text" name="name" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label for="pass" class="control-label col-md-4">Admin Password</label>
        <div class="col-md-4">
            <input id="pass" type="password" name="pass" class="form-control" required>
        </div>
    </div>

    <input type="submit" name="submit" class="btn btn-primary">

</form>


<?php require_once "./template/footer.php"; ?>

