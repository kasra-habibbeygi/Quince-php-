<?php

    require_once '../../../init.php';
    require_once '../layout/requireCheck.php';

    
    
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
    <title>Quince Login</title>
</head>

<body>

    <?php require_once '../layout/layout.php'?>

    <section class="page_main_field">
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
                            <label for="name">نام</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="input_field">
                            <label for="lastname">نام خانوادگی</label>
                            <input type="text" name="lastname" id="lastname">
                        </div>
                        <div class="input_field">
                            <label for="username">نام کاربری</label>
                            <input type="text" name="username" id="username">
                        </div>
                        <div class="input_field">
                            <label for="email">ایمیل</label>
                            <input type="text" name="email" id="email">
                        </div>
                        <div class="input_field">
                            <label for="phone">شماره تماس</label>
                            <input type="text" name="phone" id="phone">
                        </div>
                        <div class="input_field checkbox">
                            <label for="gender">جنسیت</label>
                            <div class="check_main_field">
                                <div class="grid">
                                    <label class="checkbox path">
                                        <input id="man" name="gender" type="radio" class="Q_checkbox">
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
                                        <input id="woman" name="gender" type="radio" class="Q_checkbox">
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
                                <input type="number" max="31" min="1" id="day" name="day" placeholder="DD">/
                                <input type="number" max="12" min="1" id="month" name="month" placeholder="MM">/
                                <input type="number" id="year" name="year" placeholder="YY">
                            </div>
                        </div>
                        <div class="input_field">
                            <label for="country">کشور</label>
                            <input type="text" name="country" id="country">
                        </div>
                        <div class="input_field">
                            <label for="city">شهر</label>
                            <input type="text" name="city" id="city">
                        </div>
                        <div class="input_field">
                            <label for="bio">درباره من</label>
                            <textarea type="text" name="bio" id="bio"></textarea>
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
    </section>

    <script src="../../assets/js/general/jQuery.js"></script>
    <script src="../../assets/js/general/bootstrap.js"></script>
    <script src="../../assets/js/layout/layout.js"></script>
    <script src="../../assets/js/profile/profile.js"></script>
</body>

</html>