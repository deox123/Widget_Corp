<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in() ?>

<?php
  $admin_id = urlencode($_GET["admin_id"]);
  if (!$admin_id) {
    redirect_to("manage_admins.php");
  }

  if (isset($_POST['submit'])) {
    // Validations

    $required_fields = array("username", "password");
    validate_presence($required_fields);

    $field_with_max_lengths = array("username" => 20);
    validate_max_lengths($field_with_max_lengths);

    if (empty($errors)) {
      $username = mysql_prep($_POST["username"]);
      $password = password_encrypt($_POST["password"]);

      $query  = "UPDATE admins SET ";
      $query .= "username = '{$username}', ";
      $query .= "hashed_password = '{$password}' ";
      $query .= "WHERE id = {$admin_id} ";
      $query .= "LIMIT 1";
      $result = mysqli_query($connection, $query);

      if ($result && mysqli_affected_rows($connection) >= 0) {
        // Success
        $_SESSION["message"] = "Admin updated.";
        redirect_to("manage_admins.php");
      } else {
        // Failure
        $_SESSION["message"] = "Admin update failed.";
        $_SESSION["error"] = mysqli_error($connection);
      }
    }
  }
?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php $admin = find_admin_by_id($admin_id) ?>


<div id="main">
  <div id="navigation"></div>
    <div id="page">
      <?php //$message is a variable, doesn't use SESSION
        echo message();
        if (isset($_SESSION["error"])) {
          $output  = "<div class=\"message\">";
          $output  .= htmlentities($_SESSION["error"]);
          $output  .= "</div>";
          $_SESSION["error"] = null;
          echo $output;
        }
      ?>
      <?php echo form_errors($errors); ?>

      <h2>Edit Admin: <?php echo $admin["username"]; ?></h2>

      <form action="edit_admins.php?admin_id=<?php echo $admin["id"];?>" method="post" />
        <p>Username:
          <input type="text" name="username" value="<?php echo $admin["username"];?>"  />
        </p>
        <p>Password:
          <input type="password" name="password" value=""  />
        </p>
        <input type="submit" name="submit" value="Edit Admin"  />
      </form>
      <br />
      <a href="manage_admins.php">Cancel</a>
    </div>
</div>

  <?php include("../includes/layouts/footer.php"); ?>
