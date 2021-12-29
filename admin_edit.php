<?php

session_start();
require_once "./functions/admin.php";

$title = "Edit Book";
require_once "./template/header.php";

require_once "./functions/database_functions.php";
$conn = db_connect();

if (isset($_GET['bookisbn'])) {
    $bookIsbn = $_GET['bookisbn'];
} else {
    $_SESSION["errorArray"]["isbnNotFound"] = "Book ISBN Does not found. Try Again";
    header("Location : nothingFound.php");
    exit;
}

if (!isset($bookIsbn)) {
    $_SESSION["errorArray"]["emptyIsbn"] = "Empty ISBN ! Try Again";
    header("Location : nothingFound.php");
    exit;
}

$query = "SELECT * FROM books WHERE book_isbn = '$bookIsbn'";
$result = mysqli_query($conn, $query);

if (!$result) {
    $_SESSION["errorArray"]["retrieveError"] = "Cannot Retrieve Data ! Try Again";
    header("Location : nothingFound.php");
    exit;
}

$row = mysqli_fetch_assoc($result);

?>
<form method="post" action="edit_book.php" class="text-right" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <th><label for="isbn">ISBN</label></th>
            <td><input id="isbn" type="text" class="form-control" name="isbn"
                       value="<?php echo $row['book_isbn']; ?>" readonly></td>
        </tr>
        <tr>
            <th><label for="title">Title</label></th>
            <td><input id="title" type="text" class="form-control" name="title"
                       value="<?php echo $row['book_title']; ?>" required></td>
        </tr>
        <tr>
            <th><label for="author">Author</label></th>
            <td class="form-group"><input id="author" type="text" class="form-control" name="author"
                                          value="<?php echo $row['book_author']; ?>" required>
            </td>
        </tr>
        <tr>
            <th><label for="image">Thumbnail Image</label></th>
            <td class="form-group"><input id="image" type="file" class="form-control" name="image"></td>
        </tr>
        <tr>
            <th><label for="description">Description</label></th>
            <td class="form-group"><textarea id="description" class="form-control" name="descr" cols="40" rows="5"
                                             required><?php echo $row['book_descr']; ?></textarea>
        </tr>
        <tr>
            <th><label for="price">Price in Dollers</label></th>
            <td class="form-group"><input id="price" type="number" class="form-control" name="price"
                                          value="<?php echo $row['book_price']; ?>" required></td>
        </tr>
        <tr>

            <th><label for="publisher">Publisher</label></th>
            <td class="form-group">
                <select name="publisher" id="publisher" class="form-control" data-toggle="drop-down" required>
                    <?php
                    $publisherQuery = "select publisher_name from publisher";
                    $publisherResult = mysqli_query($conn, $publisherQuery);
                    if (mysqli_num_rows($publisherResult)) {
                        while ($row = mysqli_fetch_assoc($publisherResult)) {
                            foreach ($row as $publisherName) {
                                echo "<option value='$publisherName'>$publisherName</option>";
                            }
                        }
                    } else {
                        echo "<option>Add Publisher</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <!-- getting Internal Server Error on Clicking this button "save changes" -->
    <input type="submit" name="save_change" value="Change" class="btn btn-primary">
    <input type="reset" value="Reset" class="btn btn-default">

</form>

<br/>

<div class="container text-center">

    <a href="admin_book.php" class="btn btn-success">Confirm Changes</a>

</div>

<?php

if (isset($conn)) {
    mysqli_close($conn);
}

require "./template/footer.php"
?>
