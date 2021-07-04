<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle(); ?></title>
    <link rel="stylesheet" href="<?php  echo $css ;?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php  echo $css ;?>all.min.css" />
    <link rel="stylesheet" href="<?php  echo $css ;?>brands.min.css" />
    <link rel="stylesheet" href="<?php  echo $css ;?>fontawesome.min.css" />
    <link rel="stylesheet" href="<?php  echo $css ;?>jquery-ui.min.css" />
    <link rel="stylesheet" href="<?php  echo $css ;?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php  echo $css ;?>frontEnd.css" />
</head>
<body>
    <div class="upper-bar">
        <div class="container">
            <?php 
                 if(isset($_SESSION['user'])){ ?> 

                    <img src="cards.jpg" class="img-thumbnail rounded-circle my-image" />
                    <div class="dropdown d-inline my-drop">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionUser; ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Profile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="newAd.php">My Ad</a></li>
                            <li><a class="dropdown-item" href="Profile.php#Items">My Items</a></li>
                            <li><a class="dropdown-item" href="Logout.php">Logout</a></li>
                        </ul>
                    </div>

        <?php        } else{     ?>
                        
                      <a href="login.php">
                         <span class="">Login/Signup</span>
                     </a>
               <?php }  ?>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="index.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    
                <div class="collapse navbar-collapse  justify-content-end" id="app-nav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                       <?php
                        foreach(getCats() as $cat){
                            echo '<li class="nav-item"><a class="nav-link" href="categories.php?pageid=' . $cat['ID'] .'">' . $cat['Name'] . '</a></li>';
                        }
                       ?>
                    </ul>
            </div>
        </div>
    </nav>

