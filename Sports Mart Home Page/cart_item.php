<?php
    session_start();
    require_once "header.php";

    $sucess_message = 0;
    if(isset($_SESSION['email']))
    {
        if(isset($_POST['remove_item'])){
            $remove_item_query = $pdo->prepare("DELETE FROM customer_cart WHERE product_id = :product_id AND E_mail_id = :E_mail_id");
            $remove_item_query ->execute(array(':product_id' => $_POST['product_id_remove'],':E_mail_id' => $_SESSION['email']));

            $product_quentity_inc = $pdo->prepare("UPDATE list_of_sports_item SET Quantity = Quantity + 1 WHERE product_id = :product_id");
            $product_quentity_inc -> execute(array(':product_id' => $_POST['product_id_remove']));
            $sucess_message = 1;
        }
    }

    if(isset($_SESSION['email']))
    {
        if(isset($_POST['purchase_product']))
        {
            $purchase_item_querty = $pdo->prepare("UPDATE list_of_sports_item SET product_status = 'YES' WHERE product_id = :product_id");
            $purchase_item_querty->execute(array(':product_id' => $_POST['purchase_product_item']));

            $select_all_columns = $pdo->prepare("SELECT product_id, product_name, model_name,color, Quantity, actual_price, price, 
                                        product_image,rating_of_sports_item FROM list_of_sports_item WHERE product_id =:product_id");
            $select_all_columns -> execute(array(':product_id' => $_POST['purchase_product_item']));
            $fetch_select_all_columns_query = $select_all_columns->fetch(PDO::FETCH_ASSOC);

            $purchase_item_querty = $pdo->prepare("INSERT INTO purchased_item (E_mail_id,product_id,product_name,color,model_name,
                                        product_status,actual_price,price,product_image,rating_of_sports_item)
            VALUES(:E_mail_id,:product_id,:product_name,:color,:model_name,:product_status,:actual_price,:price,:product_image,:rating_of_sports_item)");

            $purchase_item_querty->execute(array(':E_mail_id' => $_SESSION['email'],
                                             ':product_id' => $fetch_select_all_columns_query['product_id'],
                                                 ':product_name' => $fetch_select_all_columns_query['product_name'],
                                                 ':color' => $fetch_select_all_columns_query['color'],
                                                 ':model_name' => $fetch_select_all_columns_query['model_name'],
                                                 ':product_status' =>'YES',
                                                 ':actual_price' => $fetch_select_all_columns_query['actual_price'],
                                                 ':price' => $fetch_select_all_columns_query['price'],
                                                 ':product_image' => $fetch_select_all_columns_query['product_image'],
                                                 ':rating_of_sports_item' => $fetch_select_all_columns_query['rating_of_sports_item']));

            $remove_item_query_purchased = $pdo->prepare("DELETE FROM customer_cart WHERE product_id = :product_id AND E_mail_id = :E_mail_id");
            $remove_item_query_purchased ->execute(array(':product_id' => $_POST['product_id_remove'],':E_mail_id' => $_SESSION['email']));

            echo '<script>swal("'.$fetch_select_all_columns_query['product_name'].' Purchased Successfully","","success")</script>';
        }
    }
    if(isset($_SESSION['email']))
    {
        if(isset($_POST['empty_cart_delete']))
        {
            $list_book_join_custemer_cart=$pdo->prepare("SELECT customer_cart.product_id, list_of_sports_item.product_id FROM customer_cart
                    INNER JOIN list_of_sports_item ON customer_cart.product_id = list_of_sports_item.product_id WHERE E_mail_id = :E_mail_id");
            $list_book_join_custemer_cart->execute(array(':E_mail_id'=>$_SESSION['email']));

            while($row_select_all_product = $list_book_join_custemer_cart->fetch(PDO::FETCH_ASSOC))
            {
                $Quantity_increase = $pdo->prepare("UPDATE list_of_sports_item SET Quantity = Quantity + 1 WHERE product_id = :product_id");
                $Quantity_increase->execute(array(':product_id' =>  $row_select_all_product['product_id']));

                $remove_all_cart_item_query = $pdo->prepare("DELETE FROM customer_cart WHERE product_id = :product_id AND E_mail_id = :E_mail_id");
                $remove_all_cart_item_query ->execute(array(':product_id' => $row_select_all_product['product_id'],':E_mail_id' => $_SESSION['email']));
            }
        }
    }
?>

<div class="container w-70">
    <nav class="navbar bg-info navbar-default fixed-top">
    <a href="sports_shopping_home_page.php" class ="navbar-brand">
            <h3 class="px-2">
                <i class="fas fa-shopping-basket"></i><span class ="text-warning ml-2">Sports Mart</span>
            </h3>
    </a>
    <h3 class = "text-success">
        <?php if($sucess_message == 1)
            {
                echo "<script>swal('Product Removed By The Cart','','success')</script>";
            }
        ?></h3>
    <?php
        if(isset($_SESSION['email'])){
            echo '<h3 class="text-success mr-4">Welcome : '.$_SESSION['name'].'</h3>';
        }
    ?>

    </nav>
    <div class="row">
        <div class="col-md-7">
            <div class="shopping-cart pt-2">
                <span><h3 class = "text-info pt-5 mt-3 ">My cart</h6></span>
                <form action="cart_item.php" method = "post">
                    <span>
                        <?php
                            $select_product_unique=$pdo->prepare("SELECT count(product_id) AS prodct_id_unique FROM customer_cart WHERE E_mail_id = :E_mail_id");
                            $select_product_unique->execute(array(':E_mail_id' => $_SESSION['email']));
                            $row_fetching = $select_product_unique->fetch(PDO::FETCH_ASSOC);
                            if($row_fetching['prodct_id_unique'] > 1){
                                echo "<input class = 'btn btn-danger text-white' type='submit' value='Empty Cart' name='empty_cart_delete' id='empty_cart'>";
                            }
                        ?>

                    </span>
                </form>
                <hr class="text-white">
                <?php
                    $total = 0;
                    $discount_price = 0;
                    if(isset($_SESSION['email']))
                    {
                        $cart_items_count = $pdo->prepare("SELECT count(*) AS item_count FROM customer_cart WHERE E_mail_id = :emailid");
                        $cart_items_count->execute(array(':emailid' => $_SESSION['email']));
                        $fetch_cart_items_count = $cart_items_count->fetch(PDO::FETCH_ASSOC);
                        if($fetch_cart_items_count['item_count']<1){
                            echo "<h2 class='text-warning mt-5 pt-3 pl-5 ml-3'>Cart is Empty</h2>";
                        }
                        $cart_items = $pdo->prepare("SELECT * FROM customer_cart WHERE E_mail_id = :emailid");
                        $cart_items->execute(array(':emailid' => $_SESSION['email']));
                        while($fetch_cart_items = $cart_items->fetch(PDO::FETCH_ASSOC))
                        {
                            cart_element($fetch_cart_items['product_image'],$fetch_cart_items['color'],$fetch_cart_items['product_name'],$fetch_cart_items['price'],$fetch_cart_items['model_name'],$fetch_cart_items['actual_price'],$fetch_cart_items['product_id'],$fetch_cart_items['rating_of_sports_item']);
                            $total = $total + (int)$fetch_cart_items['price'];
                            $discount_price = $discount_price + ($fetch_cart_items['actual_price'] - (int)$fetch_cart_items['price']);
                        }
                    }
                    else{
                        echo "<h2 class='text-warning mt-5 pt-3 pl-5 ml-3'>Log in to View the cart item</h2>";
                    }
                ?>
            </div>
        </div>
        <?php
        if(isset($_SESSION['email']))
        {
        echo '<div class="col-md-4 offset-md-1 border-rounded bg-white h-25 float-right" style="margin-top:10%">';
            echo '<div class="pt-4 ml-3">';
                echo '<h6 class="text-success">PRICE DETAILS</h6>
                <hr>
                <div class="row price-details p-2">
                    <div class="col-md-6">';
                        if(isset($_SESSION["email"])){
                            $count = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE E_mail_id = :E_mail_id");
                            $count->execute(array(":E_mail_id" => $_SESSION["email"]));
                            $count_number = $count->fetch(PDO::FETCH_ASSOC);
                            echo "<h5>Price (".$count_number["productidunique"]." items)</h5>
                            <h5> Discount </h5>";
                        }
                       echo'<h5>Delivary charges</h5>
                        <hr>
                        <h5>Total Amount</h5>
                    </div>
                    <div class="col-md-6 pl-5">
                        <h5>₹ '.$total.'</h5>
                        <h5 class="text-success"> -₹'.$discount_price.'</h5>
                        <h5 class="text-success">FREE</h5>
                        <hr>
                        <h5>₹'. $total.'</h5>
                    </div>
                    <hr>
                    <h5 class="text-success">You will save ₹'.$discount_price.' on this order</h5>
                </div>
              </div>
           </div>';

           $select_address_details=$pdo->prepare("SELECT * FROM first_address WHERE E_mail_id = :E_mail_id");
           $select_address_details->execute(array(':E_mail_id' => $_SESSION['email']));
           $fetch_all=$select_address_details->fetch(PDO::FETCH_ASSOC);
            
           $select_customer_details=$pdo->prepare("SELECT count(E_mail_id) AS email_id_present FROM customer_cart WHERE E_mail_id = :E_mail_id");
           $select_customer_details->execute(array(':E_mail_id' => $_SESSION['email']));
           $fetch_all_custemer=$select_customer_details->fetch(PDO::FETCH_ASSOC);

        if($fetch_all_custemer['email_id_present'] > 0)
        {
            echo '<div class="h-26 col-md-3 bg-white" id="address">
                    <div class="pt-4 ml-3">
                        <h6 class="text-success">ADDRESS DETAILS</h6>
                        <hr>
                        <div class="row price-details p-2">
                            <div class="col-md-12">
                            <h5>'.$fetch_all['first_name'].'</h5>
                                <p class="text-dark">
                                    '.$fetch_all['landmark'].','.$fetch_all['address1'].','.$fetch_all['locality'].','.$fetch_all['city'].'
                                    ,'.$fetch_all['state1'].'-'.$fetch_all['pincode'].' 
                                </p> 
                                <h6>'.$fetch_all['p_number'].'</h6>
                            </div>
                        </div>
                    </div>
                </div>';
        }
}

?>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
        require_once "footer_sports.php";
    ?>