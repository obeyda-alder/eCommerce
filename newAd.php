<?php 
    session_start();

    $pageTitle = 'Create New Ad';
      
    include 'init.php';  #page init

    if(isset($_SESSION['user'])){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $formErrors = array();
    
        $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $status     = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
        $category   = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
        
        if(strlen($name) < 4){
            $formErrors[] = 'Item Title Must Be At Least Four Characters';
        }

        if(strlen($desc) < 10){
            $formErrors[] = 'Item Description Must Be At Least Ten Characters';
        }

        if(strlen($country) < 2){
            $formErrors[] = 'Item Country Must Be At Least Tow Characters';
        }

        if(empty($price)){
            $formErrors[] = 'Item Price Must Be Not Empty';
        }

        if(Empty($status)){
            $formErrors[] = 'Item Status Must Be Not Empty';
        }

        if(Empty($category)){
            $formErrors[] = 'Item Category Must Be Not Empty';
        }


        if(empty($formErrors)){

            // Insert Information In DataBase 
            $stmx = $con->prepare(" INSERT INTO 
                            items(Name, Description, Price, Add_Date, Country_Made, Status, Cat_ID, Member_ID)
                            VALUES(:iname, :idesc, :iprice, now(), :icountry, :istatus, :icategory, :imember)");
    
            $stmx->execute(array(
                'iname'       => $name,
                'idesc'       => $desc,
                'iprice'      => $price,
                'icountry'    => $country,
                'istatus'     => $status,
                'icategory'   => $category,
                'imember'     => $_SESSION['uId']
            ));
        
            if($stmx){
                echo '<div class="container mt-3 text-center w-25">';
                 echo '<div class="alert alert-success">Congrats</div>';
                echo '</div>';
                // header("refresh:2;Location:newAd.php");
            }

            // exit(); 
        }
    }

?>

        <h2 class="text-center"><?php echo $pageTitle; ?></h2>
    <div class="information mt-4">
        <div class="container">
      <div class="row">
            <div class="card border-primary mb-3 w-100 ">
                <div class="card-header">Create New Ad</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>"  method="POST" >
                                        <!-- start Name field -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input 
                                                    pattern=".{4,}"
                                                    titile="This Field Require At Least Four Characters"
                                                    type="text" 
                                                    name="name" 
                                                    class="form-control live-name"
                                                    required
                                                    autocomplete="off"
                                                    placeholder="Name Of The Item" >
                                            </div>
                                    </div>
                                        <!-- End Name field -->
                                        <!-- Start Description field -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input 
                                                    pattern=".{10,}"
                                                    titile="This Field Require At Least Ten Characters"
                                                    type="text" 
                                                    name="description" 
                                                    class="form-control live-desc"
                                                    required
                                                    autocomplete="off"
                                                    placeholder="Description Of The Item" >
                                            </div>
                                        </div>              
                                        <!-- End Description field -->
                                        <!-- Start Price field -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 control-label">Price</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input 
                                                    type="text" 
                                                    name="price" 
                                                    class="form-control live-price"
                                                    required
                                                    autocomplete="off"
                                                    placeholder="Price Of The Item" >
                                            </div>
                                        </div>              
                                        <!-- End Price field -->
                                        <!-- Start Country field -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 control-label">Country</label>
                                            <div class="col-sm-10 col-md-9">
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
                                            <div class="col-sm-10 col-md-9">
                                                <select name="status" required>
                                                    <option value="">...</option>
                                                    <option value="1">New</option>
                                                    <option value="2">Like New</option>
                                                    <option value="3">Used</option>
                                                    <option value="4">Very Old</option>
                                                </select>
                                            </div>
                                        </div>              
                                        <!-- End Status field -->
                                        <!-- Start Category field -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 control-label">Category</label>
                                            <div class="col-sm-10 col-md-9">
                                                <select name="category" required>
                                                    <option value="">...</option>
                                                    <?php
                                                    $cats = getAllFrom('categories');
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
                            
                            <div class="col-md-4">
                                <div class="card Live-Preview">
                                    <div class="card-hover">$<span class="price-carde">0</span></div>
                                        <img src="cards.jpg" class="card-img-top" alt="joker" title="Card-joker">
                                        <div class="card-body">
                                            <h5 class="card-title">Title</h5>
                                            <p class="card-text">Description</p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="erros">
                <?php
                    if(! empty($formErrors)){
                        foreach($formErrors as $error){

                            echo '<div class="alert alert-danger">' . $error . '</div>';

                        }
                    }
                ?>
            </div>
        </div>
    </div>

  


<?php

    }else{

        header('Location:login.php');

        exit();
    }
     include  $tem . 'footer.php';   #page footer  
 ?>  