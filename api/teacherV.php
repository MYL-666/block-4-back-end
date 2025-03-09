<?php 
    require "../config/db.php";
    require "../config/backValidation.php";
    if (!isset($conn)) {
        echo json_encode(["code" => 1, "msg" => "Database connection failed!"]);
        exit;
    }

    $FirstName=$_POST["first_name"] ?? "";
    $LastName=$_POST["last_name"] ?? "";
    $phone=$_POST["phone"] ?? "";
    if (isset($_POST["bcc"]) && $_POST["bcc"] === "yes") {
        $bcc = 1;
    } 
    if(isset($_POST["bcc"]) && $_POST["bcc"] === "no") {
        $bcc = 0;
    }

    // check if there are empty input box
    if (empty($FirstName) || empty($LastName) || empty($phone)) {
        echo json_encode(["code" => 1, "msg" => "All fields are required!"]);
        exit;
    }
    // check the length of name
    if(nameLength($FirstName) && nameLength($LastName)){
        echo json_encode(["code" => 1, "msg" => "First Name or Last Name incorrect format!"]);
        exit;
    }
    // check if phone number follows uk number format
    if(!phoneValidation($phone)){
        echo json_encode(["code" => 1, "msg" => "Incorrect UK phone-number format!"]);
        exit;
    }
    // check if the teacher or phone number already exist
    $sql="SELECT teacher_id FROM teachers WHERE (First_Name=:first_name AND Last_Name=:last_name) OR phone=:phone";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":first_name",$FirstName);
    $stmt->bindParam(":last_name",$LastName);
    $stmt->bindParam(":phone",$phone);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($result["First_Name"]) && isset($result["Last_Name"])) {
        echo json_encode(["code" => 1, "msg" => "This teacher already exists!"]);
        exit;
    }
    if (isset($result["phone"])) {
        echo json_encode(["code" => 1, "msg" => "Phone number already exists! Please try another one!"]);
        exit;
    }

       // insert the class to the class table
       try {
        $sql = "INSERT INTO teachers (Last_name,First_Name,phone,backgroundCheck) VALUES (:last_name, :first_name, :phone, :bcc)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":last_name", $LastName);
        $stmt->bindParam(":first_name", $FirstName);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":bcc", $bcc,PDO::PARAM_INT);
    
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