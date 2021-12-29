<?php

session_start();
require_once "./functions/database_functions.php";
$conn = db_connect();

$query = "SELECT * FROM publisher ORDER BY publisherid";
//$query = "SELECT * FROM publisher ORDER BY rand()";
$result = mysqli_query($conn, $query);

if (!$result) {
    $errorMessage = $_SESSION["errorArray"]["retrieveFailed"] = "Cannot Retrieve Data";
    header("Location : nothingFound.php");
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo "Empty publisher ! Something wrong! check again";
    exit;
}

$title = "List Of Publishers";
require "./template/header.php";

?>

    <div class="container">

        <p class="lead big-font-5 heading-hover text-center">Publishers List</p>
        <ul class="publisher-list">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $count = 0;
                $query = "SELECT publisherid FROM books";
                // $query = "SELECT publisherid FROM books ORDER BY rand()";
                $result2 = mysqli_query($conn, $query);
                if (!$result2) {
                    echo "Can't retrieve data " . mysqli_error($conn);
                    exit;
                }
                while ($pubInBook = mysqli_fetch_assoc($result2)) {
                    if ($pubInBook['publisherid'] == $row['publisherid']) {
                        $count++;
                    }
                }
                ?>
                <li>
                    <span class="badge style-badge"><?php echo $count; ?></span>
                    <a class="text-primary big-font-1 text-primary"
                       href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>"><?php echo $row['publisher_name']; ?></a>
                </li>
            <?php } ?>
            <li>
                <a class="btn btn-primary margin-top-bottom-3" href="books.php">Books List</a>
            </li>
        </ul>

    </div>

<?php

mysqli_close($conn);
require "./template/footer.php";

?>