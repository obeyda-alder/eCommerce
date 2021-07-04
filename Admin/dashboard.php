<?php 
      
      session_start();

      if(isset($_SESSION['Username'])){

        $pageTitle = 'dashboard';
        include 'init.php';  
        
        $numUser = countItem('Username', 'users'); // Number Of Latest User by function 

        $LatestUsers = getLatest("*", "users", "UserID" , $numUser, "GroupID", 1); // Latest Users array


        $numitem = countItem('Name', 'items'); // Number Of Latest Item by function 

        $LatestItems = getLatest("*", "items", "Item_ID" , $numitem, "Item_ID", 100000); // Latest Items array

        ?>


        <div class="home-stats">
          <div class="container text-center">
              <h2><i class="fas fa-chart-line"></i> Dash Board</h2>
              <div class="row">
                  <div class="col-md-3">
                    <div class="stat st-members">
                      <i class="fas fa-users"></i>
                        <div class="info">
                          Total Members
                            <span><a href="members.php"><?php  echo checkItem ('GroupID' , 'users', 0); ?></a></span>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="stat st-pending">
                        <i class="fas fa-user-plus"></i>
                        <div class="info">
                            Pending  Members
                            <span><a href="members.php?do=Manage&page=Pending"><?php  echo checkItem('RegStatus' , 'users' , '0' ); ?></a></span>
                        </div>
                  </div>
                  </div>
                  <div class="col-md-3">
                    <div class="stat st-items">
                      <i class="fas fa-tags"></i>
                        <div class="info">
                            Total Items
                            <span><a href="items.php"><?php  echo countItem ('Item_ID' , 'items'); ?></a></span>
                        </div>
                  </div>
                  </div>
                  <div class="col-md-3">
                    <div class="stat st-comments">
                      <i class="fas fa-comments"></i>
                         <div class="info">
                             Total Comments
                           <span><a href="comments.php"><?php  echo countItem ('comment' , 'comments'); ?></a></span>
                         </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>

        <div class="latest mt-3 mb-5">
          <div class="container">
              <div class="row">
                  <div class="col-md-6">
                    <div class="card">
                          <div class="card-heading">
                            <i class="fa fa-users"></i> Latest [ <?php  echo checkItem ('GroupID' , 'users', 0); ?> ] Registerd Users
                             <span class="toggel-info float-right">
                               <i class="fas fa-plus"></i>
                             </span>
                          </div>
                          <div class="card-body">
                            <ul class="list-group latest-users">
                              <?php  
                              if(! empty($LatestUsers)){
                                foreach($LatestUsers as $user){
                                  echo '<li class="list-group-item">';
                                    echo  $user['Username'];
                                      if($user['RegStatus'] == 0){
                                        echo '<a href="members.php?do=activate&userid=' . $user['UserID'] . '" class="btn btn-info ml-2 float-right"><i class="fas fa-check"></i> Activate</a>';
                                      }
                                    echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                      echo '<span class="btn btn-success float-right">';
                                        echo '<i class="fas fa-edit"></i>';
                                        echo 'Edit';
                                      echo '</span>';
                                    echo '</a>';
                                  echo '</li>';
                                }
                              }else{
                                echo '<div class="container alert alert-secondary">';
                                echo 'There\'s No Record To Show';
                                echo '</div>';
                              }
                              ?>
                            </ul>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                          <div class="card-heading">
                            <i class="fa fa-tag"></i> Latest [ <?php echo $numitem; ?> ] Items
                            <span class="toggel-info float-right">
                               <i class="fas fa-plus"></i>
                             </span>
                          </div>
                          <div class="card-body">
                            <ul class="list-group latest-users">
                                <?php  
                                if(! empty($LatestItems)){
                                  foreach($LatestItems as $item){

                                    echo '<li class="list-group-item">';
                                      echo  $item['Name'];
                                        if($item['Approve'] == 0){
                                          echo '<a href="items.php?do=Approved&itemid=' . $item['Item_ID'] . '" class="btn btn-info ml-2 float-right"><i class="fas fa-check"></i>Approve</a>';
                                        }
                                      echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                                        echo '<span class="btn btn-success float-right">';
                                          echo '<i class="fas fa-edit"></i>';
                                          echo 'Edit';
                                        echo '</span>';
                                      echo '</a>';
                                    echo '</li>';
                                  }
                                }else{   
                                  echo '<div class="container alert alert-secondary">';
                                  echo 'There\'s No Record To Show';
                                  echo '</div>';
                                }
                                ?>
                              </ul>    
                          </div>
                      </div>
                  </div>
              </div>
            <!-- Start Latest Comments -->
            <div class="row mt-5 mb-2">
                  <div class="col-md-6">
                    <div class="card">
                          <div class="card-heading">
                            <i class="fa fa-comments"></i> Latest [ <?php echo countItem("comment", "comments") ?> ] Comments
                             <span class="toggel-info float-right">
                               <i class="fas fa-plus"></i>
                             </span>
                          </div>
                          <div class="card-body">
                        <?php   $stmt = $con->prepare(" SELECT
                                                          comments.*,
                                                          users.Username AS User_from_comments
                                                      FROM 
                                                          comments
                                                      INNER JOIN 
                                                          users
                                                      ON
                                                          users.UserID = comments.user_id");
                              // Execute the statement 
                              $stmt->execute();
                              // Fetch All data And Assign To Variable 
                              $comments = $stmt->fetchAll();
                              if(! empty($comments)){
                                foreach($comments as $comment){
                                  echo '<div class="comment-box">';
                                  echo '<span class="user-name">' . $comment['User_from_comments'] . '</span>';
                                  echo '<p class="user-comm">' . $comment['comment'] . '</p>';
                                  echo '</div>';
                                }
                              }else{
                               echo '<div class="container alert alert-secondary">';
                               echo 'There\'s No Record To Show';
                               echo '</div>';
                              }
                              ?>
                          </div>
                      </div>
                  </div>
                </div>
            <!-- End Latest Comments -->
          </div>
        </div>
       
<?php    include $tem . 'footer.php';   #page languages

    } else{
            
            header('Location:index.php'); // Redirict To Dashboard Page 

            exit();
        }
    
