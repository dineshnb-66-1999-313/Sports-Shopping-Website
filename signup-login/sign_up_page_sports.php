<?php
define ('BASEPATH',true);
session_start();
require_once "pdo_sports_accessories.php";
$errors2=0;
$profileimageboy='https://previews.123rf.com/images/salamatik/salamatik1801/salamatik180100019/92979836-profile-anonymous-face-icon-gray-silhouette-person-male-default-avatar-photo-placeholder-isolated-on.jpg';
$profileimagegirl='https://media.istockphoto.com/vectors/person-gray-photo-placeholder-woman-vector-id1074273082';
if(isset($_POST['signin']))
{
    $f_name=$_POST['fname'];           $user_name=$_POST['user_name'];
    $e_mail=$_POST['email'];           $c_pass=$_POST['cpass'];
    $p_number=$_POST['pnumber'];       $co_pass=$_POST['copass'];
    $gender=$_POST['gender'];          $dateofbirth=$_POST['birthday'];
        
    if($c_pass == $co_pass)
    {
        $emailidunique = $pdo->prepare("SELECT COUNT(E_mail_id) AS emailidunique FROM sign_up_info_sports WHERE BINARY E_mail_id=:E_mail_id");
        $emailidunique->execute(array(':E_mail_id' => $e_mail));
        $row1 = $emailidunique->fetch(PDO::FETCH_ASSOC);
        
        $p_uniq = $pdo->prepare("SELECT COUNT(phone_number) AS punique FROM sign_up_info_sports WHERE phone_number=:phone_number");
        $p_uniq->execute(array(':phone_number' => $p_number));
        $row3 = $p_uniq->fetch(PDO::FETCH_ASSOC);
             
        if($row1['emailidunique']<1)
        {
            if($row3['punique']<1)
            {
                if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/",$user_name))
                {
                    if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/",$c_pass))
                    {
                        $sql1=$pdo->prepare("INSERT INTO sign_up_info_sports(first_name,E_mail_id,user_name,DOB,Gender,phone_number,cre_password,date_time_of_sign_up) 
                                    VALUES (:fname, :email, :user_name, :dob, :gender, :pnumber,:cpass,now())");
                        $sql1->execute(array(':fname' => $f_name,
                                            ':email' => $e_mail,
                                            ':user_name' => $user_name,
                                            ':dob' => $dateofbirth,
                                            ':gender' => $gender,
                                            ':pnumber' => $p_number,
                                            ':cpass' => $c_pass));

                        $selectalldata=$pdo->prepare("SELECT * FROM sign_up_info_sports WHERE BINARY E_mail_id = :emailid");
                        $selectalldata->execute(array(':emailid' => $e_mail));
                        $rty=$selectalldata->fetch(PDO::FETCH_ASSOC);
                        $userid=$rty['ID'];
                        $emailid=$rty['E_mail_id'];
                        $f_name = $rty['first_name'];
                        $ph_number = $rty['phone_number'];
                        $errors2=0;
    
                        if($rty['Gender'] == 'Male')
                        {    
                            $profilequery1=$pdo->prepare("INSERT INTO profile_data_assignment (user_id,status2,profile_img_name2,default_image2,emailid,
                                     date_of_profile_update_info) VALUES (:userid, 1,:profileimagenameb,:default_image2,:emailid,now())");
                            $profilequery1->execute(array(':userid' => $userid,
                                                        ':emailid' => $emailid,
                                                        ':profileimagenameb' => $profileimageboy,
                                                        ':default_image2' => $profileimageboy));
                            $message ='<label>Registration successful</label>';
                            header('Location:log_in_page_sports.php');
                        }
                        if($rty['Gender'] == 'Female')
                        {
                            $profilequery2=$pdo->prepare("INSERT INTO profile_data_assignment (user_id,status2,profile_img_name2,default_image2,emailid,
                            date_of_profile_update_info) VALUES (:userid, 1,:profileimagenameg2,:default_image2,:emailid,now())");
                            $profilequery2->execute(array(':userid' => $userid,
                                                        ':emailid' => $emailid,
                                                        ':profileimagenameg2' => $profileimagegirl,
                                                        ':default_image2' => $profileimagegirl));
                            $message ='<label>Registration successful</label>';
                            echo "table created successfully";
                            header('Location:log_in_page_sports.php');
                        }   
                    }
                else{
                    $errors2=1;
                    $message ='<label>Please follow the restriction in password-field </label>';
                }
            }
            else{
                $message ='<label>Please follow the restriction in user name field </label>';
            }
            }
            else{
                $errors2=1;
                $message ='<label>Phone number alredy exist</label>';
            }
        }
        else{
            $errors2=1;
            $message ='<label>E-mail alredy exist</label>';
        }
    //$c_pass = password_hash($c_pass, PASSWORD_BCRYPT, array("cost"=>12));
    }
    else
    {
        $errors2=1;
        $message ='<label>password does not match</label>';
    }
} 
?>

<html>
<head>
<title>sign-in-page</title> 
        <link rel="icon" type="image/png" href="sports_logo.png">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link href="https://fonts.googleapis.com/css?family=karla" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="sign_up_page_sports.css">
        <style>
            body{
                margin: 0;
                padding: 0;
                background:url('https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg');
                background-size: cover;
                background-position: center;
            }
            .container{
                width:85%;
                height:90%;
                border-radius:5px;
                border:1px dashed orange;
                margin:30px 80px;
                background: #042331;
            }
            .login_logo{
                width: 400px;
                height: 500px;
                background: #042331;
                position: absolute;
                left: 12%;
                top: 11%;
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
            .signinbox{
                width: 38%;
                height: 75%;
                background: #042331;
                color: #fff;
                top: 53%;
                left: 64%;
                position: absolute;
                transform: translate(-50%,-50%);
                box-sizing: border-box;
                border-radius: 20px;
                border: 2px solid orange;
            }
            .sub11{
                width: 240px;
                height: 330px;
                background:transparent;
                position: absolute;
                padding-left: 30px;
                top: 14%;
                left:1%;
            }
            .sub22{
                width: 240px;
                height: 330px;
                background:transparent;
                position: absolute;
                padding-left: 30px;
                top: 15%;
                left:50%;
            }
            .sign-in{
                width: 100px;
                height: 100px;
                border-radius: 50%;
                position: absolute;
                top: -50px;
                left: calc(50% - 50px); 
            }
            h1{
                margin: 0;
                padding: 0 0 20p;
                text-align: center;
                font-size: 30px;
                top: 20px;
                color: green;
            }
            .signinbox p{
                margin: 0;
                padding: 0;
                font-style: normal;
                font-size: 22px;
                font-family:"Times New Roman", Times, serif;
            }
            .signinbox input{
                margin: 0;
                margin-bottom: 20px;
                width:200px;
            }
            .signinbox input[type="text"],input[type="password"],input[type="email"]{
                border: none;
                border-bottom: 2px solid orange;
                border-radius:0px;
                background: transparent;
                outline: none;
                height: 40px;
                color: #fff;
                font-size: 14px;
            }
            .rto{
                width: 200px;
                position: absolute;
                height: 100px;
                left: 250px;
                top: 400px;
            }
            p sup{
                color: red;
            }
            button{
                font-size: 20px;
                color: white;
                left: 27%;
                top: 87%;
                position: absolute;
                background: #4CAF50;
                border-radius: 5px;
                padding: 10px 80px;
                border: 1px solid white;
            }
            button:hover{
                cursor: pointer;
            }
            .check1{
                width: 30px;
                height: 20px;
                left: 120px;
                top: 225px;
                position: absolute;
            }
            .check2{
                width: 30px;
                height: 20px;
                left: 120px;
                top: 317px;
                position: absolute;
            }
            .message{
                top:50px;
                left:370px;
                position:fixed;
                color:red;
                font-size:14px;
            }
            .restriction{
                width: 348px;
                height: 300px;
                position: absolute;
                left: 45px;
                top: 44%;
                background: #042331;
                border-radius: 10px;
                padding: 10px;
                border: 1px solid red;
                font-family: "Times New Roman", Times, serif;
            }
            .user_field1{
                width:280px;
                height:130px;
                position:absolute;
                left:5px;
                top:15px;
                background:transparent;
                padding-left:30px;
            }
            .rules-user-field1{
                padding-top: 0px;
                top: -16px;
                position: absolute;
                left: 43px;
                font-size: 14px;
                color: white;
            }
            .user_field1 i{
                padding-right:10px;
                color:red;
            }
            .user_field1 a{
                font-size:15px;
                color:red;
            }
            .password_field2{
                width:280px;
                height:130px;
                position:absolute;
                left:5px;
                top: 47%;
                background:transparent;
                padding-left:30px;
            }
            .password_field2 i{
                padding-right:15px;
                color:red;
            }
            .password_field2 a{
                font-size:15px;
                color:red;
            }
            .rules-password-field2{
                padding-top: 0px;
                top: -16px;
                position: absolute;
                left: 30px;
                font-size: 14px;
                color: white;
            }
            select{
                width:200px;
                font-style:normal;
                border: none;
                border-bottom: 2px solid orange;
                border-radius:0px;
                background: #042331;
                outline: none;
                height: 30px;
                color: #fff;    
                font-size: 16px;
            }
            .signinbox input[type="date"]{
                width:200px;
                font-style:normal;
                border: none;
                border-bottom: 2px solid orange;
                background: #042331;
                outline: none;
                height: 30px;
                color: #fff;    
                font-size: 16px;
                line-height:50px;
                border-radius:0px;
            }
            .eye_slash1 i{
                left: 200px;
                top: 225px;
                position:absolute;
                margin-right:30px;
                cursor:pointer;
            }
            .eye_slash2 i{
                left: 200px;
                top: 320px;
                position:absolute;
                margin-right:30px;
                cursor:pointer;
            }
        </style>
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
        <div class="user_field1">
            <i class="fa fa-info-circle"></i><a>Restriction to user-field</a>
            <label class="rules-user-field1"><br><br>1. At least a lowercase letter<br>2. At least a uppercase letter<br>3. At least a numeric digit<br>4. Maximum length is 15</label>
        </div>
        <div class="password_field2">
            <i class="fa fa-info-circle"></i><a>Restriction to password-field</a>
            <label class="rules-password-field2"><br><br>1. At least a lowercase letter<br>2. At least a uppercase letter<br>3. At least a numeric digit
            <br>4. At least a special character<br>5. Maximum length is 15<br>6. Minimum length is 8</label>
        </div>
    </div>
    </div>
    <div class="signinbox"
    <?php 
        if($errors2 == 1){
            echo 'style="border:2px solid red;"';
        }
    ?>
    >
        <img src="https://www.frenz.co.nz/wp-content/uploads/2017/04/Login.gif" class="sign-in" >
        <h5 style="margin-left:2rem;color:red";>All feilds are mandatory <sup>*</sup></h5>
        <form method="post">
            <div class="sub11">
                <p>First Name</p>
                <input type="text" name="fname" maxlength="12" autocomplete="off" placeholder="Enter first name" required="required">
                <p>E-mail</p>
                <input type="email" name="email" placeholder="Enter Email id" autocomplete="off" required="required">
                <p>User Name</p>
                <input type="text" name="user_name" placeholder="Enter user name" maxlength="12" id="usernamecheck" onkeyup="validationusername()" autocomplete="off" required="required">
                <p style="padding-bottom:15px;">Date Of Birth</p>
                <input type="date" id="birthday" name="birthday" required="required">
            </div>
            
            <div class="sub22">
                <p>Gender</p>
                <select name="gender" id="gender" required="required">
                    <option value="select">select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select><br><br>
                <p>Mobile Number</p>
                <input type="text" name="pnumber" maxlength="10" onkeyup="validationpnumber()" id="pnumberinfo" placeholder="Enter Mobile number">
                <p>Create Password</p>
                <input type="password" name="cpass" maxlength="15" onkeyup="validationpassword()" placeholder="create password" id="myinput1" required="required">
                <div class="eye_slash1"><i class="fa fa-eye" id="togglepassword1"></i></div>

                <p>Conform Password</p>
                <input type="password" name="copass" placeholder="Conform password" id="myinput2" required="required"><br>
                <div class="eye_slash2"><i class="fa fa-eye" id="togglepassword2"></i></div>

            </div>
            <button type="submit" name="signin">SIGN-UP</button>
        </form>
    </div>
</div>
    

    <script>
        function validationpassword()
        {
            var createpass=document.getElementById('myinput1').value;
            var passpattren=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
                if(passpattren.test(createpass)){
                    document.getElementById('myinput1').style.borderBottom='2px solid green';
                }
                else{
                    document.getElementById('myinput1').style.borderBottom='2px solid red';
                }
        }
        function validationpnumber()
        {
            var createnumber=document.getElementById('pnumberinfo').value;
            var numberpattren=/^[0-9].{9,9}$/;
                if(numberpattren.test(createnumber)){
                    document.getElementById('pnumberinfo').style.borderBottom='2px solid green';
                }
                else{
                    document.getElementById('pnumberinfo').style.borderBottom='2px solid red';
                }
        }
        const togglePassword1 = document.querySelector('#togglepassword1');
        const password1 = document.querySelector('#myinput1');
            togglePassword1.addEventListener('click', function (e) {
            const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
            password1.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            });

        const togglePassword2 = document.querySelector('#togglepassword2');
        const password2 = document.querySelector('#myinput2');
            togglePassword2.addEventListener('click', function (e) {
            const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
            password2.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            });

        function validationusername()
        {
            var username=document.getElementById('usernamecheck').value;
            var usernamepattren=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;
                if(usernamepattren.test(username)){
                    document.getElementById('usernamecheck').style.borderBottom='2px solid green';
                }
                else{
                    document.getElementById('usernamecheck').style.borderBottom='2px solid red';
                }
        }

    </script>
</body>
</head>
</html>