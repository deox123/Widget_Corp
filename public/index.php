<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

<div id="main">
  <div id="navigation">
    <?php include("../includes/layouts/public_navigation.php"); ?>
  </div>
  <div id="page">
    <?php
      if ($current_subject && $current_subject["visible"] == 1) {
    ?>
        <h2><?php echo htmlentities($current_subject["menu_name"]); ?></h2><br />
          <?php
          $subject_id = urlencode($_GET["subject"]);
          $page_set = find_pages_for_subject($subject_id);
          ?>
          <ul>
            <?php while ($page = mysqli_fetch_assoc($page_set)) {
              echo "<li>";
              $safe_page_id = urlencode($page["id"]);
              echo "<a href=\"index.php?page={$safe_page_id}\">";
              echo htmlentities($page["menu_name"]);
              echo "</a></li>";
            } ?>
          </ul>
        <br  />
    <?php
      } elseif ($current_page && $current_page["visible"] == 1 ) {
    ?>
        <h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
        <br />
        <?php echo nl2br(htmlentities($current_page["content"])); ?>
    <?php
      } else {
    ?>
    <h2>Welcome</h2>
    <br />
    <p>Please select a subject</p>
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
