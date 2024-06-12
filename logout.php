<?php
session_start();
session_unset();
// DESTROY THE SESSION
session_destroy();
header('Location: bye.php');
exit();