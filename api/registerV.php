<?php 
// connect the table
require "../config/db.php";

require "../config/backValidation.php";

    //responseData to make connection with front-end
    $responseData = [
        "code" => 0,
        "msg" => "",
        "data" => []
    ];

    $action = $_POST["action"] ?? "";
    
    if($action==="registration"){
        $message_error='';
        $password1='';
        $password2='';
        $email='';
        $username='';
        $role = $_POST['role'] ?? 'student';
    // for all the input value in form
    foreach(["username","email","password","re_password"] as $v){
            if(isEmpty($_POST[$v])){
                $message_error .= $v." can't be empty!";
                break;
            }
            if(!isEnough($_POST[$v])){
                $message_error .=$v . " should be at least 6 characters!";
                break;
            }

            if($v=="username"){
                $username=$_POST[$v];
            }

            if($v=="email"){
                $email=$_POST[$v];
            }

            if($v=="password"){
                $password1=$_POST[$v];
            }
            if($v=="re_password"){
                $password2=$_POST[$v];
            }
    }

    //check username only cotain letter and number with'-' '_'
    if(!preg_match('/^[a-zA-Z0-9]{3,50}$/', $username)){
        $message_error .= "username should only contain letters and number and '-' '_'";
    }

    // check if emial follow the format
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $message_error .= "Incorrect email format!";
    }

    // if password1 and password2 exist and they are equal
    if($password1!==$password2 && $password1 && $password2){
        $message_error .= "password should be the same!";
    }



    //if not pass the backend validation, send the error to front-end
    if (!empty($message_error)) {
        $responseData["code"] = 1;
        $responseData["msg"] = $message_error;
        // send json response
        print_r(json_encode($responseData, JSON_UNESCAPED_UNICODE));
        exit;
    }
    
    $valid_roles = ['student', 'teacher', 'parent', 'admin'];
    if (!in_array($role, $valid_roles)){
         $role = 'student';
        }

        // prepare statement
        $sql="SELECT * FROM user WHERE username = :username OR email = :email";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        //excute search
        $stmt->execute();
        $exist=$stmt->fetch(PDO::FETCH_ASSOC); 

            // if the username and email already exist
        if($exist){
            $responseData["code"] = 1;
            $responseData["msg"] = "The Username or Email is already existed";
            print_r(json_encode($responseData, JSON_UNESCAPED_UNICODE));
            exit;
        }

        // if not exist, inset to the table
        $sql ="INSERT INTO user(username,email,`password`,`role`) VALUES (:username,:email,:user_password,:user_role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username",$username,PDO::PARAM_STR);
        $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        $stmt->bindParam(":user_password",$password1,PDO::PARAM_STR);
        $stmt->bindParam(":user_role",$role,PDO::PARAM_STR);
        $registResult=$stmt->execute();
        if($registResult){
            $responseData["msg"] = "Registration successful!";
        }else {
            $responseData["code"] = 1;
            $responseData["msg"] = "Database error. Please try again.";
        }

        // call the front-end with json
        print_r(json_encode($responseData, JSON_UNESCAPED_UNICODE));
    }

    
?>