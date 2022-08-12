<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Methods: PUT");

// include database file
include_once $_SERVER['DOCUMENT_ROOT']."/academy/mongodb_config.php";
$dbname = 'academydb';
$collection = 'students';

//DB connection
$db = new DbManager();
$conn = $db->getConnection();

class Student{
    private $id;
    private $name;
    private $lastname;
    private $phone;
    private $email;

    public function __construct($id,$name,$lastname,$phone,$email){
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->email = $email;
    }

    public static function saveStudent(){
        require_once $_SERVER['DOCUMENT_ROOT']."/academy/db.php";

        $id = $_POST['id'] ; 
        $name = $_POST['name'] ; 
        $lastname = $_POST['lastname'] ; 
        $phone = $_POST['phone'] ;
        $email= $_POST['email'] ; 

        $obj = array (
            'id' => $id,
            'name' => $name,
            'lastname' => $lastname,
            'phone'=> $phone,
            'email'=> $email,

    );

  
    $insert = new MongoDB\Driver\BulkWrite();
    $insert->insert($obj);
    $result = $manager->executeBulkWrite('academydb.Student', $insert);

    if ($result->getInsertedCount() == 1) {
        echo 'registrado';
        
    } else {
        echo 'error';        
    }

    }

    public static function getStudents(){
        include_once $_SERVER['DOCUMENT_ROOT']."/academy/mongodb_config.php";
        $dbname = 'academydb';
        $collection = 'Student';
        $db = new DbManager();
        $conn = $db->getConnection();
        $filter = [];
        $option = [];
        $read = new MongoDB\Driver\Query($filter, $option);

        $records = $conn->executeQuery("$dbname.$collection", $read);

        echo json_encode(iterator_to_array($records));
    }
    public static function getStudent($id){
        include_once $_SERVER['DOCUMENT_ROOT']."/academy/mongodb_config.php";
        $dbname = 'academydb';
        $collection = 'students';
        $db = new DbManager();
        $conn = $db->getConnection();
        $filter = [];
        $option = [];
        $read = new MongoDB\Driver\Query($filter, $option);
        $student = json_decode("$dbname.$collection", true);
        echo json_encode($student[$id]);     
    }

    public function updateStudent(){
        include_once $_SERVER['DOCUMENT_ROOT']."/academy/mongodb_config.php";
        $dbname = 'academydb';
        $collection = 'Student';
        $db = new DbManager();
        $conn = $db->getConnection();
    }

    public static function deleteStudent(){
        include_once $_SERVER['DOCUMENT_ROOT']."/academy/mongodb_config.php";
        $dbname = 'academydb';
        $collection = 'students';
        $db = new DbManager();
        $conn = $db->getConnection();
        $data = json_encode(file_get_contents("_id", true));
        $id = $data->{'_id'};
        $delete = new MongoDB\Driver\BulkWrite();
        $delete->delete(
            ['_id' => new MongoDB\BSON\ObjectId($id)] ,
            ['limit' => 0]
        );
        $result = $conn->executeBulkWrite("$dbname.$collection", $delete);
    }
}


?>