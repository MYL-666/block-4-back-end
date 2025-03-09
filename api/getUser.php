<?php
    session_start();

    $responseUser =[
        "code"=>0,
        "msg"=>'',
        "username"=>"",
        "role"=>""
    ];
    if(!isset($_SESSION["username"])){
        $responseUser["code"]=1;
        $responseUser["msg"]="You are not log in";
        print_r(json_encode($responseUser, JSON_UNESCAPED_UNICODE));
        exit;
    }
    $responseUser["username"]=$_SESSION["username"];
    $responseUser["role"]=$_SESSION["role"];
    print_r(json_encode($responseUser, JSON_UNESCAPED_UNICODE));

?>