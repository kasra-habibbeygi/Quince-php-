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
    <title>افزودن دسته بندی</title>
</head>

<body>

    <?php require_once '../layout/layout.php'?>

    <section class="page_main_field">

        <div class="error_field warning_error <?php echo $main -> safeGet('msg') ?>">
            <i class="fal fa-exclamation-circle"></i>
            <p></p>
            <i class="fal fa-times close_error"></i>
        </div>
    </section>

    <script src="../../assets/js/general/jQuery.js"></script>
    <script src="../../assets/js/general/bootstrap.js"></script>
    <script src="../../assets/js/layout/layout.js"></script>
</body>

</html>