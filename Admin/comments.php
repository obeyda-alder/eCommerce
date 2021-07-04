<?php

/*
#######################################################
## Manage Comments page
## You Can  Edit | Delete | Approved comments From Here
#######################################################
*/

session_start();

if (isset($_SESSION['Username'])){

    $pageTitle = 'Comments';

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    // Start Manage page 

    if($do == 'Manage'){    // Manage page  
    
        $stmt = $con->prepare(" SELECT
                                    comments.*,
                                    items.Name AS Item_from_comments,
                                    users.Username AS User_from_comments
                                 FROM 
                                    comments
                                INNER JOIN 
                                    items
                                ON
                                    items.Item_ID = comments.item_id
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = comments.user_id
                                ");
        // Execute the statement 
        $stmt->execute();
        // Fetch All data And Assign To Variable 
        $rows = $stmt->fetchAll();

        if(! empty($rows)){
    
    ?>

            <h2 class="text-center">Manege Comments</h2>

        <div class="container mb-5">
         <div class="table-responsive">
            <table class="table text-center main-table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Item ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Adding Data</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                <?php   foreach($rows as $row){

                   echo '<tr>';
                       echo  '<td>'  . $row['c_id'] . '</td>';
                       echo  '<td>'  . $row['comment'] . '</td>';
                       echo  '<td>'  . $row['Item_from_comments'] . '</td>';
                       echo  '<td>'  . $row['User_from_comments'] . '</td>';
                       echo  '<td>' . $row['comment_date']. '</td>';
                       echo '<td>
                                <a href="comments.php?do=Edit&comid=' . $row['c_id'] . '"class="btn btn-success"><i class="far fa-edit"></i> Edit</a>
                                <a href="comments.php?do=Delete&comid=' . $row['c_id'] . '" class="btn btn-danger confirm"><i class="far fa-trash-alt"></i> Delete</a>';
                                
                                if($row['status'] == 0){
                                    
                                  echo '<a href="comments.php?do=Approved&comid=' . $row['c_id'] . '" class="btn btn-info ml-2"><i class="fas fa-check"></i> Approve</a>';
                                }
                             echo  '</td>';
                       echo  '</tr>';
                }   ?>
                </tbody>
            </table>
        </div>
     </div> 

         <?php  }else {

            echo '<div class=" mt-3 container alert alert-secondary">';
            echo 'There\'s No Comments To Show';
            echo '</div>';

          }?>

    <?php  } elseif ($do == 'Edit'){   // Edit page   
    
        // Check If Get Requset Comments Is Numeric & Get The Integer Value Of It 
    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
    
    // Select All Data Depend On This Id 
    $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
    // Execute Query
    $stmt->execute(array($comid));
    // Fetch the data 
    $row = $stmt->fetch();
    // the row count 
    $count = $stmt->rowCount();
    
    // if there's  such id show the form 
    if($stmt->rowCount() > 0):  ?>

    <h2 class="text-center">Edit Comment</h2>
      <div class="container text-center form-Edit">
          <form class="form-horizontal" action="?do=Update"  method="POST" >
              <input type="hidden" name="comid" value="<?php echo $comid ; ?>" />
              <!-- start Field Edit Comment -->
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Comment</label>
                  <div class="col-sm-10 col-md-6">
                        <textarea name="comment" class="form-control"><?php echo $row['comment']?></textarea>
                </div>
             </div>
              <!-- End Field Edit Comment -->
                <!-- Start Submit field -->
                <div class="row offset-sm-2 col-md-6">
                    <div >
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </div>
                <!-- End Submit field -->
        </form>
    </div>

<?php   else:

            echo '<div class="container mt-5 text-center">';

            $theMsg =  "<div class='alert alert-danger text-center'> There\'s No Such ID </div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';

        endif;


    } elseif ($do == 'Update'){  // Update page


        echo "<h2 class='text-center'>Update Comment</h2>";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Get Variables Form The Form
            $comid = $_POST['comid'];
            $comment = $_POST['comment'];

            // Update The Database With this information 
            $stmt = $con->prepare(" UPDATE comments SET comment = ? WHERE c_id = ?");
            $stmt->execute(array($comment, $comid));


            // Echo Success Message
            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Updated </div>";

            redirectHome($theMsg , 'back');

            echo '</div>';
            
          

        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg =  "<div class='alert alert-danger text-center'> Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';
        }

}elseif($do == 'Delete'){ // Delete Member page 

        echo "<h2 class='text-center'>Delete Comment</h2>";
        echo "<div class='container'>";


        // Check If Get Requset Delete Comment Is Numeric & Get The Integer Value Of It 
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the user is Exist //
        $check = checkItem('c_id' , 'comments' , $comid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :theid");
            $stmt->bindParam(':theid', $comid);
            $stmt->execute();

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Deleted </div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';

            
        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-danger text-center'> This ID Is Not Exist </div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';
        }

        echo "</div>";

    }elseif ( $do == 'Approved') {   

        echo "<h2 class='text-center'>Approved Comment</h2>";
        echo "<div class='container'>";


        // Check If Get Requset Approve Is Numeric & Get The Integer Value Of It 
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the comment is Exist //
        $check = checkItem('c_id' , 'comments' , $comid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
            $stmt->execute(array($comid));

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Updated The Information</div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';

            
        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-danger text-center'> This ID Is Not Exist </div>";

            redirectHome($theMsg);

            echo '</div>';
        }

        echo "</div>";


    }

        include $tem . 'footer.php';

    }else{

        header('Location:index.php');

        exit();
    }