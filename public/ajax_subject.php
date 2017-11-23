<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php

global $connection;

$query  = "SELECT * ";
$query .= "FROM subjects ";
$query .= "ORDER BY position ASC ";
$subject_set = mysqli_query($connection, $query);
//confirm_query($subject_set);
/*
$arr = [];
while ($subject = mysqli_fetch_assoc($subject_set)) {
  $arr[] = htmlentities($subject["menu_name"]);

}
echo json_encode($arr);
*/
//echo $subject_set;
while($result = mysqli_fetch_assoc($subject_set)) {
  $real_result[] = $result;
}
echo json_encode($real_result);

?>
