<?php

    $admin_info = $main -> getUser();

?>

<nav>
    <div class="left_items">
        <div>
            <i class="fal fa-bell"></i>
        </div>
        <div>
            <i class="fal fa-search"></i>
        </div>
    </div>
    <div class="right_items">
        <div class="full_name">
            سلام <span> <?php echo $admin_info['username']?> !</span>
        </div>
        <div class="FL_name">
            M
        </div>
    </div>
</nav>

<aside>
    <div class="logo_field">
        <img src="../../assets/img/logo2.png" alt="">
        <i class="fad fa-angle-double-right" id=close_aside></i>
    </div>
    <div class="menu_items">
        <ul>
            <li>
                <a href="../dashboard/dashboard.php">
                    <i class="fad fa-analytics"></i>
                    <p>داشبورد</p>
                </a>
            </li>
            <li>
                <a href="../profile/profile.php">
                    <i class="fad fa-id-card"></i>
                    <p>پروفایل</p>
                </a>
            </li>
            <li>
                <a href="../category/category.php">
                    <i class="fad fa-layer-plus"></i>
                    <p>دسته بندی</p>
                </a>
            </li>
            <li class="collaps_item">
                <button type="button">
                    <i class="fad fa-newspaper"></i>
                    <p>مقالات</p>
                    <i class="far fa-angle-left"></i>
                </button>
                <ul class="sub_menu">
                    <li>
                        <a href="../category/add-category.php">
                            <i class="fad fa-circle-notch"></i>
                            <p>افزودن مقاله</p>
                        </a>
                    </li>
                    <li>
                        <a href="../category/category-list.php">
                            <i class="fad fa-circle-notch"></i>
                            <p>لیست مقالات</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="collaps_item">
                <button type="button">
                    <i class="fad fa-tags"></i>
                    <p>فروشگاه</p>
                    <i class="far fa-angle-left"></i>
                </button>
                <ul class="sub_menu">
                    <li>
                        <a href="../category/add-category.php">
                            <i class="fad fa-circle-notch"></i>
                            <p>افزودن محصول</p>
                        </a>
                    </li>
                    <li>
                        <a href="../category/category-list.php">
                            <i class="fad fa-circle-notch"></i>
                            <p>لیست محصولات</p>
                        </a>
                    </li>
                    <li>
                        <a href="../category/category-list.php">
                            <i class="fad fa-circle-notch"></i>
                            <p>کد تخفیف</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="">
                    <i class="fad fa-phone"></i>
                    <p>تماس با ما</p>
                </a>
            </li>
            <li>
                <button id="exit">
                    <i class="fad fa-portal-exit"></i>
                    <p>خروج</p>
                </button>
            </li>
        </ul>
    </div>
</aside>

<!-- exit modal -->
<div class="exit_modal">
    <div class="main_field">
        <div class="content">
            <i class="fal fa-exclamation-circle"></i>
            <p>آیا برای خروج از پروفایل خود اطمینان دارید ؟</p>
            <div>
                <button id="CEM" type="button">بازگشت</button>
                <a href="?logout=1">خروج</a>
            </div>
        </div>
    </div>
</div>