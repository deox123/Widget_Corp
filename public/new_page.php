<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in() ?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

<?php
  $subject_id = (int) $_SESSION["subject_id"];
  $subject = find_subject_by_id($subject_id);

  // if GET request
  if (!$subject_id) {
    redirect_to("manage_content.php");
  }

if (isset($_POST['submit'])) {
  // process the form
  $menu_name = mysql_prep($_POST["menu_name"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);
  //$subject_id is defined already

  // Validations

  $required_fields = array("menu_name", "position", "visible");
  validate_presence($required_fields);

  $field_with_max_lengths = array("menu_name" => 30);
  validate_max_lengths($field_with_max_lengths);

  if (empty($errors)) {
    $query  = "INSERT INTO pages ( ";
    $query .= "menu_name, position, visible, subject_id, content ";
    $query .= ") VALUES ( ";
    $query .= " '{$menu_name}', {$position}, {$visible}, {$subject_id}, '{$content}' ";
    $query .=")";

    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Page created.";
      redirect_to("manage_content.php?subject=" . $subject_id);
    } else {
      // Failure
      $_SESSION["message"] = "Page creation failed.";
      $_SESSION["error"] = mysqli_error($connection);
    }
  }
}
?>
<div id="main">
  <div id="navigation">
    <br /><br />
    <?php include("../includes/layouts/navigation.php"); ?>
  </div>

  <div id="page">
    <?php //$message is a variable, doesn't use SESSION
    echo $subject["id"];
      if (!empty($_SESSION["message"])) {
        echo "<div class=\"message\">" . htmlentities($message) . "</div>";
      }
     ?>
     <?php echo form_errors($errors); ?>

    <h2>Create Page for subject: <?php
    $subject = find_subject_by_id($subject_id);
    echo ($subject["menu_name"]);?></h2>
    <form id="new_page" action="new_page.php" method="post" />
      <p>Page name:
        <input type="text" name="menu_name" value=""  />
      </p>

      <p>Position:
        <select name="position">
          <?php
          $page_set = find_pages_for_subject($subject_id, false);
          $page_count = mysqli_num_rows($page_set);
          for ($count=1; $count <= ($page_count + 1) ; $count++) {
            echo "<option value=\"{$count}\">{$count}</option>";
          }
          ?>
          </select>
      </p>

      <p>Visible
        <input type="radio" name="visible" value="0"  /> No
        <input type="radio" name="visible" value="1"  /> Yes
      </p>
      <textarea name="content" form="new_page" cols="50" rows="4">Content...</textarea>
      <br  />
      <input type="submit" name="submit" value="Create Page"  />
    </form>
    <br />
    <a href="manage_content.php?subject=<?php echo $subject_id?>">Cancel</a>
  </div>
</div>

  <?php include("../includes/layouts/footer.php"); ?>
