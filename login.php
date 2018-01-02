<?php
    var_dump($_GET);

if(isset($_GET["username"])&&isset($_GET["password"])){
    $username=$_GET["username"];
    $password=$_GET["password"];
    if($username==11&&$password==1111){
        echo json_encode(array('status'=>110,'result'=>'ok'));


    }else{
        echo json_encode(array('status'=>'110','result'=>'error'));


    }


}
