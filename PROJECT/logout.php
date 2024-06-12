<?php
session_start();
session_unset();
// DESTROY THE SESSION
session_destroy();
header('Location: index.php');
exit();
?>
