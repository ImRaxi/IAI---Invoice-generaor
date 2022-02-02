<?php 

include "db_connect.php";

$conn = OpenCon();

$delId = $_POST['delid'];


//USUWANIE FAKTURY
$sql = "DELETE FROM `fv` WHERE id = '$delId'";
$conn->query($sql);


header("Location: /lista.php");

$conn->close();

?>