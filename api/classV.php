<?php


require "../config/db.php";
require "../config/backValidation.php";

if (!isset($conn)) {
    echo json_encode(["code" => 1, "msg" => "Database connection failed!"]);
    exit;
}
// for admin user who can manage the system
// get the value from form
    $teacherName = $_POST["teacher_name"] ?? "";
    $className =$_POST["class_name"] ?? "";
    $capacity = $_POST["capacity"]?? "";
    $grade = $_POST["grade"] ?? "";
    // check all inputs are not empty
    if (empty($teacherName) || empty($className) || empty($capacity) || empty($grade) || $grade==="none") {
        echo json_encode(["code" => 1, "msg" => "All fields are required!"]);
        exit;
    }
    // check if teacher's name input both first and last name
    $nameParts = explode(" ", $teacherName);
    if(count($nameParts) <2){
        echo json_encode(["code" => 1, "msg" => "Please input both First and Last name of the teacher"]);
        exit;
    }
    // check the capacity
    if($capacity<20 || $capacity>50){
        echo json_encode(["code"=>1,"msg"=>"The capacity of class should bewteen 20 and 50"]);
        exit;
    }

    $teacherFirst=trim($nameParts[0]);
    // for multiple last anme
    $teacherLast=trim(implode(" ",array_slice($nameParts,1)));

    // search if teacher exist
    $sql="SELECT teacher_id from teachers where First_name=:first_name AND Last_name=:last_name";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":first_name",$teacherFirst);
    $stmt->bindParam(":last_name",$teacherLast);
    $stmt->execute();
    $teacherExist=$stmt->fetch(PDO::FETCH_ASSOC);

    if(!$teacherExist){
        echo json_encode(["code" => 1, "msg" => "This teacher doesn't exist!"]);
    exit;
    }

    // check if this teacher already has class
    $sql = "SELECT teacher_id, class_name FROM classes WHERE teacher_id = :teacher_id OR class_name = :class_name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":teacher_id", $teacherExist["teacher_id"]);
    $stmt->bindParam(":class_name", $className);
    $stmt->execute();
    $existingClass = $stmt->fetch(PDO::FETCH_ASSOC);    

    if ($existingClass) {
        // 检查该老师是否已经被分配到某个班级
        if (isset($existingClass["teacher_id"]) && $existingClass["teacher_id"] == $teacherExist["teacher_id"]) {
            echo json_encode(["code" => 1, "msg" => "This teacher is already assigned to class: " . $existingClass["class_name"]]);
            exit;
        }
    
        // 检查班级名是否已存在
        if (isset($existingClass["class_name"]) && $existingClass["class_name"] == $className) {
            echo json_encode(["code" => 1, "msg" => "This class Name is already taken!"]);
            exit;
        }
    }

    // insert the class to the class table
    try {
        $sql = "INSERT INTO Classes (class_name, capacity, teacher_id, Grade) VALUES (:class_name, :capacity, :teacher_id, :Grade)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":class_name", $className);
        $stmt->bindParam(":capacity", $capacity);
        $stmt->bindParam(":teacher_id", $teacherExist["teacher_id"]);
        $stmt->bindParam(":Grade", $grade);
    
        if ($stmt->execute()) {
            echo json_encode(["code" => 0, "msg" => "Insert Success!"]);
        } else {
            echo json_encode(["code" => 1, "msg" => "Insert Failed!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["code" => 1, "msg" => "Database error: " . $e->getMessage()]);
    }
    exit;

?>