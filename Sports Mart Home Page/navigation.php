<?php
    require_once "header.php";
    if(isset($_POST['logout'])){
        session_start();
        session_unset();
        session_destroy();
        header('Location : log_in_page_library.php');
    }
?>

<nav class="navbar bg-info navbar-default fixed-top">
    <h3 class="card-title ml-4 text-success">Library shopping website</h3>
    <small class="text-success">Welcome : <?php echo $_SESSION['name']?></small>
    <form class="form-inline" action="search.php" method="post">
            <button type="submit" class ="btn btn-danger" name="logout"> Log Out</button>
            <input class="form-control ml-5" type="text" placeholder="Search" name="value_field" required="required">
            <button class="btn btn-warning btn-rounded btn-outline-success btn-xl ml-4" type="submit" name="search">Search</button>
    </form>
</nav> 