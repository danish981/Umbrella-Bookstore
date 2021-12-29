<?php

session_start();
require_once "./functions/admin.php";

$title = "List book";
require_once "./template/header.php";

require_once "./functions/database_functions.php";
$conn = db_connect();
$result = getAll($conn);

?>

    <p class="lead text-center margin-top-bottom-5">
        <a href="admin_addPublisher.php" class="btn btn-primary">Add Publisher</a>
        <a href="admin_add.php" class="btn btn-primary">Add new book</a>
        <a href="admin_signout.php" class="btn btn-primary">Sign out!</a>
    </p>

    <table class="table beautify-table-rows" style="margin-top: 20px">
        <tr class="table-heading-bg">
            <th class="text-info big-font-1">ISBN</th>
            <th class="text-info big-font-1">Title</th>
            <th class="text-info big-font-1">Author</th>
            <th class="text-info big-font-1">Image</th>
            <th class="text-info big-font-1">Description</th>
            <th class="text-info big-font-1">Price</th>
            <th class="text-info big-font-1">Publisher</th>
            <th class="text-info big-font-1 text-center" colspan="2">Actions</th>
<!--            <th>&nbsp;</th>-->
<!--            <th>&nbsp;</th>-->
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['book_isbn']; ?></td>
                <td><?php echo $row['book_title']; ?></td>
                <td><?php echo $row['book_author']; ?></td>

                <!-- book image thumnail -->
                <td><img class="img-responsive img-thumbnail book-hover"
                         src="./assets/img/<?php echo $row['book_image']; ?>"></td>
                <td><?php echo $row['book_descr']; ?></td>
                <td>$<?php echo $row['book_price']; ?></td>
                <td><?php echo getPubName($conn, $row['publisherid']); ?></td>

                <td><a class="btn btn-primary btn-sm" href="admin_edit.php?bookisbn=<?php echo $row['book_isbn']; ?>">Edit</a>
                </td>
                <td><a class="btn btn-primary btn-sm" href="admin_delete.php?bookisbn=<?php echo $row['book_isbn']; ?>">Delete</a>
                </td>

            </tr>
        <?php } ?>
    </table>

<?php
if (isset($conn)) {
    mysqli_close($conn);
}
require_once "./template/footer.php";
?>