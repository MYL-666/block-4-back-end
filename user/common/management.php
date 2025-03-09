<?php
    
    $response_table=[
        "code"=>0,
        "msg"=>"",
        "data"=>[]
    ];
    

    if($_SERVER["REQUEST_METHOD"]===$_POST){
        foreach ($form_item as $field) {
            $value = trim($_POST[$field] ?? ""); 
            if (empty($value)) {
                $response_table['code'] = 1;
                $response_table['msg'] = "$field can't be empty!";
                echo json_encode($response_table, JSON_UNESCAPED_UNICODE);
                exit;
            }
        }
    
        $response_table['msg'] = "Validation passed!";
        echo json_encode($response_table, JSON_UNESCAPED_UNICODE);
    }

?>