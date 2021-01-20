<?php
    session_start();
    require_once "header.php";
?>
        
<?php
    $name_and_p_number=$pdo->prepare("SELECT * FROM sign_up_info_sports WHERE E_mail_id = :E_mail_id");
    $name_and_p_number->execute(array(':E_mail_id' => $_SESSION['email']));
    $fetch_name_and_p_number= $name_and_p_number->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['address_save']))
    {
        $name=$_POST['name'];   $address1=$_POST['address'];
        $p_number=$_POST['p_number'];   $city=$_POST['city'];
        $pincode=$_POST['pincode'];   $state=$_POST['state'];
        $locality=$_POST['locality'];   $landmark=$_POST['landmark'];
        $address=$pdo->prepare("INSERT INTO first_address(E_mail_id, first_name, p_number,pincode,locality,address1, city,state1,landmark)
                        VALUES (:E_mail_id, :first_name, :p_number,:pincode,:locality,:address1, :city,:state1,:landmark)");
        $address->execute(array( ':E_mail_id' => $_SESSION['email'],
                                ':first_name' => $name,
                                ':p_number'  => $p_number,
                                ':pincode' => $pincode,
                                ':locality' => $locality,
                                ':address1' => $address1,
                                ':city' => $city,
                                ':state1' => $state,
                                ':landmark' => $landmark ));     
        header('Location: sports_shopping_home_page.php');
    }
    

?>
            
<div class="border-rounded mb-3" style="margin-left:20rem; margin-top:5rem;">
<div class="col-md-4 mt-5 ml-5 bg-white pl-5 pt-4 pb-2">
    <form action ="address.php" method="post">
        <h4>Name</h4>
            <input type="text" value="<?php echo $fetch_name_and_p_number['first_name'] ?>" name="name" class="input-group ml-3">
        <h4>Phone Number</h4>
            <input type="text" value="<?php echo $fetch_name_and_p_number['phone_number'] ?>" name="p_number" class="input-group ml-3">    
        <h4>Pincode</h4>
            <input type="text" placeholder="Pincode" name="pincode" class="input-group ml-3">
        <h4>Locality</h4>
            <input type="text" placeholder="Locality" name="locality" class="input-group ml-3">
        <h4>Address</h4>
            <input type="text" placeholder="address" name="address" class="input-group ml-3">
        <h4>City/District/town</h4>
            <input type="text" placeholder="city/District/town" name="city" class="input-group ml-3">
        <h4>State</h4>
            <input type="text" placeholder="state" name="state" class="input-group ml-3">
        <h4>Landmark</h4>
            <input type="text" placeholder="landmark" name="landmark" class="input-group ml-3">
        <button type="submit" class="btn btn-primary ml-5 mt-2 pl-5 pr-5" name="address_save">SAVE</button>
    </form>
</div>
</div>
    
</body>
</html>