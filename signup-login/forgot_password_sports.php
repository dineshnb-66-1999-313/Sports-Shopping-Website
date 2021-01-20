<?php
session_start();
require_once "pdo_sports_accessories.php";
$email_dob_error_message=0;
if(isset($_POST['send_email']))
{
    $e_mail = $_POST['email'];
    $dob = $_POST['birthday'];

    $forgot_password_query = $pdo->prepare("SELECT E_mail_id,DOB FROM sign_up_info_sports WHERE BINARY E_mail_id = :email");
    $forgot_password_query->execute(array(':email' => $e_mail));
    $fetching_the_row = $forgot_password_query->fetch(PDO::FETCH_ASSOC);

    if($fetching_the_row == true)
    {
        if($dob == $fetching_the_row['DOB'])
        {
            $_SESSION['email'] = $e_mail;
            $email_dob_error_message=0;
            header('Location: password_retrival_sports.php');
        }
        else
        {
            $email_dob_error_message=1;
            $message ='<label>Date of birth not matching</label>';
        }
    }
    else
    {
        $email_dob_error_message=1;
        $message ='<label>E-mail does not Exist</label>';
    }
}

?>
<html>
<head>
<title>forgot password page</title> 
    <link rel="icon" type="image/png" href="sports_logo1.png">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="https://fonts.googleapis.com/css?family=karla" rel="stylesheet">
    <style>
        body{
            margin: 0;
            padding: 0;
            background:url('https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg');
            background-size: cover;
            background-position: center;
            font-family:"Times New Roman", Times, serif;
        }
        .container{
            width:70%;
            height:80%;
            border-radius:5px;
            border:1px dashed orange;
            margin:50px 180px;
            background: #042331;
        }
        .login_logo{
            width: 400px;
            height: 230px;
            background: #042331;
            position: absolute;
            left: 20%;
            top: 15%;
        }
        .loginimglogo{
            border: 45%;
            width: 130px;
            height: 120px;
            left: 27%;
            top: 0%;
            position: absolute;
        }
        .heading12 h2{
            font-size: 30px;
            background: -webkit-linear-gradient(blue,white,blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            top: 100px;
            position: absolute;
            padding-left: 30px;
            color: blue;
            font-family:"Times New Roman", Times, serif;
        }
        .heading12 h3{
            font-size: 22px;
            background: -webkit-linear-gradient(blue,white,blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            top: 155px;
            position: absolute;
            left: 80px;
            color: blue;
            font-family:"Times New Roman", Times, serif;
        }
        .forgotpasswordbox{
            width: 320px;
            height: 380px;
            top: 20px;
            left: 450px;
            background: transparent;
            color: #fff;
            position: absolute;
            box-sizing: border-box;
            border-radius: 18px;
            border: 1px solid yellow;
        }
        .forgot{
            width: 100px;
            height: 100px;
            border-radius: 50%;
            position: absolute;
            top: -50px;
            left: calc(50% - 50px);
        }
        p.email1{
            margin: 0;
            padding: 0;
            font-size: 22px;
            top:80px;
            left:40px;
            position:absolute;
        }
        p.email2{
            margin: 0;
            padding: 0;
            font-size: 22px;
            top:170px;
            left:40px;
            position:absolute;
        }
        .forgotpasswordbox input{
            margin: 0;
            margin-bottom: 20px;
            width:230px; 
            position:absolute;
            left:30px;
            border-radius:5px;
        }
        .forgotpasswordbox input[type="email"]{
            border: none;
            background: transparent;
            font-size: 16px;
            outline: none;
            border-bottom: 2px solid green;
            height: 30px; 
            color: #fff;
            top:120px;
            position:absolute;
        }
        .forgotpasswordbox input[type="date"]{
           
            border: none;
            background: #042331;
            font-size: 16px;
            outline: none;
            border-bottom: 2px solid green;
            height: 30px; 
            color: #fff;
            position:absolute;
            top: 220px;
        }
        /*.fa-gradient {
            background: -webkit-gradient(linear, left top, left bottom, from(red), to(green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position:center;
        }*/
        button{
            font-size: 18px;
            color: white;
            left: 50px;
            top: 290px;
            position: absolute;
            background: transparent;
            border-radius: 5px;
            padding: 5px 10px;
            border: 1px solid white;
            padding:10px 30px;
        }
        button:hover{
            cursor: pointer;
            background: transparent;
            color: #fff; 
        }
        sup{
            color: red;
        }
        .message{
            top:65px;
            left:500px;
            position:fixed;
            color:red;
            font-size:20px;
        }
    </style>
<body>
    <div class="container">
    <div class="login_logo">
            <img src="sports_logo1.png" class="loginimglogo">
            <div class="heading12">
                <h2><span style="font-size:40px;color:blue";>o</span>nline Sports Accessories</h2>
                <h3>Shopping Website</h3>
            </div>
        <div class="forgotpasswordbox"
        <?php 
        if($email_dob_error_message == 1){
            echo 'style="border:1px solid red;"';
        }
    ?>
        >
            <img src="https://img1.pnghut.com/t/21/21/5/5cimRf9DiD/security-password-login-blue-padlock.jpg" class="forgot">
                <?php
                    if(isset($message))
                    {
                        echo '<label class ="message">'.$message.'</label>';
                    }
                ?>
                <form method="post">
                        <p class="email1">E-mail <sup>*</sup></p>
                        <input type="email" name="email" placeholder=" Enter E-mail" autocomplete="off" required="required">
                        <p class="email2">Date of Birth <sup>*</sup></p>
                        <input type="date" id="birthday" name="birthday" autocomplete="off"><br>
                        <button type="submit" name="send_email">SEND EMAIL</button>
                </form>
        </div>  
        </div>
</body>
</head>
</html>