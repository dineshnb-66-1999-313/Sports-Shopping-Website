<?php
    session_start();
    // error_reporting(0);
    require_once "component.php";
    require_once "pdo_sports_accessories.php";
    
$random1 = substr(number_format(time() * rand(),0,'',''),0,8);
if(isset($_POST['submit']))
{
    $file = $_FILES['file'];                           $filename=$_FILES['file']['name'];
    $filetempname=$_FILES['file']['tmp_name'];         $filesize=$_FILES['file']['size'];
    $fileerror=$_FILES['file']['error'];               $filetype=$_FILES['file']['type'];

    $fileext=explode('.',$filename);
    $fileactualext = strtolower(end($fileext));
    $allowed=array('jpg','jpeg','png');

    if(in_array($fileactualext,$allowed))
    {
        if($fileerror===0)
        {
            if($filesize<(1*1024*1024))
            {
                $all_data_from_profile_data=$pdo->prepare("SELECT * FROM profile_data_assignment WHERE emailid=:emailid");
                $all_data_from_profile_data->execute(array(':emailid' => $_SESSION['email']));
                $select_profile_image_row=$all_data_from_profile_data->fetch(PDO::FETCH_ASSOC);
                unlink($select_profile_image_row['profile_img_name2']);

                $email_given = $_SESSION['email'];
                $email_split = explode('@',$email_given,2);
                $filenamenew="profile_".$email_split[0]."_".$random1.".".$fileactualext;
                $filedestination='uploads/'.$filenamenew;
                move_uploaded_file($filetempname,$filedestination);
                $sql123=$pdo->prepare("UPDATE profile_data_assignment SET status2 = 0,profile_img_name2=:profilename,
                                        date_of_profile_update_info=now() WHERE emailid=:emailid");
                $sql123->execute(array(':profilename' => $filedestination,':emailid' => $_SESSION['email']));
                $message ='<label style="color:yellow;";>Profile updated successfully </label>';
            }
            else{
                $message ='<label>file is too big</label>';
            }
        }
        else{
            $message ='<label>There was an error in uploading the file</label>';
        }
    }
    else{
         $message ='<label>You cannot upload files of this kind</label>';
    }
}
if(isset($_POST['button2'])){
    $selectimagequery=$pdo->prepare("SELECT * FROM profile_data_assignment WHERE emailid=:emailid");
    $selectimagequery->execute(array(':emailid' => $_SESSION['email']));
    $rowimage=$selectimagequery->fetch(PDO::FETCH_ASSOC);

    unlink($rowimage['profile_img_name2']);
    $deleteimagequery=$pdo->prepare("UPDATE profile_data_assignment SET status2=1,profile_img_name2=:profiledefaultimage,date_of_profile_update_info=now() WHERE emailid=:emailid");
    $deleteimagequery->execute(array(':profiledefaultimage' => $rowimage['default_image2'],':emailid' => $_SESSION['email']));
    header('Location:profile_and_personal_info_update.php');
}
if(isset($_POST['save']))
{
    $name=$_POST['name'];  $p_number=$_POST['p_number'];

    $select_phone_number_query1 = $pdo->prepare("SELECT phone_number FROM sign_up_info_sports WHERE E_mail_id=:emailid");
    $select_phone_number_query1->execute(array(':emailid'=> $_SESSION['email']));
    $row32 = $select_phone_number_query1->fetch(PDO::FETCH_ASSOC);
    $p_number_user=$row32['phone_number'];

    $select_phone_number_query = $pdo->prepare("UPDATE sign_up_info_sports SET phone_number='NULL' WHERE E_mail_id=:emailid");
    $select_phone_number_query->execute(array(':emailid'=> $_SESSION['email']));

    $p_uniq = $pdo->prepare("SELECT COUNT(phone_number) AS punique, phone_number FROM sign_up_info_sports WHERE phone_number=:p_number");
    $p_uniq->execute(array(':p_number'=> $p_number));
    $row3 = $p_uniq->fetch(PDO::FETCH_ASSOC);

    if($row3['punique']<1)
    {
        $name_and_phone_update=$pdo->prepare("UPDATE sign_up_info_sports SET first_name=:fname, phone_number=:pnumber WHERE E_mail_id=:emailid");
        $name_and_phone_update->execute(array(':fname' => $name,':pnumber' => $p_number, ':emailid' => $_SESSION['email']));
        $_SESSION['name']=$name;
        $message ='<label style="color:yellow;";>Personal Info Update Sucessfull</label>';
    }
    else
    {
        $update_phone_number_if_not_correct=$pdo->prepare("UPDATE sign_up_info_sports SET phone_number=:pnumber WHERE E_mail_id=:emailid");
        $update_phone_number_if_not_correct->execute(array(':pnumber' => $p_number_user,':emailid' => $_SESSION['email']));
        $message ='<label>Phone number already exist</label>';
    }

}
?>
<html>
    <head>
        <title>Profile Area</title>
            <link rel="icon" type="image/png" href="https://pngimg.com/uploads/book/book_PNG51090.png">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <link href="https://fonts.googleapis.com/css?family=karla" rel="stylesheet">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
            <!-- <link rel="stylesheet" type="text/css" href="profile_and_personal_info_update.css"> -->
        <style>
            html{
                    min-height:100%;
                }
            body{
                margin: 0;
                padding: 0;
                background: url('https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg')/*linear-gradient(50deg,#063146,green)*/;
                background-size: 100% 120%;
                background-position: center;
                transition: all .5s;
                height: 100vh;
                align-items: center;
                /*font-family: sans-serif;*/
            }
            /*-------------------------------------------------------------------------*/
            .loaderclass{
                    position:fixed;
                    z-index:99;
                    top :0;
                    left:0;
                    width:100%;
                    height:100%;
                    background:grey;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                }
                .loaderclass img{
                    width:1000px;
                    height:800px;
                }
                .loaderclass > img{
                    width:500px;
                }
                .loaderclass.hidden{
                    animation:fadeOut 2s;
                    animation-fill-mode:forwards;
                }
                .loaderclass i{
                    left:38.8%;
                    top:28%;
                    font-size:150px;
                    position:absolute;
                }
                @keyframes fadeOut{
                    100%{
                        opacity:0;
                        visibility:hidden;
                    }
                }
                .mySlides {display:none;}
                .coverimg{
                    width: 100%;
                    height: 100%;
                    background-size: cover;
                    background-position: center;
                }
                /*-------------------------------------------------------------------------*/
            .headertop{
                position: fixed;
                width: 1520px;
                height: 80px;
                top: 0px;
                background: #063146;
                left: 0px;
                font-size: 16px;
                border-bottom:2px solid green;
                z-index:1;
            }
            .logo1{
                margin-top:0px;
                width: 100px;
                height: 75px;
                border-radius: 50%;
                position: absolute;
                top: 2px;
                left:20px;
            }
            p.head{
                padding: 10px;
                font-size:20px;
                color: aqua;
                position: fixed;
                left: 80%;
                top: 2px;
                z-index:1;
            }
            p.heading{
                font-size:30px;
                color:orange;
                padding-left:150px;
                padding-top:20px;
                margin-top:0px;
            }
            .container{
                width:40%;
                height:55%;
                position:absolute;
                background:transparent;
                left:25%;
                top:18%;
            }
            .footer-image{
                height: 60px;
                width: 300px;
                left:-100px;
                position:absolute;
            }
            .cropimg{
                background:transparent/*#063146 linear-gradient(50deg,#063146,green)*/;
                width:85%;
                height:85%;
                position:relative;
                top:5%;
                left:5%;
                border-radius:5%;
                border-top:12px solid orange;
                border-bottom:12px solid orange;
                border-left:2px dashed white;
                border-right:2px dashed white;
            }
            .container .cropimg img{
                width:40%;
                height:65%;
                position:absolute;
                top:7%;
                left:30%;
                border:2px solid #fff;
                border-radius:50%;
            }
            p.servent{
                left:38%;
                color:orange;
                font-style:bold;
                align:center;
            }
            input[type="file"]{
                top:400px;
                left:360px;
                position:absolute;
                font-size:22px;
            }
            input[type="file"]:hover{
                cursor:pointer;
            }
            .button1{
                top: 20px;
                left: 68%;
                position: absolute;
                font-size: 18px;
                border-radius: 3px;
                background: transparent/*4d8cf2*/;
                width: 28%;
                height: 28%;
                color: white;
                border: 0.5px solid #fff;
                overflow: hidden;
                cursor:pointer;
            }
            .button1 i{
                cursor:pointer;
                color:orange;
                padding-right:12px;
            }
            .button2{
                top: 53%;
                left: 68%;
                position: absolute;
                font-size: 18px;
                border-radius: 3px;
                background: transparent;
                width: 28%;
                height: 28%;
                color: white;
                border: 0.5px solid #fff;
                padding: 6px;
                overflow: hidden;
                cursor:pointer;
            }
            .button2 i{
                padding-right:12px;
                color:red;
            }
            .message{
                top:15%;
                left:35%;
                position:absolute;
                color:red;
                font-size:18px;
                z-index:0;
            }
            input#file-input{
                display: none;
            }
            input#file-input + label{
                padding:7px;
                background:transparent/*#4d8cf2*/;
                color: white;
                top:15%;
                left:5%;
                position:absolute;
                font-size:18px;
                border-radius:3px;
                border:0.5px solid white;
                max-width: 15%;
                max-width: 65%;
            }
            input#file-input + label:hover{
                cursor:pointer;
            }
            strong{
                color: #fff;
                top:55%;
                left:6%;
                position:absolute;
                font-size:18px;
            }
            .span{
                color:black;
                top:55%;
                left:28%;
                position:absolute;
                font-size:18px;
            }

            .footer-class1{
                padding: 5px;
                background-color: white;
                color: #fff;
                top: 700px;
                width: 100%;
                height: 200px;
                position: absolute;
                text-align: left;
            }
            .footer-image{
                height: 60px;
                width: 300px;
                padding-left: 100px;
                padding-top: 12px;
            }
            .footer-address{
                height: 60px;
                width: 300px;
                left: 10px;
                top: 100px;
                position: absolute;
            }
            .add1{
                height: 40px;
                width: 320px;
                left: 2px;
                top: -10px;
                background:transparent;
                position: absolute;
                /*text-align: center;*/
            }
            .add1 i{
                color:green;
                padding-left:10px;
                padding-right:10px;

            }
            .footer-address121{
                height: 60px;
                width: 300px;
                left: 4px;
                top: 130px;
                position: absolute;
            }
            .add11{
                height: 40px;
                width: 300px;
                left: 10px;
                top: 12px;
                background: transparent;
                position: absolute;
            }
            .add11 i{
                color:green;
                padding-left:10px;
                padding-right:10px;
            }
            .add11 a{
                color:blue;
                font-size:13px;
                cursor:pointer;
                text-decoration:none;
                font-style:normal;
            }
            #myid{
                width: 35%;
                height: 20%;
                top: 72%;
                left: 27%;
                position: absolute;
                background: transparent;
                display: block;
                z-index: 1;
                display: none;
            }
            .edit{
                width:50px;
                height:30px;
                position:absolute;
                background:transparent;
                top:5%;
                left:88%;
                display:block;
                /*z-index:1;*/
            }
            .edit i{
                cursor:pointer;
                color:orange;
            }
            .cancel_but{
                cursor:pointer;
                position:absolute;
                background:transparent;
                top:15%;
                left:5%;
                color: white;
                padding: 2px;
                border-radius: 3px;
                border:none;
            }
            .cancel_but i{
                color:red;
                padding-right:12px;
                font-size:20px;
            }
            .edit_but{
                top: 22%;
                left: 68%;
                position: absolute;
                z-index: 1;
                color: white;
                border-radius: 4px;
                background: transparent/*#4d8cf2*/;
                font-size: 18px;
                padding: 8px;
                border:0.7px solid #fff;
                cursor:pointer;
            }
            .edit_but i{
                color:orange;
                padding-right:10px;
            }
            #edit_personal_data{
                width:30%;
                height:36%;
                top:30%;
                left:55%;
                position:absolute;
                background:transparent/*#063146 linear-gradient(50deg,#063146,green)*/;
                display:block;
                z-index:1;
                visibility: hidden;
                border-radius:15px;
                border-top:5px solid orange;
                border-bottom:5px solid orange;
                border-left:2px solid white;
                border-right:2px solid white;
            }
            #edit_inside_personal_data{
                z-index:1;
                color:#fff;
                display:block;
                padding-left:80%;
                top:10%;
                position:absolute;
            }
            #edit_inside_personal_data:hover{
                cursor:pointer;
            }
            .border{
                padding:10px;
                border:3px solid white;
                width: 40%;
                height: 20%;
                top:15%;
                left:30%;
                position:absolute;
                font-size:18px;
                color: white;
            }
            #edit_form_personal_data{
                display:none;
                padding:10px;
                top:15px;
                left:15%;
                position:absolute;
                color:#fff;
            }
            #edit_form_personal_data input{
                width:180px;
                height:40px;
                color:#fff;
                text-align:left;
                padding-left:20px;
                font-size:18px;

            }
            #edit_form_personal_data input[type="text"]{
                background: transparent;
                border:1px solid orange;
                outline:none;
                border-radius:5px;
            }
            #edit_form_personal_data i{
                color: orange;
                padding-right:25px;
            }
            .submit_info{
                top:150px;
                left:120px;
                position:absolute;
                color:white;
                border-radius:3px;
                background:transparent/*#4d8cf2*/;
                font-size:18px;
                padding:4px 20px;
                border:1px solid #fff;
                cursor:pointer;
            }
            .phone_number{
                padding:10px;
                border:2px solid white;
                width: 100%;
                line-height: 55%;
                top:80px;
                left:0px;
                position:absolute;
                color:#fff;
                text-align: center;
            }
            h1{
                font-size: 30px;
                color: white;
                padding: 25% 0 0 0;
                top: -21rem;
                position: absolute;
                left: 23rem;
            }
            .password_retrival_404{
                width: 27rem;
                height: 24rem;
                border-radius: 50%;
                position: absolute;
                top: 17%;
                left: 30%;
            }
        </style>
    </head>
