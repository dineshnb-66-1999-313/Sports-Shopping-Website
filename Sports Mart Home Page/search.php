<?php
    session_start();
    require_once "header.php";
    
    if(isset($_POST['add_to_cart']))
    {
        if(isset($_SESSION['email']))
        {   
            $select_address=$pdo->prepare("SELECT COUNT(E_mail_id) AS emailunique FROM first_address WHERE E_mail_id = :E_mail_id");
            $select_address->execute(array(':E_mail_id' => $_SESSION['email']));
            $fetch_address_unique = $select_address ->fetch(PDO::FETCH_ASSOC);

            if($fetch_address_unique['emailunique']==1)
            {
                $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE product_id = :product_id AND E_mail_id = :E_mail_id");
                $productidunique->execute(array(':product_id' => $_POST['product_id'],':E_mail_id' => $_SESSION['email']));
                $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);

                if($fetch_unique_of_product_id['productidunique']<1)
                {
                    $first_query = $pdo->prepare("SELECT * FROM list_of_sports_item WHERE product_id =:product_id");
                    $first_query -> execute(array(':product_id' => $_POST['product_id']));
                    $fetch_first_query = $first_query->fetch(PDO::FETCH_ASSOC);

                    $second_query = $pdo->prepare("INSERT INTO customer_cart (product_id, product_name, model_name, color,actual_price, price, product_image, E_mail_id,rating_of_sports_item) 
                                    VALUES (:product_id, :product_name, :model_name, :color,:actual_price, :price, :product_image, :E_mail_id,:rating_of_sports_item) ");
                    $second_query -> execute(array(':product_id' => $fetch_first_query['product_id'],
                                                ':product_name' => $fetch_first_query['product_name'], 
                                                ':model_name' => $fetch_first_query['model_name'],
                                                ':color' => $fetch_first_query['color'],
                                                ':actual_price' => $fetch_first_query['actual_price'],
                                                ':price' => $fetch_first_query['price'],
                                                ':product_image' => $fetch_first_query['product_image'],
                                                ':E_mail_id' => $_SESSION['email'],
                                                ':rating_of_sports_item' => $fetch_first_query['rating_of_sports_item']));  

                    $third_query = $pdo->prepare("UPDATE list_of_sports_item SET Quantity = Quantity - 1 WHERE product_id = :product_id");
                    $third_query -> execute(array(':product_id' => $_POST['product_id']));
                    echo '<script>swal("'.$fetch_first_query['product_name'].' Sports item Successfully Added to cart"," ","success").then(function(){window.location = "sports_shopping_home_page.php";});</script>';
                }   
                else
                {
                    echo '<script>swal("Sorry!!","Product is alredy there in the cart","warning").then(function(){window.location = "sports_shopping_home_page.php";});</script>';
                
                } 
            }  
            else
            {
                header('Location: address.php');
            }   
        }
        else
        {
            echo '<script>swal("Something wrong!!","Please login to the website to buy the Products","warning").then(function(){window.location = "sports_shopping_home_page.php";});</script>';
        }   
    }
?>
<div class="container ml-2" style="max-width: 100%;">
    <nav class="navbar bg-info navbar-default fixed-top">
        <a href="sports_shopping_home_page.php" class ="navbar-brand">
            <h3 class="px-2">
                <i class="fas fa-shopping-basket"></i><span class ="text-warning ml-2">Sports Mart</span>
            </h3>
        </a>
        <?php
            if(isset($_SESSION['email'])){
                echo '<h3 class="text-dark">Welcome : <span class = "text-secondary pr-5">'.$_SESSION['name'].'</span></h3>';
            }
        ?>
        
        <form class="form-inline" action="search.php" method="post">
                <input class="form-control" type="text" placeholder="Search" name="value_field" required="required">
                <button style="margin-left:25%;" class="btn btn-warning btn-rounded btn-outline-success btn-xl ml-4 mr-0" type="submit" name="search">Search</button>
        </form>
        <?php
            if(isset($_SESSION['email']))
            {
                $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE E_mail_id = :E_mail_id");
                $productidunique->execute(array(':E_mail_id' => $_SESSION['email']));
                $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);
                    echo '<h4 class="text-warning">
                            <a href="cart_item.php" class = "nav-link"><i class = "fa fa-shopping-cart text-warning"></i><span class="text-white ml-2">Cart
                            <span class="text-success">('.$fetch_unique_of_product_id['productidunique'].')</span>
                            </a>
                        </h4>';
            }
        ?>
    </nav> 
    <div class="row text-center pl-1 ml-1">
    <h3 class = "text-info" style="margin-top:5%;">
    </h3>
        <?php
            if(isset($_POST['search']))
            {
                $value_filter = $_POST['value_field'];

                $sql = "SELECT count(*) FROM list_of_sports_item WHERE (product_name LIKE '%$value_filter%' OR 
                                                    model_name LIKE '%$value_filter%') AND Quantity > 0 AND product_status !='YES'";
                $res = $pdo->query($sql);
                $count = $res->fetchColumn();

                echo '<div class="row text-center mt-2">
                    <h3 class="text-white""><b>There are <span class="text-success">'.$count.'</span> matching record.</b></h3>
                    </div>';

                $search = $pdo->prepare("SELECT * FROM list_of_sports_item WHERE (product_name LIKE '%$value_filter%' OR 
                                                    model_name LIKE '%$value_filter%') AND Quantity > 0 AND product_status !='YES'");
                $search->execute();
                while($row = $search->fetch(PDO::FETCH_ASSOC))
                {
                    product_items($row['product_name'],$row['color'],$row['actual_price'],$row['price'],$row['model_name'],
                                                    $row['product_image'],$row['Quantity'],$row['product_id'],$row['rating_of_sports_item']);
                }
            }
        ?>
    </div>
</div><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
        require_once "footer_sports.php";
?>
</body>
</html>
    
