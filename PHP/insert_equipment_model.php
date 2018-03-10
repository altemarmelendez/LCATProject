<?php
$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'equipment_model';

//Connecting to MySQL server

$conn = new PDO('mysql: host='.$host.';dbname='.$db.';charset=utf8', $username, $password);

//Adding attributes to the connection

$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//getting id the data from the HTML
$id = $_GET['id'];
$equipment_model = $_POST['equipment_model'];
//Condition for the id value
if ($id == ''){
$stm = $conn->prepare('INSERT INTO '.$table.' (equipment_model) VALUES (:equipment_model)');

//Execution to MySQL and insert the values in the table

    $execute = $stm->execute(array(':equipment_model' => $equipment_model));

}else{
$stm = $conn->prepare('UPDATE SET '.$table.' equipment_model = :equipment_model WHERE :id='.$id);

    $execute = $stm->execute(array(':equipment_model' => $equipment_model, ':id' => $id ));
}

//Display a Json with the last info inserted

$stmselect = $conn->prepare('SELECT * FROM '.$table.' WHERE id=(SELECT MAX(id) FROM '.$table.')');

$stmselect_exe = $stmselect->execute();

$stmselect_results = array();

$stmselect_results = $stmselect->fetchAll(PDO::FETCH_ASSOC);

echo JSON_encode($stmselect_results);

//Closing connection with MySQL
$conn->close();

?>