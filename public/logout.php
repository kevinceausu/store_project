<?php
session_start();
session_unset();      // Remove all session variables
session_destroy();    // Destroy the session

header("Location: router.php?controller=auth&action=login");

exit;
?>
