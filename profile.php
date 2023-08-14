<?php
session_start();
//login user
$username = $_SESSION['user']['userName'];
//var_dump($username);
//echo $username;


//make dir username,bio,pictures
if (!is_dir('./users/' . $username)) mkdir('./users/' . $username);
if (!is_dir('./users/' . $username . '/pictures')) mkdir('./users/' . $username . '/pictures');
if (!is_dir('./users/' . $username . '/bio')) mkdir('./users/' . $username . '/bio');
//delete pic
if (isset($_POST['delete'])) {
    // if (is_dir($_POST['delete'])) {
    unlink($_POST['delete']);
    // }
}
//set profile pic
if (isset($_POST['setProfile'])) {
    $profileUser = json_decode(file_get_contents('userData.json'), 1);
    foreach ($profileUser as $user => $data) {
        if ($data['userName'] == $username) {
            $data['profilePic'] = $_POST['setProfile'];
            $profileUser[$user] = $data;
        }
        file_put_contents('userData.json', json_encode($profileUser, JSON_PRETTY_PRINT));

        header('Location:homePage.php');
    }

}
//$new = json_decode(file_get_contents('chat.json'),1);
//foreach ($new as $users => $item){
//    $item['img'] = $_POST['setProfile'];
//    $new['users'] = $item;
//}
//
//file_put_contents('chat.json',json_encode($new,JSON_PRETTY_PRINT));


// action for set submit
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    move_uploaded_file($file['tmp_name'], './users/' . $username . '/pictures/' . $fileName);

    file_put_contents('./users/' . $username . '/bio/bio.txt', $_POST['bio']);

    $userData = json_decode(file_get_contents('userData.json'), 1);
////    echo '<pre>';
////     var_dump($userData[2]);
////    echo '</pre>';
////     die();
    foreach ($userData as $user => $data) {
        if ($data['userName'] == $username) {
            $userData[$user] = $data;
            $data['bio'] = './users/' . $username . '/bio/bio.txt';
            $userData[$user]=$data;

////            echo '<pre>';
////            var_dump($data);
////            echo '</pre>';
////            die();
        }
    }
    file_put_contents('userData.json', json_encode($userData, JSON_PRETTY_PRINT));

}
//put pics to variable
$pics = scandir('./users/' . $username . '/pictures');
$pics = array_slice($pics, 2);
if (isset($_POST['home'])){
    header('Location:homePage.php');

}
if (isset($_POST['logOut'])){
    header('Location:signUp.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

</head>
<body>
<form action="" method="post">
<div class="d-flex flex-row justify-content-between">
<button class="btn btn-warning m-3 " type="submit" name="home" >Home</button>
<button class="btn btn-warning m-3 " type="submit" name="logOut" >logout</button>
</div>
</form>
<form action="" enctype="multipart/form-data" method="post">
    <input type="text" name="bio" placeholder="bio">
    <input type="file" name="file">
    <input type="submit" name="submit">
</form>
<form method="post">
    <?php
    if (count($pics)) {
    foreach ($pics as $pic) {
    $picDir = './users/' . $username . '/pictures/' . $pic;
    // var_dump($pics);die();
    ?>

    <img style="width:150px; height: 150px; border-radius: 205px" src="<?= $picDir ?> ">
    <form action="" method="post">
        <button type="submit" name="delete" value="<?= $picDir ?>">Delete</button>
        <button type="submit" name="setProfile" value="<?php echo $picDir ?>">Set this as profile picture</button>
        <?php }
        } ?>
    </form>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>

