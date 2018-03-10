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

$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = array();

$id = $_POST['id'];

if ($id == ''){
    echo 'It need a ID to delete the row!';
}else{

    $stm = $conn->prepare('SELECT * FROM '.$table.' WHERE id ='.$id);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    
    $type_equipment_id = $result[0]['equipment_type_id'];
    $model_equipment_id = $result[0]['equipment_model_id'];
    
    $stm_equip_type = $conn->prepare('DELETE FROM equipment_type WHERE id='.$type_equipment_id);
    
    $stm_equip_model = $conn->prepare('DELETE FROM equipment_model WHERE id='.$model_equipment_id);
    
    $stm_equip_type->execute();
    $stm_equip_model->execute();
    
    $stm_delete = $conn->prepare('DELETE FROM '.$table.' WHERE id='.$id);
    
    $stm_delete->execute();
}

echo JSON_encode($result);

$conn->close();

?>