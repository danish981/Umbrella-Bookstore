<?php

// destory the session 
session_start();
session_destroy();

// and redirect the user to the index / home page
header("Location: index.php");
