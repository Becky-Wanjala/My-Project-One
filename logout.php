<?php
// logout.php

// Destroy the session and redirect to index.php
session_start();
session_destroy();
header("Location: index.php");
exit;
?>
