<?php 
    session_start();

    $pageTitle = 'Index';
      
    include 'init.php';  #page init  ?>

    <div class="container mt-5">
        <div class="row">
                <?php
                $allItems = getAllFrom('Items', 'WHERE Approve = 1');
                    foreach( $allItems as $item){
                        
                            echo '<div class="col-sm-6 col-md-4 mt-2">';
                                echo '<div class="card mt-2">';
                                if($item['Approve'] == 0){echo '<div class="Approved">Not Approved</div>'; }
                                echo '<span class="card-text price-card">' . $item['Price'] . '</span>';
                                echo '<img src="cards.jpg" class="card-img-top" alt="joker" title="Card-joker">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title"><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h5>';
                                echo '<p class="card-text">' . $item['Description'] . '</p>';
                                echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
            
            ?>
        </div>
    </div>

<?php  include  $tem . 'footer.php';   #page footer  ?>  