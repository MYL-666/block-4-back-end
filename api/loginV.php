<?php 
    //call session to store the username and id 
    session_start();
    require "../config/db.php";
    function isEmpty($str){
        return $str===Null || empty($str);
    }

    $action_login= $_POST["action"] ?? "";
    if($action_login==="login"){
    $message_error_login="";
    $login_email="";
    $login_password="";


    foreach(["login_email","login_password"] as $v){
        if(isEmpty($_POST[$v])){
            $message_error_login .= $v." can't be empty!";
        }

        if($v==='login_email'){
            $login_email=$_POST[$v];
        }

        if($v=="login_password"){
            $login_password=$_POST[$v];
        }
    }
        // prepare the statement
        $sql="SELECT id,username,`password`,`role` FROM user where email = :email ";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(":email",$login_email,PDO::PARAM_STR);
        $stmt->execute();
        $exist_user=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!$exist_user){
            $responseData["code"]=1;
            $responseData["msg"]="The user doesn't exist!";
            print_r(json_encode($responseData,JSON_UNESCAPED_UNICODE));
            exit;
        }
        
      
        if ($exist_user["role"] === "admin") {
            // for adminusers only, their password was hashed
            if (!password_verify($login_password, $exist_user["password"])) {
                $responseData["code"] = 1;
                $responseData["msg"] = "The password is incorrect!";
                print_r(json_encode($responseData, JSON_UNESCAPED_UNICODE));
                exit;
            }
        } else {
            // for other userslike student, parents and teachers they are normal password
            if ($login_password !== $exist_user["password"]) {
                $responseData["code"] = 1;
                $responseData["msg"] = "The password is incorrect!";
                print_r(json_encode($responseData, JSON_UNESCAPED_UNICODE));
                exit;
            }
        }
        // sotore into session about username and role
        $_SESSION["username"] = $exist_user["username"];
        $_SESSION["role"] = $exist_user["role"];
        $_SESSION["id"]=$exist_user["id"];
        $responseData["code"] = 0;
        $responseData["msg"] = "Login successful!";    

    print_r(json_encode($responseData,JSON_UNESCAPED_UNICODE));
}
?>