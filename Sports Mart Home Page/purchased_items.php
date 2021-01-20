
<?php
    session_start();
    require_once "header.php";
?>

<div class="container w-70">
    <nav class="navbar bg-info navbar-default fixed-top">
    <a href="sports_shopping_home_page.php" class ="navbar-brand">
            <h3 class="px-2">
                <i class="fas fa-shopping-basket"></i><span class ="text-warning ml-2">Sports Mart</span>
            </h3>
    </a>
    <?php
        if(isset($_SESSION['email'])){
            echo '<h3 class="text-success mr-4">Welcome : '.$_SESSION['name'].'</h3>';
        }
    ?>
    
    </nav> 
    <div class="row px-0">
        <div class="col-md-7">
            <div class="shopping-cart pt-2">
                <h3 class = "text-info pt-5 mt-3 ">My orders</h6>
                <hr class="text-white">
                <?php
                    if(isset($_SESSION['email']))
                    {
                        $order_items_count = $pdo->prepare("SELECT count(*) AS item_count FROM purchased_item WHERE E_mail_id = :emailid");
                        $order_items_count->execute(array(':emailid' => $_SESSION['email']));
                        $fetch_order_items_count = $order_items_count->fetch(PDO::FETCH_ASSOC);
                        if($fetch_order_items_count['item_count']<1){
                            echo "<h2 class='text-warning mt-5 pt-3 pl-5 ml-3'>Move to Home Page and Purchase the Product</h2>";
                        }
                        $cart_items = $pdo->prepare("SELECT * FROM purchased_item WHERE E_mail_id = :emailid");
                        $cart_items->execute(array(':emailid' => $_SESSION['email']));
                        while($fetch_cart_items = $cart_items->fetch(PDO::FETCH_ASSOC))
                        {
                            my_oder($fetch_cart_items['product_image'],$fetch_cart_items['color'],$fetch_cart_items['product_name'],$fetch_cart_items['price'],$fetch_cart_items['model_name'],$fetch_cart_items['actual_price'],$fetch_cart_items['product_id'],$fetch_cart_items['rating_of_sports_item']);
                        }
                    }
                    else{
                        echo "<h2 class='text-warning mt-5 pt-3 pl-5 ml-3'>Log in to View the ordered item</h2>";
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
        $select_address_details=$pdo->prepare("SELECT * FROM first_address WHERE E_mail_id = :E_mail_id");
        $select_address_details->execute(array(':E_mail_id' => $_SESSION['email']));
        $fetch_all=$select_address_details->fetch(PDO::FETCH_ASSOC);
         
        $select_customer_details=$pdo->prepare("SELECT count(E_mail_id) AS email_id_present FROM purchased_item WHERE E_mail_id = :E_mail_id");
        $select_customer_details->execute(array(':E_mail_id' => $_SESSION['email']));
        $fetch_all_custemer=$select_customer_details->fetch(PDO::FETCH_ASSOC);

     if($fetch_all_custemer['email_id_present'] > 0)
     {
         echo '<div class="h-26 col-md-3 bg-white" style="margin-top:2%;margin-right:11rem;margin-left:59rem;position:absolute;top:7rem;">
                 <div class="pt-4 ml-3">
                     <h6>ADDRESS DETAILS</h6>
                     <hr>
                     <div class="row price-details p-2">
                         <div class="col-md-12">
                         <h5>'.$fetch_all['first_name'].'</h5>
                             <p class="text-dark">
                                 '.$fetch_all['landmark'].', '.$fetch_all['address1'].', '.$fetch_all['locality'].', '.$fetch_all['city'].'
                                 , '.$fetch_all['state1'].' - '.$fetch_all['pincode'].' 
                             </p> 
                             <h6>'.$fetch_all['p_number'].'</h6>
                         </div>
                     </div>
                 </div>
             </div>';
     }
    
    ?>
    </div>

<br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
        require_once "footer_sports.php";
    ?>