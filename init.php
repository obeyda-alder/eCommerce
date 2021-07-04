<?php

   if(!isset($_SESSION)) 
      { 
         session_start(); 
      } 
   // Show All Errors In My WebSite 
   ini_set('dispaly_errors', 'On');
   error_reporting(E_ALL);
   
     include 'Admin/connect.php';
   
     // Register session in variable
     $sessionUser = '';

     if(isset($_SESSION['user'])){

      $sessionUser = $_SESSION['user'];

     }


        //Routes 
        $tem = 'includes/templates/';  //Template Directory
        $css = 'layout/css/';          //css Directory
        $func = 'includes/functions/'; //functions Directory
        $js = 'layout/js/';            //js Directory
        $lang = 'includes/languages/'; //languages Directory

        // include the Important files
        include $func . 'functions.php';   #page languages
        include $lang . 'english.php';   #page languages
        include $tem . 'header.php';   #page header
        
