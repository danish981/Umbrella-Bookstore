<?php

session_start();

require("functions/functions.php");

// todo : validations needed for admin verification

if (!isset($_POST['submit'])) {
    $_SESSION["errorArray"]["adminError"] = "Cannot Let You Enter Admin Area. Try Entering Data";
    header("Location : nothingFound.php");
    exit;
}

require_once "./functions/database_functions.php";
$conn = db_connect();

$name = validateField($_POST['name']);
$pass = validateField($_POST['pass']);

if ($name === "" || $pass === "") {
    $_SESSION["errorArray"]["adminEmpty"] = "Name or Password is Blank. Try to Enter Some Valid Data";
    header("Location : nothingFound.php");
    exit;
}

$name = mysqli_real_escape_string($conn, $name);
$pass = mysqli_real_escape_string($conn, $pass);
$pass = sha1($pass);

$query = "SELECT name, pass from admin";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Empty data " . mysqli_error($conn);
    exit;
}

$row = mysqli_fetch_assoc($result);

if ($name != $row['name'] && $pass != $row['pass']) {
    $_SESSION["errorArray"]["adminIncorrect"] = "Username or Password is Wrong. Try to Enter Correct Data";
    header("Location : nothingFound.php");
    $_SESSION['admin'] = false;
    exit;
}

if (isset($conn)) {
    mysqli_close($conn);
}

$_SESSION['admin'] = true;
header("Location: admin_book.php");
