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
$id = $_POST['id'];

//Condition for the id value
$stm = $conn->prepare('UPDATE '.$table.' SET rented= :rented WHERE id= :id');

//Execution to MySQL and insert the values in the table

$execute = $stm->execute(array(':rented' => 'false', ':id' => $id));

//Closing connection with MySQL
$conn->close();

?>