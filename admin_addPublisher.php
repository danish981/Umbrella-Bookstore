<?php

$title = "Add Publisher";
require_once("template/header.php");
require_once("functions/database_functions.php");

$conn = db_connect();

$isAdded = false;
$publisherName = "";
$matchFound = false;

if (isset($_POST["submit"])) {
    $publisherName = mysqli_real_escape_string($conn, $_POST["publisher_name"]);
    $findQuery = "SELECT publisher_name FROM publisher";
    $queryResult = mysqli_query($conn, $findQuery);
    while ($row = mysqli_fetch_assoc($queryResult)) {
        if (strtolower($publisherName) === strtolower($row["publisher_name"])) {
            $matchFound = true;
            break;
        }
    }
    if ($matchFound == false) {
        $publisherName = ucwords($publisherName);
        $insertPublisher = "INSERT INTO publisher(publisher_name) values('$publisherName')";
        $isAdded = mysqli_query($conn, $insertPublisher);
    }
}

if ($isAdded) {
    echo "<h2 class='text-center text-capitalize big-font-3'>Publisher \"{$publisherName}\" Added Successfully</h2><br><br><hr>";
}
if ($matchFound) {
    echo "<h2 class='text-warning text-center text-capitalize big-font-3'>Publisher \"{$publisherName}\" Already Exists</h2><br><br><hr>";
}
?>

    <form action="admin_addPublisher.php" class="form-horizontal" autocomplete="off" method="post">

        <div class="form-group">
            <label for="publisher_name" class="control-label col-md-4">Publisher Name</label>
            <div class="col-md-4">
                <input type="text" id="publisher_name" class="form-control" name="publisher_name"
                       placeholder="Rowan Atkinsen e.g" required>
            </div>
            <input type="submit" name="submit" value="Add Publisher" class="btn btn-primary">
        </div>

    </form>


<?php include("template/footer.php") ?>
