<?php
session_start();

if (isset($_SESSION['redirect_url'])) {
    $redirect_url = $_SESSION['redirect_url'];

    //REMOVE URL FROM SESSION
    unset($_SESSION['redirect_url']);
    header("Location: $redirect_url");
    exit();
} 
else 
{
    // IF THERE IS NO STORED URL, REDIRECT TO HOMEPAGE
    header("Location: login.php");
    exit();
}

