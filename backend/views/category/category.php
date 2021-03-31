<?php

    require_once '../../../init.php';
    require_once '../layout/requireCheck.php';

    if(isset($_GET['create_category'])){

        $C_name = $main -> safeGet('category_title');
        $C_parent = (int)$_GET['category_parent'];

        if($C_name == '')
            $main -> redirect('?msg=empty-input');

        else    
            $main -> createCategory($C_name , $C_parent);

    }

    if(isset($_GET['delete-row']))
        $main -> deleteCategory();

    if(isset($_GET['delete-all']))
        $main -> deleteAllCategory();

    if(isset($_GET['edit_category'])){

        $E_name = $main -> safeGet('ECN');
        $E_parent = (int)$_GET['ECP'];
        $E_id = (int)$_GET['ECI'];

        $main -> editCategory($E_name , $E_parent , $E_id);

    }

    // get category table rows
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if($page < 1)
        $page = 1;

    $m = isset($_GET['page-count']) ? (int)$_GET['page-count'] : 5;
    $n = ($page * $m) - $m;

    $category_get_Q = "SELECT * FROM `category` ORDER BY id DESC LIMIT $n,$m";
    $category_get_result = $main -> query($category_get_Q);
    $category_rows = mysqli_fetch_assoc($category_get_result);

    // select how many record in db
    $count_records = "SELECT count(*) AS CR FROM `category`";
    $CR_send = $main -> query($count_records);
    $CR_result = $main -> getRow($CR_send);
    $total_page = ceil($CR_result['CR'] / $m);

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
    <link rel="stylesheet" href="../../assets/css/general/select2.css">
    <link rel="stylesheet" href="../../assets/css/layout/layout.css">
    <link rel="stylesheet" href="../../assets/css/category/category.css">
    <title>افزودن دسته بندی</title>
</head>

