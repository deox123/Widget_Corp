<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php
  $username = ""; //default value

  if (isset($_POST['submit'])) {
    // Validations

    $required_fields = array("username", "password");
    validate_presence($required_fields);

    if (empty($errors)) {
      // Attemp Login
      $username = $_POST["username"];
      $password = $_POST["password"];
      $found_admin = attempt_login($username, $password);

      if ($found_admin) {
        // Success
        // Mark user as logged in
        $_SESSION["admin_id"] = $found_admin["id"];
        $_SESSION["username"] = $found_admin["username"];
        redirect_to("admin.php");
      } else {
        // Failure
        $_SESSION["message"] = "Username/password not found.";
      }
    }
  }
?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation"></div>
    <div id="page">
      <?php //$message is a variable, doesn't use SESSION
        echo message();
      ?>
      <?php echo form_errors($errors); ?>

      <h2>Login </h2>

      <form action="login.php" method="post" />
        <p>Username:
          <input type="text" name="username" value="<?php echo htmlentities($username);?>"  />
        </p>
        <p>Password:
          <input type="password" name="password" value=""  />
        </p>
        <input type="submit" name="submit" value="Submit"  />
      </form>
    </div>
</div>

  <?php include("../includes/layouts/footer.php");
