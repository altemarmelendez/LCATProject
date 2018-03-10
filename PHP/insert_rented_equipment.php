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
$equipmentAndRenter = array();
$equipmentAndRenter = json_decode($_REQUEST['equipmentrenter']);

//Condition for the id value
if($equipmentAndRenter ==''){
    $message = 'There are not info coming!';
    echo "<SCRIPT>alert('$message');</SCRIPT>";
    echo $message;
}else{
  for ($x=0; $x < count($equipmentAndRenter); $x++){
      
          $renter_id = '';
          $equipment_id = '';
          $equipment_model_id = '';
          $amount = '';
          $note = '';
          $pickup_date = '';
          $return_date = '';
          $rented = '';
     
        // {"renter_id":renterSelectedId, "equipment_id": selectedEquipmentValue , "equipment_model_id": selectedEquipmentModelValueOption, "amount": selectedNumber, "note": noteText, "pickup_date": pickUpDateVal, "return_date": returnDateVal, "rented": 'true'}      
      
    $stm = $conn->prepare('INSERT INTO '.$table.' (renter_id, equipment_id, equipment_model_id, amount, note, pickup_date, return_date, rented) values (:renter_id, :equipment_id, :equipment_model_id, :amount, :note, :pickup_date, :return_date, :rented)');
          
          $renter_id = $equipmentAndRenter[$x]->renter_id;
          $equipment_id = $equipmentAndRenter[$x]->equipment_id;
          $equipment_model_id = $equipmentAndRenter[$x]->equipment_model_id;
          $amount = $equipmentAndRenter[$x]->amount;
          $note = $equipmentAndRenter[$x]->note;
          $pickup_date = $equipmentAndRenter[$x]->pickup_date;
          $return_date = $equipmentAndRenter[$x]->return_date;
          $rented = $equipmentAndRenter[$x]->rented;
        
    $execute = $stm->execute(array(':renter_id' => $renter_id, ':equipment_id' => $equipment_id,':equipment_model_id' => $equipment_model_id, ':amount' => $amount, ':note' => $note, ':pickup_date' => $pickup_date, ':return_date' =>$return_date, ':rented' => $rented)); 

  }

// Printing JSON from a javascript variable object
 

    
//Execution to MySQL and insert the values in the table
}

$json_rented_equipment = json_decode($_REQUEST['equipmentrenter']);

$stm_equipment_type = $conn->prepare('SELECT * FROM equipment_type');

$stm_equipment_type->execute();
$result_equipment_type = $stm_equipment_type->fetchAll(PDO::FETCH_ASSOC);

$result_equipment = array();

for ($y=0; $y < count($json_rented_equipment); $y++){
    for ($x=0; $x < count($result_equipment_type); $x++){
    if ($json_rented_equipment[$y]->equipment_id == $result_equipment_type[$x]['id']){
        array_push($result_equipment, ['equipment' => $result_equipment_type[$x]['equipment_type_name']]);
      }
    }
}

print json_encode($result_equipment);

//Closing connection with MySQL
$conn->close();

?>