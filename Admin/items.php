<?php

/*
===================================================
==  ITEMS PAGE   ==================================
===================================================
*/
ob_start();

session_start();

$pageTitle = 'Items';

 if(isset($_SESSION['Username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if($do == 'Manage'){

        // ** INNER JOIN ** //
        $stmt = $con->prepare(" SELECT 
                                    items.*,
                                    categories.Name AS Category,
                                    users.Username AS Users
                                FROM
                                     items
                                INNER JOIN 
                                    categories
                                ON
                                    categories.ID = items.Cat_ID
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = items.Member_ID");
        // Execute the statement 
        $stmt->execute();
        // Fetch All data And Assign To Variable 
        $items = $stmt->fetchAll();

        if(! empty($items)){

    ?>

            <h2 class="text-center">Manege Items</h2>
        <div class="container mb-5">
         <div class="table-responsive">
            <table class="table text-center main-table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Adding Data</th>
                        <th scope="col">Category</th>
                        <th scope="col">UserName</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                <?php   foreach($items as $item){

                   echo '<tr>';
                       echo  '<td>'  . $item['Item_ID'] . '</td>';
                       echo  '<td>'  . $item['Name'] . '</td>';
                       echo  '<td>'  . $item['Description'] . '</td>';
                       echo  '<td>'  . $item['Price'] . '</td>';
                       echo  '<td>' . $item['Add_Date']. '</td>';
                       echo  '<td>' . $item['Category']. '</td>';
                       echo  '<td>' . $item['Users']. '</td>';
                       echo '<td>
                                <a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '"class="btn btn-success p-1 "><i class="far fa-edit"></i> Edit</a>
                                <a href="items.php?do=Delete&itemid=' . $item['Item_ID'] . '" class="btn btn-danger confirm p-1"><i class="far fa-trash-alt"></i> Delete</a>';
                                if($item['Approve'] == 0){
                                    echo '<a href="items.php?do=Approved&itemid=' . $item['Item_ID'] . '" class="btn btn-info p-1 ml-1"><i class="fas fa-check"></i> Aprove</a>';
                                  }
                              echo  '</td>';
                       echo  '</tr>';
                }   ?>
                </tbody>
            </table>
        </div>
              <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>      
     </div> 

        <?php 
            }else{
                
                echo '<div class="mt-3 container alert alert-secondary">';
                    echo 'There\'s No Items To Show';
                    echo '<div class="alert alert-dark" role="alert">';
                    echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>';
                    echo '</div>';
                echo '</div>';
            }
        ?>

    <?php      

    }elseif($do == 'Add'){  ?>

            <h2 class="text-center">Add New Item</h2>
        <div class="container text-center form-Edit">
            <form class="form-horizontal" action="?do=Insert"  method="POST" >
                <!-- start Name field -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Name Of The Item" >
                    </div>
               </div>
                  <!-- End Name field -->
                  <!-- Start Description field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10 col-md-6">
                          <input 
                            type="text" 
                            name="description" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Description Of The Item" >
                      </div>
                  </div>              
                  <!-- End Description field -->
                  <!-- Start Price field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Price</label>
                      <div class="col-sm-10 col-md-6">
                          <input 
                            type="text" 
                            name="price" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Price Of The Item" >
                      </div>
                  </div>              
                  <!-- End Price field -->
                  <!-- Start Country field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10 col-md-6">
                          <input 
                            type="text" 
                            name="country" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Country Of Made" >
                      </div>
                  </div>              
                  <!-- End Country field -->
                  <!-- Start Status field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Status</label>
                      <div class="col-sm-10 col-md-6">
                          <select name="status">
                              <option value="0">...</option>
                              <option value="1">New</option>
                              <option value="2">Like New</option>
                              <option value="3">Used</option>
                              <option value="4">Very Old</option>
                          </select>
                      </div>
                  </div>              
                  <!-- End Status field -->
                  <!-- Start Member field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Member</label>
                      <div class="col-sm-10 col-md-6">
                          <select name="member">
                              <option value="0">...</option>
                              <?php
                               $stmt = $con->prepare("SELECT * FROM users");
                               $stmt->execute();
                               $users = $stmt->fetchAll();
                               foreach($users as $user){
                                   echo "<option value=" . $user['UserID'] . ">" . $user['Username'] . "</option>";
                               }
                               ?>
                          </select>
                      </div>
                  </div>              
                  <!-- End Member field -->
                  <!-- Start Category field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Category</label>
                      <div class="col-sm-10 col-md-6">
                          <select name="category">
                              <option value="0">...</option>
                              <?php
                               $stmt = $con->prepare("SELECT * FROM categories");
                               $stmt->execute();
                               $cats = $stmt->fetchAll();
                               foreach($cats as $cat){
                                   echo "<option value=" . $cat['ID'] . ">" . $cat['Name'] . "</option>";
                               }
                               ?>
                          </select>
                      </div>
                  </div>              
                  <!-- End Category field -->
                  <!-- Start Submit field -->
                  <div class="row offset-sm-2 col-md-6">
                      <div >
                          <input type="submit" class="btn btn-primary" value="Add Item">
                      </div>
                  </div>
                  <!-- End Submit field -->
          </form>
      </div>


  <?php

    }elseif($do == 'Insert'){

         
          
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h2 class='text-center'>Insert Item</h2>";

            // Get Variables Form The Form
            $name        = $_POST['name'];
            $desc        = $_POST['description'];
            $price       = $_POST['price'];
            $country     = $_POST['country'];
            $status      = $_POST['status'];
            $category      = $_POST['category'];
            $member      = $_POST['member'];


            $formErrors = array();

            if(empty($name)){

                $formErrors[] =  'Name Can\'t Be <strong>Empty</strong>';
            }

            if(empty($desc)){

                $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
                
            }

            if(empty($price)){

                $formErrors[] =  'Price Can\'t Be <strong>Empty</strong>';
                
            }
            if(empty($country)){

                $formErrors[] =  'Country Can\'t Be <strong>Empty</strong>';
                
            }

            if($status == 0){

                $formErrors[] = 'You Must Choose The <strong>Status</strong>';
                
            }

            if($member == 0){

                $formErrors[] = 'You Must Choose The <strong>Member</strong>';
                
            }

            if($category == 0){

                $formErrors[] = 'You Must Choose The <strong>Category</strong>';
                
            }


            // Loop Into Errors Array And Echo It
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger text-center">' . $error . '</div>';
            }
            


         // check If There's No Error Proceed The Update Operation
          if(empty($formErrors)){

                //  Insert The information In Database  
                $stmt = $con->prepare(" INSERT INTO  
                                items(Name, Description, Price, Country_Made, Status,  Add_Date, Cat_ID, Member_ID)
                                VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember) ");
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zprice'    => $price,
                    'zcountry'  => $country,
                    'zstatus'   => $status,
                    'zcat'      => $category,
                    'zmember'   => $member
                    ));
    

                // Echo Success Message
                echo '<div class="container mt-5 text-center">';

                $theMsg =  "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Updated </div>";
    
                redirectHome($theMsg , 'back', 6);
    
                echo '</div>';
            
                }


        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg);

            echo '</div>';
        }

        
    }elseif($do == 'Edit'){

        // Check If Get Requset itemid Is Numeric & Get The Integer Value Of It 
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
    
        // Select All Data Depend On This Id 
        $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
        // Execute Query
        $stmt->execute(array($itemid));
        // Fetch the data 
        $item = $stmt->fetch();
        // the row count 
        $count = $stmt->rowCount();
        
        // if there's  such id show the form 
        if($stmt->rowCount() > 0):  ?>
    
 
    <h2 class="text-center">Edit Item</h2>
        <div class="container text-center form-Edit">
            <form class="form-horizontal" action="?do=Update"  method="POST" >
            <input type="hidden" name="itemid" value="<?php echo $itemid ; ?>" />

                <!-- start Name field -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Name Of The Item"
                            value="<?php echo $item['Name']?>" >
                    </div>
               </div>
                  <!-- End Name field -->
                  <!-- Start Description field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10 col-md-6">
                          <input 
                            type="text" 
                            name="description" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Description Of The Item"
                            value="<?php echo $item['Description']?>" >
                      </div>
                  </div>              
                  <!-- End Description field -->
                  <!-- Start Price field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Price</label>
                      <div class="col-sm-10 col-md-6">
                          <input 
                            type="text" 
                            name="price" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Price Of The Item"
                            value="<?php echo $item['Price']?>" >
                      </div>
                  </div>              
                  <!-- End Price field -->
                  <!-- Start Country field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10 col-md-6">
                          <input 
                            type="text" 
                            name="country" 
                            class="form-control"
                            required
                            autocomplete="off"
                            placeholder="Country Of Made"
                            value="<?php echo $item['Country_Made']?>" >
                      </div>
                  </div>              
                  <!-- End Country field -->
                  <!-- Start Status field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Status</label>
                      <div class="col-sm-10 col-md-6">
                          <select name="status">
                              <option value="1" <?php if($item['Status'] == 1){ echo 'selected' ;}?> >New</option>
                              <option value="2" <?php if($item['Status'] == 2){ echo 'selected' ;}?> >Like New</option>
                              <option value="3" <?php if($item['Status'] == 3){ echo 'selected' ;}?> >Used</option>
                              <option value="4" <?php if($item['Status'] == 4){ echo 'selected' ;}?> >Very Old</option>
                          </select>
                      </div>
                  </div>              
                  <!-- End Status field -->
                  <!-- Start Member field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Member</label>
                      <div class="col-sm-10 col-md-6">
                          <select name="member">
                              <?php
                               $stmt = $con->prepare("SELECT * FROM users");
                               $stmt->execute();
                               $users = $stmt->fetchAll();
                               foreach($users as $user){
                                   echo "<option value='" . $user['UserID'] . "'";
                                    if($item['Member_ID'] == $user['UserID']){echo 'selected' ;} 
                                   echo ">" . $user['Username'] . "</option>";
                               }
                               ?>
                          </select>
                      </div>
                  </div>              
                  <!-- End Member field -->
                  <!-- Start Category field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Category</label>
                      <div class="col-sm-10 col-md-6">
                          <select name="category">
                              <?php
                               $stmt = $con->prepare("SELECT * FROM categories");
                               $stmt->execute();
                               $cats = $stmt->fetchAll();
                               foreach($cats as $cat){
                                   echo "<option value='" . $cat['ID'] . "'";  if($item['Cat_ID'] == $cat['ID']){echo 'selected' ;} echo  ">" . $cat['Name'] . "</option>";
                               }
                               ?>
                          </select>
                      </div>
                  </div>              
                  <!-- End Category field -->
                  <!-- Start Submit field -->
                  <div class="row offset-sm-2 col-md-6">
                      <div >
                          <input type="submit" class="btn btn-primary" value="Save Item">
                      </div>
                  </div>
                  <!-- End Submit field -->
          </form>


          <?php 

             
        $stmt = $con->prepare(" SELECT
                                    comments.*,
                                    users.Username AS User_from_comments
                                 FROM 
                                    comments
                                INNER JOIN 
                                    users
                                ON
                                    users.UserID = comments.user_id
                                WHERE item_id = ?");
        // Execute the statement 
        $stmt->execute(array($itemid));
        // Fetch All data And Assign To Variable 
        $rows = $stmt->fetchAll();
    if(! empty($rows)){
    ?>

          <h2 class="text-center">Manege [ <?php echo $item['Name'] ;?> ] Comments</h2>
            <div class="container mb-5">
            <div class="table-responsive">
                <table class="table text-center main-table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Comment</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Adding Data</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php   foreach($rows as $row){

                    echo '<tr>';
                        echo  '<td>'  . $row['comment'] . '</td>';
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
    </div>

    <?php } ?> 

    <?php   else:
    
                echo '<div class="container mt-5 text-center">';
    
                $theMsg =  "<div class='alert alert-danger text-center'> There\'s No Such ID </div>";
    
                redirectHome($theMsg , 'back', 6);
    
                echo '</div>';
    
            endif;
    


    }elseif($do == 'Update'){



        echo "<h2 class='text-center'>Update Item</h2>";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Get Variables Form The Form
            $id          = $_POST['itemid'];
            $name        = $_POST['name'];
            $desc        = $_POST['description'];
            $price       = $_POST['price'];
            $country     = $_POST['country'];
            $status      = $_POST['status'];
            $category    = $_POST['category'];
            $member      = $_POST['member'];


            $formErrors = array();

            if(empty($name)){

                $formErrors[] =  'Name Can\'t Be <strong>Empty</strong>';
            }

            if(empty($desc)){

                $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
                
            }

            if(empty($price)){

                $formErrors[] =  'Price Can\'t Be <strong>Empty</strong>';
                
            }
            if(empty($country)){

                $formErrors[] =  'Country Can\'t Be <strong>Empty</strong>';
                
            }

            if($status == 0){

                $formErrors[] = 'You Must Choose The <strong>Status</strong>';
                
            }

            if($member == 0){

                $formErrors[] = 'You Must Choose The <strong>Member</strong>';
                
            }

            if($category == 0){

                $formErrors[] = 'You Must Choose The <strong>Category</strong>';
                
            }


            // Loop Into Errors Array And Echo It
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger text-center">' . $error . '</div>';
            }
                   
            // check If There's No Error Proceed The Update Operation
          if(empty($formErrors)){

              // Update The Database With this information 
              $stmt = $con->prepare(" UPDATE 
                                            items 
                                      SET 
                                            Name          = ?,
                                            Description   = ? ,
                                            Price         = ?,
                                            Country_Made  = ?,
                                            Status        = ? ,
                                            Cat_ID        = ?,
                                            Member_ID     = ?
                                      WHERE 
                                             Item_ID = ?");
              $stmt->execute(array($name , $desc , $price , $country , $status, $category, $member, $id));
  

              // Echo Success Message
              echo '<div class="container mt-5 text-center">';

              $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Updated </div>";
  
              redirectHome($theMsg , 'back');
  
              echo '</div>';
              
          }

        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg =  "<div class='alert alert-danger text-center'> Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg);

            echo '</div>';
        }

    }elseif($do == 'Delete'){


        echo "<h2 class='text-center'>Delete Item</h2>";
        echo "<div class='container'>";


        // Check If Get Requset Item ID Is Numeric & Get The Integer Value Of It 
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the item is Exist //
        $check = checkItem('Item_ID' , 'items' , $itemid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :theid");
            $stmt->bindParam(':theid', $itemid);
            $stmt->execute();

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-success text-center'><i class='fas fa-check-square'></i> { " . $stmt->rowCount()  . " } Record Deleted </div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';

            
        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-danger text-center'> This ID Is Not Exist </div>";

            redirectHome($theMsg);

            echo '</div>';
        }

        echo "</div>";



    }elseif($do == 'Approved'){ //Approve
        

        echo "<h2 class='text-center'>Approve Item</h2>";
        echo "<div class='container'>";


        // Check If Get Requset Item ID Is Numeric & Get The Integer Value Of It 
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the item is Exist //
        $check = checkItem('Item_ID' , 'items' , $itemid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
            $stmt->execute(array($itemid));

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

ob_end_flush();

?>