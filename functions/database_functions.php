<?php

require("config.php");

/**
 * @return mysqli Connection variable to establish connection with the project database
 */
function db_connect(): mysqli {
    // when using offline, try with this line
    $conn = mysqli_connect("localhost", "root", "", "bookstore");

    //    $conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        echo "Error communicating with databae | Try after a while | " . mysqli_connect_error();
        exit;
    }
    return $conn;
}

/**
 * @param $conn mysqli connection variable
 * @param int $count number of books to be shown on index/home page, default value is 4
 * @return array of latest books with ISBN and image
 */
function selectLatestBooks($conn, int $count = 4): array {
    $row = [];
    // $query = "SELECT book_isbn, book_image FROM books ORDER BY book_isbn DESC";      
    $query = "SELECT book_isbn, book_image FROM books ORDER BY RAND()";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Cannot Fetch the books from the store | Try after a while when developers fix this | " . mysqli_error($conn);
        exit;
    }
    for ($i = 0; $i < $count; $i++) {
        array_push($row, mysqli_fetch_assoc($result));
        // $row[] = mysqli_fetch_assoc($result);    // another approach
    }
    return $row;
}

/**
 * @param $conn mysqli connection variable with established connection
 * @param $isbn
 * @return bool|mysqli_result returns title, author and price of the book , false otherwise
 */
function getBookByIsbn($conn, $isbn) {
    $query = "SELECT book_title, book_author, book_price FROM books WHERE book_isbn = '$isbn'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Can't retrieve data " . mysqli_error($conn);
        exit;
    }
    return $result;
}

function getOrderId($conn, $customerid) {
    $query = "SELECT orderid FROM orders WHERE customerid = '$customerid'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error Fetching book data from the database | try after a while | thanks | " . mysqli_error($conn);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['orderid'];
}

function insertIntoOrder(
    $conn,
    $customerid,
    $total_price,
    $date,
    $ship_name,
    $ship_address,
    $ship_city,
    $ship_zip_code,
    $ship_country) {
    $query = "INSERT INTO orders VALUES (
              '', 
              '{$customerid}', 
              '{$total_price}', 
              '{$date}', 
              '{$ship_name}', 
              '{$ship_address}', 
              '{$ship_city}', 
              '{$ship_zip_code}', 
              '{$ship_country}')";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error Inserting Customer shipment data into database | Try after a while |  " . mysqli_error($conn);
        exit;
    }
}

function getbookprice($isbn) {
    $conn = db_connect();
    $query = "SELECT book_price FROM books WHERE book_isbn = '$isbn'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error Fetching book price from the database | try again " . mysqli_error($conn);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['book_price'];
}

function getCustomerId($name, $address, $city, $zip_code, $country) {
    $conn = db_connect();
    $query = "SELECT customerid from customers WHERE 
		name = '$name' AND 
		address= '$address' AND 
		city = '$city' AND 
		zip_code = '$zip_code' AND 
		country = '$country'";
    $result = mysqli_query($conn, $query);
    // if there is customer in db, take it out
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['customerid'];
    }
    return NULL;
}

function setCustomerId($name, $address, $city, $zip_code, $country, $email) {
    $conn = db_connect();
    $query = "INSERT INTO customers VALUES 
			('$name', '$address', '$city', '$zip_code', '$country', '$email')";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error Customer Registration | Try after a while plz " . mysqli_error($conn);
        exit;
    }
    return mysqli_insert_id($conn);
}

/**
 * gets the publisher name from the database and prints error message and close the script
 * if no error found
 * @param $conn mysqli connection variable with established connection
 * @param $pubid int publisher id, the int type id matching inside the huge DB-table
 * @return mixed returns array if query is successful and publishers found, if query is unsuccessful then
 * generates error and terminates script, and if no records found the displays error and terminates the
 * script
 */
function getPubName($conn, $pubid) {
    $query = "SELECT publisher_name FROM publisher WHERE publisherid = '$pubid'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Cannot get the Publisher Name from the database " . mysqli_error($conn);
        exit;
    }
    // publisher id is not found, that means the publisher does not exist in the database
    if (mysqli_num_rows($result) === 0) {
        echo "No Books Found | Try after a while when publisher adds some books into his store stock";
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['publisher_name'];
}

// create publisher method here , when adding a book , if the publisher not found,
// create a new publisher, or create a drop down there of publisher, good idea here

/**
 * @param $conn Mysqli database connection variable
 * @return $publisherName associative array of publishers list
 */
function listPublishers($conn) {
    $query = "SELECT publisher_name FROM publisher";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Publishers List Blank | No Publishers found in the store backend";
        exit();
    }
    $row = mysqli_fetch_assoc($result);
    return $row["publisher_name"];
}

/**
 * @param $conn mysqli connection variable with established connection
 * @return bool|mysqli_result all the latest books ordered by ISBN
 */
function getAll($conn) {
    $query = "SELECT * from books ORDER BY book_isbn DESC";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error fetching book details from the database | Try aftr a while when developer fixes it | " . mysqli_error($conn);
        exit;
    }
    return $result;
}

/**
 * @param array $array the array to be printed with proper formatting
 */
function printFormattedArray(array $array): void {
    echo "<br><pre>";
    print_r($array);
    echo "</pre>";
}

function getRandomNumArray(int $arrayLength = 20, int $lowerLimit = 10, int $upperLimit = 90): array {
    $arrayLength = abs($arrayLength);
    $randomArray = [];
    for ($i = 0; $i < $arrayLength; $i++) {
        $randomArray[] = random_int($lowerLimit, $upperLimit);
    }
    return $randomArray;
}

/**
 * @param array $array the array to be printed with proper formatting then die | to check the code
 */
function printFormattedArray_die(array $array): void {
    echo "<br><pre>";
    print_r($array);
    echo "</pre>";
    die();
}

/**
 * @param $object Object to displayed and its data
 */
function showObject($object): void {
    echo "<br><pre>";
    print_r($object);
    echo "</pre>";
}
