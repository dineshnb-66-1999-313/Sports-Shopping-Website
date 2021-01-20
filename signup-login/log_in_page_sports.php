<?php
session_start();
require_once "pdo_sports_accessories.php";
$wrong_out_put=0;
if(isset($_POST['login']))
{
    $emailid = !empty($_POST['emailid']) ? trim($_POST['emailid']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    $sql = $pdo->prepare("SELECT ID, E_mail_id,user_name,cre_password,first_name FROM sign_up_info_sports WHERE BINARY E_mail_id = :emailid OR user_name = :user_name");
    $sql->execute(array(':emailid' =>$emailid , ':user_name' => $emailid));
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if($user == true)
    {
        if($passwordAttempt == $user['cre_password'])
        {
            $_SESSION['name']= $user['first_name'];
            $_SESSION['email']=$user['E_mail_id'];
            $_SESSION['id']=$user['ID'];

            $countoflogin =$pdo->prepare("SELECT COUNT(E_mail_id) AS emailunique FROM time_data_sports WHERE BINARY E_mail_id=:emailid");
            $countoflogin->execute(array(':emailid' => $_SESSION['email']));
            $row23 = $countoflogin->fetch(PDO::FETCH_ASSOC);
            $wrong_out_put=0;

        if($row23['emailunique']<1)
        {
            $countoflogin1 =$pdo->prepare("INSERT INTO time_data_sports (E_mail_id,login_count,login_time) VALUES (:emailid,1,now())");
            $countoflogin1->execute(array(':emailid' => $_SESSION['email']));
        }
        else
        {
            $updaterepeateduser = $pdo->prepare("UPDATE time_data_sports SET login_count=login_count+1,login_time=now() WHERE BINARY E_mail_id=:emailid");
            $updaterepeateduser->execute(array(':emailid' => $_SESSION['email']));
        }
            header('Location: sports_shopping_home_page.php');
        }
        else
        {
            $wrong_out_put=1;
            $message ='<label>Incorrect password</label>';
        }
    }
    else
    {
        $wrong_out_put=2;
        $message ='<label>Incorrect Email</label>';
    }
    
}

?>
<html>
    <head>
        <title>Login page for library</title>
            <link rel="icon" type="image/png" href="sports_logo.png">
            <meta charset="utf-8">
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <link href="https://fonts.googleapis.com/css?family=karla" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="log_in_page_sports.css">
            <style>
                body{
                    margin: 0;
                    padding: 0;
                    background:url('https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg');
                    background-size: cover;
                    background-position: center; 
                    height: 100vh;
                    align-items: center;
                }
                .container{
                    width:70%;
                    height:80%;
                    border-radius:5px;
                    border:1px dashed orange;
                    margin:50px 180px;
                    background:#042331;
                }
                .login_logo{
                    width: 400px;
                    height: 430px;
                    background:#042331;
                    position: absolute;
                    left: 15%;
                    top: 15%;
                }
                .loginimglogo{
                    border: 45%;
                    width: 130px;
                    height: 120px;
                    left: 27%;
                    top: 0%;
                    position: absolute;
                    border-radius:5%;
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
                .restriction{
                    width:300px;
                    height:50px;
                    position:absolute;
                    left:55px;
                    top:250px;
                    background: #042331;
                    border-radius:3px;
                    border:1px solid red;
                    font-family:"Times New Roman", Times, serif;
                    padding:10px 5px 5px 5px;
                }
                .rules-password-field2 {
                  
                    color:#fff;
                }
                .loginbox{
                    width: 360px;
                    height: 220px; 
                    background: #042331;
                    color: #fff;
                    top: 45%;
                    left: 62%;
                    position: absolute;
                    transform: translate(-50%,-50%);
                    padding: 60px 0px;
                    border-radius: 10px;  
                    border: 1px solid yellow;
                }
                .login{
                    width: 100px;
                    height: 100px;
                    border: -50%;
                    position: fixed;
                    top: -50px;
                    left: 37%;
                }
                .loginbox input{
                    margin: 0;
                    margin-bottom: 35px;
                    text-align:left;
                    padding-left:20px;
                }
                .loginbox ul li i{
                    padding-right: 20px;
                    color: green;
                }
                .loginbox input[type="text"], input[type="password"]{
                    border: none;
                    border-bottom: 2px solid orange;
                    border-top: 2px solid orange;
                    border-radius:15px;
                    background: transparent;
                    outline: none;
                    height: 44px;
                    width:240px;
                    color: #fff;
                    font-size: 16px;
                    /*border-color:dodgerblue;
                    box-shadow: 0 0 8px 0 dodgerblue; */
                    /*padding-left:55px;*/
                }
                .loginbox input[type="text"]::-webkit-input-placeholder {
                    text-align: left;
                    padding-left:10px;
                }
                .loginbox input[type="password"]::-webkit-input-placeholder {
                    text-align: left;
                    padding-left:10px;
                }
                .but1{
                    font-size: 16px;
                    color: white;
                    left: 90px;
                    top: 270px;
                    position: absolute;
                    background: #4CAF50;
                    border-radius: 5px;
                    border: 1px solid white;
                    padding:10px 80px;
                }
                .but1:hover{
                    cursor: pointer;
                }
                sup{
                    color: red;
                    font-size:20px;
                }
                .loginbox a{
                    text-decoration: none;
                    font-size: 18px;
                    line-height: 40px;
                    color: green;
                    top: 205px;
                    left: 190px;
                    position: fixed;
                }
                .loginbox a:hover
                {
                    cursor: pointer;
                    color: blue;
                }
                .loginbox input[type="checkbox"]
                {
                    width: 30px;
                    height: 20px;
                    left: 260px;
                    top: 159px;
                    position: absolute;
                }
                header{
                    width: 1000px;
                    height: 100px;
                    position: absolute;
                    background: green;
                }
                header ul li{
                    display: inline-flex;
                    color: white;
                }
                header ul li a{
                    color: white;
                    text-decoration: none;
                    padding-left: 100px;
                }
                .message{
                    top:60px;
                    left:550px;
                    position:fixed;
                    color:red;
                    font-size:20px;
                    font-style:normal;
                }
                .eye_slash i{
                    left: 300px;
                    top: 171px;
                    position:absolute;
                    margin-right:30px;
                    cursor:pointer;
                }
                .imagechild{
                    width: 300px;
                    height: 20px;
                    background: #042331;
                    position: absolute;
                    left: 7%;
                    top: 73%;
                }
                .imagechild i{
                    color:green;
                }
                
            </style>
    </head>      
<body>
    <div class="container">
            <?php
                if(isset($message)){
                    echo '<label class ="message">'.$message.'</label>';
                }
            ?>
        <div class="login_logo">
            <img src="sports_logo1.png" class="loginimglogo">
                <div class="heading12">
                    <h2><span style="font-size:40px;color:blue";>o</span>nline Sports Accessories</h2>
                    <h3>Shopping Website</h3>
                </div>
            <div class="restriction">
                <label class="rules-password-field2"><span style="color:red";>NOTE: </span>User Name and Password Inputs are case Sensitive</label>
            </div>
        </div>

            <div class="loginbox">
                <img src="https://www.frenz.co.nz/wp-content/uploads/2017/04/Login.gif" class="login">
                <form method="post">
                    <ul style="list-style: none;">
                        <li><i class="fa fa-envelope fa-2x" <?php if($wrong_out_put == 2){echo 'style="color: red"';}?>></i><input type="text" name="emailid" autocomplete="off" placeholder=" Enter email or user name" required="required"<?php 
                            if($wrong_out_put == 2){
                                echo 'style="border:2px solid red;border: none;
                                border-bottom: 2px solid red;
                                border-top: 2px solid red;
                                border-radius:15px;
                                background: transparent;"';
                            }
                        ?>></li>
                        <li><i class="fa fa-lock fa-2x" <?php if($wrong_out_put == 1){echo 'style="color: red"';}?>></i><input type="password" name="password" id="password" placeholder=" Enter password" required="required"
                        <?php 
                            if($wrong_out_put == 1){
                                echo 'style="border-bottom: 2px solid red;
                                border-top: 2px solid red;
                                border-radius:15px;
                                background: transparent;"';
                            }
                        ?>></li>
                        <div class="eye_slash"><i class="fa fa-eye" id="togglepassword"></i></div>

                    <a href="http://localhost/php_files/Sport_accessories_shopping_cart/forgot_password_sports.php">forgot password?</a><br>
                    <button class="but1" type="submit" name="login">LOG-IN</button><br>
                    </ul>
                </form>
            </div>
    </div>
            <script>
                const togglePassword = document.querySelector('#togglepassword');
                const password = document.querySelector('#password');
                    togglePassword.addEventListener('click', function (e) {
                    // toggle the type attribute
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    // toggle the eye slash icon
                    this.classList.toggle('fa-eye-slash');
                    });

            </script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
</body>
</html>  
    