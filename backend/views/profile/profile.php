<?php

    require_once '../../../init.php';
    require_once '../layout/requireCheck.php';

    $adminId = $_SESSION['admin_id'];    
    $HAI = $main -> getUser();
    $AI = $HAI['id'];
    $birthday = explode('-' , $HAI['birthday']);
    
    if(isset($_POST["pro_info"])){
        
        $firstname = $main -> safePost('firstname');
        $lastname = $main -> safePost('lastname');
        $username =$main -> safePost('username');
        $email = $main -> safePost('email');
        $phone = $main -> safePost('phone');
        $gender = (int)$main -> safePost('gender') == '0' ? 'man' : 'woman'; 
        $validEmail = $main -> validEmail($email);
        $validphone = $main -> validphone($phone);

        if($firstname === '' || $lastname === '' || $username ==='' || $email === '' || $phone === '')
            $main -> redirect('?msg=empty-input');
        
        else if(strlen($firstname) > 15 || strlen($lastname) > 40 || strlen($username) > 15 || is_numeric($username) || is_numeric($firstname))
            $main -> redirect('?msg=invalid-input');

        else if(!$validEmail)
            $main -> redirect('?msg=invalid-email');

        else if(!$validphone)
            $main -> redirect('?msg=invalid-phone');

        else{

            $main -> updateProfile($adminId , $firstname , $lastname , $username , $validEmail , $validphone , $gender);
            $main -> redirect('?msg=profile-update');

        }

    }else if(isset($_POST['personal_info'])){

        $day = (int)$main -> safePost('day');
        $month = (int)$main -> safePost('month');
        $year = (int)$main -> safePost('year');
        $country = $main -> safePost('country');
        $city = $main -> safePost('city');
        $bio = $main -> safePost('bio');
        $DB_birthday_arr = array($year , $month , $day);
        $DB_birthday = implode('-' , $DB_birthday_arr);

        if($day === '' || $month === '' || $year === '' || $country === '' || $city === '' || $bio === '')
            $main -> redirect('?msg=empty-input');
        
        else{

            $UQ = "UPDATE `admins` SET birthday = '$DB_birthday' , country = '$country' , city = '$city' , bio = '$bio' WHERE id = '$AI'";
            $UR = $main -> query($UQ);
            $main -> redirect('?msg=profile-update');

        } 


    }else if(isset($_POST['change_pass'])){

        $current_pass = $main -> safePost('current_pass');
        $new_pass = $main -> safePost('new_pass');
        $re_new_pass = $main -> safePost('re_new_pass');

        $safe_current_pass = $main -> safePassword($current_pass);
        $safe_new_pass = $main -> safePassword($new_pass);
        $safe_re_new_pass = $main -> safePassword($re_new_pass);

        $SQ = "SELECT password FROM `admins` WHERE id = '$AI'";
        $RSQ = $main -> query($SQ);
        $FRSQ = $main -> getRow($RSQ);
      
        if($current_pass === '' || $new_pass === '' || $re_new_pass ==='')
            $main -> redirect('?msg=empty-input');

        else if(strlen($current_pass) < 8 ||strlen($new_pass) < 8 ||strlen($re_new_pass) < 8)
            $main -> redirect('?msg=short-pass');

        else if($new_pass !== $re_new_pass)
            $main -> redirect('?msg=dont-match');

        else{

            if($safe_current_pass == $FRSQ['password']){

                $UQ = "UPDATE `admins` SET password = '$safe_new_pass' WHERE id = '$AI'";
                $UR = $main -> query($UQ);
                if($UR > 0)
                    $main -> redirect('?msg=profile-update');
                    
                else 
                    $main -> redirect('?msg=profile-error');
    
            }else {
    
                $main -> redirect('?msg=incorect-pass');
    
            }

        }

    }else if(isset($_POST['chose_avatar'])){

        $allowType = array('jpg' , 'jpeg' , 'png' , 'gif');
        $avatarFileName = $main -> uploadFile('avatar' , '../../assets/media/avatars' , $allowType , $adminId);

        if($avatarFileName === 'upload_error')
            $main -> redirect('?msg=upload-error');

        else if($avatarFileName === 'type_denied')
            $main -> redirect('?msg=type-denied');

        else if($avatarFileName === 'update_error2')
            $main -> redirect('?msg=update-error-2');

        else if($avatarFileName === 'DB_error')
            $main -> redirect('?msg=DB-error');

        else
            $main -> redirect('?msg=profile-update');

    }else if(isset($_POST['del_avatar'])){

        $user_info = $HAI;
        $path = '../../assets/media/avatars/'.$user_info['avatar'];
        unlink($path);
        $RUQ = "UPDATE `admins` SET avatar = '' WHERE id = '$adminId'";
        $result = $main -> query($RUQ);

        if($result)
            $main -> redirect('?msg=avatar-deleted');
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
    <link rel="stylesheet" href="../../assets/css/layout/layout.css">
    <link rel="stylesheet" href="../../assets/css/profile/profile.css">
    <title>پروفایل</title>
</head>

<body>

    <?php require_once '../layout/layout.php'?>

    <section class="page_main_field">

        <div class="error_field warning_error <?php echo $main -> safeGet('msg') ?>">
            <i class="fal fa-exclamation-circle"></i>
            <p></p>
            <i class="fal fa-times close_error"></i>
        </div>

        <div class="field_of_content">
            <div class="left_field">
                <header class="header_field">
                    <h1>اطالاعات پروفایل</h1>
                    <h2>ویرایش مشحصات حساب کاربری</h2>
                    <hr>
                </header>
                <div class="input_content">
                    <form action="" method="post" autocomplete="off" class="profile_form show">
                        <div class="input_field">
                            <label for="firstname">نام</label>
                            <input type="text" name="firstname" id="firstname"
                                value="<?php echo $admin_info['firstname']?>">
                        </div>
                        <div class="input_field">
                            <label for="lastname">نام خانوادگی</label>
                            <input type="text" name="lastname" id="lastname"
                                value="<?php echo $admin_info['lastname']?>">
                        </div>
                        <div class="input_field">
                            <label for="username">نام کاربری</label>
                            <input type="text" name="username" id="username"
                                value="<?php echo $admin_info['username']?>">
                        </div>
                        <div class="input_field">
                            <label for="email">ایمیل</label>
                            <input type="text" name="email" id="email" value="<?php echo $admin_info['email']?>">
                        </div>
                        <div class="input_field">
                            <label for="phone">شماره تماس</label>
                            <input type="text" name="phone" id="phone" value="<?php echo $admin_info['phone']?>">
                        </div>
                        <div class="input_field checkbox">
                            <label for="gender">جنسیت</label>
                            <div class="check_main_field">
                                <div class="grid">
                                    <label class="checkbox path">
                                        <input id="man" name="gender" value="0" type="radio" class="Q_checkbox"
                                            <?php echo $admin_info['gender'] == 'man' ? 'checked' : ''?>>
                                        <svg viewBox="0 0 21 21">
                                            <path
                                                d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186">
                                            </path>
                                        </svg>
                                    </label>
                                    <label class="check_label" for="man">آقا</label>
                                </div>
                                <div class="grid">
                                    <label class="checkbox path">
                                        <input id="woman" name="gender" value="1" type="radio" class="Q_checkbox"
                                            <?php echo $admin_info['gender'] == 'woman' ? 'checked' : ''?>>
                                        <svg viewBox="0 0 21 21">
                                            <path
                                                d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186">
                                            </path>
                                        </svg>
                                    </label>
                                    <label class="check_label" for="woman">خانوم</label>
                                </div>
                            </div>
                        </div>
                        <button type="reset" class="btn red_btn">لغو</button>
                        <button type="submit" class="btn green_btn" name="pro_info">ثبت تغییرات</button>
                    </form>

                    <form action="" method="post" autocomplete="off" class="profile_form">
                        <div class="input_field">
                            <label for="phone">تاریخ تولد</label>
                            <div class="birthday">
                                <input type="number" max="31" min="1" id="day" name="day" placeholder="DD"
                                    value="<?php echo $birthday[2]?>">/
                                <input type="number" max="12" min="1" id="month" name="month" placeholder="MM"
                                    value="<?php echo $birthday[1]?>">/
                                <input type="number" id="year" name="year" placeholder="YY"
                                    value="<?php echo $birthday[0]?>">
                            </div>
                        </div>
                        <div class="input_field">
                            <label for="country">کشور</label>
                            <input type="text" name="country" id="country" value="<?php echo $admin_info['country']?>">
                        </div>
                        <div class="input_field">
                            <label for="city">شهر</label>
                            <input type="text" name="city" id="city" value="<?php echo $admin_info['city']?>">
                        </div>
                        <div class="input_field">
                            <label for="bio">درباره من</label>
                            <textarea type="text" name="bio" id="bio"><?php echo $admin_info['bio']?></textarea>
                        </div>
                        <button type="reset" class="btn red_btn">لغو</button>
                        <button type="submit" class="btn green_btn" name="personal_info">ثبت تغییرات</button>
                    </form>

                    <form action="" method="post" autocomplete="off" class="profile_form">
                        <div class="input_field">
                            <label for="current_pass">رمز عبور فعلی</label>
                            <input type="text" name="current_pass" id="current_pass">
                        </div>
                        <div class="input_field">
                            <label for="new_pass">رمز عبور جدید</label>
                            <input type="text" name="new_pass" id="new_pass">
                        </div>
                        <div class="input_field">
                            <label for="re_new_pass">تکرار رمز عبور</label>
                            <input type="text" name="re_new_pass" id="re_new_pass">
                        </div>

                        <button type="reset" class="btn red_btn">لغو</button>
                        <button type="submit" class="btn green_btn" name="change_pass">ثبت تغییرات</button>
                    </form>

                </div>
            </div>
            <div class="right_field">
                <div class="avatar_field">
                    <div class="name_access">
                        <h2><?php echo $admin_info['username']?></h2>
                        <p>ادمین اصلی</p>
                    </div>
                    <div class="field_of_img_template">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="box_of_img_template">
                                <div class="box_of_img_template img-box">
                                    <div class="img-show">
                                        <?php
                                            if($admin_info['avatar'] !== ''){
                                        ?>
                                        <div class="remove_parent">
                                            <img class="uploading_img_from_brows"
                                                src="../../assets/media/avatars/<?php echo $admin_info['avatar']?>">
                                        </div>
                                        <button type="submit" name="del_avatar"
                                            class="remove_img_icon remove del_avatar"></button>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <input type="file" name="avatar" id="avatar_img"
                                        accept="image/jpeg, image/png, image/jpg, image/gif"
                                        class="input-file-custom file_ajax">
                                    <label for="avatar_img" class="btn btn-tertiary2 js-labelFile">
                                        <i class="fas fa-upload"></i>
                                        <span class="js-fileName mr-2">تصویر پروفایل</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tabs_field">
                    <button class="active">
                        <i class="fas fa-user-tie"></i>
                        اطلاعات پروفایل
                    </button>
                    <button>
                        <i class="far fa-info-circle"></i>
                        اطلاعات شخصی
                    </button>
                    <button>
                        <i class="far fa-shield-alt"></i>
                        امنیت
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script src="../../assets/js/general/jQuery.js"></script>
    <script src="../../assets/js/general/bootstrap.js"></script>
    <script src="../../assets/js/layout/layout.js"></script>
    <script src="../../assets/js/profile/profile.js"></script>
    <script src="../../assets/js/custom/uploader.js"></script>
</body>

</html>