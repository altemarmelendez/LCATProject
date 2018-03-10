<?php
//id: "1",
//first_name: "Roman",
//last_name: "Jaquez",
//address: "23 Ames st",
//city: "Lawrence",
//zip_code: "01841",
//phone: "978-234-1234",
//email: "a@jaquez.com",
//created_date: "2017-10-16"

$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'renters';

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
    array_push($array_result, ['id' => $row['id'], 'first_name' => $row['first_name'],'last_name' => $row['last_name'], 'address' => $row['address'], 'city' => $row['city'], 'zip_code' => $row['zip_code'],  'phone' => $row['phone'], 'email' => $row['email'], 'created_date' => $row['created_date']]);
}

echo JSON_encode($array_result);

$conn->close();

?>