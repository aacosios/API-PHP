<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once("../class/class-student.php");

$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method)
{
case 'GET':
if(isset($_GET['id'])){
    Student::getStudent($_GET['id']);
}
else {
    Student::getStudents();
}

break;
case 'POST':
    $_POST = json_decode(file_get_contents('php://input'), true);
    $student = new Student($_POST["id"], $_POST["name"],$_POST["lastname"],$_POST["phone"],$_POST["email"],);
    Student::saveStudent();    
break;

case 'DELETE':
// Delete Product
$_DELETE = json_decode(file_get_contents('php://input'), true);
if(isset($_DELETE['_id'])){
//if(isset($_DELETE['_id'])){
    Student::deleteStudent ($_DELETE['_id']);
}

else{
echo "Falta el id del cliente a eliminar";
}

case 'PUT':
    $_PUT = json_decode(file_get_contents('php://input'), true);
    IF (isset($_PUT['_id'])){
        Student::updateStudent ($_PUT['_id']);
    }
    else{
        echo "mal";
    }

break;
default:
// Invalid Request Method
header("HTTP/1.0 405 Method Not Allowed");
break;
}


?>