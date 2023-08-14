<?php
session_start();
$jsonArray = [];
if (is_file('userData.json')) {
    $jsonArray = json_decode(file_get_contents('userData.json'), true);
}

if (isset($_POST['submit'])) {
    $users = [
        'userName' => userNameValidation($_POST["username"]),
        'name' => nameValidation($_POST["name"]),
        'email' => emailValidation($_POST["email"]),
        'password' => passwordValidation($_POST["password"]),
        'profilePic' => './default/pic.txt',
        'bio' => './default/bio.txt',
        'userAdmin'=>false,
        'isBlocked'=>false
    ];

    $_SESSION['errorUserName'] = errorUserName($users['userName']);
    $_SESSION['errorName'] = errorName($users['name']);
    $_SESSION['errorEmail'] = errorEmail($users['email']);
    $_SESSION['errorPassword'] = errorPassword($users['password']);
    if ($_SESSION['errorUserName']=='' && $_SESSION['errorName']=='' && $_SESSION['errorEmail']=='' && $_SESSION['errorPassword']=='') {

    $jsonArray[] = $users;
        file_put_contents('userData.json', json_encode($jsonArray, JSON_PRETTY_PRINT));
        header('Location:signIn.php');


    }
}
if (isset($_POST['signIn'])) {
    if ($_POST['username-log'] != "" && $_POST['password-log'] != "") {
        if (signIn($_POST['username-log'], $_POST['password-log'])) {
$users= json_decode(file_get_contents('userData.json'),1);
foreach ($users as $user => $data) {
    if ($data['userName'] == $_POST['username-log'])
        $_SESSION['user'] =$data;
}
            header('Location:homePage.php');
            die();
        }
    }

        header('Location:signUp.php');
}
   // $users['userName'] = $_POST['username-log'];
   // $users['password'] = $_POST['password-log'];



$errors = [
    'userName' => '',
    'name' => '',
    'email' => '',
    'password' => ''
];

function userNameValidation($userName)
{
    global $jsonArray, $errors;
    $userName_is_unique = true;
    foreach ($jsonArray as $userData) {
        if ($userData['userName'] == $userName) {
            $userName_is_unique = false;
        }
    }
    if ($userName == '') {
        return $errors['userName'] = 'please enter your username';
    }
    if (!$userName_is_unique) {
        return $errors['userName'] = 'your username is not unique';
    }
    if ($userName_is_unique && preg_match("/[a-zA-Z0-9]{3,32}/", $userName)) {
        return $userName;
    } else {
        return $errors['userName'] = 'your username not valid';
    }
}


function nameValidation($name)
{
    global $errors;
    if ($name == '') {
        return $errors['name'] = 'please enter your name';
    }
    if (preg_match("/[a-z\s]{3,32}/", $name)) {
        return $name;
    } else {
        return $errors['name'] = 'your name is not valid';
    }
}

function emailValidation($email)
{
    global $jsonArray, $errors;
    $email_is_unique = true;
    foreach ($jsonArray as $userData) {
        if ($userData['email'] == $email) {
            $email_is_unique = false;
        }
    }
    if ($email == '') {
        return $errors['email'] = 'please enter your email';
    }
    if (!$email_is_unique) {
        return $errors['email'] = 'your email is not unique';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $errors['email'] = 'write correct format';
    }
    if ($email_is_unique && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        return $errors['email'] = 'your email is not valid';
    }
}

function passwordValidation($password)
{
    global $errors;
    if ($password == '') {
        return $errors['password'] = 'please enter your password';
    }
    if (preg_match('/[a-zA-Z0-9]{4,32}/', $password)) {
        return $password;
    } else {
        return $errors['password'] = 'your password is not valid';
    }
}

function errorUserName($users)
{
    global $users;
    if ($users['userName'] == 'please enter your username') {
        return 'please enter your username';
    }
    if ($users['userName'] == 'your username is not unique') {
        return 'your username is not unique';
    }
    if ($users['userName'] == 'your username not valid') {
        return 'your username not valid';
    }
    return '';
}

function errorName($users)
{
    global $users;
    if ($users['name'] == 'please enter your name') {
        return 'please enter your name';
    }
    if ($users['name'] == 'your name is not valid') {
        return 'your name not valid';
    }
    return '';
}

function errorEmail($users)
{
    global $users;
    if ($users['email'] == 'please enter your email') {
        return 'please enter your email';
    }
    if ($users['email'] == 'your email is not unique') {
        return 'your email is not unique';
    }
    if ($users['email'] == 'write correct format') {
        return 'write correct format';
    }
    return '';
}

function errorPassword($users)
{
    global $users;
    if ($users['password'] == 'please enter your password') {
        return 'please enter your password';
    }
    if ($users['password'] == 'your password is not valid') {
        return 'your password not valid';
    }
    return '';
}

function SignIn($userName, $password): bool
{
    global $jsonArray;
    foreach ($jsonArray as $user) {
        if ($user['userName'] == $userName && $user['password'] == $password) {

            return true;
        }

    }
    return false;
}

