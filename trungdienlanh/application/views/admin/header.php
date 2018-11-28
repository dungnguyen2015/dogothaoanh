<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi-vn" lang="vi-vn" dir="ltr">
<head>
    <link rel="alternate" hreflang="vi-vn" href="<?php echo base_url();?>">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title> ZOZODA  </title>
    <link href="<?php echo base_url()?>public/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/jquery-2.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/style.js"></script>
    <script>
        var base_url = '<?php echo base_url()?>';
    </script>
</head>
<body>
<header class = "wrap-main">
    <div class="wrap-h1"><h1>Secondary text</h1></div>
    <div class="w-header-top">
        <div class= "container">
            <a href = "<?php echo base_url()?>" class = 'logo-main'> <img src="<?php echo base_url()?>public/img/logo.png"/> </a>
            <div class="rb">
            <ul  class="list-unstyled head-link">
                <li class="shopping-cart-link">
                    <a href > Giỏ hàng</a>
                </li>

                <li class="login-link">
                    <a href > Đăng nhập</a>
                </li>

                <li class="phone">
                   <p class="txt1"> 0963 107 251</p>
                    <p class="txt2"> T2-T7 / 8:00 - 19:00</p>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <div class="menu-main-headed">
        <div class="container">
            <ul class="list-inline top-menu">
                <li class="active"> <a href = ""> trang chủ </a></li>
                <li> <a href = ""> Bài viết</a></li>
                <li> <a href = ""> Khuyễn mãi</a></li>
                <li> <a href = ""> Liên hệ</a></li>
                <li>
                    <form action="<?php echo base_url()?>search" method="get" class="form-inline">
                        <div class="input-key">
                            <input type="text" name = "keysearch" class="form-control" placeholder="Tìm kiếm..."/>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>