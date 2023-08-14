<?php

session_start();
$user = $_SESSION['user'];
if (isset($_POST['block'])){
   $blockedUser = $_POST['text'];
  $users= json_decode(file_get_contents('userData.json') ,1);
   foreach ($users as $user => $data){
       if ($data['userName']== $blockedUser){
           $data['isBlocked'] =true;
           $users[$user]=$data;
       }
   }
   file_put_contents('userData.json',json_encode($users,JSON_PRETTY_PRINT));
}
if (isset($_POST['unblock'])){
    $blockedUser = $_POST['text'];
    $users= json_decode(file_get_contents('userData.json') ,1);
    foreach ($users as $user => $data){
        if ($data['userName']== $blockedUser){
            $data['isBlocked'] =false;
            $users[$user]=$data;
        }
    }
    file_put_contents('userData.json',json_encode($users,JSON_PRETTY_PRINT));
}