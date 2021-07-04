<?php

    /*
    =================================================
    == Category Page  ===============================
    =================================================
    */
    ob_start(); // Output Buffering[ Befor storage ] Start

    session_start();

    $pageTitle = 'Categories';

    if (isset($_SESSION['Username'])){


        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


        if($do == 'Manage'){   
        
            $sort = 'ASC';
            $sort_array = array('ASC', 'DESC');

            if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

                $sort = $_GET['sort'];

            }

            // call All information in the database
            $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
            $stmt2->execute();
            $cats = $stmt2->fetchAll();  

                if(!empty($cats)){

            ?>

            <h2 class="text-center">Manage Categories</h2>
            <div class="latest mt-3 mb-5">
                    <div class="container categories">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-heading">
                                      <i class="fas fa-tasks mr-2"></i>
                                          Manage Categories
                                            <div class="option float-right"> 
                                               <div class="ordering">Ordering: 
                                                <a class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC"><i class="fas fa-sort-up"></i>ASC</a> | 
                                                <a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC"><i class="fas fa-sort-down"></i>DESC</a>
                                                </div> 
                                                <div class="view">View:
                                                    <span class="active" data-view="full">Full</span> | 
                                                    <span class="" data-view="classic">Classic</span>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card-body">
                                            <?php  
                                            foreach($cats as $cat){
                                                echo '<div class="cat">';
                                                    echo '<div class="hidden-buttons">';
                                                       echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-outline-primary btn-sm mr-2'><i class='fas fa-edit'></i> Edit</a>";
                                                       echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-outline-danger btn-sm'><i class='far fa-trash-alt'></i> Delete</a>";
                                                    echo '</div>';
                                                    echo  '<h3>' . $cat['Name'] . '</h3>';
                                                    echo '<div class="full-view">';
                                                        echo '<p>'; if($cat['Description'] == ''){echo 'This Category Has No Descrption';}else{ echo $cat['Description']; }; echo '</p>';
                                                        if($cat['Visibility'] == 1){echo '<sapn class="visibility">Hidden</sapn>'; }; 
                                                        if($cat['Allow_Comment'] == 1){echo '<sapn class="commenting">Comment Disabled</sapn>'; }; 
                                                        if($cat['Allow_Ads'] == 1){echo '<sapn class="advertises">Ads Disabled</sapn>'; };
                                                   echo '</div>';
                                                echo '</div>';
                                                echo '<hr/>';
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href='categories.php?do=Add' class="btn btn-primary mt-3 ml-2"><i class="fas fa-plus"></i> Add New Category</a>
                    </div>
                </div>
        <?php 
                }else{
                    echo '<div class="mt-3 container alert alert-secondary">';
                        echo 'There\'s No Categorys To Show';
                        echo '<div class="alert alert-dark" role="alert">';
                        echo '<a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>';
                        echo '</div>';
                    echo '</div>';
                }


    } elseif ($do == 'Add') {  ?>

        <h2 class="text-center">Add New Category</h2>
        <div class="container text-center form-Edit">
            <form class="form-horizontal" action="?do=Insert"  method="POST" >
                <!-- start Name field -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" required autocomplete="off"  placeholder="Name Of The Category" >
                    </div>
               </div>
                  <!-- End Name field -->
                  <!-- Start Description field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10 col-md-6">
                          <input type="text" name="description" class="form-control"  placeholder="Describe The Category" >
                      </div>
                  </div>              
                  <!-- End Description field -->
                  <!-- Start Ordering field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-label">Ordering</label>
                      <div class="col-sm-10 col-md-6">
                          <input type="text" name="ordering" class="form-control" placeholder="To Arrange The Categories"></div>
                  </div>
                  <!-- End Ordering field -->
                  <!-- Start Visibility field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-labell">Visible</label>
                      <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" checked >
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1">
                            <label for="vis-no">No</label>
                        </div>
                      </div>
                  </div>
                  <!-- End Visibility field -->
                  <!-- Start Commenting field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-labell">Allow Commenting</label>
                      <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked >
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1">
                            <label for="com-no">No</label>
                        </div>
                      </div>
                  </div>
                  <!-- End Commenting field -->
                  <!-- Start Ads field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-labell">Allow Ads</label>
                      <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked >
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1">
                            <label for="ads-no">No</label>
                        </div>
                      </div>
                  </div>
                  <!-- End Ads field -->
                  <!-- Start Submit field -->
                  <div class="row offset-sm-2 col-md-6">
                      <div >
                          <input type="submit" class="btn btn-primary" value="Add Category">
                      </div>
                  </div>
                  <!-- End Submit field -->
          </form>
      </div>


  <?php
    
    } elseif ($do == 'Insert') {  
          
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo "<h2 class='text-center'>Insert Category</h2>";

            echo '<div class="container mt-5 text-center">';   

            // Get Variables Form The Form
            $name    = $_POST['name'];
            $desc    = $_POST['description'];
            $order   = $_POST['ordering'];
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads     = $_POST['ads'];

            //check if category Exist in database
            $check = checkItem("Name", "categories", $name);

            if($check == 1){

                $theMsg = '<div class="alert alert-danger">Sorry This Category Is Exist</div>';

                redirectHome($theMsg , "back");

            }else{

                // Insert Category Info In Database
                $stmt = $con->prepare("INSERT INTO 
                categories (Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
                VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)");
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zorder'    => $order,
                    'zvisible'  => $visible,
                    'zcomment'  => $comment,
                    'zads'      => $ads
                ));

                // Echo Success Message 
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Inserted </div>";
                redirectHome($theMsg , 'back');

            }


        }else{

            echo '<div class="container mt-5 text-center">';

            $theMsg = "<div class='alert alert-danger text-center'>Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg , 'back', 6);

            echo '</div>';
        }
        echo '</div>';

        
    } elseif ($do == 'Edit') {   // Edit page   

             // Check If Get Requset category Is Numeric & Get The Integer Value Of It 
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
    
    // Select All Data Depend On This Id 
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
    // Execute Query
    $stmt->execute(array($catid));
    // Fetch the data 
    $cat = $stmt->fetch();
    // the row count 
    $count = $stmt->rowCount();
    
    // if there's  such id show the form 
    if($stmt->rowCount() > 0):  ?>

            <h2 class="text-center">Edit Category</h2>
        <div class="container text-center form-Edit">
            <form class="form-horizontal" action="?do=Update"  method="POST" >
                <input type="hidden" name="catid" value="<?php echo $catid ?>">
                <!-- start Name field -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" required placeholder="Name Of The Category" value="<?php echo $cat['Name']; ?>">
                    </div>
               </div>
                  <!-- End Name field -->
                  <!-- Start Description field -->
                  <div class="row mb-3">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10 col-md-6">
                          <input type="text" name="description" class="form-control"  placeholder="Describe The Category" value="<?php echo $cat['Description']; ?>">
                      </div>
                  </div>              
                  <!-- End Description field -->
                  <!-- Start Ordering field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-label">Ordering</label>
                      <div class="col-sm-10 col-md-6">
                          <input type="text" name="ordering" class="form-control" placeholder="To Arrange The Categories" value="<?php echo $cat['Ordering']; ?>">
                        </div>
                  </div>
                  <!-- End Ordering field -->
                  <!-- Start Visibility field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-labell">Visible</label>
                      <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0){echo 'checked';} ?> >
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1){echo 'checked';} ?>>
                            <label for="vis-no">No</label>
                        </div>
                      </div>
                  </div>
                  <!-- End Visibility field -->
                  <!-- Start Commenting field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-labell">Allow Commenting</label>
                      <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0"  <?php if($cat['Allow_Comment'] == 0){echo 'checked';} ?> >
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1){echo 'checked';} ?> >
                            <label for="com-no">No</label>
                        </div>
                      </div>
                  </div>
                  <!-- End Commenting field -->
                  <!-- Start Ads field -->
                  <div class="row mb-3">
                      <label  class="col-sm-2 control-labell">Allow Ads</label>
                      <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){echo 'checked';} ?> >
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){echo 'checked';} ?> >
                            <label for="ads-no">No</label>
                        </div>
                      </div>
                  </div>
                  <!-- End Ads field -->
                  <!-- Start Submit field -->
                  <div class="row offset-sm-2 col-md-6">
                      <div >
                          <input type="submit" class="btn btn-primary" value="Add Category">
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
        

    } elseif ($do == 'Update') {  // Update page

        echo "<h2 class='text-center'>Update Category</h2>";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Get Variables Form The Form
            $Id          = $_POST['catid'];
            $name        = $_POST['name'];
            $desc        = $_POST['description'];
            $order       = $_POST['ordering'];
            $visible     = $_POST['visibility'];
            $comment     = $_POST['commenting'];
            $ads         = $_POST['ads'];
          

              // Update The Database With this information 
              $stmt = $con->prepare("UPDATE 
                                        categories 
                                    SET 
                                        Name = ?,
                                        Description = ?,
                                        Ordering = ?,
                                        Visibility = ?,
                                        Allow_Comment = ?,
                                        Allow_Ads = ?
                                    WHERE 
                                            ID = ?");
              $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $Id));
  

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
        
        
    } elseif ($do == 'Delete') { // Delete Member page 

        echo "<h2 class='text-center'>Delete Category</h2>";
        echo "<div class='container'>";


        // Check If Get Requset userid Is Numeric & Get The Integer Value Of It 
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
        
        // Fucntion check Item == rowCount if > 0 meaning the user is Exist //
        $check = checkItem('ID' , 'categories' , $catid);
        
        // if there's  such id show the form 
        if( $check > 0){

            $stmt = $con->prepare("DELETE FROM categories WHERE ID = :catid");
            $stmt->bindParam(':catid', $catid);
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

    } 
        include $tem . 'footer.php';

    }else{

        header('Location:index.php');

        exit();
    }

    ob_end_flush();
    ?>