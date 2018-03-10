<?php
//JSON Format:
//
//id: "1",
//equipment_type: "Camera",
//equipment_model: "Sony",
//amount: "4",
//note: "Cameras with Memory Sticks",
//year_equipment: "2012-01-01"

$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'equipment';

$conn = new PDO("mysql: host=".$host.";dbname=".$db.";charset=utf8", $username, $password);

$id = $_GET['id'];
//if($conn) echo '<p>it is connected!</p>';
if ($id == ''){
    $stm = $conn->prepare('SELECT * FROM '.$table);
}else{
    $stm = $conn->prepare('SELECT * FROM '.$table.' WHERE id ='.$id);
}
// if($stm) echo 'Statemant is ready!';

$stm_equip_type = $conn->prepare('SELECT * FROM equipment_type');
$stm_equip_model = $conn->prepare('SELECT * FROM equipment_model');

$stm_equip_type->execute();
$stm_equip_model->execute();
$exec = $stm->execute();
//if($exec) echo 'Execute is ready!';

$result_equip_type = $stm_equip_type->fetchAll(PDO::FETCH_ASSOC);
$result_equip_model = $stm_equip_model->fetchAll(PDO::FETCH_ASSOC);
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

$array_result_equip_type = array();
$array_result_equip_model = array();
$array_result = array();


foreach($result_equip_type as $row1){
    array_push($array_result_equip_type, ['id' => $row1['id'], 'equipment_type_name' => $row1['equipment_type_name']]); 
}

foreach($result_equip_model as $row2){
    array_push($array_result_equip_model, ['id' => $row2['id'], 'equipment_model' => $row2['equipment_model']]);
}

$final_result_array = array();
$cnt=0;
foreach($result as $row){
    
    array_push($array_result, ['id' => $row['id'], 'equipment_type' => $row['equipment_type_id'],'equipment_model' => $row['equipment_model_id'], 'amount' => $row['amount'], 'note' => $row['note'], 'year_equipment' => $row['year_equipment']]);
    
        for($i=0; $i < count($array_result_equip_type) ; $i++){ 

            if ($array_result[$cnt]['equipment_type'] == $array_result_equip_type[$i]['id'] ){
                $array_result[$cnt]['equipment_type'] = $array_result_equip_type[$i]['equipment_type_name'];
            } 
       }

        for($i=0; $i < count($array_result_equip_model) ; $i++){ 

                if ($array_result[$cnt]['equipment_model'] == $array_result_equip_model[$i]['id'] ){
                    $array_result[$cnt]['equipment_model'] = $array_result_equip_model[$i]['equipment_model'];
                }
           }
    
    $cnt++;

}

echo JSON_encode($array_result);

$conn->close();

?>