<?php
$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'equipment';

//Connecting to MySQL server

$conn = new PDO('mysql: host='.$host.';dbname='.$db.';charset=utf8', $username, $password);

//Adding attributes to the connection

$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//getting id the data from the HTML
        $id = $_POST['id'];

//Condition for the id value
if ($id == ''){
    $stm = $conn->prepare('INSERT INTO '.$table.' (equipment_type_id, equipment_model_id, amount, note, year_equipment) VALUES (:equipment_type_id, :equipment_model_id, :amount, :note, :year_equipment)');
    
    $equipment_type_id = $_POST['equipment_type_id'];
    $equipment_model_id = $_POST['equipment_model_id'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];
    $year_equipment = $_POST['year_equipment'];

    $execute = $stm->execute(array(':equipment_type_id' => $equipment_type_id, ':equipment_model_id' => $equipment_model_id, ':amount' => $amount, ':note' => $note, ':year_equipment' => $year_equipment));
    
    $stmselect = $conn->prepare('SELECT * FROM '.$table.' WHERE id=(SELECT MAX(id) FROM '.$table.')');

        $stmselect_exe = $stmselect->execute();

        $stmselect_results = array();

        $stmselect_results = $stmselect->fetchAll(PDO::FETCH_ASSOC);

        echo JSON_encode($stmselect_results);

}else{
    
    $stm = $conn->prepare('UPDATE '.$table.' SET equipment_type_id = :equipment_type_id, equipment_model_id = :equipment_model_id, amount = :amount, note = :note, year_equipment = :year_equipment WHERE id='.$id);
    
        $equipment_type_id = $_POST['equipment_type_id'];
        $equipment_model_id = $_POST['equipment_model_id'];
        $amount = $_POST['amount'];
        $note = $_POST['note'];
        $year_equipment = $_POST['year_equipment'];

    $stm_select_id = $conn->prepare('SELECT * FROM '.$table.' WHERE id='.$id);
    $stm_select_id->execute();
    
    $result_id = array();
    $result_id = $stm_select_id->fetchAll(PDO::FETCH_ASSOC);
    
    $type_id = $result_id[0]['equipment_type_id'];
    $model_id = $result_id[0]['equipment_model_id'];
    
    $stm_update_type = $conn->prepare('UPDATE equipment_type SET equipment_type_name = :equipment_type_name WHERE id='.$type_id);
    $stm_update_type->execute(array(':equipment_type_name' => $equipment_type_id));
    
    $stm_update_model = $conn->prepare('UPDATE equipment_model SET equipment_model =:equipment_model WHERE id='.$model_id);
    $stm_update_model->execute(array(':equipment_model' => $equipment_model_id));

    $execute = $stm->execute(array(':equipment_type_id' => $type_id, ':equipment_model_id' => $model_id, ':amount' => $amount, ':note' => $note, ':year_equipment' => $year_equipment));
    
        $stm_select_equipment = $conn->prepare('SELECT * FROM '.$table.' WHERE id='.$id);

        $stm_select_equipment->execute();

        $select_equipment_results = $stm_select_equipment->fetchAll(PDO::FETCH_ASSOC);

        echo JSON_encode($select_equipment_results);
}

//Display a Json with the last 


//Closing connection with MySQL
$conn->close();

?>