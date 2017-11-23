<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in() ?>

<?php
  $current_page["id"] = $_GET["page"];
  if (!$current_page) {
    // ID was missing or invalid or subject couldnt be found in DB
    redirect_to("manage_content.php");
  }
  //echo $_GET["page"];

  $id = $current_page["id"];
  $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION["message"] = "Page deleted.";
    redirect_to("manage_content.php?subject=" . $_SESSION["subject_id"]);
  } else {
    // Failure
    $_SESSION["message"] = "Subject deletion failed.";
    //$_SESSION["error"] = mysqli_error($connection);
    redirect_to("manage_content.php?subject=" . $_SESSION["subject_id"]);
  }

?>
