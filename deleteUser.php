<?php
session_start();
include "config.php";

// functions to validate the input
if( isset( $_SESSION['counter'])) 
{
    $_SESSION['counter'] += 1;
}
else {
    $_SESSION['counter'] = 1;
}

$id = $POST['profileID'];


$sql = mysqli_query($con,"DELETE FROM userprofile WHERE id= $id");

header("Location:index.php");

?>