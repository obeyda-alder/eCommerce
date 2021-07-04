<?php

/*
** Get  Any Tabel Function v1.0
** Function To Get Any Tabel From Database
*/

function getAllFrom($Tabel, $where = NULL){

    global $con;

    $getAll = $con->prepare("SELECT * FROM $Tabel $where ");
    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all;
}

/*
** Get  Categories Function v1.0
** Function To Get Categories From Database
*/

    function getCats(){

        global $con;

        $getcat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
        $getcat->execute();

        $cats = $getcat->fetchAll();

        return $cats; 
    }


/*
** Get  Items Function v1.0
** Function To Get Items From Database
*/

    function getItems($where, $value, $approv = NULL){
        global $con;

        if($approv == NULL){

            $sql = 'AND Approve = 1';

        }else {

            $sql = NULL;
        }


        $getitem = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");
        $getitem->execute(array($value));

        $items = $getitem->fetchAll();

        return $items; 
    }

/*
** Get  RegStstua Function v1.0
** Function To Get RegStatus for User
*/

    function checkUserStatus($user){

        global $con;

        $stmtx = $con->prepare("SELECT Username , RegStatus FROM users WHERE Username = ? AND RegStatus = 0 ");
        $stmtx->execute(array($user));

        $status = $stmtx->rowCount();

        return $status; 
    }



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