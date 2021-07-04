<?php

     include 'connect.php';
     
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

         if(!isset($noNavbar)):

            include $tem . 'navbar.php';
            
         endif;

        
