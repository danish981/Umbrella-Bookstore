<?php
session_start();
$book_isbn = $_GET['bookisbn'];

require_once "./functions/database_functions.php";
$conn = db_connect();

$query = "DELETE FROM books WHERE book_isbn = '$book_isbn'";
$result = mysqli_query($conn, $query);

if (!$result) {
    $_SESSION["errorArray"]["deleteDataFailed"] = "Data Cannot be Deleted. Try Again";
    header("Location : nothingFound.php");
    exit;
}
header("Location: admin_book.php");



