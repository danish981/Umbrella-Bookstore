<?php

session_start();
require_once "./functions/database_functions.php";

if (isset($_GET['pubid'])) {
    $publisherId = $_GET['pubid'];
} else {
    $_SESSION["errorArray"]["pubIdMissing"] = "Publisher ID is Missing &nbsp; Please Try Again!";
    header("Location: nothingFound.php");
    exit;
}

$conn = db_connect();
$publisherName = getPubName($conn, $publisherId);

$query = "SELECT book_isbn, book_title, book_image, book_author, book_descr, book_price FROM books WHERE publisherid = '$publisherId'";
$result = mysqli_query($conn, $query);

if (!$result) {
    $_SESSION["errorArray"]["retrieveError"] = "Cannot Retrieve Data &nbsp; Please Try Again!";
    echo mysqli_error($conn);
    exit;
}

if (mysqli_num_rows($result) === 0) {
    $_SESSION["errorArray"]["emptyBooksPub"] = "Empty Books! Please wait until new books coming";
    header("Location:nothingFound.php");
    exit;
}

$title = "Books Per Publisher";
require "./template/header.php";

?>
    <p class="lead"><a href="publisher_list.php">Publishers</a> &nbsp; <span
                class="glyphicon glyphicon-arrow-right"></span> &nbsp; <?php echo $publisherName; ?></p>
<?php while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="row">

        <div class="col-md-3">
            <img class="img-responsive img-thumbnail book-hover"
                 src="./assets/img/<?php echo $row['book_image']; ?>" alt="the book thumbnail image">
        </div>
        
        <div class="col-md-7">
            <h4><?php echo $row['book_title']; ?></h4>
            <h4><?php echo $row['book_isbn']; ?></h4>
            <h4><?php echo $row['book_author']; ?></h4>
            <h4>$<?php echo $row['book_price']; ?></h4>
            <p><?php echo $row['book_descr']; ?></p>
            <a href="book.php?bookisbn=<?php echo $row['book_isbn']; ?>" class="btn btn-primary">Get Details</a>
        </div>

    </div>
    <br>
    <br>
    <br>
    <?php
}

if (isset($conn)) {
    mysqli_close($conn);
}
require "./template/footer.php";
?>