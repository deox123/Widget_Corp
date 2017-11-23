<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in() ?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php
  if (isset($_POST['submit'])) {
    // Validations

    $required_fields = array("username", "password");
    validate_presence($required_fields);

    $field_with_max_lengths = array("username" => 20);
    validate_max_lengths($field_with_max_lengths);

    if (empty($errors)) {
      $username = mysql_prep($_POST["username"]);
      $password = password_encrypt($_POST["password"]);

      $query  = "INSERT INTO admins ( ";
      $query .= "username, hashed_password ";
      $query .= ") VALUES ( ";
      $query .= " '{$username}', '{$password}' ";
      $query .=")";

      $result = mysqli_query($connection, $query);

      if ($result) {
        // Success
        $_SESSION["message"] = "Admin created.";
        redirect_to("manage_admins.php");
      } else {
        // Failure
        $_SESSION["message"] = "Admin creation failed.";
        $_SESSION["error"] = mysqli_error($connection);
      }
    }
  }
?>
<div id="main">
  <div id="navigation"></div>
    <div id="page">
      <?php //$message is a variable, doesn't use SESSION
        echo message();
      ?>
      <?php echo form_errors($errors); ?>

      <h2>Create New Admin: </h2>

      <form id="new_admin" action="new_admin.php" method="post" />
        <p>Username:
          <input type="text" name="username" value=""  />
        </p>
        <p>Password:
          <input type="password" name="password" value=""  />
        </p>
        <input type="submit" name="submit" value="Create Admin"  />
      </form>
      <br />
      <a href="manage_admins.php">Cancel</a>
    </div>
</div>

  <?php include("../includes/layouts/footer.php"); ?>
