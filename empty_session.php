<?php

session_start();
session_unset();

// redirect to cart.php
// if the user in cart.php clicks the "empty cart" button, then this happens
header("Location: cart.php");


