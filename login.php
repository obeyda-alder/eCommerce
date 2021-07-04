<?php  
   
   session_start();
   $pageTitle = 'Login';
   if(isset($_SESSION['user'])){
       header('Location:index.php');
   } 

    include 'init.php';  #page init 

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){

        

        $user = $_POST['username'];
        $pass = $_POST['password'];

        $hashPass = sha1($pass);

        // check if the user Exist In database
        $stmt = $con->prepare(" SELECT 
                                    UserID, Username , Password  
                                FROM   
                                    users
                                WHERE
                                     Username = ? 
                                AND 
                                    Password = ? ");

        $stmt->execute(array($user, $hashPass));
        $uid = $stmt->fetch();
        $count = $stmt->rowCount();

        if($count > 0){

            $_SESSION['user'] = $user;

            $_SESSION['uId'] = $uid['UserID'];

             header('Location:index.php');

             exit();
        }

    }else{

            $formErrors = array();

            $Username       = $_POST['username'];
            $password1      = $_POST['password'];
            $password2      = $_POST['password-again'];
            $email          = $_POST['email'];

            if(isset($Username)){
                $filterUser = filter_var($Username, FILTER_SANITIZE_STRING);
                if(strlen($filterUser) < 4){
                    $formErrors[] =  'Username Must Be Larger Than Four Characters';
                }
            }

            if(isset($password1) && isset($password2) ){

                if(empty($password1)){

                    $formErrors[] = 'Sorry Password cant Be Empty';

                }

                if(sha1($password1) !== sha1($password2)){
                    $formErrors[] =  'Sorry Password Is Not Match';
                }
            }

            if(isset($email)){
                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                if(filter_var($email, FILTER_VALIDATE_EMAIL) != true){

                    $formErrors[] =  'This Email Is Not Valid';

                }
            }

            // check If There's No Errors Proceed When The User Add 
            if(empty($formErrors)){

                // check If User Exist In Database
               $check =  checkItem('Username' , 'users' , $Username );

               if($check == 1){

                $formErrors[] =  'Sorry This Username Is Exists';

               }else {

                $stmt = $con->prepare("INSERT INTO 
                                 users(Username, Password, Email, RegStatus, Date) 
                                      VALUES( :zuser, :zpass, :zemail, 0, now())");
                    $stmt->execute(array(
                        'zuser'     => $Username,
                        'zpass'     => sha1($password1),
                        'zemail'    => $email
                    ));

                    $successMsg = 'Congrats You Are new Register User';

               }

            }

    }

    }

    ?>
 
    <div class="container login-page">
        <h2 class="text-center"><span class="selected" data-class=".login">Login</span> | <span data-class=".signup">SignUp</span></h2>
        <form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
            <div class="form-ast">
                <input 
                    pattern=".{4,}"
                    title="Username Must Be Larger Than Four Characters"
                    class="form-control" 
                    type="text" 
                    name="username" 
                    autocomplete="off"
                    placeholder="User Name" 
                    required >
            </div>
            <div class="form-ast">
                <input 
                    minlength="4"
                    title="Please Type Your Password"
                    class="form-control" 
                    type="password" 
                    name="password" 
                    autocomplete="new-password"
                    placeholder="Password" 
                    required >
            </div>
            <input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
        </form>

        <!-- form for register new users -->
        <!-- form for register new users -->
        <form class="signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
            <div class="form-ast">
                <input 
                    pattern=".{4,}"
                    title="Username Must Be Larger Than Four Characters"
                    class="form-control" 
                    type="text" 
                    name="username" 
                    autocomplete="off"
                    placeholder="User Name"
                    required >
            </div>
            <div class="form-ast">
                <input 
                    minlength="4"
                    class="form-control" 
                    title="Please Type Your Password"
                    type="password" 
                    name="password" 
                    autocomplete="new-password"
                    placeholder="Password"
                    required >
            </div>
            <div class="form-ast">
                <input 
                    minlength="4"
                    class="form-control" 
                    title="Please Type Your Password"
                    type="password" 
                    name="password-again" 
                    autocomplete="new-password"
                    placeholder="Again Password"
                    required >
            </div>
            <div class="form-ast">
                <input 
                    class="form-control" 
                    title="Please Type Your Email"
                    type="email" 
                    name="email" 
                    autocomplete="off"
                    placeholder="Email" 
                    required >
            </div>
            <input class="btn btn-success btn-block" name="signup" type="submit" value="Signup">
        </form>

        <div class="the-errors text-center">
            <?php
              if(! empty($formErrors)){
                  foreach($formErrors as $error){

                    echo '<div class="alert alert-danger w-25 p-2 m-auto">' . $error . '</div>';
                  }
              }
              if(isset($successMsg)){
                echo '<div class="alert alert-success w-25 p-2 m-auto">' . $successMsg . '</div>';
              }

            ?>
        </div>
    </div>

<?php include  $tem . 'footer.php';   #page footer ?>  