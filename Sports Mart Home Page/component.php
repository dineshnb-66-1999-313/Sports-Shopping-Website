<?php
require_once "pdo_sports_accessories.php";

// if(isset($_SESSION['email'])){
//     if(isset($_POST['delete']))
//     {
//         foreach($_POST['checkbox'] as $id)
//         {
//             $deleteUser = $pdo->prepare("DELETE FROM customer_cart WHERE product_id = :product_id AND E_mail_id = :E_mail_id");
//             $deleteUser -> execute(array(':product_id' => $id ,':E_mail_id' => $_SESSION['email']));
//         }
//     }
// }
function product_items($product_name,$color,$actual_price,$Price,$model_name,$product_img,$Quantity,$product_id,$rating)
{
    echo '<div class="col-xs-12 col-sm-7 col-md-2 col-xl-1  my-3 mx-3 pr-4" style="width: 16.7rem; height:27rem;" id="row">
        <form method="post">
            <div class="card-shadow1">
                <div class="card-shadow my-2">
                    <img src='."$product_img".' alt="image1" class="img-fluid card-img-top rounded mr-3">
                </div>
                <div class="card-body pt-0 ml-0"> 
                    <h5><b>'."$product_name"." (".$color.") ".'</b></h5>
                    <h6>'.$model_name.'</h6>
                    <h4>
                        <span class="text-success">₹ '."$Price".'</span>
                        <small><s>₹ '."$actual_price".'</s>'."(".$Quantity.")".'</small>
                    </h4>';
            echo '<h5>';
                    for($i=0;$i<$rating;$i++){
                        echo '<i class="fa fa-star text-success"></i>';
                    }
                    for($j=0;$j<5-$rating;$j++){
                        echo '<i class="far fa-star"></i>';
                    }
                    echo "(".$rating.")";
            echo '</h5>';
                    echo '<button type="submit" class="btn-md btn btn-warning mt-4" name="add_to_cart" style="border=2px solid #000;">
                                    Add to cart <i class="fa fa-cart-plus pl-2"></i></button>
                    <input type="hidden" name="product_id" value="'.$product_id.'">
                </div>
            </div>
        </form>
        </div>';
}

function cart_element($product_img,$color,$product_name,$Price,$model_name,$actual_price,$products_id,$rating){
    $discount = (int) ((100 * ($actual_price - $Price))/$actual_price);
    echo '
    <form action="cart_item.php" method="post" class = "cart-items">
    <div class="border-rounded mb-3">
        <div class="row bg-white">
            <div class="col-md-3">
                <img style="height: 150px;" src="'.$product_img.'" alt="" class = "img-fluid mt-2 mb-2 ml-4 rounded">
            </div>
            <div class="col-md-6">
                <h5 class="pt-2">'.$product_name.'</h5>
                <h6 class="text-secondary">'.$model_name.' '.$color.'</h6>
                <h4>
                    <span class="text-success">₹ '."$Price".'</span>
                    <code class="text-secondary"><s>₹'."$actual_price".'</s></code>
                    <span class = "text-success">'.$discount.'% off</span>
                </h4>';
                echo '<h5>';
                    for($i=0;$i<$rating;$i++){echo '<i class="fa fa-star text-success"></i>';}
                    for($j=0;$j<5-$rating;$j++){echo '<i class="far fa-star"></i>';}
                    echo "(".$rating.")";
            echo '</h5>
            <button class="btn btn-danger mx-3 mb-2" name="remove_item" id="remove">Remove</button>
                <input type="hidden" name="product_id_remove" value="'.$products_id.'">
                <button class="btn btn-warning mx-3 mb-2" name="purchase_product">Purchase</button>
                <input type="hidden" name="purchase_product_item" value="'.$products_id.'">
            </div>';
                echo '<div class="col-md-3 pt-4">
                <h7>Delivery by Wed Jan 20 | <span class="text-success">Free</span> <code class="text-dark"><s>₹40</s></code></h7>
                <h6> 7 Days Replacement Policy </h6>
            </div>
        </div>
    </div>
</form>';
}

function my_oder($product_img,$color,$product_name,$Price,$model_name,$actual_price,$products_id,$rating)
{
    echo '
    <form action="cart_item.php" method="post" class = "cart-items">
    <div class="border-rounded mt-3">
        <div class="row bg-white">
            <div class="col-md-2">
                <img style="height: 150px;" src="'.$product_img.'" alt="" class = "img-fluid mt-4 mb-2 rounded">
            </div>
            <div class="col-md-7 ml-3">
                <h6 class="pt-2"><b>'.$product_name.'</b></h6>
                <h6 class="text-secondary">'.$model_name.' '.$color.'</h6>
                <h4>
                    <span class="text-success">₹ '."$Price".'</span>
                    <code class="text-secondary"><s>₹'."$actual_price".'</s></code>
                </h4>';
                echo '<h5>';
                        for($i=0;$i<$rating;$i++){
                            echo '<i class="fa fa-star text-success"></i>';
                        }
                        for($j=0;$j<5-$rating;$j++){
                            echo '<i class="far fa-star"></i>';
                        }
                    echo "(".$rating.")";
                echo '</h5>';
                
                echo '<div class="col-md-12 mt-4" style="max-width:100%;">
                        <h4 class="text-success mb-3">Product will be Deliver to You Soon to the given Address <img src="https://cms-assets.tutsplus.com/uploads/users/523/posts/32694/preview_image/tutorial-preview-small.png" class="success_tick_mark"></h4>
                      </div>
            </div>
            <div class="col-md-3 pt-4">
                <h6> 7 Days Replacement Policy </h6>
            </div>
        </div>
    </div>
</form>';}
?>
<!-- <i class="fa fa-check"></i> -->
