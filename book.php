<?php

session_start();

$book_isbn = $_GET['bookisbn'];

require_once "./functions/database_functions.php";
$conn = db_connect();

$query = "SELECT * FROM books WHERE book_isbn = '$book_isbn'";
$result = mysqli_query($conn, $query);
if (!$result) {
    $_SESSION["errorArray"]["retrieveFailed"] = "Cannot Retrieve Data";
    header("Location : nothingFound.php");
    exit;
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
    $_SESSION["errorArray"]["emptyBooks"] = "There Are No Books in the Database";
    header("Location : nothingFound.php");
    exit;
}

$title = $row['book_title'];
require "./template/header.php";

?>
<p class="lead" style="margin: 25px 0"><a href="books.php">Books</a> &nbsp; <span
        class="glyphicon glyphicon-arrow-right"></span> &nbsp; <?php echo $row['book_title']; ?></p>
<div class="row">
    <div class="col-md-3 text-center">
        <img class="img-responsive img-thumbnail book-hover" alt="the book image"
             src="./assets/img/<?php echo $row['book_image']; ?>">
    </div>
    <div class="col-md-6">
        <h4>Book Description</h4>
        <p><?php echo $row['book_descr']; ?></p><br>
        <h4>Book Details</h4>
        <table class="table">
            <?php foreach ($row as $key => $value) {
                if ($key == "book_descr" || $key == "book_image" || $key == "publisherid" || $key == "book_title") {
                    continue;
                }
                switch ($key) {
                    case "book_isbn":
                        $key = "ISBN";
                        break;
                    case "book_title":
                        $key = "Title";
                        break;
                    case "book_author":
                        $key = "Author";
                        break;
                    case "book_price":
                        $key = "Price";
                        break;
                }
                ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value; ?></td>
                </tr>
                <?php
            }
            if (isset($conn)) {
                mysqli_close($conn);
            }
            ?>
        </table>
        <form method="post" action="cart.php">
            <input type="hidden" name="bookisbn" value="<?php echo $book_isbn; ?>">
            <input type="submit" value="Purchase / Add to cart" name="cart" class="btn btn-primary">
        </form>
    </div>
</div>

<?php require "./template/footer.php"; ?>