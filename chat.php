<?php
session_start();
//require_once 'homePage.php';
date_default_timezone_set('asia/tehran');
$userName = $_SESSION['user']['userName'];
$userdata = $_SESSION['user'];
$jsonArray = [];
$err=[
    'imgErr' => 'too large',
    'txtErr' => 'between 0 & 100',
    'blockedErr'=>'you are block'
];
if (is_file('chat.json')) {
    $jsonArray = json_decode(file_get_contents('chat.json'), 1);
}
if (isset($_POST['send'])) {
    if ($userdata['isBlocked']){
        $_SESSION['blckErr']=$err['blockedErr'];
    }
    else{
    if (!empty($_POST['message'])) {
        if (strlen($_POST['message'])>100){
           $_SESSION['errTxt']= $err['txtErr'] ;
        }
        else{
        $message = stripslashes(htmlspecialchars($_POST['message']));
        $dateMessage = date('h:i:s');
        $id = 1;
        if (isset($jsonArray)) {
            $id = count($jsonArray) + 1;
        }
        $chatProperty = [
            'message' => $message,
            'id' => $id,
            'userName' => $userName,
            'date' => $dateMessage,
            'img' => $userdata['profilePic']
        ];


        $jsonArray[] = $chatProperty;
        file_put_contents('chat.json', json_encode($jsonArray, JSON_PRETTY_PRINT));
        //header('Location:homePage.php');
//fwrite(fopen('./users/'.$userName.'/chat.txt','a+'),"\n".$dateMessage.':'.$message);
//fclose(fopen('chat.txt','a+'));
    }}}
}

if (isset($_POST['btnFile'])) {
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        if ($fileSize > 2 * 1024 * 1024) {

           $_SESSION['errImg'] = $err['imgErr'];
           //var_dump($_SESSION['errImg']);die();

        } elseif ($fileSize > 0) {
            @mkdir('./users/' . $userName . '/uploadImg');
            move_uploaded_file($file['tmp_name'], './users/' . $userName . '/uploadImg/' . $fileName);
            $dateMessage = date('h:i:s');
            $id = 1;
            $picDir = './users/' . $userName . '/uploadImg/' . $fileName;
            $data = "<img style='width: 150px; border-radius:105px;height: 150px' src='$picDir' >";

            if (isset($jsonArray)) {
                $id = count($jsonArray) + 1;
            }
            $chatProperty = [
                'message' => $data,
                'id' => $id,
                'userName' => $userName,
                'date' => $dateMessage,
                'img' => $userdata['profilePic']
            ];


            $jsonArray[] = $chatProperty;
            file_put_contents('chat.json', json_encode($jsonArray, JSON_PRETTY_PRINT));
            //header('Location:homePage.php');

            // var_dump($pics);die();

        }
    }
    //header('Location:homePage.php');
}

//var_dump($img);die();



