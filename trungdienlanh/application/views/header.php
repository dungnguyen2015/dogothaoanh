<!DOCTYPE html>
<!-- saved from url=(0021)<?php echo base_url();?> -->
<html lang="en"><!--<![endif]--><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $title;?></title>

	<!-- Meta -->
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $description;?>">
	<meta name="keywords" content="<?php echo $keywords;?>">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>public/img/favicon.ico">

	<!-- CSS Global Compulsory -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/style.css">
	
	<!-- Slider banner-->
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/settings.css" type="text/css" media="screen">

	<!-- CSS Header and Footer -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/header-v6.css">
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/footer-v1.css">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/animate.css"> 
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/font-awesome.min.css">
	
	<!-- Gallery tab-->
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/cubeportfolio.min.css">	
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/custom-cubeportfolio.css">

	<!-- CSS Customization -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/custom.css">
	
	<!-- CSS Page Style -->	
	<link rel="stylesheet" href="<?php echo base_url();?>public/trungdienlanh/css/home_page.css">
	
	<script type="application/ld+json">
    {
      "@context" : "http://schema.org",
      "@type" : "Organization",
      "name" : "Trung Điện Lạnh",
      "url" : "http://www.trungdienlanh.com/",
      "sameAs" : [
        "https://www.facebook.com/trungdienlanhHCM/",
        "https://www.pinterest.com/zozodavn/",
        "https://www.linkedin.com/in/tramhuongthaoanh/",
        "https://twitter.com/tramhuongta/"
     ]
    }
    </script>
	
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-57983783-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-57983783-6');
</script>


</head>	

<body class="header-fixed header-fixed-space home">
<div class="wrapper">

	<!--=== Header ===-->
    <div class="header-v6 header-classic-white header-sticky">
        <div class="bg-follows">
            <div class="container">
                <ul class="follows">
                    <li><p id="lienket">Liên kết với chúng tôi:</p></li>
                    <li>
                        <a class="icon-sns" href="https://www.facebook.com/trungdienlanhHCM/" target="_blank"><p class="fa fa-facebook-official" aria-hidden="true"></p></a>
                        <a class="icon-sns" href="https://www.instagram.com/trungdienlanh/" target="_blank"><p class="fa fa-instagram" aria-hidden="true"></p></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar mega-menu" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="menu-container">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                    <div class="navbar-brand">
                        <a href="<?php echo base_url();?>"><img class="shrink-logo img-responsive" src="<?php echo base_url();?>public/trungdienlanh/img/trungdienlanh_logo.png" alt="trungdienlanh"></a>
                    </div>
                </div>

                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <div class="menu-container">
                        <ul class="nav navbar-nav">
                            <li class="menu_active"><a href="<?php echo base_url();?>" title="Trang chủ">Trang chủ</a></li>
                            <li><a href="<?php echo base_url();?>dich-vu/" title="Dịch vụ">Dịch vụ</a></li>
							<li><a href="<?php echo base_url();?>tuyen-dung/" title="Thông tin tuyển dụng">Thông tin tuyển dụng</a></li>
							<!--	
						   <li class=" dropdown">
	                        <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo base_url();?>tuyen-dung/" onclick="window.location.href=&#39;/catalog.php&#39;;">
	                            Thông tin tuyển dụng
	                        </a>
		                        <ul class="dropdown-menu">
		                            <li>
		                                <a href="<?php echo base_url();?>recruite.php" onclick="window.location.href=&#39;/recruite.php&#39;;" title="Vị trí tuyển dụng">Vị trí tuyển dụng</a>
		                            </li>
		                            <li>
		                                <a href="<?php echo base_url();?>company_feature.php" onclick="window.location.href=&#39;/company_feature.php&#39;;" title="Đặc trưng công ty">Đặc trưng công ty</a>
		                            </li>
		                            <li>
		                                <a href="<?php echo base_url();?>list_staff.php" onclick="window.location.href=&#39;/list_staff.php&#39;;" title="Phỏng vấn nhân viên">Phỏng vấn nhân viên</a>
		                            </li>
		                        </ul>
                    		</li>
							-->
                            <li><a href="<?php echo base_url();?>bai-viet/" title="Bài viết">Bài viết</a></li>
                        </ul>
                    </div>
                </div>
            </div>    
        </div> 
    </div>