<body>
    <div class="loaderclass">
        <i class="fa fa-spinner fa-spin fa-5x"></i>
    </div>
    <?php
    if(isset($_SESSION['email'])){
        $insert_into_value_info = $pdo->prepare("SELECT * FROM sign_up_info_sports WHERE E_mail_id=:emailid");
        $insert_into_value_info->execute(array(':emailid' => $_SESSION['email']));
        $fetching_row = $insert_into_value_info->fetch(PDO::FETCH_ASSOC);

        $sqlimg_user=$pdo->prepare("SELECT * FROM profile_data_assignment WHERE emailid=:emailid");
        $sqlimg_user->execute(array(':emailid' => $_SESSION['email']));
        $rty2=$sqlimg_user->fetch(PDO::FETCH_ASSOC);

            echo '<div id="myid">';
            echo '<form method="post" enctype="multipart/form-data">
                <input type="file" id="file-input" name="file">
                <label for="file-input">Choose Image..</label>
                <span>
                    <strong >Chosen file:</strong>
                    <span class="span" id="file-name">None</span>
                </span>
                <button class="button1" type="submit" name="submit"><i class="fa fa-upload"></i>Upload</button>
                </form>';
                if($rty2['status2'] == 0){
                echo '<form method="post" enctype="multipart/form-data">
                    <button class="button2" name="button2"><i class="fa fa-trash-o fa-lg"></i>Remove</button>
                    </form>';
                }
        echo '</div>';
        /*--------------------------------------------------------------------- */
        echo '<button class="edit_but" id="main_personal_edit" onclick=myfunction1()><i class="fa fa-pencil fa-lg"></i>Personal Info</button>';
        /* -------------------------------------------------------------------------*/
            echo '<div id="edit_personal_data">';
                echo '<div class="border" id="myid5">';
                    echo '<span>'.$fetching_row["first_name"].'</span>
                        <label class="phone_number">'.$fetching_row['phone_number'].'</label>';

                    echo '</div>';
                    echo '<i onclick=myfunction2() id="edit_inside_personal_data" class="fa fa-pencil fa-2x"></i>';
                    echo '<div id="edit_form_personal_data">';
                            echo '<form method="post">
                            <i class="fa fa-user fa-2x"></i><input type="text" autocomplete="off" value="'.$fetching_row["first_name"].'" name="name"><br><br>
                            <i class="fa fa-phone fa-2x"></i><input type="text" autocomplete="off" value="'.$fetching_row['phone_number'].'" name="p_number" maxlength="10" onkeyup="validationpnumber()" id="pnumberinfo">
                            <button class="submit_info" name="save">Save</button>
                            </form>';
                echo '</div>';

            echo '</div>';
            /*--------------------------------------------------------------------------- */
        }
    ?>
    <!-- header starting-->
    <?php
    if(isset($_SESSION['email'])){
        echo '<nav class="navbar navbar-expand-xs bg-info fixed-top w-100" style="border:1px solid #000;">
            <div class="col-sm-3">
                <a href="sports_shopping_home_page.php" class ="navbar-brand">
                    <h3 class="mr-5">
                        <span class ="text-warning text-dark ml-4 mt-5">Sports Mart</span>
                    </h3>
                </a>
            </div>';
                
        echo '<h3 class=" text-dark" style="margin-right:15%;;">Welcome : <span class = "text-success pr-5">'.$_SESSION['name'].'</span></h3>';
        echo '</nav>';
    }
    else{
        echo "<h1>You can't access this site without session</h1>";
        echo '<img src="https://media2.giphy.com/media/8L0Pky6C83SzkzU55a/giphy.gif" class="password_retrival_404">';
    }
    ?>
    <!-- header ending -->

