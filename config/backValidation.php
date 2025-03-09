<?php 

function isEmpty($str){
    return $str===Null || empty($str);
}

// if the length more than 6 character
function isEnough($str){
    return strlen($str) >=6 && strlen($str)<=30;
}

function nameLength($str){
    return strlen($str) <1 && strlen($str)>50;
}

function phoneValidation($str){
    if(!preg_match('/^(\+44\s?7\d{9}|07\d{9})$/',$str)){
        return false;
    }
    return true;
}
function emailValidation($str){
    if(!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$str)){
        return false;
    }
    return true;
}
?>