<?php
$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'equipment_model';

$conn = new PDO("mysql: host=".$host.";dbname=".$db.";charset=utf8", $username, $password);

$id = $_GET['id'];
//if($conn) echo '<p>it is connected!</p>';
if ($id == ''){
    $stm = $conn->prepare('SELECT * FROM '.$table);
}else{
    $stm = $conn->prepare('SELECT * FROM '.$table.' WHERE id ='.$id);
}
// if($stm) echo 'Statemant is ready!';

$exec = $stm->execute();

//if($exec) echo 'Execute is ready!';

$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$array_result = array();

foreach($result as $row){
    array_push($array_result, ['id' => $row['id'], 'equipment_model' => $row['equipment_model']]);
}

echo JSON_encode($array_result);

$conn->close();

?>