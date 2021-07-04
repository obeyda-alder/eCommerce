<?php

/*
#################################################
## Manage Members page
## You Can Add | Edit | Delete Members From Here
#################################################
*/

session_start();

if (isset($_SESSION['Username'])){

    $pageTitle = 'Members';

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    // Start Manage page 

    if($do == 'Manage'){    // Manage page  
    
        $query = '';

        if(isset($_GET['page']) && $_GET['page'] == 'Pending'){

            $query = 'AND RegStatus = 0';
        }
    
        // Select All Users Except Admin 
        $stmt = $con->prepare(" SELECT * FROM users WHERE GroupID != 1 $query ");
        // Execute the statement 
        $stmt->execute();
        // Fetch All data And Assign To Variable 
        $rows = $stmt->fetchAll();
    
        if(! empty($rows)){

    ?>

            <h2 class="text-center">Manege Members</h2>

        <div class="container mb-5">
         <div class="table-responsive">
            <table class="table text-center main-table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Registered Data</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                <?php   foreach($rows as $row){

                   echo '<tr>';
                       echo  '<td>'  . $row['UserID'] . '</td>';
                        echo  '<td>';
                            if(! empty($row['Avatar'])){
                            echo '<img class="avatar img-thumbnail" src="uploads/avatar/' . $row['Avatar'] . '" >';
                                }else{
                            echo '<img class="avatar img-thumbnail" src="uploads/avatar/images.png">';
                                }
                        echo '</td>';
                       echo  '<td>'  . $row['Username'] . '</td>';
                       echo  '<td>'  . $row['Email'] . '</td>';
                       echo  '<td>'  . $row['FullName'] . '</td>';
                       echo  '<td>' . $row['Date']. '</td>';
                       echo '<td>
                                <a href="members.php?do=Edit&userid=' . $row['UserID'] . '"class="btn btn-success"><i class="far fa-edit"></i> Edit</a>
                                <a href="members.php?do=Delete&userid=' . $row['UserID'] . '" class="btn btn-danger confirm"><i class="far fa-trash-alt"></i> Delete</a>';
                                
                                if($row['RegStatus'] == 0){
                                    
                                  echo '<a href="members.php?do=activate&userid=' . $row['UserID'] . '" class="btn btn-info ml-2"><i class="fas fa-check"></i> Activate</a>';
                                }
                             echo  '</td>';
                       echo  '</tr>';
                }   ?>
                </tbody>
            </table>
        </div>
              <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>      
     </div> 

     <?php }else {
                echo '<div class="mt-3 container alert alert-secondary">';
                    echo 'There\'s No Memebers To Show';
                    echo '<div class="alert alert-dark" role="alert">';
                    echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>';
                    echo '</div>';
                echo '</div>';
            }  ?>


    <?php  }elseif($do == 'Add'){  //Add  Members page ?>

   <h2 class="text-center">Add New Member</h2>
      <div class="container text-center form-Edit">
          <form class="form-horizontal" action="?do=Insert"  method="POST" enctype="multipart/form-data">
              <!-- start Username field -->
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Username</label>
                  <div class="col-sm-10 col-md-6">
                      <input type="text" name="username" class="form-control" required autocomplete="off"  placeholder="Type Your Name" >
                  </div>
             </div>
                <!-- End Username field -->
                <!-- Start Password field -->
                <div class="row mb-3">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="Password" class="password form-control" required autocomplete="new-password" placeholder="Type Your Password" >
                        <i class="show-pass fas fa-eye"></i>
                    </div>
                </div>              
                <!-- End Password field -->
                <!-- Start Email field -->
                <div class="row mb-3">
                    <label  class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control" required autocomplete="off"  placeholder="Type Your Email" >
                    </div>
                </div>
                <!-- End Email field -->
                <!-- Start Full Name field -->
                <div class="row mb-3">
                    <label  class="col-sm-2 control-labell">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control" required autocomplete="off"  placeholder="Type Your Full Name" >
                    </div>
                </div>
                <!-- End Full Name field -->
              <!-- start Avatar field -->
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">User Avatar</label>
                  <div class="col-sm-10 col-md-6">
                      <input type="file" name="Avatar" class="form-control" required >
                  </div>
             </div>
                <!-- End Avatar field -->
                <!-- Start Submit field -->
                <div class="row offset-sm-2 col-md-6">
                    <div >
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </div>
                <!-- End Submit field -->
        </form>
    </div>



 <?php   
 
      }elseif($do == 'Insert'){  // Insert page
          
          
          if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h2 class='text-center'>Insert Member</h2>";

            // Upload Variables
            $avatarName = $_FILES['Avatar']['name'];
            $avatarSize = $_FILES['Avatar']['size'];
            $avatarTmp  = $_FILES['Avatar']['tmp_name'];
            $avatarType = $_FILES['Avatar']['type'];

            // List Of Allowed File Typed To Upload
            $ListAvatarExtension = array("jpeg", "jpg", "png", "gif");

            // Get Avatar Extension whene Upload
            $Extension = explode('.', $avatarName);
            $AvatarExtension = strtolower(end($Extension));


            // Get Variables Form The Form
            $user = $_POST['username'];
            $pass = $_POST['Password'];
            $email = $_POST['email'];
            $name = $_POST['full'];


         $hashPass = sha1($_POST['Password']);

            $formErrors = array();

            if(strlen($user) < 4){

                $formErrors[] =  'UserName Can\'t Be Less Than <strong>4 Characters</strong>';
            }

            if(strlen($user) > 20){

                $formErrors[] = 'UserName Can\'t Be More Than <strong>20 Characters</strong>';
                
            }

            if(empty($user)){

                $formErrors[] =  'UserName Can\'t Be <strong>Empty</strong>';
                
            }
            if(empty($pass)){

                $formErrors[] =  'Password Can\'t Be <strong>Empty</strong>';
                
            }

            if(empty($email)){

                $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
                
            }

            if(empty($name)){

                $formErrors[] = 'FullName  Can\'t Be <strong>Empty</strong>';
                
            }

            if(! empty($avatarName) && !in_array($AvatarExtension, $ListAvatarExtension)){
                
                $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
            }

            if(empty($avatarName)){
                
                $formErrors[] = 'Image Is <strong>Required</strong>';
                
            }
            if($avatarSize > 4194304){
                
                $formErrors[] = 'Image Can\'t Be Larger Than <strong>4MB</strong>';
                
            }



            // Loop Into Errors Array And Echo It
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger text-center">' . $error . '</div>';
            }
            
         // check If There's No Error Proceed The Update Operation

          if(empty($formErrors)){

            $AvatarOrImage = rand(0, 100000000) . '_' . $avatarName;

            // the is peltein function for [whene Upload Img insert to img in your folder in Ypu path]
            move_uploaded_file($avatarTmp, "uploads\avatar\\" . $AvatarOrImage);

                $check = checkItem("Username", "users", $user);

                if($check == 1){

                    echo '<div class="container mt-5 text-center">';

                    $theMsg =  "<div class='alert alert-danger text-center'> Sorry This User Is Exist </div>";
        
                    redirectHome($theMsg , 'back', 6);
        
                    echo '</div>';
                    
                }else{

                    //  Insert The information In Database  
                    $stmt = $con->prepare(" INSERT INTO  
                                    users(Username, Password , Email, FullName, RegStatus,  Date , Avatar)
                                    VALUES(:Kuser , :Kpass , :Kemail , :Kfull , 1 , now(), :kavatar) ");
                    $stmt->execute(array(
                        'Kuser'   => $user,
                        'Kpass'   => $hashPass,
                        'Kemail'  => $email,
                        'Kfull'   => $name,
                        'kavatar' => $AvatarOrImage
                        ));
        

                    // Echo Success Message
                    echo '<div class="container mt-5 text-center">';

                    $theMsg =  "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Updated </div>";
        
                    redirectHome($theMsg , 'back', 6);
        
                    echo '</div>';
            
                }

                
          }

        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg);

            echo '</div>';
        }
     } elseif ($do == 'Edit'){   // Edit page   
    
        // Check If Get Requset userid Is Numeric & Get The Integer Value Of It 
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
    
    // Select All Data Depend On This Id 
    $stmt = $con->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
    // Execute Query
    $stmt->execute(array($userid));
    // Fetch the data 
    $row = $stmt->fetch();
    // the row count 
    $count = $stmt->rowCount();
    
    // if there's  such id show the form 
    if($stmt->rowCount() > 0):  ?>

    <h2 class="text-center">Edit Member</h2>
      <div class="container text-center form-Edit">
          <form class="form-horizontal" action="?do=Update"  method="POST" >
              <input type="hidden" name="userid" value="<?php echo $userid ; ?>" />
              <!-- start Username field -->
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Username</label>
                  <div class="col-sm-10 col-md-6">
                      <input type="text" name="username" class="form-control" autocomplete="off" required value=<?php echo $row['Username']; ?> >
                  </div>
             </div>
                <!-- End Username field -->
                <!-- Start Password field -->
                <div class="row mb-3">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="hidden" name="oldPassword" value=<?php echo $row['Password']; ?> >
                        <input type="password" name="newPassword" class="form-control"  autocomplete="new-password" placeholder="Leave Blank If You Don't Want To Change">
                    </div>
                </div>              
                <!-- End Password field -->
                <!-- Start Email field -->
                <div class="row mb-3">
                    <label  class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control" required value=<?php echo $row['Email']; ?> >
                    </div>
                </div>
                <!-- End Email field -->
                <!-- Start Full Name field -->
                <div class="row mb-3">
                    <label  class="col-sm-2 control-labell">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control" required value=<?php echo $row['FullName']; ?> >
                    </div>
                </div>
                <!-- End Full Name field -->
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


        echo "<h2 class='text-center'>Update Member</h2>";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Get Variables Form The Form
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['full'];


            // Password Tricks 
            $pass = '';

            if(empty($_POST['newPassword'])){

                $pass = $_POST['oldPassword'];

            }else{

                $pass = sha1($_POST['newPassword']);
            }


            $formErrors = array();

            if(strlen($user) < 4){

                $formErrors[] =  'UserName Can\'t Be Less Than <strong>4 Characters</strong>';
            }

            if(strlen($user) > 20){

                $formErrors[] = 'UserName Can\'t Be More Than <strong>20 Characters</strong>';
                
            }

            if(empty($user)){

                $formErrors[] =  'UserName Can\'t Be <strong>Empty</strong>';
                
            }

            if(empty($email)){

                $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
                
            }

            if(empty($name)){

                $formErrors[] = 'FullName  Can\'t Be <strong>Empty</strong>';
                
            }

            // Loop Into Errors Array And Echo It
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger text-center">' . $error . '</div>';
            }
            
            // check If There's No Error Proceed The Update Operation
          if(empty($formErrors)){

            $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND  UserID != ? ");
            $stmt2->execute(array($user, $id));
            $count = $stmt2->rowCount();

            if($count == 1){

                echo '<div class="container">'; 
                $theMsg = "<div class='alert alert-danger text-center'><i class='fas fa-check-square'></i> Sorry This User Is Exist</div>";
                redirectHome($theMsg , 'back');
                echo '</div>';

            }else{

                // Update The Database With this information 
                $stmt = $con->prepare(" UPDATE users SET Username = ?, Email = ? , FullName = ? , Password = ? WHERE UserID = ?");
                $stmt->execute(array($user , $email , $name , $pass , $id));
    
    
                // Echo Success Message
                echo '<div class="container mt-5 text-center">';
    
                $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Updated </div>";
    
                redirectHome($theMsg , 'back');
    
                echo '</div>';
            }

              
          }

        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg =  "<div class='alert alert-danger text-center'> Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';
        }

    }elseif($do == 'Delete'){ // Delete Member page 

        echo "<h2 class='text-center'>Delete Member</h2>";
        echo "<div class='container'>";


        // Check If Get Requset userid Is Numeric & Get The Integer Value Of It 
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the user is Exist //
        $check = checkItem('userID' , 'users' , $userid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("DELETE FROM users WHERE userID = :theid");
            $stmt->bindParam(':theid', $userid);
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

    }elseif ( $do == 'activate') {  // Activate Member page 

        echo "<h2 class='text-center'>Activate Member</h2>";
        echo "<div class='container'>";


        // Check If Get Requset userid Is Numeric & Get The Integer Value Of It 
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the user is Exist //
        $check = checkItem('userID' , 'users' , $userid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE userID = ?");
            $stmt->execute(array($userid));

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Updated The Information </div>";

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