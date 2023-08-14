<?php
session_start();
$userName = $_SESSION['user'][0];
//var_dump($userName);
$users = json_decode(file_get_contents('userData.json'),1);
foreach ($users as $user => $data ){
    if ($userName == $data['userName']){
        $bio = file_get_contents($data['bio']);
        $profilePic = file_get_contents($data['profilePic']);

    }
}


foreach ($users as $user => $data) {
    if ($userName == $data['userName'])
        continue;
    $bio = file_get_contents($data['bio']);
    //var_dump($bioAnother);die();
    $profilePic = @$data['profilePic'];
var_dump($profilePic);die();
?>








<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex flex-col items-center justify-center w-screen min-h-screen bg-gray-100 text-gray-800 p-10">

<div class="flex  flex-col  border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col items-center pb-10">
        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" style="width: 150px" src="<?php echo $profilePic ?>"
             alt="Bonnie image"/>
        <h5 class="mb-1 text-xl font-medium  text-gray-900 dark:text-white"><?php echo $userName ?></h5>
        <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo $bio ?></span>
        <div class="flex mt-4 space-x-3 md:mt-6">
            <a href="#"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                friend</a>
            <a href="#"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Message</a>
        </div>
    </div>
</div>
<?php } ?>
<div class="p-4">
    <p class="text-blue-500">Welcome, <b><?php echo $userName ?></b></p>
    <div class="my-5">
</div>
<form class="mt-4" action="chat.php" method="post" enctype="multipart/form-data">
    <input type="text" name="message">
    <input type="file" name="image"><br>
    <input type="submit" name="send" value="send">

</form>
</div>
<div class="flex flex-col justify-items-start p-4">
    <div class="flex  flex-col  border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col items-center pb-10">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg" style="width: 150px"
                 src="<?php echo $profilePic ?>"
                 alt="Bonnie image"/>
            <h5 class="mb-1 text-xl font-medium  text-gray-900 dark:text-white"><?php echo $userName ?></h5>
            <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo $bio ?></span>
            <div class="flex mt-4 space-x-3 md:mt-6">
                <a href="#"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                    friend</a>
                <a href="profile.php"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">profile</a>
            </div>
        </div>
    </div>

    <a href="profile.php" name="profile">profile</a>
</div>

</body>
</html>

