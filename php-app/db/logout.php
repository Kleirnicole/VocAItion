<?php
session_start();
$_SESSION = array(); // Clear all session variables
session_destroy();

// Redirect to the main index.php outside the db folder
header("Location: ../index.php");
exit;
?>
