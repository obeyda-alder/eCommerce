<?php 
      
      session_start();
      $noNavbar = '';

      $pageTitle = 'Login';
      
      if(isset($_SESSION['Username'])){
        header('Location:dashboard.php'); // Redirict To Dashboard Page 
      }
     
    include 'init.php';  #page init

    // Check If user coming from HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      $username = $_POST['user'];
      $password = $_POST['pass'];
      $hashedpass = sha1($password);

      // check if the user Exist In Database

      $stmt = $con->prepare("SELECT 
                               UserID ,  Username , Password 
                            FROM 
                               users
                            WHERE 
                                Username = ? 
                            AND 
                                Password = ? 
                            AND 
                                GroupID = 1
                            LIMIT 1");
      $stmt->execute(array($username , $hashedpass));
      $row = $stmt->fetch();
      $count = $stmt->rowCount(); // this is return status about connection (1 Or 0 ) 0 -> no connection !== 1 -> yes the user Existing in database



      // If count > 0 this Mean the Database contain record about this username

      if($count > 0){
          $_SESSION['Username'] = $username ; // Register Session Name
          $_SESSION['ID'] = $row['UserID'] ; // Register Session ID
          header('Location:dashboard.php'); // Redirect To Dashboard Page 
          exit();
      }

    }
    
?>

    <form action="<?php  echo $_SERVER['PHP_SELF']?>" method="POST" class="login">

      <i class="fas fa-key fa-4x"></i>
      <h4 class="text-center">ADMIN PANEL</h4>
      <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
      <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
      <input class="btn btn-secondary btn-block" type="submit" value="Login">

    </form>






<?php 
     include  $tem . 'footer.php';   #page footer  
 ?>  