<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php
$_SESSION["User_ID"]=null;
$_SESSION["Username"]=null;
$_SESSION["AdminName"]=null;
session_destroy();
Redirect_to("Login.php");
?>
