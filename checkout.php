<?php

session_start();
require_once "./functions/database_functions.php";
require_once "./functions/functions.php";

//require("stripe/config.php");
require("stripe/submit.php");

$conn = db_connect();

$title = "Checkout";
require "./template/header.php";

$name = $email = $address = $city = $country = $zipcode = "";
$nameErr = $emailErr = $addressErr = $cityErr = $countryErr = $zipcodeErr = "";

$isAdded = "";

if (isset($_POST["submit"])) {

    $name = validateField($_POST['name']);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Name can only have letters and no special characters";
    }

    $email = validateField($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Email is Invalid. Try Entering correct email";
    }

    $address = validateField($_POST['address']);
    if (!preg_match("/^[a-zA-Z0-9]*$/", $address)) {
        $addressErr = "Address can only have letters and numbers";
    }

    $city = validateField($_POST['city']);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $city)) {
        $cityErr = "city name can only have letters";
    }

    $country = $_POST['country'];

    $zipcode = validateField($_POST['zip_code']);
    if (!preg_match("/^[0-9]*$/", $zipcode)) {
        $zipcodeErr = "Zip code can only have digits";
    }

    // code fragment under maintenance 
    $insertQuery = "INSERT into customers (name, address, city, zip_code, country, email) values ('$name', '$address', '$city', '$zipcode', '$country' , '$email')";
    $isAdded = mysqli_query($conn, $insertQuery);

}

if (isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
    ?>
    <table class="table">
        <tr>
            <th class="text-primary big-font-1">Book Title</th>
            <th class="text-primary big-font-1">Price</th>
            <th class="text-primary big-font-1">Quantity</th>
            <th class="text-primary big-font-1">Total</th>
        </tr>
        <?php
        foreach ($_SESSION['cart'] as $isbn => $qty) {
            $conn = db_connect();
            $book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
            ?>
            <tr>
                <td><?php echo $book['book_title'] . " by " . $book['book_author']; ?></td>
                <td><?php echo "$" . $book['book_price']; ?></td>
                <td><?php echo $qty; ?></td>
                <td><?php echo "$" . $qty * $book['book_price']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td>Shipping</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$20.00</td>
        </tr>
        <tr>
            <th>Total Including Shipping</th>
            <th>&nbsp;</th>
            <th><?php echo $_SESSION['total_items']; ?></th>
            <th><?php echo "$" . ($_SESSION['total_price'] + 20); ?></th>
            <?php $_SESSION['grand_total'] = $_SESSION['total_price'] + 20; ?>
        </tr>
    </table>

    <!-- =======================================form =============================================================== -->
    <form method="post" action="checkout.php" class="form-horizontal"
          autocomplete="off">

        <div class="form-group">
            <label for="name" class="control-label col-md-4">Name</label>
            <div class="col-md-4">
                <input id="name" type="text" name="name" class="col-md-4 form-control" placeholder="Haroon Ahmad e.g"
                       required>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="control-label col-md-4">Email</label>
            <div class="col-md-4">
                <input id="name" type="email" name="email" class="col-md-4 form-control"
                       placeholder="haroonAhmad321@gmail.com e.g"
                       required>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="control-label col-md-4">Address</label>
            <div class="col-md-4">
                <input id="address" type="text" name="address" class="col-md-4 form-control"
                       placeholder="DHA Block D, H-21, Lahore e,g" required>
            </div>
        </div>

        <div class="form-group">
            <label for="city" class="control-label col-md-4">City</label>
            <div class="col-md-4">
                <input id="city" type="text" name="city" class="col-md-4 form-control" placeholder="Lahore e,g"
                       required>
            </div>
        </div>

        <div class="form-group">
            <label for="zip_code" class="control-label col-md-4">Zip Code</label>
            <div class="col-md-4">
                <input id="zip_code" type="text" name="zip_code" class="col-md-4 form-control" placeholder="52250 e,g"
                       required>
            </div>
        </div>

        <div class="form-group">
            <label for="country" class="control-label col-md-4">Country</label>
            <div class="col-md-4">

                <select name="country" class="form-control" id="country" required>
                    <?php
                    $countryQuery = "select nicename from country";
                    $countryResult = mysqli_query($conn, $countryQuery);
                    if (mysqli_num_rows($countryResult)) {
                        while ($row = mysqli_fetch_assoc($countryResult)) {
                            foreach ($row as $countryName) {
                                echo "<option value='$countryName'>$countryName</option>";
                            }
                        }
                    }
                    ?>
                </select>

            </div>
        </div>

        <!-- payment button -->
        <div class="form-group text-center">
            <input type="submit" name="submit" value="Purchase" class="btn btn-primary">
        </div>

        <!-- payment button is shown only when the purchase button is clicked and detailed added of the user -->
        <?php // if ($isAdded): ?>
            <!-- <p class="text-center text-capitalize text-info">Details Enterd. Now create payment with card</p> -->
            <!-- this code segment is under maintainance -->
            <div class="form-group text-center">
                <form action="stripe/submit.php" method="post">
                    <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="<?php echo $publishableKey ?>"
                            data-amount="<?php echo($_SESSION['grand_total'] * 100); ?>"
                            data-name="Umbrella Bookstore"
                            data-description="Thanks for buying books from our store"
                            data-image="https://i.pinimg.com/originals/f9/6a/26/f96a261e5a60d7d66b36e2850e3eb19b.png"
                            data-currency="USD"
                            data-email="<?php echo $email; ?>"
                    >
                    </script>
                </form>
            </div>
        <?php // endif; ?>
    </form>

    <!-- ===========================================form ======================================================== -->
    <p class="text-center text-info big-font-1">
        Please press Purchase Button to confirm your purchase, or Continue Shopping to add or remove more items
    </p>

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