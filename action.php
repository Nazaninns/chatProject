<?php
include_once 'Connection.php';
session_start();
$connection=Connection::getInstance()->getPdo();
$user = $_SESSION['user'];
if (isset($_POST['block'])){
   $blockedUser = $_POST['text'];
  //$users= json_decode(file_get_contents('userData.json') ,1);
  $stmt=$connection->prepare('select * from users');
  $users=$stmt->fetchAll();
   foreach ($users as $user => $data){
       if ($data['userName']== $blockedUser){
           $data['isBlocked'] =true;
           $users[$user]=$data;
       }
   }
   //file_put_contents('userData.json',json_encode($users,JSON_PRETTY_PRINT));
   $stmt=$connection->prepare("update users set isBlocked=1 where users.userName=:userName");
   $stmt->execute(['userName'=>$blockedUser]);
}
if (isset($_POST['unblock'])){
    $blockedUser = $_POST['text'];
    //$users= json_decode(file_get_contents('userData.json') ,1);
    $stmt=$connection->prepare('select * from users');
    $stmt->execute();
    $users=$stmt->fetchAll();
    foreach ($users as $user => $data){
        if ($data['userName']== $blockedUser){
            $data['isBlocked'] =false;
            $users[$user]=$data;
        }
    }
    //file_put_contents('userData.json',json_encode($users,JSON_PRETTY_PRINT));
    $stmt=$connection->prepare('update users set isBlocked=0 where users.userName=:userName');
    $stmt->execute(['userName'=>$blockedUser]);
}