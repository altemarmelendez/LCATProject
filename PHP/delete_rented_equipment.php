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
$stm_select = $conn->prepare('SELECT * FROM '.$table.' WHERE id= :id');
$execute_select = $stm_select->execute(array(':id' => $id));

echo json_encode($execute_select);


$stm = $conn->prepare('DELETE FROM '.$table.' WHERE id= :id');

//Execution to MySQL and insert the values in the table

$execute = $stm->execute(array(':id' => $id));

//Closing connection with MySQL
$conn->close();

?>