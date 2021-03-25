<?php

    require_once '../../../init.php';
    require_once '../layout/requireCheck.php';

    if(isset($_GET['create_category'])){

        $category_title = $main -> safeGet('category_title');
        $category_parent = $main -> safeGet('category_parent');
        
        if($category_title === '')
            $main -> redirect('?msg=empty-input');

        else if(!is_numeric($category_parent))            
            $main -> redirect('?msg=invalid-input');

        else
            $main -> createCategory($category_title , (int)$category_parent);


    }else if(isset($_GET['delete-row'])){

        $row_req = $main -> safeGet('delete-row');

        $select_all = "SELECT * FROM `category` WHERE id = '$row_req'";
        $con_SA = $main -> query($select_all);
        $SA_result = mysqli_fetch_assoc($con_SA);

        if($SA_result['parent_id'] === '0'){

            $find_child = "SELECT id FROM `category` WHERE parent_id = '$row_req'";
            $con_SA = $main -> query($find_child);

            while($result = mysqli_fetch_assoc($con_SA)){
                
                $RR = $result['id'];
                $del_q = "DELETE FROM `category` WHERE id = '$RR'";
                $del_result = $main -> query($del_q);

            }

        }else{

            // $del_q = "DELETE FROM `category` WHERE id = $row_req";
            // $del_result = $main -> query($del_q);
    
            // if($del_result > 0)
            //     $main -> redirect('?msg=delete-row');

        }
        

    }

    $select_main_category = "SELECT * FROM `category` WHERE parent_id = '0' ORDER BY id DESC";
    $select_sub_category = "SELECT * FROM `category` WHERE parent_id != '0' ORDER BY id DESC";
    $select_category = "SELECT * FROM `category`ORDER BY id DESC";
    $result_MC = $main -> query($select_main_category);
    $result_SC = $main -> query($select_sub_category);
    $result = $main -> query($select_category);

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
                    <h1>لیست دسته بندی ها</h1>
                    <h2>لیست دسته بندی ها موجود در سایت </h2>
                    <hr>
                </header>

                <form action="" method="get">
                    <div class="input_field">
                        <label for="category_title">نام دسته</label>
                        <input type="text" id="category_title" name="category_title">
                    </div>
                    <div class="input_field mt-4">
                        <label for="row_count">والد دسته</label>
                        <select class="parent_select" name="category_parent">
                            <optgroup label="دسته های اصلی">
                                <option value="0">دسته اصلی </option>
                            </optgroup>
                            <optgroup label="زیر دسته ها">
                                <option value="0">دسته اصلی</option>
                            </optgroup>
                        </select>
                    </div>
                    <button type="submit" class="btn green_btn mt-5" name="edit_category">ویرایش دسته</button>
                    <button type="button" class="btn red_btn close_edit_modal mt-5">بازگشت</button>
                </form>

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
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                        </div>
                        <button class="btn red_btn">
                            <i class="fal fa-trash-alt"></i>
                        </button>
                    </div>
                </header>
                <div class="page_content">

                <?php
                    $i = 1;
                    $CE = mysqli_num_rows($result);                    
                    if($CE > 0){
                        ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="grid">
                                                <label class="checkbox path">
                                                    <input name="check_row" value="0" type="checkbox" class="Q_checkbox">
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
                                        while($rows = mysqli_fetch_assoc($result)){
                                            $row_PI = $rows['parent_id'];
                                            $select_parent = "SELECT title FROM `category` WHERE id = '$row_PI'";
                                            $SP_result = $main -> query($select_parent);
                                            $SP_result = mysqli_fetch_assoc($SP_result);

                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="grid">
                                                            <label class="checkbox path">
                                                                <input name="check_row" value="0" type="checkbox" class="Q_checkbox">
                                                                <svg viewBox="0 0 21 21">
                                                                    <path
                                                                        d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186">
                                                                    </path>
                                                                </svg>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $i++?></td>
                                                    <td><?php echo $rows['title']?></td>
                                                    <td><?php echo $SP_result['title'] !== null ? $SP_result['title'] : 'دسته اصلی' ?></td>
                                                    <td>
                                                        <a href=""><?php echo $rows['creator']?></a>
                                                    </td>
                                                    <td>
                                                        <div class="table_pill green">
                                                            10
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn blue_btn edit_modal_btn"><i class="fal fa-pencil-alt"></i></button>
                                                        <a href="?delete-row=<?php echo $rows['id']?>" class="btn red_btn"><i class="fal fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                    }
                ?>
                <?php
                    if($CE == 0){
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
                <form action="" method="get">
                    <div class="input_field">
                        <label for="category_title">نام دسته</label>
                        <input type="text" id="category_title" name="category_title">
                    </div>
                    <div class="input_field mt-4">
                        <label for="row_count">والد دسته</label>
                        <select class="parent_select" name="category_parent">
                            <optgroup label="دسته های اصلی">
                                <option value="0">دسته اصلی </option>
                                <?php
                                    while($MC_rows = mysqli_fetch_assoc($result_MC)){
                                        ?>
                                <option value="<?php echo $MC_rows['id']?>"><?php echo $MC_rows['title']?></option>
                                <?php
                                    }
                                ?>
                            </optgroup>
                            <optgroup label="زیر دسته ها">
                                <option value="0">دسته اصلی</option>
                                <?php
                                    while($SC_rows = mysqli_fetch_assoc($result_SC)){
                                        ?>
                                <option value="<?php echo $SC_rows['id']?>"><?php echo $SC_rows['title']?></option>
                                <?php
                                    }
                                ?>
                            </optgroup>
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