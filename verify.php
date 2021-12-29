<?php

$email = $_POST['inputEmail'];
$pswd = $_POST['inputPasswd'];

$conn = mysqli_connect("localhost", "root", "", "bookstore");
if (!$conn) {
    $_SESSION["errorArray"]["dbConnFailed"] = "Cannot Establish Connection with the Database";
    header("Location : nothingFound.php");
    exit;
}

$query = "SELECT name, pass FROM admin";
$result = mysqli_query($conn, $query);

if (!$result) {
    $_SESSION["errorArray"]["dbConnFailed_2"] = "Something went Wrong. Try to Enter Data Again";
    header("Location : nothingFound.php");
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    if ($email == $row['username'] && $pswd == $row['password']) {
        echo "Welcome admin! After long time you have logged in";
        break;
    }
}
