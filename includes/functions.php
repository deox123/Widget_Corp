<?php
function redirect_to($new_location) {
  header ("Location: " . $new_location);
  exit;
}

function mysql_prep($string) {
  global $connection;

  $escaped_string = mysqli_real_escape_string($connection, $string);
  return $escaped_string;
}

function confirm_query($result_set) {
  if (!$result_set) {
    die("Database query failed.");
  }
}

function form_errors($errors = array()) {
  $output = "";
  if (!empty($errors)) {
    $output .= "<div class=\"error\">";
    $output .= "Please fix the following errors:";
    $output .="<ul>";
    foreach ($errors as $key => $error) {
      $output .= "<li>";
      $output .= htmlentities($error);
      $output .= "</li>";
    }
    $output .="</ul>";
    $output .= "</div>";
  }
  return $output;
}

function find_all_subjects($public = true) {
     global $connection;

     $query  = "SELECT * ";
     $query .= "FROM subjects ";
     if ($public) {
       $query .= "WHERE visible = 1 ";
     }
     $query .= "ORDER BY position ASC";
     $subject_set = mysqli_query($connection, $query);
     confirm_query($subject_set);
     return $subject_set;
}

function find_all_admins() {
  global $connection;

  $query  = "SELECT * ";
  $query .= "FROM admins ";
  $query .= "ORDER BY username ASC";
  $admin_set = mysqli_query($connection, $query);
  confirm_query($admin_set);
  return $admin_set;
}

function find_pages_for_subject($subject_id, $public = true) {
  global $connection;

  $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

  $query  = "SELECT * ";
  $query .= "FROM pages ";
  $query .= "WHERE subject_id = {$safe_subject_id} ";
  if ($public) {
    $query .= "AND visible = 1 ";
  }
  $query .= "ORDER BY position ASC";
  $page_set = mysqli_query($connection, $query);
  confirm_query($page_set);
  return $page_set;
}

function find_subject_by_id($subject_id) {
  global $connection;

  $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

  $query  = "SELECT * ";
  $query .= "FROM subjects ";
  $query .= "WHERE id = {$safe_subject_id} ";
  $query .= "LIMIT 1";
  $subject_set = mysqli_query($connection, $query);
  confirm_query($subject_set);
  if ($subject = mysqli_fetch_assoc($subject_set)){
    return $subject;
  } else {
    return null;
  }
}

function find_admin_by_id($admin_id) {
  global $connection;

  $safe_admin_id = mysqli_real_escape_string($connection, $admin_id);

  $query  = "SELECT * ";
  $query .= "FROM admins ";
  $query .= "WHERE id = {$safe_admin_id} ";
  $query .= "LIMIT 1";
  $admin_set = mysqli_query($connection, $query);
  confirm_query($admin_set);
  if ($admin = mysqli_fetch_assoc($admin_set)){
    return $admin;
  } else {
    return null;
  }
}

function find_admin_by_username($username) {
  global $connection;

  $safe_username = mysqli_real_escape_string($connection, $username);

  $query  = "SELECT * ";
  $query .= "FROM admins ";
  $query .= "WHERE username = '{$username}' ";
  $query .= "LIMIT 1";
  $admin_set = mysqli_query($connection, $query);
  confirm_query($admin_set);
  if ($admin = mysqli_fetch_assoc($admin_set)){
    return $admin;
  } else {
    return null;
  }
}

/*
function find_default_page_for_subject($subject_id) {
  $first_page = null;
  $page_set = find_pages_for_subject($subject_id);
  if ($first_page == mysqli_fetch_row($page_set)) {
    return $first_page;
  } else {
    return null;
  }
}
*/

function find_selected_page() {
  global $selected_subject_id;
  global $selected_page_id;
  global $current_subject;
  global $current_page;

  if (isset($_GET["subject"])) {
    $selected_subject_id = $_GET["subject"];
    $current_subject = find_subject_by_id($selected_subject_id);
    $selected_page_id = null;
    $current_page = null;
  } elseif (isset($_GET["page"])) {
    $selected_subject_id = null;
    $current_subject = null;
    $selected_page_id = $_GET["page"];
    $current_page = find_page_by_id($selected_page_id);
  } else {
    $selected_subject_id = null;
    $current_subject = null;
    $selected_page_id = null;
    $current_page = null;
  }
}

function find_page_by_id($page_id) {
  global $connection;

  $safe_page_id = mysqli_real_escape_string($connection, $page_id);

  $query  = "SELECT * ";
  $query .= "FROM pages ";
  $query .= "WHERE id = {$safe_page_id} ";
  $query .= "LIMIT 1";
  $page_set = mysqli_query($connection, $query);
  confirm_query($page_set);
  if ($page = mysqli_fetch_assoc($page_set)){
    return $page;
  } else {
    return null;
  }
}

function password_encrypt($password) {
  $hash_format = "$2y$10$"; //Use blowfish with a 'cost' of 10
  $salt_length = 22; // Blowfish salt should be 22 or MessageFormatter
  $salt = generate_salt($salt_length);
  $format_and_salt = $hash_format . $salt;
  $hash = crypt($password, $format_and_salt);
  return $hash;
}

function generate_salt($length) {
  // Not 100% unique nor 100$ random, but good enough
  //MD5 returns 32 characters
  $unique_random_string = md5(uniqid(mt_rand(), true));

  // Volid characters for a salt are [a-zA-Z0-9./]
  $base64_string = base64_encode($unique_random_string);

  //But not '+' wich is valid in base64 encoding
  $modified_base64_string = str_replace('+', '.', $base64_string);

  // String to the correct Length
  $salt = substr($modified_base64_string, 0, $length);

  return $salt;
}

function password_check($password, $existing_hash) {
  $hash = crypt($password, $existing_hash);
  if ($hash == $existing_hash) {
    return true;
  } else {
    return false;
  }
}

function attempt_login($username, $password) {
  $admin = find_admin_by_username($username);
  if ($admin) {
    // found admin, now check password
    if (password_check($password, $admin["hashed_password"])) {
      return $admin;
    } else {
      return false;
    }
  } else {
    // admin not found
    return false;
  }
}

function logged_in() {
  return isset($_SESSION["admin_id"]);
}

function confirm_logged_in() {
  if (!logged_in()) {
    redirect_to("login.php");
  }
}
?>
