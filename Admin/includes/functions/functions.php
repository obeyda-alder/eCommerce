<?php

/*
**  Title function that v1.0
** echo the page title in case the page Has 
** the variable $pageTitle and echo default title for other pages
*/
    function getTitle(){

        global $pageTitle;

        if(isset($pageTitle)){

            echo $pageTitle;

        }else{

            echo 'Default';

        }
    }

/*
**  Home Redirect Function v2.0
**  [ This Function Accept Parameters ]
** $errorMsg = Echo The Error Message 
** $seconds = Seconds Before Redirecting
*/

    function redirectHome ($theMsg , $url= null,  $seconds = 3){

        if($url === null){

            $url = 'index.php';

            $link = 'Home Page';
        }else {

            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                $url = $_SERVER['HTTP_REFERER'];

                $link = 'previous page';

            }else {

                $url = 'index.php';

                $link = 'Home Page';

            }
        }

        echo $theMsg;

        echo  "<div class='alert alert-info'> You Will Be Redirected To $link After $seconds Seconds. </div>";

        header("refresh:$seconds;url=$url");

        exit();
    }


/*
** check Items Function v1.0
** Function to check item in database [ function Accept Parameters ]
** $select  = the item to select from [ Example: user, item , category ]
** $from = the table to slect from [ Example: users, items , categories ]
** $value = the value of select from [ Example: osama , Box , name ]
*/

        function checkItem($select , $from , $value ){

            global $con;

            $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");

            $statement->execute(array($value));

            $count = $statement->rowCount();

            return  $count;

            }

/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = the item to count 
** $table = the table to choose form
*/

        function countItem ($item , $table) {

            global $con;

            $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

            $stmt2->execute();

            return $stmt2->fetchColumn();
        }


/*
** Get Latest Records Function v2.0
** Function To Latest Items From Database [ Users , Items , Comments ]
** $select = Field To Select
** $table = The Table To Choose From 
** $order = The Desc Ordering
** $limit = Number Of Records To Get 
*/

function getLatest($select , $table , $order , $limit = 5, $table2, $value){

    global $con;

    $getStmt = $con->prepare("SELECT $select FROM $table  WHERE $table2 != $value ORDER BY $order DESC LIMIT $limit ");
    $getStmt->execute();

    $rows = $getStmt->fetchAll();

    return $rows; 
}