<body>

    <?php require_once '../layout/layout.php'?>

    <div class="edit_modal">
        <div class="EM_mian_field">
            <div class="content">
                <header class="modal_header_field">
                    <h1>ویرایش دسته بندی</h1>
                    <h2>ویرایش دسته بندی های سایت</h2>
                    <hr>
                </header>

                <form action="" method="get" autocomplete="off">
                    <div class="input_field">
                        <label for="ECN">نام دسته</label>
                        <input type="text" id="ECN" name="ECN">
                    </div>
                    <input type="text" id="modal_row_id" value="" name="ECI" hidden>
                    <div class="input_field mt-4">
                        <label for="row_count">والد دسته</label>
                        <select class="parent_select ECP" name="ECP">
                            <option value="0">دسته اصلی</option>
                            <?php
                                $find_parent_Q = "SELECT * FROM `category` WHERE parent_id = 0 ORDER BY id DESC";
                                $find_parent_result = $main -> query($find_parent_Q);

                                while($P_rows = mysqli_fetch_assoc($find_parent_result)){
                                    ?>
                                        <option value="<?php echo $P_rows['id']?>"><?php echo $P_rows['title']?></option>
                                    <?php
                                }                                    
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn green_btn mt-5" name="edit_category">ویرایش دسته</button>
                    <button type="button" class="btn red_btn close_edit_modal mt-5">بازگشت</button>
                </form>

            </div>
        </div>
    </div>

    <div class="delete_modal">
        <div class="DM_main_field">
            <div class="content">
                <i class="fal fa-exclamation-circle"></i>
                <p></p>
                <span class="alert_box"></span>
                <div>
                    <button id="CDCM" type="button">خیر</button>
                    <a href="">بله</a>
                </div>
            </div>
        </div>
    </div>

    <section class="page_main_field">
        <div class="error_field warning_error <?php echo $main -> safeGet('msg') ?>">
            <i class="fal fa-exclamation-circle"></i>
            <p></p>
            <i class="fal fa-times close_error"></i>
        </div>
        <div class="field_of_content">
            <div class="left_field">
                <header class="header_field">
                    <div class="title">
                        <h1>لیست دسته بندی ها</h1>
                        <h2>لیست دسته بندی ها موجود در سایت </h2>
                    </div>
                    <div class="options">
                        <div class="search">
                            <form action="" method="get">
                                <button type="submit" class="search_sub"><i class="fal fa-search"></i></button>
                                <input type="text" type="text" placeholder="جستجو ...">
                                <span><i class="fal fa-times"></i></span>
                            </form>
                        </div>
                        <div class="row_count_select">
                            <label for="row_count">تعداد ردیف ها :</label>
                            <select id="row_count">
                                <option <?php echo $m == '5' ? 'selected' : ''?>>5</option>
                                <option <?php echo $m == '10' ? 'selected' : ''?>>10</option>
                                <option <?php echo $m == '25' ? 'selected' : ''?>>25</option>
                                <option <?php echo $m == '50' ? 'selected' : ''?>>50</option>
                            </select>
                        </div>
                        <button class="btn red_btn delete_all">
                            <i class="fal fa-trash-alt"></i>
                        </button>
                    </div>
                </header>
                <div class="page_content">
                    <?php 
                        if(gettype($category_rows['id']) !== 'NULL'){
                            ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="grid">
                                                    <label class="checkbox path">
                                                        <input type="checkbox" class="Q_checkbox check_all">
                                                        <svg viewBox="0 0 21 21">
                                                            <path
                                                                d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186">
                                                            </path>
                                                        </svg>
                                                    </label>
                                                </div>
                                            </th>
                                            <th>ردیف</th>
                                            <th>نام دسته</th>
                                            <th>والد دسته</th>
                                            <th>سازنده</th>
                                            <th>تعداد زیر دسته</th>
                                            <th>تنظیمات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($page == 1)
                                                $list_id = 1;
                                            else
                                                $list_id = (($page-1) * 5) + 1;
                                                
                                            mysqli_data_seek($category_get_result , 0);
                                            while($C_rows = mysqli_fetch_assoc($category_get_result)){

                                                // find parents
                                                $C_name = $C_rows['parent_id'];
                                                $parent_name_Q = "SELECT title FROM `category` WHERE id = '$C_name'";
                                                $PNQ_result = $main -> query($parent_name_Q);
                                                $parent_name = mysqli_fetch_assoc($PNQ_result);

                                                // find sub category count
                                                if($C_name == '0'){

                                                    $C_id = $C_rows['id'];
                                                    $SC_count_Q = "SELECT id FROM `category` WHERE parent_id = '$C_id'";
                                                    $SC_result = $main -> query($SC_count_Q);
                                                    $C_count = mysqli_num_rows($SC_result);

                                                }else{

                                                    $C_count = '0';

                                                }
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="grid">
                                                                <label class="checkbox path">
                                                                    <input name="check_row" type="checkbox" class="Q_checkbox check_row" value="<?php echo $C_rows['id']?>">
                                                                    <svg viewBox="0 0 21 21">
                                                                        <path
                                                                            d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186">
                                                                        </path>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td data-id="<?php echo $C_rows['id']?>">
                                                            <?php                                                            
                                                                echo $list_id++;
                                                            ?>
                                                        </td>
                                                        <td><?php echo $C_rows['title']?></td>
                                                        <td><?php echo $C_rows['parent_id'] == 0 ? 'دسته اصلی' : $parent_name['title'] ?></td>
                                                        <td>
                                                            <a href=""><?php echo $C_rows['creator']?></a>
                                                        </td>
                                                        <td>
                                                            <div class="table_pill green">
                                                                <?php echo $C_count?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="btn blue_btn edit_modal_btn" data-id="<?php echo $C_rows['id']?>">
                                                                <i class="fal fa-pencil-alt"></i>
                                                            </button>
                                                            <button class="btn red_btn delete_confirm">
                                                                <i class="fal fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="page_pagination">
                                    <ul>
                                        <li>
                                            <?php
                                                if($page == 1){
                                                    ?>
                                                        <a href="javascript:void(0);" class="disable_anchor"><i class="fal fa-angle-double-right"></i></a>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <a href="?page=<?php echo 1?>"><i class="fal fa-angle-double-right"></i></a>
                                                    <?php
                                                }
                                            ?>
                                        </li>
                                        <?php 
                                            if($page == 1){
                                                $j = $page;
                                                while($j < $page + 3){
                                                    ?>
                                                        <li class="<?php echo $j == $page ? 'active' : ''?>">
                                                            <a href="?page=<?php echo $j?>"><?php echo $j?></a>
                                                        </li>
                                                    <?php
                                                    $j++;
                                                }
                                            }
                                            else if($page > 1 && $page < $total_page){
                                                $j = $page;
                                                while($j < $page + 3){
                                                    ?>
                                                        <li class="<?php echo $j-1 == $page ? 'active' : ''?>">
                                                            <a href="?page=<?php echo $j-1?>"><?php echo $j-1?></a>
                                                        </li>
                                                    <?php
                                                    $j++;
                                                }
                                            }
                                            else if($page == $total_page){
                                                $j = $page;
                                                while($j < $page + 3){
                                                    ?>
                                                        <li class="<?php echo $j-2 == $page ? 'active' : ''?>">
                                                            <a href="?page=<?php echo $j-2?>"><?php echo $j-2?></a>
                                                        </li>
                                                    <?php
                                                    $j++;
                                                } 
                                            }
                                        ?>
                                        <li>
                                            <?php
                                                if($page == $total_page){
                                                    ?>
                                                        <a href="javascript:void(0);" class="disable_anchor"><i class="fal fa-angle-double-left"></i></a>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <a href="?page=<?php echo $total_page?>"><i class="fal fa-angle-double-left"></i></a>
                                                    <?php
                                                }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            <?php   
                        }else{
                            ?>
                                <div class="not_exist">
                                    موردی جهت نمایش وجود ندارد !
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="right_field">
                <header>
                    <h3>ثبت دسته جدید</h3>
                </header>
                <form action="" method="get" autocomplete="off">
                    <div class="input_field">
                        <label for="category_title">نام دسته</label>
                        <input type="text" id="category_title" name="category_title" autofocus>
                    </div>
                    <div class="input_field mt-4">
                        <label for="row_count">والد دسته</label>
                        <select class="parent_select" name="category_parent">
                            <option value="0">دسته اصلی </option>
                                <?php
                                    mysqli_data_seek($find_parent_result , 0);
                                    while($P_rows = mysqli_fetch_assoc($find_parent_result)){
                                    ?>
                                        <option value="<?php echo $P_rows['id']?>"><?php echo $P_rows['title']?></option>
                                    <?php
                                }                                    
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn green_btn mt-4" name="create_category">ثبت دسته جدید</button>
                </form>
            </div>
        </div>
    </section>
    <script src="../../assets/js/general/jQuery.js"></script>
    <script src="../../assets/js/general/bootstrap.js"></script>
    <script src="../../assets/js/general/select2.js"></script>
    <script src="../../assets/js/layout/layout.js"></script>
    <script src="../../assets/js/category/category.js"></script>
</body>

</html>