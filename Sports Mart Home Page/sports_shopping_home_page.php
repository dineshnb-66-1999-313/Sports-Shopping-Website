<?php
    session_start();
    require_once "header.php";

    if(isset($_POST['logout']))
    {   
        $logout_time_query=$pdo->prepare("UPDATE time_data_sports SET logout_time = now() WHERE E_mail_id=:emailid");
        $logout_time_query->execute(array(':emailid' => $_SESSION['email']));

        $time_spent=$pdo->prepare("UPDATE time_data_sports SET time_spent = TIMEDIFF(logout_time,login_time) WHERE E_mail_id = :emailid");
        $time_spent->execute(array(':emailid' => $_SESSION['email']));

        session_unset();
        session_destroy();
        header('Location: log_out_page_sports.php');
    }
    
    if(isset($_POST['add_to_cart']))
    {
        if(isset($_SESSION['email']))
        {   
            $select_address=$pdo->prepare("SELECT COUNT(E_mail_id) AS emailunique FROM first_address WHERE E_mail_id = :E_mail_id");
            $select_address->execute(array(':E_mail_id' => $_SESSION['email']));
            $fetch_address_unique = $select_address ->fetch(PDO::FETCH_ASSOC);

            if($fetch_address_unique['emailunique']==1)
            {
                $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE product_id = :product_id 
                                                AND E_mail_id = :E_mail_id");
                $productidunique->execute(array(':product_id' => $_POST['product_id'],':E_mail_id' => $_SESSION['email']));
                $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);

                if($fetch_unique_of_product_id['productidunique']<1)
                {
                    $first_query = $pdo->prepare("SELECT * FROM list_of_sports_item WHERE product_id =:product_id");
                    $first_query -> execute(array(':product_id' => $_POST['product_id']));
                    $fetch_first_query = $first_query->fetch(PDO::FETCH_ASSOC);

                    $second_query = $pdo->prepare("INSERT INTO customer_cart (product_id, product_name, model_name, color,actual_price, price, 
                        product_image, E_mail_id,rating_of_sports_item) VALUES (:product_id, :product_name, :model_name, :color,:actual_price, :price, 
                                                  :product_image, :E_mail_id,:rating_of_sports_item)");
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
                    echo '<script>swal("'.$fetch_first_query['product_name'].' Sports item Successfully Added to cart","","success")</script>';
                }   
                else
                {
                    echo '<script>swal("Sorry!!","Product is alredy there in the cart","warning")</script>';
                
                } 
            }  
            else
            {
                header('Location: address.php');
            }   
        }
        else
        {
            echo '<script>swal("Something wrong!!","Please login to the website to buy the Products","error")</script>';
        }   
    }
    
?>
<div class="loaderclass">
        <i class="fa fa-spinner fa-spin fa-5x"></i>
    </div>
