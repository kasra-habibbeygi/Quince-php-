<?php

    require_once '../../../init.php';
    
    if($main -> checkLogin())
        $main -> redirect('../dashboard/dashboard.php');

    if(isset($_POST['login'])){

        $email = $main -> safePost('email');
        $password = $main -> safePost('password');
        $checkEmail = $main -> validEmail($email);
        $safePass = $main -> safePassword($password);

        if($email === '' || $password === ''){

            $main -> redirect('?msg=empty-input');
            
        }else if(!$checkEmail || strlen($password) < 8 || !$checkEmail){
            
            $main -> redirect('?msg=wrong-input');

        }

        $checkLog = $main -> login($email , $safePass);
        if($checkLog){

            $main -> redirect('../dashboard/dashboard.php');

        }else{

            $main -> redirect('?msg=user-notfound');

        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/general/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/general/fontAwsome.css">
    <link rel="stylesheet" href="../../assets/css/general/general.css">
    <link rel="stylesheet" href="../../assets/css/login_recovery/login.css">
    <title>Quince Login</title>
</head>

<body>

    <div class="main_field">

        <div class="error_field warning_error <?php echo $main -> safeGet('msg') ?>">
            <i class="fal fa-exclamation-circle"></i>
            <p></p>
            <i class="fal fa-times close_error"></i>
        </div>

        <div class="content">
            <img class="logo" src="../../assets/img/logo2.png" alt="">
            <form action="" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="email" placeholder="ایمیل" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="رمز عبور" name="password">
                </div>
                <div class="captcha">
                    <div class="CI">
                        <img src="../../assets/img/captcha.svg" alt="">
                    </div>
                    <button type="button" class="btn">
                        <i class="far fa-redo"></i>
                    </button>
                    <div class="form-group">
                        <input type="text" class="form-control" id="captcha" placeholder="کد امنیتی" name="captcha">
                    </div>
                </div>
                <button type="submit" class="btn log_btn" name="login">ورود به حساب کاربری</button>
                <a href="" class="forget_pass">رمز خود را فراموش کرده اید ؟</a>
            </form>
        </div>
    </div>

    <script src="../../assets/js/general/jQuery.js"></script>
    <script src="../../assets/js/login_recovery/login.js"></script>

</body>

</html>