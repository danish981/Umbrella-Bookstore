<?php

session_start();
require_once "./functions/admin.php";
require("functions/functions.php");

$title = "Add new book";
require "./template/header.php";

require "./functions/database_functions.php";
$conn = db_connect();

if (isset($_POST['add'])) {
    $isbn = validateField($_POST['isbn']);
    $isbn = mysqli_real_escape_string($conn, $isbn);

    $title = validateField($_POST['title']);
    $title = mysqli_real_escape_string($conn, $title);

    $author = validateField($_POST['author']);
    $author = mysqli_real_escape_string($conn, $author);

    $descr = validateField($_POST['descr']);
    $descr = mysqli_real_escape_string($conn, $descr);

    $price = (float)validateField($_POST['price']);
    $price = mysqli_real_escape_string($conn, $price);

    // it is drop down, no need of its validation
    $publisher = $_POST['publisher'];

    // add image and move image to the bootstra/img/???.png, repeating code
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "assets/img/";
        $uploadDirectory .= $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
    }

    // find publisher and return pubid
    // if publisher is not in db, create new
    $findPub = "SELECT * FROM publisher WHERE publisher_name = '$publisher'";
    $findResult = mysqli_query($conn, $findPub);
    if (!$findResult) {
        // insert into publisher table and return id
        $insertPub = "INSERT INTO publisher(publisher_name) VALUES ('$publisher')";
        $insertResult = mysqli_query($conn, $insertPub);
        if (!$insertResult) {
            $_SESSION["errorArray"]["cantAddPub"] = "Cannot Add New Publisher";
            header("Location : nothingFound.php");
            exit;
        }
        $publisherid = mysqli_insert_id($conn);
    } else {
        $row = mysqli_fetch_assoc($findResult);
        $publisherid = $row['publisherid'];
    }

    $query = "INSERT INTO books VALUES ('$isbn', '$title', '$author', '$image', '$descr', '$price', '$publisherid')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $_SESSION["errorArray"]["cantAddBookData"] = "Cannot Add New Book Data";
        header("Location : nothingFound.php");
        exit;
    } else {
        header("Location: admin_book.php");
    }
}
?>
    <form method="post" action="admin_add.php" class="text-center" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <!-- example ISBN number, use this for tool tip -->
                <!-- 	978-3-16-148410-0    -->
                <th><label for="isbn">ISBN</label></th>
                <td class="form-group"><input id="isbn" class="form-control" type="text" name="isbn"
                                              placeholder="978-3-16-148410-0 (format) e.g" required></td>
            </tr>
            <tr>
                <th><label for="title">Title</label></th>
                <td class="form-group"><input id="title" class="form-control" type="text" name="title"
                                              placeholder="Mine Kamphh e.g" required></td>
            </tr>
            <tr>
                <th><label for="author">Author</label></th>
                <td class="form-group"><input id="author" class="form-control" type="text" name="author"
                                              placeholder="Rowan Atkinsen e.g" required></td>
            </tr>
            <tr>
                <th><label for="image">Book Cover</label></th>
                <td class="form-group"><input id="image" name="image" class="form-control" type="file"
                                              placeholder="Book Thumbnail" required></td>
            </tr>
            <tr>
                <th><label for="description">Description</label></th>
                <td class="form-group"><textarea id="description" name="descr" class="form-control" cols="40"
                                                 rows="5" placeholder="The book description goes here" required></textarea></td>
            </tr>
            <tr>
                <th><label for="price">Price in Dollers</label></th>
                <td class="form-group"><input id="price" class="form-control" type="number" name="price"
                                              placeholder="25.00" required></td>
            </tr>
            <tr>
                <th><label for="publisher">Select Publisher</label></th>
                <td class="form-group">
                    <select name="publisher" class="form-control" id="publisher" required>
                        <?php
                        $publisherQuery = "select publisher_name from publisher";
                        $publisherResult = mysqli_query($conn, $publisherQuery);
                        if (mysqli_num_rows($publisherResult)) {
                            while ($row = mysqli_fetch_assoc($publisherResult)) {
                                foreach ($row as $publisherName) {
                                    echo "<option value='$publisherName'>$publisherName</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

        </table>
        <input type="submit" name="add" value="Add new book" class="btn btn-primary">
        <input type="reset" value="cancel" class="btn btn-default">
    </form>
    <br/>

<?php
if (isset($conn)) {
    mysqli_close($conn);
}

require_once "./template/footer.php";

?>