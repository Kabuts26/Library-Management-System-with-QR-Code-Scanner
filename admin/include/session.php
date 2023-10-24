<?php 
session_start();
if (!isset($_SESSION['id'])){
header('location:home.php');
}
$id_session=$_SESSION['id'];
?>