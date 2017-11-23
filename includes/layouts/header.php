<?php if (!isset($leyout_context)) {
  $leyout_context = "public";
}
?>
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget Corp <?php if ($leyout_context == "admin") {echo "Admin";} ?></title>
    <link href="css/responsive2.css" media="all" rel="stylesheet" type="text/css"  />
  </head>
  <body>
    <div id="header">
      <h1>Widget Corp <?php if ($leyout_context == "admin") {echo "- Admin";} ?></h1>
    </div>
