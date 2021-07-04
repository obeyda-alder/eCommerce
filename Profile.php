<?php 
    session_start();

    $pageTitle = 'Profile';
      
    include 'init.php';  #page init

    if(isset($_SESSION['user'])){

        $getUser = $con->prepare("SELECT * FROM users WHERE Username = ? ");
        $getUser->execute(array($sessionUser));
        $info = $getUser->fetch();


?>

        <h2 class="text-center">My Profile</h2>
    <div class="information mt-4">
        <div class="container">
      <div class="row">
            <div class="card border-primary mb-3 w-100">
                <div class="card-header">Information</div>
                    <div class="card-body card-span">
                    <i class="fas fa-unlock-alt fa-fw"></i>
                    Name:<span class="card-text text-primary"> <?php echo $info['Username']; ?></span><hr>
                    <i class="far fa-envelope fa-fw"></i>
                    Email:<span class="card-text text-primary"> <?php echo $info['Email']; ?></span><hr>
                    <i class="fas fa-user fa-fw"></i>
                    Full Name:<span class="card-text text-primary"> <?php echo $info['FullName']; ?></span><hr>
                    <i class="fas fa-calendar-alt fa-fw"></i>
                    Register Date:<span class="card-text text-primary"> <?php echo $info['Date']; ?></span><hr>
                    <i class="fas fa-tags fa-fw"></i>
                    Favourite Category:<span class="card-text text-primary"> <?php echo $info['UserID']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <div class="my-advs mt-4">
        <div class="container">
            <div class="card border-primary mb-3 w-100">
                <div class="card-header" id="Items">My Items</div>
                    <div class="card-body">
                    <?php
                    if(! empty(getitems('Member_ID', $info['UserID']))){
                        echo '<div class="row">';
                        
                        foreach(getitems('Member_ID', $info['UserID'], 1) as $item){
                            
                                echo '<div class="col-sm-6 col-md-4 mt-2">';
                                    echo '<div class="card">';
                                    if($item['Approve'] == 0){echo '<div class="Approved">Not Approved</div>'; }
                                    echo '<span class="card-text card-hover">' . $item['Price'] . '</span>';
                                    echo '<img src="cards.jpg" class="card-img-top" alt="joker" title="Card-joker">';
                                    echo '<div class="card-body">';
                                        echo '<h5 class="card-title"><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h5>';
                                        echo '<p class="card-text">' . $item['Description'] . '</p>';
                                        echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        echo '</div>';
                    }else {

                        echo "There's No Ads To Show, Create New Ad <a href='newAd.php'>New Ad</a>";
                    }

                            
                            ?>
                </div>
            </div>
        </div>
    </div>

  <div class="my-comment mt-4">
        <div class="container">
         <div class="row">
            <div class="card border-primary mb-3 w-100">
                <div class="card-header">my comment</div>
                    <div class="card-body text-primary">
                        <?php
                          $getcom = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");
                          $getcom->execute(array($info['UserID']));
                          $comments = $getcom->fetchAll();
                          
                          if(! empty($comments)){
                              

                              foreach($comments as $comment){
                                  echo '<p>' . $comment['comment'] . '</p>';
                              }
                              echo '</div>';

                          }else{
                              echo "There's No Comment To Show";
                          }
                        ?>
                </div>
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