<div class="container ml-2" style="max-width: 100%;">
    <div class="row text-center pl-1 ml-4 mt-4 pt-5">
         <nav class="navbar navbar-expand-xs bg-info fixed-top" style="border:1px solid #000;">
            <div class="col-sm-3">
                <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                <a href="sports_shopping_home_page.php" class ="navbar-brand">
                    <h2 class="mr-5">
                        <span class ="text-warning text-dark ml-4 mt-5">Sports Mart</span>
                    </h2>
                </a>
            </div>
        
            <?php
                if(isset($_SESSION['email'])){
                    echo '<h3 class=" text-dark" style="margin-right:15%;;">Welcome : <span class = "text-success pr-5">'.$_SESSION['name'].'</span></h3>';
                }
            ?>
            <?php
                if(isset($_SESSION['email']))
                {
                    echo '<form method ="post" action="sports_shopping_home_page.php">
                            <button type="submit" class ="btn btn-danger" name="logout">Log Out</button>
                        </form>';
                }    
                else{
                echo '<a href="log_in_page_sports.php" style="margin-left:35%;color:green;" class="test-white bg-warning rounded border border-success nav-link"><i class="fa fa-sign-in mr-2"></i>LOGIN</a>
                      <a href="sign_up_page_sports.php" style="margin-right:10%;color:green;" class="test-warning bg-warning nav-link rounded border border-success"><i class="fa fa-user-plus mr-2"></i>SIGNUP</a>';
                }
            ?>
        </nav>

    <div id="mySidenav" class="sidenav">
        <a class="closebtn" id="closebtn" onclick="closeNav()"><i class="fas fa-arrow-left"></i></a>
        <?php
            if(isset($_SESSION['email']))
            {
                $sqlimg=$pdo->prepare("SELECT * FROM profile_data_assignment WHERE emailid=:emailid");
                $sqlimg->execute(array(':emailid'=> $_SESSION['email']));
                $rty2=$sqlimg->fetch(PDO::FETCH_ASSOC);

                if($rty2['status2'] == 0)
                {
                    echo "<img src=".$rty2['profile_img_name2']." class='profile_img'>";
                }
                else
                {
                    echo "<img src=".$rty2['profile_img_name2']." class='profile_img'>";
                }
            }
            else{
                echo "<img src='sports_logo1.png' class='profile_img1'>";
            }
        ?>
    <div class="list">
        <ul>
            <?php
                if(isset($_SESSION['email']))
                {
                    echo '<li><a href="profile_and_personal_info_update.php"><i class="fa fa-user"></i>My Profile</a></li>';

                    $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE E_mail_id = :E_mail_id");
                    $productidunique->execute(array(':E_mail_id' => $_SESSION['email']));
                    $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);
                    echo '<li><a href="cart_item.php"><i class="fa fa-shopping-cart"></i>My Cart ('.$fetch_unique_of_product_id['productidunique'].')</a></li>';

                    $number_of_orders = $pdo->prepare("SELECT COUNT(product_id) AS productidorder FROM purchased_item WHERE E_mail_id = :E_mail_id");
                    $number_of_orders->execute(array(':E_mail_id' => $_SESSION['email']));
                    $fetch_number_of_orders = $number_of_orders->fetch(PDO::FETCH_ASSOC);
                    echo '<li><a href="purchased_items.php"><i class="fa fa-arrow-right"></i>My Orders ('.$fetch_number_of_orders['productidorder'].')</a></li>';
                }
            ?>
            <li><a href="#"><i class="fa fa-link"></i>shortcuts</a></li>
            <li><a href="#"><i class="fa fa-calendar-alt"></i>Events</a></li>
            <li><a href="#"><i class="fa fa-cog fa-spin"></i>Setting</a></li>
            <!-- <li><a href="#"><i class="fa fa-phone"></i>contact-info</a></li> -->
            <?php
                if(isset($_SESSION['email']))
                {
                    echo '<li><a href="delect_account_sports.php"><i class="fa fa-user-times" style="color:darkred"></i><span style="color:red">Delete Account</span></a></li>';
                }
            ?>
        </ul>
    </div>

    </div>
</div>
    <div class="col-md-8 mt-4 mb-4" style="margin-left:20%;">
        <form class="form-inline" action="search.php" method="post">
            <input class="form-control" style="padding-right:25rem;padding-top:1.5rem;padding-bottom:1.5rem;border-radius:2rem;"; type="text" placeholder="Search Here" name="value_field" required="required">
            <button style="padding: 0.4rem 2.0rem 0.1rem 2.0rem;" class="btn btn-warning btn-rounded btn-outline-success btn-xl ml-4 mr-0" type="submit" name="search"><h3>Search</h3></button>
        </form>
    </div>
<div class="container ml-2" style="max-width: 100%;">
    <div class="row text-center pl-1 ml-4">
        <?php
        if(isset($_SESSION['email'])){
            $product = $pdo->prepare("SELECT * FROM list_of_sports_item WHERE product_status !='YES' AND Quantity > 0");
            $product->execute();
            while($row = $product->fetch(PDO::FETCH_ASSOC))
            {
                product_items($row['product_name'],$row['color'],$row['actual_price'],$row['price'],$row['model_name'],
                $row['product_image'],$row['Quantity'],$row['product_id'],$row['rating_of_sports_item']);
            }
        }
        else{
            $all_product = $pdo->prepare("SELECT * FROM list_of_sports_item");
            $all_product->execute();
            while($row = $all_product->fetch(PDO::FETCH_ASSOC))
            {
                product_items($row['product_name'],$row['color'],$row['actual_price'],$row['price'],$row['model_name'],
                $row['product_image'],$row['Quantity'],$row['product_id'],$row['rating_of_sports_item']);
            }
        }
        ?>
    </div>
</div>
<?php
        require_once "footer_sports.php";
?>
    <script>
        function openNav() {
        document.getElementById("mySidenav").style.left = "-20px";
        }

        function closeNav() {
        document.getElementById("mySidenav").style.left = "-244px";
        }

        window.addEventListener("load",function(){
        const loader=document.querySelector(".loaderclass");
        console.log(loader);
        loader.className += " hidden";
     });
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
