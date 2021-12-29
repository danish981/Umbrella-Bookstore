<?php

session_start();

$title = "Nothing Found";

require_once "./template/header.php";
require_once "./functions/database_functions.php";
$conn = db_connect();

$errorMessage = "";
if (isset($_SESSION["errorArray"]["pubIdMissing"])) {
    $errorMessage = $_SESSION["errorArray"]["pubIdMissing"];
} else if (isset($_SESSION["errorArray"]["retrieveError"])) {
    $errorMessage = $_SESSION["errorArray"]["retrieveError"];
    echo mysqli_error($conn);
} else if (isset($_SESSION["errorArray"]["emptyBooksPub"])) {
    $errorMessage = $_SESSION["errorArray"]["emptyBooksPub"];
} else if (isset($_SESSION["errorArray"]["cantAddPub"])) {
    $errorMessage = $_SESSION["errorArray"]["cantAddPub"];
    echo mysqli_error($conn);
} else if (isset($_SESSION["errorArray"]["cantAddBookData"])) {
    $errorMessage = $_SESSION["errorArray"]["cantAddBookData"];
    echo mysqli_error($conn);
} else if (isset($_SESSION["errorArray"]["deleteDataFailed"])) {
    $errorMessage = $_SESSION["errorArray"]["deleteDataFailed"];
    echo mysqli_error($conn);
} else if (isset($_SESSION["errorArray"]["isbnNotFound"])) {
    $errorMessage = $_SESSION["errorArray"]["isbnNotFound"];
} else if (isset($_SESSION["errorArray"]["adminError"])) {
    $errorMessage = $_SESSION["errorArray"]["adminError"];
} else if (isset($_SESSION["errorArray"]["adminEmpty"])) {
    $errorMessage = $_SESSION["errorArray"]["adminEmpty"];
} else if (isset($_SESSION["errorArray"]["adminIncorrect"])) {
    $errorMessage = $_SESSION["errorArray"]["adminIncorrect"];
    $_SESSION["admin"] = false;
} else if (isset($_SESSION["errorArray"]["retrieveFailed"])) {
    $errorMessage = $_SESSION["errorArray"]["retrieveFailed"];
    echo mysqli_error($conn);
} else if (isset($_SESSION["errorArray"]["emptyBooks"])) {
    $errorMessage = $_SESSION["errorArray"]["emptyBooks"];
} else if (isset($_SESSION["errorArray"]["emtpyCart"])) {
    $errorMessage = $_SESSION["errorArray"]["emtpyCart"];
} else if (isset($_SESSION["errorArray"]["saveChangesFailed"])) {
    $errorMessage = $_SESSION["errorArray"]["saveChangesFailed"];
} else if (isset($_SESSION["errorArray"]["dbConnFailed"])) {
    $errorMessage = $_SESSION["errorArray"]["dbConnFailed"];
    echo mysqli_connect_error();
} else if (isset($_SESSION["errorArray"]["dbConnFailed_2"])) {
    $errorMessage = $_SESSION["errorArray"]["dbConnFailed_2"];
} else if (isset($_SESSION["errorArray"]["updateFailed"])) {
    $errorMessage = $_SESSION["errorArray"]["updateFailed"];
    echo mysqli_error($conn);
} else {
    $errorMessage = "Error Encountered | Please wait until developers solve the problem";
}




?>

<p class="text-warning text-center text-capitalize big-font-3"><?php echo $errorMessage ?></p>

<?php require_once "./template/footer.php" ?>


