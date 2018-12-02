<?php
session_start(); 
if(!isset($_SESSION['name']) || empty($_SESSION['name']) || $_SESSION['utype'] != 0) {
   header('Location: index.php');
}
?>
