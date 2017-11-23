  <ul class="subjects">
  <?php $subject_set = find_all_subjects(); ?>
  <?php
    while ($subject = mysqli_fetch_assoc($subject_set)) {
  ?>
    <?php
      echo "<li";
      if ($subject["id"] == $selected_subject_id) {
        echo " class=\"selected\"";
      }
      echo ">"
    ?>
      <a href="index.php?subject=<?php echo urlencode($subject["id"]) ?>">
      <?php echo htmlentities($subject["menu_name"]); ?>
      </a>
      <?php
       $page_set = find_pages_for_subject($subject["id"]);
       if ($subject["id"] == $selected_subject_id
            || $current_page["subject_id"] == $subject["id"]) {
      ?>
      <ul class="pages">
        <?php //$page_set = find_pages_for_subject($subject["id"]); ?>
        <?php while ($page = mysqli_fetch_assoc($page_set)) {
            echo "<li";
            if ($page["id"] == $selected_page_id) {
              echo " class=\"selected\"";
            }
            echo ">"
          ?>
              <a href="index.php?page=<?php echo $page["id"] ?>">
                <?php echo $page["menu_name"]; ?>
              </a>
          </li>


          <?php
            }
            mysqli_free_result($page_set);
          echo "</ul>";
          }
          ?>

    </li>
    <?php
  }
   ?>
   <?php mysqli_free_result($subject_set); ?>
  </ul>
