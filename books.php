<?php

session_start();

require_once "./functions/database_functions.php";
$conn = db_connect();

// $query = "SELECT book_isbn, book_image FROM books";

$query = "SELECT book_isbn, book_image FROM books ORDER BY rand()";

$result = mysqli_query($conn, $query);

$totalBooksFound = mysqli_num_rows($result);

if (!$result) {
    $_SESSION["errorArray"]["retrieveFailed"] = "Cannot Retrieve Book Data";
    header("Location : nothingFound.php");
    exit;
}

$title = "Full Catalogs of Books";
require_once "./template/header.php";
$count = 0;
?>

    <p class="lead text-center text-muted">Full Catalog of Books (<?php echo $totalBooksFound; ?>)</p>
<?php for ($i = 0; $i < mysqli_num_rows($result); $i++) { ?>

    <div class="row four-books-margin-bottom">
        <?php while ($query_row = mysqli_fetch_assoc($result)) { ?>
            <!-- text-center is added here to make the book thumbnails in the center -->
            <div class="col-md-3 text-center">
                <a href="book.php?bookisbn=<?php echo $query_row['book_isbn']; ?>">
                    <img class="img-responsive img-thumbnail book-hover"
                         src="./assets/img/<?php echo $query_row['book_image']; ?>" alt="the responsive book image">
                </a>
            </div>
            <?php
            $count++;
            if ($count >= 4) {
                $count = 0;
                break;
            }
        } ?>
    </div>
    <?php
}

if (isset($conn)) {
    mysqli_close($conn);
}

require_once "./template/footer.php";

?>