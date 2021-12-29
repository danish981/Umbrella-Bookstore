<?php

session_start();
$count = 0;

$title = "Index";
require_once "./template/header.php";

require_once "./functions/database_functions.php";
$conn = db_connect();

$numBooks = 4;

$row = selectLatestBooks($conn, $numBooks);

?>

<p class="lead text-center text-muted text-primary big-font-3">Latest books</p>
<div class="row four-books-margin-bottom">

    <?php foreach ($row as $book) { ?>
        <div class="col-md-3 text-center">
            <a href="book.php?bookisbn=<?php echo $book['book_isbn']; ?>">
                <img class="img-responsive img-thumbnail book-hover"
                     src="./assets/img/<?php echo $book['book_image']; ?>" alt="the image book image">
            </a>
        </div>
        <?php
        $count++;
        if ($count >= $numBooks) {
            $count = 0;
            break;
        }
        ?>
    <?php } ?>

</div>

<?php

if (isset($conn)) {
    mysqli_close($conn);
}

require_once "./template/footer.php";
?>
