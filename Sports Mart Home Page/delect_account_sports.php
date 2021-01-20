<?php
session_start();
require_once "pdo_sports_accessories.php";
require_once "header.php";
if(isset($_POST['ok']))
{
    $rty1= $pdo->prepare("DELETE FROM sign_up_info_sports WHERE E_mail_id=:email");
    $rty1->execute(array(':email'=> $_SESSION['email']));

    $rty2=$pdo->prepare("DELETE FROM profile_data_assignment WHERE emailid=:email");
    $rty2->execute(array(':email'=> $_SESSION['email']));

    $rty3=$pdo->prepare("DELETE FROM time_data_sports WHERE E_mail_id=:email");
    $rty3->execute(array(':email'=> $_SESSION['email']));

    $rty4 = $pdo->prepare("DELETE FROM customer_cart WHERE E_mail_id=:email");
    $rty4->execute(array(':email'=> $_SESSION['email']));

    $rty5 = $pdo->prepare("DELETE FROM purchased_item WHERE E_mail_id=:email");
    $rty5->execute(array(':email'=> $_SESSION['email']));

    session_unset();
    session_destroy();
    header('Location:sports_shopping_home_page.php');
}
if(isset($_POST['cancel'])){
  header('Location:sports_shopping_home_page.php');
}

?>

<html>
<head>
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<title>Account Deletion</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="icon" type="image/png" href="https://i1.wp.com/www.telugustories.org/wp-content/uploads/2018/02/cpsia-kid-safe-logo.gif?ssl=1">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="https://fonts.googleapis.com/css?family=karla" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.window {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0px;
  top: 0px;
  width: 100%;
  position:absolute; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.window_element {
  background:white;
  margin: auto;
  padding: 20px;
  width: 380px;
  height:150px;
  top:250px;
  left:32%;
  position:absolute;
}

/* The Close Button */
.close_btn1 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close_btn1:hover,
.close_btn1:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.cancel{
  top:115px;
  left:280px;
  position:absolute;
  cursor:pointer;
  background:green;
  color:black;
  border-radius:5px;
  opacity:0.8;
}
.ok{
  top:115px;
  left:230px;
  position:absolute;
  cursor:pointer;
  background:red;
  color:black;
  border-radius:5px;
  opacity:0.8;
}
.delete{
      font-size: 16px;
      color: darkred;
      position: absolute;
      background: red;
      border-radius: 2px;
      padding: 5px 10px;
      border: 1px solid #000;
      width:250px;
      height:50px;
      top:100px;
      left:35%;
    }
    .delete i{
        padding-right:10px;
        color:darkred;
    }
    .delete:hover{
        cursor:pointer;
        background:red;
    }
    .mess1{
      margin:0px;
      position:absolute;
      top:5px;
    }
    .mess2{
      margin:0px;
      position:absolute;
      top:60px;
    }
/*inside the window element*/
/*.cropimg{
        width:500px;
        height:280px;
        position:absolute;
        top:100px;
        left:350px;
        border-radius:20px;
        border:2px solid white;
    }*/
    
</style>
</head>
<body>
<p style="text-align:center;font-size:20px;color:red";>Before click ok button remember that you will not be access to your account</p>
<!--<button class="btn btn-success">success</button>-->
<button class="delete" id="button1" name="delete"><i class="fa fa-user-times"></i>Delete Account</button>
    <div id="window" class="window open">

        <div class="window_element">
          <p class="mess1">If 'ok' button preesed your account will be<br> permanently deleted</p>
          <p class="mess2">If 'cancel' button pressed you will be redirected <br>to home page</p>
        <form action="" method="post">
              <button class="cancel" name="cancel">CANCEL</button>
              <button class="ok" name="ok">OK</button>
        </form>
          
        </div>
    </div>


<script>
// Get the modal
var modal1 = document.getElementById("window"); 


// Get the button that opens the modal
var btn1 = document.getElementById("button1");


// Get the <span> element that closes the modal
var span1 = document.getElementsByClassName("close_btn1")[0];



// When the user clicks the button, open the modal 
btn1.onclick = function() {
  modal1.style.display = "block";
}


// When the user clicks on <span> (x), close the modal
span1.onclick = function() {
  modal1.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
  }
}


// When the user clicks anywhere outside of the modal, close it

</script>

</body>
</html>
