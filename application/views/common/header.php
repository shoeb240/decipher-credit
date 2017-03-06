<html>
  <head>
          <title>Decipher Creditxx</title>
  </head>
      
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
       
        <ul class="nav navbar-nav">
           <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo site_url() . $this->config->item('index_page')?>/questions/create">Create</a></li>                  
              <li><a href="<?php echo base_url() . $this->config->item('index_page')?>/questions/view">View</a></li>          

            </ul>
          </li>
          
           <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sections
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url() . $this->config->item('index_page')?>/sections/create">Create</a></li>
              <li><a href="<?php echo base_url() . $this->config->item('index_page')?>/sections/view">View</a></li>          
            </ul>
          </li>
          
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Templates
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/templates/create">Create</a></li>
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/templates/view">View</a></li>          
            </ul>
          </li>
          
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Applications
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/applications/index">view</a></li>
            </ul>
          </li>
          
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/auth/login">Login</a></li>
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/auth/forgot_password">Password Reset</a></li>          
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/auth/logout">Logout</a></li>          
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/auth/create_user">Create User</a></li>          
              <li><a href="<?php echo base_url() .$this->config->item('index_page')?>/auth/create_group">Create ACL Level</a></li>          
            </ul>
          </li>
          
         
          
        </ul>
      </div>
    </nav>
