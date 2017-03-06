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
    </style>
    <title>Create Question</title>
    <link rel="stylesheet" type="text/css" media="screen" href="http://formbuilder.online/assets/css/form-builder.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  

    <script>

    function easy(){

    }


    var options = {
                prepend: '<span class="well well-sm"> Drag and drop controls to create question.</span>  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#prevModal">Preview</button>',
                controlPosition: 'left'

              };


    jQuery(document).ready(function($) {
            var fbTemplate = document.getElementById('fb-template'),
              renderedContainer = document.getElementById('rendered-form');
            $(fbTemplate).formBuilder(options);

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
            return true;

    }

    </script>

</head>
<body>

<div class="container">


    <?php echo validation_errors(); ?>

    <div class="row">
        <div class="col-md-12">
        <?php echo form_open('questions/create'); ?>
        <input type="hidden" id="content" name ="content"/>

        <div class="container">

            <div class="row">

                <div class="col-md-3">
                   <div class="form-group">
                   <input type="text"  name="des" id="des" class="form-control" placeholder="Question Label" required />
                   </div>
                </div>

                <div class="col-md-3">
                   <div class="form-group">   
                   <input type="text" name="type" id="type" class="form-control"  placeholder="Type"  />
                   </div>
                </div>

                <div class="col-md-3"> 
                    <div class="form-group"> 
                    <input type="text" name="weight" class="form-control"  placeholder="Weight"  />
                    </div> 
                </div>
            </div>



            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                    <!-- <input type="text" name="outputType" class="form-control"  placeholder="Output Type" /> -->
                        <select name="outputType" class="form-control">
                            <?php foreach($output_types as $each):?>
                            <option value="<?php echo $each['id'];?>"><?php echo $each['description'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                    <!-- <input type="text" name="status" class="form-control"  placeholder="Status" /> -->
                    <select name="status" class="form-control">
                        <?php foreach($statuses as $each):?>
                        <option value="<?php echo $each['ID'];?>"><?php echo $each['Description'];?></option>
                        <?php endforeach;?>
                    </select>   
                    </div>
                </div>
            
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea name="parameters" class="form-control"  placeholder="Parameters"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <textarea id="fb-template"></textarea>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 pull-right">
                <input type="submit" name="submit" class="btn btn-primary " value="Create question item" onclick="return setHTML()" />
                </div>
            </div>

        </div>    
        </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="prevModal">  

    <div class="container">
        <div class="modal-content col-md-10">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Preview Generated Form</h4>
            </div>
        <div class="modal-body"  id="rendered-form">

    </div>
 
</div>

</body>
</html>
