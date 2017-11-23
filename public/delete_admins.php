<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
  $admin_id = urlencode($_GET["admin_id"]);;
  if (!$admin_id) {
    // ID was missing or invalid or subject couldnt be found in DB
    redirect_to("manage_admins.php");
  }
  $query = "DELETE FROM admins WHERE id = {$admin_id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION["message"] = "Admin deleted.";
    redirect_to("manage_admins.php");
  } else {
    // Failure
    $_SESSION["message"] = "Admin deletion failed.";
    //$_SESSION["error"] = mysqli_error($connection);
    redirect_to("manage_admins.php");
  }

?>
