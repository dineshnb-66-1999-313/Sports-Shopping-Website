<?php
session_start();
require_once "pdo_sports_accessories.php";
$password_not_match_error=0;
if(isset($_POST['rpass']))
{
    $crepass=$_POST['crepass'];
    $conpass=$_POST['conpass'];
    if($crepass == $conpass)
    {
        if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/",$crepass))
        {
            $password_update_query=$pdo->prepare("UPDATE sign_up_info_sports SET cre_password=:crepass WHERE E_mail_id=:email");
            $password_update_query->execute(array(':crepass' => $crepass, ':email' => $_SESSION['email']));
            $password_not_match_error=0;

            session_unset();
            session_destroy();
            header('Location: log_in_page_sports.php');
        }
        else
        {
            $password_not_match_error=1;
            $message ='<label>Please follow the restriction in password-field </label>';
        }
    }
    else
    {
        $password_not_match_error=1;
        $message ='<label>password does not match</label>';

    }
}
else{
    // echo '<meta http-equiv="refresh" content="120;URL=log_in_page_sports.php" />';
    // session_destroy();
}

?>
<html>
    <head>
        <title>password retrival</title>
        <link rel="icon" type="image/png" href="https://pngimg.com/uploads/book/book_PNG51090.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="password_retrival_library.css">
        <!-- <meta http-equiv="refresh" content="8;URL=log_in_page_library.php" />  -->
        <style>
            body{
                margin: 0;
                padding: 0;
                background:url('https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg');
                background-size: cover;
                background-position: center;
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
                height: 430px;
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
            .password_retrivalbox{
                width: 320px;
                height: 380px;
                top: 50%;
                left: 63%;
                background: transparent;
                color: #fff;
                position: absolute;
                transform: translate(-50%,-50%);
                box-sizing: border-box;
                padding: 80px 30px;
                border-radius: 18px;
                border: 1px solid yellow;
            }
            .password_retrival{
                width: 100px;
                height: 100px;
                border-radius: 50%;
                position: absolute;
                top: -50px;
                left: calc(50% - 50px);
            }
            h1{
                margin: 0;
                padding: 0 0 20px;
                text-align:center;
                font-size: 30px;
            }
            .password_retrivalbox p{
                margin: 0;
                padding: 0;
                /*font-weight: bold;*/
                font-size: 25px;
            }
            .password_retrivalbox input{
                margin: 0;
                margin-bottom: 5px;
            }
            .password_retrivalbox input[type="password"],input[type="text"]{
                border: none;
                background: transparent;
                font-size: 16px;
                outline: none;
                border-bottom: 2px solid green;
                height: 40px;
                color: #fff;
            }
            .check1{
                width: 30px;
                height: 20px;
                left: 185px;
                top: 130px;
                position: absolute;
            }
            .check2{
                width: 30px;
                height: 20px;
                left: 185px;
                top: 220px;
                position: absolute;
            }
            button{
                font-size: 20px;
                color: white;
                left: 30px;
                top: 290px;
                position: absolute;
                background: transparent;
                border-radius: 5px;
                padding: 5px 10px;
                border: 1px solid white;
            }
            button:hover{
                cursor: pointer;
            }
            sup{
                color: red;
            }
            .message{
                top:60px;
                left:500px;
                position:fixed;
                color:red;
                font-size:17px;
            }
            .restriction{
                width:260px;
                height:160px;
                position:absolute;
                left:55px;
                top:55%;
                background: #042331;
                border-radius:10px;
                padding:10px;
                border:1px solid red;
                font-family:"Times New Roman", Times, serif;
            }
            .password_field2{
                width:280px;
                height:140px;
                position:absolute;
                left:5px;
                top:10px;
                background:transparent;
                padding-left:25px;
            }
            .password_field2 i{
                padding-right:10px;
                color:red;
            }
            .password_field2 a{
                font-size:18px;
                color:red;
            }
            .rules-password-field2{
                padding:10px;
                font-size:17px;
                color:white;
            }
            h1{
                font-size: 30px;
                color: white;
                padding:25% 0 0 0;
            }
            .password_retrival_404{
                width: 200px;
                height: 150px;
                border-radius: 50%;
                position: absolute;
                top: 15%;
                left:38%;
            }
            .count_down_timer{
                color:white;
                font-size:20px;
                padding:10px;
            }
            span{
                color:red;
            }
            .eye_slash1 i{
                left: 210px;
                top: 125px;
                position:absolute;
                margin-right:30px;
                cursor:pointer;
            }
            .eye_slash2 i{
                left: 210px;
                top: 225px;
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
        <?php
            if(isset($_SESSION['email']))
            {
                echo '<div class="count_down_timer">Session closes in <span id="time"></span> minutes</div>';
            echo '<div class="login_logo">';
                echo '<img src="sports_logo1.png" class="loginimglogo">';
                    echo '<div class="heading12">';
                    echo '<h2><span style="font-size:40px;color:blue";>o</span>nline Sports Accessories</h2>
                        <h3>Shopping Website</h3>';
                    echo '</div>';

                echo '<div class="restriction">';
                    echo '<div class="password_field2">';
                        echo '<i class="fa fa-info-circle"></i><a>Restriction to password-field</a>
                        <label class="rules-password-field2"><br><br>1. At least a lowercase letter
                        <br>2. At least a uppercase letter<br>3. At least a numeric digit
                        <br>4. At least a special character<br>5. Miximum length is 15<br>6. Minimum length is 8</label>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

                echo '<div class="password_retrivalbox"
                    <?php
                        if($password_not_match_error == 1){
                            echo "style="border:1px solid red;"";
                        }
                    ?>';
                    echo '<img src="https://icons-for-free.com/iconfiles/png/512/locked+login+password+privacy+private+protect+protection+safe-1320196167397530530.png" class="password_retrival">
                        <form method="post">
                            <p>Create password <sup>*</sup></p>
                            <input type="password" name="crepass" maxlength="15" onkeyup="validationpassword()" id="myinput1" placeholder="create password" required="required"><br><br>
                            <div class="eye_slash1"><i class="fa fa-eye" id="togglepassword1"></i></div>
                            <p>Conform Password <sup>*</sup></p>
                            <input type="password" name="conpass" placeholder="conform password" id="myinput2" required="required">
                            <div class="eye_slash2"><i class="fa fa-eye" id="togglepassword2"></i></div>
                            <button type="submit" name="rpass"><b>Remember Password</b></button>
                        </form>';
                    echo '</div>';
            }
            else{
                echo "<h1>You can't access this site without session</h1>";
                echo '<img src="https://media2.giphy.com/media/8L0Pky6C83SzkzU55a/giphy.gif" class="password_retrival_404">';
            }
        ?>

</div>
    <script>
        function validationpassword()
        {
            var createpass=document.getElementById('myinput1').value;
            var passpattren=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
                if(passpattren.test(createpass))
                {
                    document.getElementById('myinput1').style.borderBottom='2px solid green';
                }
                else
                {
                    document.getElementById('myinput1').style.borderBottom='2px solid red';
                }
        }

        function startTimer(duration, display) {
        var start = Date.now(),
            diff,
            minutes,
            seconds;
        function timer() {
            // get the number of seconds that have elapsed since
            // startTimer() was called
            diff = duration - (((Date.now() - start) / 1000) | 0);

            // does the same job as parseInt truncates the float
            minutes = (diff / 60) | 0;
            seconds = (diff % 60) | 0;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (diff <= 0) {
                // add one second so that the count down starts at the full duration
                // example 05:00 not 04:59
                start = Date.now() + 1000;
            }
        };
        // we don't want to wait a full second before the timer starts
        timer();
        setInterval(timer, 1000);
            }

            window.onload = function () {
                var fiveMinutes = 60*2,
                    display = document.querySelector('#time');
                startTimer(fiveMinutes, display);
            };

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
    </script>
</body>
</head>
</html>