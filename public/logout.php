<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
  // v1: simple logout
  $_SESSION["admin_id"] = null;
  $_SESSION["username"] = null;
  redirect_to("login.php");
?>


<?php include("../includes/layouts/header.php"); ?>
<?php include("../includes/layouts/footer.php"); ?>
