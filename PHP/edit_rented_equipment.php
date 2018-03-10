<?php
$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'rented_equipment';

//Connecting to MySQL server

$conn = new PDO('mysql: host='.$host.';dbname='.$db.';charset=utf8', $username, $password);

//Adding attributes to the connection

$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//getting id the data from the HTML
$id = $_GET['id'];

//Condition for the id value
//if ($id == ''){
$stm = $conn->prepare('UPDATE '.$table.' SET renter_id= :renter_id, equipment_id= :equipment_id, amount= :amount, note= :note, pickup_date= :pickup_date, return_date = :return_date WHERE id= :id');

//}else{
//$stm = $conn->prepare('INSERT INTO '.$table.' (first_name, last_name, city, zip_code, phone, email, created_date) values(:first_name, :last_name, :city, :zip_code, :phone, :email, :created_date) WHERE id='.$id);
//}

// data from the html

$renter_id = $_POST['renter_id'];
$equipment_id = $POST['equipment_id'];
$amount = $POST['amount'];
$note = $POST['note'];
$pickup_date = $POST['pickup_date'];
$return_date = $POST['return_date'];


//Execution to MySQL and insert the values in the table

$execute = $stm->execute(array(':renter_id' => $renter_id, ':equipment_id' => $equipment_id, ':amount' => $amount, ':note' => $note, ':pickup_date' => $pickup_date, ':return_date' =>$return_date, ':id' => $id));

//Closing connection with MySQL
$conn->close();

?>