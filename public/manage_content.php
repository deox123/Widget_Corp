<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php confirm_logged_in() ?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

<div id="main">
  <div id="navigation">
    <br  /><a href="admin.php">&laquo; Main menu</a><br  />
    <?php include("../includes/layouts/navigation.php"); ?>
    <br  />
    <a href="new_subject.php">+ Add a subject</a>
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php// echo $_SESSION["error"]; ?>
    <?php
      if ($current_subject) {
        // Subject id for new_page
        $_SESSION["subject_id"] = $current_subject["id"];
    ?>
        <h2>Manage Subject</h2><br />
        Menu name:
        <?php
            echo htmlentities($current_subject["menu_name"]);
        ?> <br  />
        Position: <?php echo $current_subject["position"]; ?> <br  />
        Visible: <?php echo $current_subject["visible"] == 1 ? "Yes" : "No"; ?>
        <br  />
        <br  />
        <a href="edit_subject.php?subject=<?php echo $current_subject["id"]?>">Edit Subject</a>

        <a href="delete_subjects.php?subject=<?php echo $current_subject["id"]?>">Delete subject</a>
        <h2>Pages in this subject:</h2>
          <?php
          $subject_id = urlencode($_GET["subject"]);
          $page_set = find_pages_for_subject($subject_id, false);
          ?>
          <ul>
            <?php while ($page = mysqli_fetch_assoc($page_set)) {
              echo "<li>";
              $safe_page_id = urlencode($page["id"]);
              echo "<a href=\"manage_content.php?page={$safe_page_id}\">";
              echo htmlentities($page["menu_name"]);
              echo "</a></li>";
            } ?>
          </ul>
          <br /><br />
          <a href="new_page.php">+ Add a new page to this subject</a>
        <?php
      } elseif ($current_page) {
    ?>
    <h2>Manage Page</h2><br />
    Page name:
    <?php echo htmlentities($current_page["menu_name"]); ?> <br  />
      Position: <?php echo $current_page["position"]; ?> <br  />
      Visible: <?php echo $current_page["visible"] == 1 ? "Yes" : "No"; ?>
      <br  />
      Content:<br />
      <div class="view-content">
        <?php echo htmlentities($current_page["content"]); ?>
      </div>
      <br  />
      <a href="edit_page.php?page=<?php echo $current_page["id"] ?>">Edit page</a>
      <a href="delete_page.php?page=<?php echo $current_page["id"]?>">Delete page</a>
    <?php
      } else {
    ?>
    <p>Please select a subject or a page</p>
    <?php
      }
    ?>
    <?php //echo $selected_subject_id; ?> <br />
    <?php  //echo $selected_page_id; ?>


  </div>
</div>
<?php

?>
<?php include("../includes/layouts/footer.php"); ?>
