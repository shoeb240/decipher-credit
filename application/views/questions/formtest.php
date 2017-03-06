<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body {
  background: lightgrey;
  font-family: sans-serif;
}
#rendered-form{
  width:40%;
float:left;
}
.form-wrap{
  float:right;
  width:60%;
}
</style>
<title>Example formBuilder</title>
<link rel="stylesheet" type="text/css" media="screen" href="http://formbuilder.online/assets/css/form-builder.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
   <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  

  <script>

  function easy(){

  }


  jQuery(document).ready(function($) {
	  var fbTemplate = document.getElementById('fb-template'),
	    renderedContainer = document.getElementById('rendered-form');
	  $(fbTemplate).formBuilder();

	  $(fbTemplate).bind("change", function(e) {
	    $(fbTemplate).formRender({
	      container: renderedContainer
	    });
	    
	  });
	  
	});

function setHTML()
{

	renderedContainer = document.getElementById('rendered-form');	
	$("#content").val(renderedContainer.innerHTML);

	alert($("#content").val());
	
}
	
  </script>

</head>
<body>
<?php echo validation_errors(); ?>
<?php echo form_open('questions/create'); ?>
<input type="hidden" id="content" name ="content"/>

    <label for="des">Question Label</label>
    <input type="text" name="des" /><br />

    <label for="type">type</label>
    <input name="type"></input><br />

    <label for="weight">weight</label>
    <input name="weight"></input><br />

<textarea id="fb-template"></textarea>


<div id="rendered-form">
  
  <button class="btn btn-default edit-form">Edit</button>
</div>

    <label for="outputType">outputType</label>
    <input name="outputType"></input><br />


    <label for="status">status</label>
    <input name="status"></input><br />

    <input type="submit" name="submit" value="Create question item" onclick="setHTML()" />

</form>

</body>
</html>
