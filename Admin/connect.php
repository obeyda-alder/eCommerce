<?php

            ###############################################
            ####### page for connection with Databases ####
            ###############################################


    $dsn = 'mysql:host=localhost;dbname=eCommerce';
    $user = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try{

        $con = new PDO ($dsn , $user , $pass , $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'You Are Connected Welcome Database';

    }
    catch(PDOException $e){

        echo 'Failed To Connect' . $e->getMessage();
    }
