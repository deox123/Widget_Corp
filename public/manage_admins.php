<?php ob_start(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php confirm_logged_in() ?>

<?php $leyout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
    <br />
    <a href="admin.php">&laquo; Main menu</a>
    <br  />
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo mysqli_error($connection); ?>
    <?php// echo $_SESSION["error"]; ?>

    <h2>Manage Admins</h2><br />
    <table>
      <tr>
        <th style="text-align: left; width: 200px;">Username</th>
        <th colspan="2" style="text-align: left;">Action</th>
      </tr>
      <?php
        $admin_set = find_all_admins();
        while ($admin = mysqli_fetch_assoc($admin_set)) {
      ?>
          <tr>
            <th style="text-align: left;"><?php echo $admin["username"];?></th>
            <th><a href="edit_admins.php?admin_id=<?php echo $admin["id"] ?>">Edit</a></th>
            <th><a href="delete_admins.php?admin_id=<?php echo $admin["id"] ?>">Delete</a></th>
          </tr>
      <?php
        }
      ?>
    </table>
    <br /><br />
    <a href="new_admin.php">+ Add new admin</a>
    <hr />
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
