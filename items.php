<?php 
    session_start();

    $pageTitle = 'Items';
      
    include 'init.php';  #page init

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

    $stmt = $con->prepare("SELECT 
                                items.* , 
                                categories.Name AS cat_nam ,
                                users.Username
                            FROM 
                                 items 
                            INNER JOIN 
                                 categories
                            ON 
                                 categories.ID = items.Cat_ID
                            INNER JOIN
                                  users 
                            ON  
                                 users.UserID = items.Member_ID
                             WHERE 
                                 Item_ID = ? 
                            AND 
                                Approve = 1");
    $stmt->execute(array($itemid));
    $count = $stmt->rowCount();
    if($count > 0){

    
    $item = $stmt->fetch();


?>

 <h2 class="text-center"> <?php echo $item['Name']; ?></h2>
   <div class="container mt-5">
     <div class="row">
       <div class="col-md-4">
           <img src="cards.jpg" class="card-img-top center-block" alt="joker" title="Card-joker">
       </div>
       <div class="col-md-8">
             
            <h4 class="m-2">The Name Is: <?php echo $item['Name'] ?></h4>
            <p class="m-3">Describe: <?php echo  $item['Description']  ?></p>
        <ul class="list-group nth-child">
             
            <li class="list-group-item"><i class="fas fa-calendar-alt fa-fw"></i> <span>Added date: </span><?php echo $item['Add_Date'] ?></li>
            <li class="list-group-item"><i class="fas fa-money-bill-alt"></i> <span>Price: </span><?php echo $item['Price'] ?></li>
            <li class="list-group-item"><i class="fas fa-building"></i> <span>Made In: </span><?php echo $item['Country_Made'] ?></li>
            <li class="list-group-item"><i class="fas fa-tags fa-fw"></i> <span>Category: </span><a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['cat_nam'] ?></a></li>
            <li class="list-group-item"><i class="fas fa-user"></i> <span>Added By: </span><a href="#"><?php echo $item['Username'] ?></a></li>
        </ul>
       </div>
     </div>

     <hr>
     <?php if(isset($_SESSION['user'])) {  ?>
        <!-- Start Add Comment -->
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="form-floating">
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                        <label for="floa">Add Your Comments</label>
                        <textarea class="form-control mb-3" id="floa" name="comment" required></textarea>
                        <input type="submit" class="btn btn-info" value="Add Comment">
                    </form>
                    <?php  
                    
                      if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                        $itemid  = $item['Item_ID'];
                        $userid  = $_SESSION['uId'];

                        if(! empty($comment)){
                            $stmt = $con->prepare("INSERT INTO 
                                            comments(comment, status, comment_date, item_id, user_id)
                                            VALUES(:qcomment, 0, now(), :qitem, :quser) ");
                            $stmt->execute(array(
                                'qcomment'  => $comment,
                                'qitem'     => $itemid,
                                'quser'     => $userid
                            ));
                            if($stmt){
                                echo '<div class="alert alert-success mt-3">Comment Added</div>';
                            }
                        }else{
                            echo '<div class="alert alert-warning mt-2 text-center">You Must Be Writing Something</div>';
                        }
                      }
                    
                    ?>
                </div>
            </div>
        </div>
    <!-- End Add Comment -->
      <?php }else { echo '<div class="text-center"><a href="login.php">Login</a> or <a href="login.php">Register</a> To Here</div>'; } ?>
     <hr>

     <?php   
   
        $stmt = $con->prepare("SELECT comments.*, users.Username AS Users
                                    FROM comments
                                        INNER JOIN users
                                            ON users.UserID = comments.user_id
                                                WHERE item_id = ? 
                                                    AND status = 1
                                                        ORDER BY c_id DESC");
        $stmt->execute(array($item['Item_ID']));
        $coment = $stmt->fetchAll();


        foreach($coment as $show):

            ?>


                <hr>
            <div class="comment-box">
                <div class="row">
                        <div class="col-md-2 text-center">
                                <img src="cards.jpg" class="img-thumbnail rounded-circle d-block text-center" />
                                <div class="text1">
                                <?php echo $show['Users'] ?>
                                </div>
                        </div>

                        <div class="col-md-10">
                            <div class="text">
                                <?php echo  $show['comment']  ?>
                            </div>
                        </div>
                    </div>
            </div>
       
        

<?php  endforeach;

    }else {

        echo '<div class="container text-center">';
        echo '<div class="alert alert-danger mt-5">There\'s No Such ID Or Witing For Approved</div>';
        echo '</div>';
    }

    include  $tem . 'footer.php';   #page footer  
    
    ?>  