<?php
$host = 'localhost';
$db = 'lcat_db';
$charset = 'utf8';
$username = 'root';
$password = 'root';
$table = 'renters';

//Connecting to MySQL server

$conn = new PDO('mysql: host='.$host.';dbname='.$db.';charset=utf8', $username, $password);

//Adding attributes to the connection

$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//getting id the data from the HTML
$id = $_POST['id'];

//Condition for the id value
if ($id == ''){
    
    $stm = $conn->prepare('INSERT INTO '.$table.' (first_name, last_name, address, city, zip_code, phone, email, created_date) VALUES (:first_name, :last_name, :address, :city, :zip_code, :phone, :email, :created_date)');
    
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $zip_code = $_POST['zip_code'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $created_date = $_POST['created_date'];
    
    $stm->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':address' => $address, ':city' => $city, ':zip_code' => $zip_code, ':phone' => $phone, ':email' => $email, ':created_date' => $created_date));
    
        $stmselect = $conn->prepare('SELECT * FROM '.$table.' WHERE id=(SELECT MAX(id) FROM '.$table.')');

        $stmselect->execute();

        $stmselect_results = array();

        $stmselect_results = $stmselect->fetchAll(PDO::FETCH_ASSOC);

        echo JSON_encode($stmselect_results);
    
}else{
    
    $stm = $conn->prepare('UPDATE '.$table.' SET first_name = :first_name, last_name = :last_name, address = :address, city = :city, zip_code = :zip_code, phone = :phone, email = :email, created_date = :created_date WHERE id='.$id); 

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $zip_code = $_POST['zip_code'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $created_date = $_POST['created_date'];
    
    $stm->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':address' => $address, ':city' => $city, ':zip_code' => $zip_code, ':phone' => $phone, ':email' =>$email, ':created_date' => $created_date));
    
        $stm_select_equipment = $conn->prepare('SELECT * FROM '.$table.' WHERE id='.$id);

        $stm_select_equipment->execute();

        $select_equipment_results = $stm_select_equipment->fetchAll(PDO::FETCH_ASSOC);

        echo JSON_encode($select_equipment_results);
    
}


//Closing connection with MySQL
$conn->close();

?>