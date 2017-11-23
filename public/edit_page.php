<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in() ?>

<?php find_selected_page(); ?>
<?php
  $subject_id = (int) $current_page["subject_id"];

  //$subject_id = (int) $_SESSION["subject_id"];
  //$_SESSION["subject_id"] = null;
  // if GET request
  if (!$subject_id) {
    redirect_to("manage_content.php");
  }
?>

<?php
  if (!$current_page) {
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Validations
  $required_fields = array("menu_name", "position", "visible");
  validate_presence($required_fields);

  $field_with_max_lengths = array("menu_name" => 30);
  validate_max_lengths($field_with_max_lengths);

  if (empty($errors)) {
    // Perform update

    $id = $current_page["id"];
    $menu_name = mysql_prep($_POST["menu_name"]);
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];
    $content = ($_POST["content"]);

    // Perform database query
    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) >= 0) {
      // Success
      $_SESSION["message"] = "Subject updated.";
      redirect_to("manage_content.php?page=" . $current_page["id"]);
    } else {
      // Failure
      $message = "Subject update failed." . mysqli_error($connection) . $content;
    }
  }
}
?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
    <?php include("../includes/layouts/navigation.php"); ?>
  </div>
  <div id="page">
    <?php //$message is a variable, doesn't use SESSION
      if (!empty($message)) {
        echo "<div class=\"message\">" . htmlentities($message) . "</div>";
      }
     ?>
     <?php echo form_errors($errors);

     ?>

    <h2>Edit Subject: <?php echo htmlentities($current_page["menu_name"]); ?></h2>

    <form id="edit_page" action="edit_page.php?page=
      <?php echo urlencode($current_page["id"]);?>" method="post" />
    <p>Subject name:
      <input type="text" name="menu_name"
      value="<?php echo htmlentities($current_page["menu_name"]); ?>"  />
    </p>
    <p>Position:
      <select name="position">
        <?php
        $page_set = find_pages_for_subject($subject_id, false);
        $page_count = mysqli_num_rows($page_set);
        for ($count = 1; $count <= $page_count ; $count ++) {
          echo "<option value=\"{$count}\"";
          if ($current_page["position"] == $count) {
            echo "selected";
          }
          echo ">{$count}</option>";
        }
        ?>
        </select>
    </p>
    <p>Visible
      <input type="radio" name="visible" value="0"
      <?php if ($current_page["visible"] == 0) {echo "checked";} ?> /> No
      <input type="radio" name="visible" value="1"
      <?php if ($current_page["visible"] == 1) {echo "checked";} ?> /> Yes
    </p>
    <textarea name="content" form="edit_page" cols="50" rows="4">
      <?php echo htmlentities($current_page["content"]); ?></textarea>
    <br  />
    <input type="submit" name="submit" value="Edit Page"  />
    </form>
    <br />
    <a href="manage_content.php?page="<?php echo urlencode($current_page["id"]);?>>Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_page.php?page=
    <?php echo urlencode($current_page["id"])?>">Delete subject</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
