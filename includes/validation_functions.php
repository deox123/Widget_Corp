<?php

$errors = array();

function fieldnamse_as_text($fieldname) {
  $fieldname = str_replace("_", " ", $fieldname);
  $fieldname = ucfirst($fieldname);
  return $fieldname;
}

function has_presence($value) {
  return isset($value) && $value !== "";
}

function validate_presence($required_fields) {
  global $errors;
  foreach ($required_fields as $field) {
    $value = trim($_POST[$field]);
    if (!has_presence($value)) {
      $errors[$field] = fieldnamse_as_text($field) . " can't be blank";
    }
  }
}

function has_max_length($value, $max) {
  return strlen($value) <= $max;
}

function validate_max_lengths($field_with_max_lengths) {
  global $errors;
  // Expects an assoc. array
  foreach ($field_with_max_lengths as $field => $max) {
    $value = trim($_POST[$field]);
    if (!has_max_length($value, $max)) {
      $errors[$field] = fieldnamse_as_text($field) . " is too long.";
    }
  }
}

function has_inclusion_in($value, $set) {
  return in_array($value, $set);
}

/*
function form_errors($errors = array()){
  $output = "";
  if (!empty($errors)) {
    $output .= "<div name=\"error\">";
    $output .= "Please fix the following errors: ";
    $output .= "<ul>";
    foreach ($errors as $key => $error) {
      $output .= "<li>{$error}</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}
*/
?>
