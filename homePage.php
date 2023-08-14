<?php
//session_start();
include_once 'chat.php';

$userName = $_SESSION['user']['userName'];
$users = json_decode(file_get_contents('userData.json'), 1);

//$_SESSION['img']=@$_FILES['file'];
//if (isset($_POST['btnFile']))
//    var_dump($_FILES['file']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://code.jquery.com/jquery-3.7.0.min.js">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="./src/script.js"></script>
</head>

<body>
<section style="background-color: #eee;">
    <div class="container py-5">

        <div class="row">

            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                <div class="d-flex flex-row gap-3 justify-content-around">
                    <a href="profile.php">
                        <iconify-icon icon="iconamoon:profile-fill" width="30"></iconify-icon>
                    </a>
                    <h5 class="font-weight-bold mb-3 text-center text-lg-start text-info"> welcome <?= $userName ?></h5>

                </div>

                <div class="card">
                    <div class="card-body">

                        <ul class="list-unstyled mb-0">
                            <?php
                            foreach ($users as $user => $data) {
                                if ($userName == $data['userName']) {
                                        $bio = file_get_contents($data['bio']);
                                    $profilePic = @$data['profilePic'];


                                    ?>

                                    <li class="p-2 border-bottom" style="background-color: #eee;">
                                        <a href="#!" class="d-flex justify-content-between">
                                            <div class="d-flex flex-row">
                                                <img src="<?= $profilePic ?>" alt="avatar"
                                                     class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                     width="65" height="60">
                                                <div class="pt-1">
                                                    <p class="fw-bold mb-0"><?= $userName ?></p>
                                                    <p class="small text-muted"><?= $bio ?></p>
                                                </div>
                                            </div>
                                            <div class="pt-1">
                                                <p class="small text-muted mb-1">Just now</p>
                                                <span class="badge bg-danger float-end">1</span>
                                            </div>
                                        </a>
                                    </li>
                                <?php }
                            } ?>



                            <?php foreach ($users as $user => $data) {
                                $userNameSome = $data['userName'];
                                if ($userName == $data['userName'])
                                    continue;

                                $bioSome = file_get_contents($data['bio']);
                                //var_dump($bioAnother);die();
                                $profilePicSome = @$data['profilePic']; ?>
                                <li class="p-2 border-bottom">
                                    <a href="#!" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="<?= $profilePicSome ?>"
                                                 alt="avatar"
                                                 class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                 width="65" height="60">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0"><?= $userNameSome ?></p>

                                                <p class="small text-muted"><?= $bioSome ?></p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1">5 mins ago</p>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>
                </div>

            </div>

            <div class="col-md-6 col-lg-7 col-xl-8">

                <ul class="list-unstyled">
                    <?php
                    $jsonChat = json_decode(file_get_contents('chat.json'), 1);
                    foreach ($jsonChat as $key => $value) {
                        //var_dump($value);
                        $date = $value['date'];
                        $message = $value['message'];
                        $id = $value['id'];
                        if ($_SESSION['user']['userAdmin']){
                            $message=$message."<form action='delete.php' method='post'><button name='delete' type='submit' value='$id'>delete</button></form>";
                        }
                        $user = $value['userName'];
                        $profile = $value['img']
                        ?>


                        <li class="d-flex justify-content-between mb-4 ">
                            <img src="<?= $profile ?>" alt="avatar"
                                 class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="65"
                                 height="60">
                            <div class="card" style="width: 50rem">
                                <div class="card-header d-flex justify-content-between p-3">
                                    <p class="fw-bold mb-0"><?= $user ?></p>
                                    <p class="text-muted small mb-0"><i class="far fa-clock"></i> <?= @$date ?></p>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">
                                        <?= $message
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <li class="bg-white mb-3" style="width: 41rem;margin-left: 5rem">
                            <div class="form-outline">
                                <textarea class="form-control" id="description" rows="2" name="message"></textarea>
                                <label class="form-label" for="textAreaExample2">Message</label>
                                <span class="text-sm text-green-600" id="textCount">characters</span>
                            </div>

                            <?php
                            if (isset($_POST['btnFile']) && $_FILES['file']['size']>2*1024*1024){
                                ?>
                                <div class="errImg text-danger">

                                    <?php echo $_SESSION['errImg']?>

                                </div>
                            <?php } ?>
                            <?php
                            if (isset($_POST['send']) && strlen($_POST['message'])>100 ){
                                ?>
                                <div class="errTxt text-danger">

                                    <?php echo $_SESSION['errTxt']?>

                                </div>
                            <?php } ?>
                        </li>
                        <div class="d-flex flex-row justify-content-end gap-2  " style="width: 41rem;margin-left: 5rem">

                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" name="btnFile" type="submit"
                                        id="inputGroupFileAddon03">Button
                                </button>
                                <input type="file" class="form-control" name="file" id="inputGroupFile03"
                                       aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                            </div>


                            <button type="submit" class="btn btn-outline-secondary btn-rounded  float-end"
                                    style="height: 2.5rem" name="send">Send
                            </button>
                        </div>

                    </form>

                </ul>

            </div>

        </div>

    </div>
    <?php
    if ($_SESSION['user']['userAdmin']){

    ?>
    <form action="action.php" method="post">
        <input type="text" name="text" placeholder="username">
        <button class="btn btn-secondary" name="block">block</button>
        <button  class="btn btn-secondary" name="unblock">unblock</button>

        <?php } ?>
</section>


</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>

</html>