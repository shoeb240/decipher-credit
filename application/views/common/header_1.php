
<?php
    $toprocess = json_decode($menulist);
 ?>              
        
 <nav class="navbar navbar-inverse">
  <div class="container-fluid">
   
    <ul class="nav navbar-nav">
   <?php
     $opened = false;
     foreach($toprocess as $menuitem){
         if($menuitem->level == '1'){
             if($opened){
              echo "</ul>";
              echo "</li>";
             }
          echo "<li class='dropdown'>";
          echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
          echo "$menuitem->label";
          echo '<span class="caret"></span></a>';
          echo '<ul class="dropdown-menu"> ';
          $opened = true;
          } else {
            $alink = base_url() . $this->config->item('index_page').$menuitem->link;
            echo "<li><a href='$alink'>$menuitem->label</a></li>";             
         }
     }
             if($opened){
              echo "</ul>";
              echo "</li>";
              
             }
   
   ?>
        
      
    </ul>
  </div>
</nav>