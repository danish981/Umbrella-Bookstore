<?php

session_start();

require_once "./functions/database_functions.php";
require_once "./functions/cart_functions.php";

// book_isbn got from form post method, change this place later.
if (isset($_POST['bookisbn'])) {
    $book_isbn = $_POST['bookisbn'];
}

if (isset($book_isbn)) {
    // new iem selected
    if (!isset($_SESSION['cart'])) {
        // $_SESSION['cart'] is associative array that bookisbn => qty
        $_SESSION['cart'] = [];
        $_SESSION['total_items'] = 0;
        $_SESSION['total_price'] = '0.00';
    }

    if (!isset($_SESSION['cart'][$book_isbn])) {
        $_SESSION['cart'][$book_isbn] = 1;
    } elseif (isset($_POST['cart'])) {
        $_SESSION['cart'][$book_isbn]++;
        unset($_POST);
    }
}

// if save change button is clicked , change the qty of each bookisbn
if (isset($_POST['save_change'])) {
    foreach ($_SESSION['cart'] as $isbn => $qty) {
        if ($_POST[$isbn] == '0') {
            unset($_SESSION['cart']["$isbn"]);
        } else {
            $_SESSION['cart']["$isbn"] = $_POST["$isbn"];
        }
    }
}

$title = "Your shopping cart";
require "./template/header.php";

if (isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
    $_SESSION['total_price'] = total_price($_SESSION['cart']);
    $_SESSION['total_items'] = total_items($_SESSION['cart']);
    ?>
    <form action="cart.php" method="post">
        <table class="table table-bg">
            <tr class="table-heading-bg">
                <th class="big-font-1">Book Title</th>
                <th class="big-font-1">Price</th>
                <th class="big-font-1">Quantity</th>
                <th class="big-font-1">Total</th>
            </tr>
            <?php
            $conn = db_connect();
            foreach ($_SESSION['cart'] as $isbn => $qty) {
                $book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
                ?>
                <tr>
                    <td><?php echo $book['book_title'] . " by " . $book['book_author']; ?></td>
                    <td><?php echo "$" . $book['book_price']; ?></td>
                    <td><input type="number" value="<?php echo abs($qty); ?>" size="5" name="<?php echo $isbn; ?>"></td>
                    <td><?php echo "$" . $qty * $book['book_price']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><?php echo $_SESSION['total_items']; ?></th>
                <th><?php echo "$" . $_SESSION['total_price']; ?></th>
            </tr>
        </table>
        <input type="submit" class="btn btn-primary" name="save_change" value="Save Changes">
    </form>
    <br/><br/>

    <div class="container text-center">
        <!-- created empty cart button, if user clicks it, cart will be emptied, sessions will be destroyed and redirected to cart -->
        <a href="empty_session.php" class="btn btn-primary">Empty Cart</a>
        <a href="checkout.php" class="btn btn-primary">Go To Checkout</a>
        <a href="books.php" class="btn btn-primary">Continue Shopping</a>
    </div>

    <?php
} else {
    $_SESSION["errorArray"]["emtpyCart"] = "Your Cart is Empty. Make Sure You Add Some Books in it";
    header("location:nothingFound.php");
}
if (isset($conn)) {
    mysqli_close($conn);
}
require_once "./template/footer.php";
?>