<?php

$conn = mysqli_connect("localhost", "root", "", "uploads");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
