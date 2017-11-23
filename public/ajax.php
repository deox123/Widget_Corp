<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>


<div id="main">
  <div id="navigation">
    <?php include("../includes/layouts/navigation.php"); ?>
  </div>
  <div id="page">

    <form id="ajax" action="ajax_subject.php" method="get">
      <br />
      <input id="ajax-submit" type="button" value="Ajax Submit" />
    </form>

    <div id="result">

    </div>

  </div>
</div>

<script>

  var result_div = document.getElementById("result");
  var button = document.getElementById("ajax-submit");


  function suggestionsToList(items) {
    //<li><a href="manage_content.php?page=1">Alpha</a></li>
    var output = '';

    for(i = 0; i < items.length; i++) {
      output += '<li>';
      output += '<a href="manage_content.php?page=' + items[i]['id'] + '">';
      output += items[i]['menu_name'];
      output += '</a>';
      output += '</li>';
    }
    return output;
  }

  function showSuggestions(json) {
    var li_list = suggestionsToList(json);
    result_div.innerHTML = li_list;
    result_div.style.display = 'block';
  }

  function calculateMeasurements() {

    var form = document.getElementById("ajax");
    var action = form.getAttribute("action");

    var xhr = new XMLHttpRequest();
    xhr.open('GET', action, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if(xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
        console.log('Result: ' + result);

        var json = JSON.parse(result);
        showSuggestions(json);


      }
    };
    xhr.send();
  }

  button.addEventListener("click", calculateMeasurements);

</script>




<?php include("../includes/layouts/footer.php"); ?>
