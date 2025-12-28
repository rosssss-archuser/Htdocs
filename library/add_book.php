<?php
include "db.php";

$title = $_POST['title'];
$author = $_POST['author'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];

$sql = "INSERT INTO books VALUES (NULL, '$title', '$author', '$category', '$quantity')";
mysqli_query($conn, $sql);

header("Location: index.php");
?>
