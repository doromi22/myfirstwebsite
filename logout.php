<?php
session_start();

session_destroy();

// logout and redirect to index file
echo '<script>alert("logged out successfully."); window.location.href = "index.php";</script>';
exit();
?>