<?php

 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set ('display_errors', true);
error_reporting (E_ALL);


?>