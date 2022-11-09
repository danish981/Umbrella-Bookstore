<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- link proper font here, like signica, offline font -->
    <!--    <link rel="stylesheet" href="./bootstrap/css/bootstrap/signica-light.ttf">-->
    <!--    <link rel="stylesheet" href="./bootstrap/css/bootstrap/signica-bold.ttf">-->
    <!--    <link rel="stylesheet" href="./bootstrap/css/bootstrap/signica-regular.ttf">-->
    <!--    <link rel="stylesheet" href="./bootstrap/css/bootstrap/signica-semibold.ttf">-->

    <link rel="stylesheet" href="./assets/css/bootstrap/montserrat-regular.ttf">

    <!-- this title variable is written before the page executed -->
    <title><?php echo $title ?? 'Umbrella Bookstore'; ?></title>

    <link rel="shortcut icon" type="image/jpg" href="./assets/img/favicon.png"/>

    <!-- enable these links when in production -->
    <!--            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <!--            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    <!--            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->
    <!--            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
    <!---->

    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <!--    <link href="./bootstrap/css/bootstrap4.min.css" rel="stylesheet">-->

    <!--    <link href="./bootstrap/js/popper.min.js" rel="stylesheet">-->
    <!--    <link href="./bootstrap/js/jquery.min.js" rel="stylesheet">-->
    <!--    <link href="./bootstrap/js/bootstrap.min.js" rel="stylesheet">-->

    <link href="./assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="./assets/css/jumbotron.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Umbrella Bookstore</a>
        </div>

        <!--/.navbar-collapse -->
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- link to publiser_list.php -->
                <li><a href="publisher_list.php"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;
                        Publishers</a>
                </li>
                <!-- link to books.php -->
                <li><a href="books.php"><span class="glyphicon glyphicon-book"></span>&nbsp; Books</a></li>
                <!-- link to contacts.php -->
                <li><a href="contact.php"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp; Contact</a></li>
                <!-- link to shopping cart -->
                <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp; My Cart</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php
if (isset($title) && $title == "Index") {
    ?>

    <div class="container text-center text-info front-bg" style="background-color: rgba(46, 109, 77, 0.05);">
        <h1 class="heading-hover py-2">Welcome to Umbrella Bookstore</h1>
        <p class="lead">We have a huge collection of programming books for beginners and professionals</p>
        <p>The layout use Bootstrap to make it more responsive. It's just a simple web!</p>
    </div>

<?php } ?>

<div class="container" id="main">