<?php
    if(isset($message)){
        echo '<label class ="message">'.$message.'</label>';
    }
    if(isset($_SESSION['email']))
    {
        $sqlimg=$pdo->prepare("SELECT * FROM profile_data_assignment WHERE BINARY emailid=:emailid");
        $sqlimg->execute(array(':emailid' => $_SESSION['email']));
        $rty2=$sqlimg->fetch(PDO::FETCH_ASSOC);
        echo "<div class='container' id='container_of_user_profile'>";
        echo "<div class='cropimg'>";
            if($rty2['status2'] == 0){
                echo "<img src=".$rty2['profile_img_name2'].">";
            }
            else{
                echo "<img src=".$rty2['profile_img_name2'].">";
            }
            echo '<div class="edit">';
            echo '<i onclick=myfunction() id="edit_profile" class="fa fa-pencil fa-2x"></i>';
            echo '</div>';
        echo "</div>";
        echo "</div>";

    }
?>
<?php
    // require_once "footer_library.php";
?>
<script>
    let inputfile=document.getElementById('file-input');
    let filenamefield=document.getElementById('file-name');
    inputfile.addEventListener('change',function(event){
        let uploadedfilename=event.target.files[0].name;
        filenamefield.textContent=uploadedfilename;
    })

        function myfunction() {
            var x=document.getElementById("myid");
            var y=document.getElementById("edit_profile");
            if (x.style.display == "block") {
                x.style.display = "none";
              } else {
                x.style.display = "block";
                y.style.display="none";
              }
        }
        function myfunction1() {
            var x1=document.getElementById("edit_personal_data");
            var z1=document.getElementById("main_personal_edit");
            var y1=document.getElementById("edit_inside_personal_data");
            var b1=document.getElementById("myid");
            var a1=document.getElementById("container_of_user_profile");
            if (x1.style.display == "block") {
                x1.style.display = "none";
              } else {
                x1.style.visibility = "visible";
                x1.style.opacity="1";
                x1.style.transition="1s";
                y1.style.display="block";
                z1.style.display="none";
                a1.style.left="13%";    
                a1.style.top="20%";
                a1.style.transition="0.8s";
                b1.style.left="14%";
                b1.style.top="73%";
                b1.style.transition="1s";
              }
        }
        function myfunction2() {
            var x2=document.getElementById("main_personal_edit");
            var z2=document.getElementById("edit_personal_data");
            var y2=document.getElementById("edit_inside_personal_data");
            var p2=document.getElementById("myid5");
            var v2=document.getElementById("edit_form_personal_data");
            if (x2.style.display == "block") {
                x2.style.display = "none";
              } else {
                x2.style.display = "none";
                y2.style.display="none";
                z2.style.display="block";
                p2.style.display="none";
                v2.style.display="block";
              }
        }

        function validationpnumber()
        {
            var createnumber=document.getElementById('pnumberinfo').value;
            var numberpattren=/^[0-9].{9,9}$/;
                if(numberpattren.test(createnumber)){
                    document.getElementById('pnumberinfo').style.border='2px solid green';
                }
                else{
                    document.getElementById('pnumberinfo').style.border='2px solid red';
                }
        }


        window.addEventListener("load",function(){
        const loader=document.querySelector(".loaderclass");
        console.log(loader);
        loader.className += " hidden";
     });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>

</html>