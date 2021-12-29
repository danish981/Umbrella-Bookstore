<?php


require("functions/functions.php");


if (!isset($_POST['save_change'])) {
    $_SESSION["errorArray"]["saveChangesFailed"] = "Save Changes Failed. Try Again";
    header("location: nothingFound.php");
    exit;
}

$isbn = validateField($_POST['isbn']);
$title = validateField($_POST['title']);
$author = validateField($_POST['author']);
$descr = validateField($_POST['descr']);
$price = floatval(validateField($_POST['price']));
$publisher = $_POST['publisher'];      

if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
    $image = $_FILES['image']['name'];
    $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "assets/img/";
    $uploadDirectory .= $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
}

require_once("./functions/database_functions.php");
$conn = db_connect();

// if publisher is not in db, create new
$findPub = "SELECT * FROM publisher WHERE publisher_name = '$publisher'";
$findResult = mysqli_query($conn, $findPub);

if (!$findResult) {
    $insertPub = "INSERT INTO publisher(publisher_name) VALUES ('$publisher')";
    $insertResult = mysqli_query($conn, $insertPub);
    if (!$insertResult) {
        echo "Cannot add publisher at the moment | try after a while | " . mysqli_error($conn);
        exit;
    }
}

$query = "UPDATE books SET  
	book_title = '$title', 
	book_author = '$author', 
	book_descr = '$descr', 
	book_price = '$price'";

if (isset($image)) {
    $query .= ", book_image='$image' WHERE book_isbn = '$isbn'";
} else {
    $query .= " WHERE book_isbn = '$isbn'";
}

// two cases for fie , if file submit is on => change a lot
$result = mysqli_query($conn, $query);
if (!$result) {
    $_SESSION["errorArray"]["updateFailed"] = "Cannot Update Book data. Try Again with Valid Data";
    header("Location : nothingFound.php");
    exit;
} else {
    header("Location: admin_edit.php?bookisbn=$isbn");
}
