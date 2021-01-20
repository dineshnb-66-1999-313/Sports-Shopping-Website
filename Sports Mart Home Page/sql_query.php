<?php

require_once 'pdo_sports_accessories.php';

if(isset($_POST['try']))
{
$sing_up_table ="CREATE TABLE IF NOT EXISTS sign_up_info_sports(
    ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(150) NOT NULL,
    user_name varchar(150) NOT NULL,
	E_mail_id varchar(150) NOT NULL,
    DOB date NOT NULL,
    Gender varchar(150) NOT NULL,
    phone_number bigint(15) NOT NULL,
    cre_password varchar(150) NOT NULL,
    date_time_of_sign_up datetime NOT NULL
)";

$profile_date = "CREATE TABLE IF NOT EXISTS profile_data_assignment(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id int(150) NOT NULL,
    emailid varchar(150) NOT NULL,
    status2 int(15) NOT NULL,
    default_image2 varchar(200) NOT NULL,
    profile_img_name2 varchar(200) NOT NULL,
    date_of_profile_update_info datetime NOT NULL
)";

$list_of_books = "CREATE TABLE IF NOT EXISTS list_of_sports_item(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id int(150) NOT NULL,
    product_name varchar(150) NOT NULL,
    brand_name varchar(150) NOT NULL,
    color varchar(150) NOT NULL,
    product_status varchar(10) NOT NULL,
    actual_price int(15) NOT NULL,
    price int(15) NOT NULL,
    Quantity int(15) NOT NULL,
    Actual_Quantity int(15) NOT NULL,
    rating_of_sports_item int(15) NOT NULL,
    product_image varchar(150) NOT NULL
)";

$customer_cart="CREATE TABLE IF NOT EXISTS customer_cart(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id int(150) NOT NULL,
    E_mail_id varchar(150) NOT NULL,
    product_name varchar(150) NOT NULL,
    brand_name varchar(150) NOT NULL,
    color varchar(150) NOT NULL,
    actual_price int(15) NOT NULL,
    price int(15) NOT NULL,
    rating_of_sports_item int(15) NOT NULL,
    product_image varchar(150) NOT NULL
)";

$purchased_item="CREATE TABLE IF NOT EXISTS purchased_item(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id int(150) NOT NULL,
    E_mail_id varchar(150) NOT NULL,
    product_name varchar(150) NOT NULL,
    brand_name varchar(150) NOT NULL,
    color varchar(150) NOT NULL,
    product_status varchar(150) NOT NULL,
    actual_price int(15) NOT NULL,
    price int(15) NOT NULL,
    rating_of_sports_item int(15) NOT NULL,
    product_image varchar(150) NOT NULL
)";

$time_data = "CREATE TABLE IF NOT EXISTS time_data_sports(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    E_mail_id varchar(120) NOT NULL,
    login_count int(120) NOT NULL,
    login_time time NOT NULL,
    logout_time time NOT NULL,
    time_spent time NOT NULL
)";

$first_address = "CREATE TABLE first_address (
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    E_mail_id varchar(150) NOT NULL,
    first_name varchar(150) NOT NULL,
    p_number bigint(20) NOT NULL,
    pincode int(150) NOT NULL,
    locality varchar(150) NOT NULL,
    address1 varchar(150) NOT NULL,
    city varchar(150) NOT NULL,
    state1 varchar(150) NOT NULL,
    landmark varchar(150) NOT NULL
)";

// echo "Table created succeffully";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sql_query</title>
</head>
<body>
    <form action="sql_quer.php" method ="post">
        <button type="submit" name="try">Try</button>
    </form>
</body>
</html>