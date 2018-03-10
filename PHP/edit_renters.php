<?php
$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'renters';

//Connecting to MySQL server

$conn = new PDO('mysql: host='.$host.';dbname='.$db.';charset=utf8', $username, $password);

//Adding attributes to the connection

$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//getting id the data from the HTML
$id = $_GET['id'];

//Condition for the id value
//if ($id == ''){
$stm = $conn->prepare('UPDATE '.$table.' SET first_name= :first_name, last_name= :last_name, city = :city, zip_code = :zip_code, phone = :phone, email = :email, created_date = :created_date WHERE id= :id');

//}else{
//$stm = $conn->prepare('INSERT INTO '.$table.' (first_name, last_name, city, zip_code, phone, email, created_date) values(:first_name, :last_name, :city, :zip_code, :phone, :email, :created_date) WHERE id='.$id);
//}

// data from the html

$first_name = $_POST['firstname'];
$last_name = $POST['lastname'];
$city = $POST['city'];
$zip_code = $POST['zip_code'];
$phone = $POST['phone'];
$email = $POST['email'];
$last_name = $POST['created_date'];

//Execution to MySQL and insert the values in the table

$execute = $stm->execute(array(':first_name' => $firstname, ':last_name' => $last_name, ':city' => $city, ':zip_code' => $zip_code, ':phone' => $phone, ':email' =>$email, ':created_date' => $last_name, ':id' => $id));

//Closing connection with MySQL
$conn->close();

?>