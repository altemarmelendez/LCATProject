<?php

//id: "1",
//renter: "Roman Jaquez",
//equipment: "Camera",
//amount: "1",
//note: "Roman is taking the cord cable",
//pickup_date: "2017-10-06",
//return_date: "2017-10-09"

$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'rented_equipment';

$conn = new PDO("mysql: host=".$host.";dbname=".$db.";charset=utf8", $username, $password);

$id = $_GET['id'];
//if($conn) echo '<p>it is connected!</p>';
if ($id == ''){
    $stm = $conn->prepare('SELECT * FROM '.$table);
}else{
    $stm = $conn->prepare('SELECT * FROM '.$table.' WHERE id ='.$id);
}
// if($stm) echo 'Statemant is ready!';


$stm_renters = $conn->prepare('SELECT * FROM renters');
$stm_equipment = $conn->prepare('SELECT * FROM equipment');
$stm_equipment_type = $conn->prepare('SELECT * FROM equipment_type');
$stm_equipment_model = $conn->prepare('SELECT * FROM equipment_model');

$exec = $stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm_renters->execute();
$result_renters = $stm_renters->fetchAll(PDO::FETCH_ASSOC);

$stm_equipment->execute();
$result_equipment = $stm_equipment->fetchAll(PDO::FETCH_ASSOC);

$stm_equipment_type->execute();
$result_equipment_type = $stm_equipment_type->fetchAll(PDO::FETCH_ASSOC);

$stm_equipment_model->execute();
$result_equipment_model = $stm_equipment_model->fetchAll(PDO::FETCH_ASSOC);
//if($exec) echo 'Execute is ready!';

$array_result = array();

$cnt=0;
foreach($result as $row){
    array_push($array_result, ['id' => $row['id'], 'renter' => $row['renter_id'],'equipment' => $row['equipment_id'],'equipment_model' => $row['equipment_model_id'], 'amount' => $row['amount'], 'note' => $row['note'], 'pickup_date' => $row['pickup_date'], 'return_date' => $row['return_date'], 'rented' => $row['rented']]);
    
    for($i=0; $i < count($result_renters); $i++){
        if($array_result[$cnt]['renter'] == $result_renters[$i]['id']){
            
            $array_result[$cnt]['renter'] = $result_renters[$i]['first_name'].' '.$result_renters[$i]['last_name'];
            
        }
    }
    
    for($i=0; $i < count($result_equipment); $i++){
        if($array_result[$cnt]['equipment'] == $result_equipment[$i]['equipment_type_id']){
            
            for($x=0; $x < count($result_equipment_type); $x++){
                
                if ($result_equipment_type[$x]['id'] == $result_equipment[$i]['equipment_type_id']){

                    $array_result[$cnt]['equipment'] = $result_equipment_type[$x]['equipment_type_name'];
                    
                }
            }
            
        }
    }
    
    for($i=0; $i < count($result_equipment); $i++){
        if($array_result[$cnt]['equipment_model'] == $result_equipment[$i]['equipment_model_id']){
            
            for($y=0; $y < count($result_equipment_model); $y++){
                
                if ($result_equipment_model[$y]['id'] == $result_equipment[$i]['equipment_model_id']){

                    $array_result[$cnt]['equipment_model'] = $result_equipment_model[$y]['equipment_model'];
                    
                }
            }
            
        }
    }
    

    $cnt++;
}

echo JSON_encode($array_result);

$conn->close();

?>