<?php
include_once 'Connection.php';
session_start();
$connection=Connection::getInstance()->getPdo();
if (isset($_POST['delete'])){
    $number = $_POST['delete'];
    //$userChat = json_decode(file_get_contents('./storage/chat.json'), true);
    $stmt=$connection->prepare('select * from chat');
    $stmt->execute();
    $userChat=$stmt->fetchAll();
    // foreach ($userChat as $user => $data) {
    //     if ($user + 1 == $number) {
    //         $chat['message'] = '';
    //         $chat['deletedByAdmin'] = $_SESSION['user']['userName'];
    //         $chat['deletedTime'] = date("y/m/d h:i:s");
    //         $chats[$user] = $chat;

    //     }}
    //file_put_contents('chat.json', json_encode($userChat, JSON_PRETTY_PRINT));
    $stmt=$connection->prepare('delete from chat where chat.id=:id');
    $stmt->execute(['id'=>$number]);
    header('Location:homePage.php');
}
