<?php 
require_once '../../connection.php';

public function addstudent(){
    $sql = "INSERT INTO students (name, year, date, time) VALUES (:name, :year, :date, :time)";
    $stmt = $connection->prepare($sql);
}

public function getstudent(){

}

public function updatestudent(){

}

public function deletestudent(){

}
public function editstudent(){

}

?>