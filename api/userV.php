<?php 
session_start();
header('Content-Type: application/json');
require "../config/backValidation.php";
require "../config/db.php";
$title= "User";
$page_name="user";
$userLastName = "";
$userFirstName = "";
$userEmail = "";
$userGender = "";
$userBirth = "";
$userId='';
// require "../config/db.php";
$sql="SELECT *  from user where username=:username";
$stmt=$conn->prepare($sql);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$resultUser=$stmt->fetch(PDO::FETCH_ASSOC);
if($resultUser){
   $userId=$resultUser['id'] ?? "";
   $userLastName=$resultUser["Last_Name"] ?? "";
   $userFirstName=$resultUser["First_Name"] ?? "";
   $userEmail=$resultUser["email"] ?? "";
   $userGender=$resultUser["Gender"] ?? "";
   $userBirth = date('Y-m-d', strtotime($resultUser["birthday"]));
}

    $newuserName=$_POST['username'] ?? "";
    $newuserFirstName=$_POST['firstName'] ?? "";
    $newuserLastName=$_POST['lastName'] ?? "";
    $newuserEmail=$_POST['email'] ?? "";
    $newuserGender=$_POST['gender'] ?? "";
    $newuserBirth=$_POST['birth'] ?? "";
    $error='';

    if(isEmpty($newuserName) || isEmpty($newuserFirstName) || isEmpty($newuserLastName) || isEmpty($newuserEmail) || isEmpty($newuserGender) || isEmpty($newuserBirth)){
        echo json_encode(["code"=>1,"msg"=>"All fildes required!"]);
        exit;
    }
    if(nameLength($newuserFirstName) || nameLength($newuserLastName)){
        echo json_encode(["code"=>1,"msg"=>"Incorrect Name format!"]);
        exit;
    }
    if(!emailValidation($newuserEmail)){
        echo json_encode(["code"=>1,"msg"=>"Incorrect Email format!"]);
        exit;
    }

    if($newuserName!==$_SESSION["username"]){
        $stmt=$conn->prepare("SELECT count(*) from user where username=:username AND id!=:id");
        $stmt->execute([
            ":username"=>$newuserName,
            ":id"=>$userId
        ]);
        if($stmt->fetchColumn()>0){
            $error .= "This username is already be taken!";
        }
    }

    if($newuserEmail!==$userEmail){
        $stmt=$conn->prepare("SELECT count(*) from user where email=:email AND id!=:id");
        $stmt->execute([
            ":email"=>$newuserEmail,
            ":id"=>$userId
        ]);
        if($stmt->fetchColumn()>0){
            $error .= "This email is already be taken!";
        }
    }

    if (!empty($errors)) {
        echo json_encode(['code' => 1, 'msg' => $errors]);
        exit;
    }

    $updateForm=$conn->prepare("UPDATE user SET username=:username,last_name=:last_name,first_name=:first_name,email=:email,Gender=:gender,birthday=:birth WHERE id=:id");
    $updateForm->execute([
        ":username"=>$newuserName,
        ":last_name"=>$newuserLastName,
        ":first_name"=>$newuserFirstName,
        ":email"=>$newuserEmail,
        ":gender"=>$newuserGender,
        ":birth"=>$newuserBirth,
        ":id"=>$userId
    ]);

    echo json_encode(['code' => 0, 'msg' => "User Inform update successfully"]);
    exit;
?>          