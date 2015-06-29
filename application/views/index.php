<?php
ob_start();
session_start();
//Получаем объект для работы с моделями.
$obj = new Shop_model;
//Корзина
$count = 0;//Для количества товаров у юзера в корзине.
$count = $obj->basketInit();
$l = 0;
if(isset($_GET['l']))
  $l = $_GET['l'];
//Проверяем куки, делаем сверку пароля, который пришел с куки и если все ок даем ссылку на личный кабинет и открываем сессию.
if(!isset($_SESSION['auth'])){
  if(isset($_COOKIE['auth'])){
    $auth = json_decode(urldecode($_COOKIE['auth']), true);
    $password_cookie = $auth['password_cookie'];
    $id = $auth['id'];
    if(!$id){
      echo 'Вы злосный злоумышленник. Доступ вам запрещен';
      exit;
    }
    $pass_bd = $obj->get_cookie_hash($id);
    if($pass_bd == $password_cookie){
      $_SESSION['email'] = $auth['email'];
      $_SESSION['id'] = $auth['id'];
      $_SESSION['auth'] = 1;
    }
  }
}
if(isset($_GET['exit'])){
  setcookie("auth", "", time()-3600, '/');
  setcookie('PHPSESSID', '', time()-3600, '/');
  header('Location: /shop');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
  <?php
//Выводим title.
$home = '';
$product = '';
$about = '';
$faq = '';
$contacts = '';
switch($l){
  case 0: {echo 'Главная страница'; $home= "background: url(images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
  case 1: {echo 'Товары'; $product= "background: url(images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
  case 2: {echo 'О нас'; $about= "background: url(images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
  case 3: {echo 'FAQs'; $faq= "background: url(images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
  case 4: {echo 'Контакты'; $contacts= "background: url(images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
  case 5: echo 'Корзина'; break;
  case 6: echo 'Описание товара'; break;
  case 7: echo 'Оформление заказа'; break;
  case 8: echo 'Страница авторизации'; break;
  case 9: echo 'Страница регистрации'; break;
  case 10: echo 'Сохранение заказа'; break;
}
?>
</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<!-- templatemo 352 station shop -->
<!--
Station Shop Template
http://www.templatemo.com/preview/templatemo_352_station_shop
-->
<link href="/css/templatemo_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/ddsmoothmenu.css" />

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/ddsmoothmenu.js">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "top_nav", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<link rel="stylesheet" type="text/css" media="all" href="/css/jquery.dualSlider.0.2.css" />

<script src="/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="/js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="/js/jquery.timers-1.2.js" type="text/javascript"></script>
<script src="/js/jquery.dualSlider.0.3.min.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $(".carousel").dualSlider({
            auto:true,
            autoDelay: 6000,
            easingCarousel: "swing",
            easingDetails: "easeOutBack",
            durationCarousel: 1000,
            durationDetails: 600
        });

    });

</script>

</head>

<body>

<div id="templatemo_wrapper">
	<div id="templatemo_header">

    	<div id="site_title">
        	<h1><a href="#">Station Shop</a></h1>
        </div>

        <div id="header_right">
          <?php
          //Проверяем пришла ли в куках инфа о пользователеи если да, то дадимссылку на личнй кабинет.
          $str = '';
          $log_out = '<a href="/shop?l=8">Войти</a>';
          if(isset($_SESSION['auth'])){
            if($_SESSION['auth']==1){
              $str = '<a href="#">'.$_SESSION['email'].'</a> |';
              $log_out = '<a href="/shop?exit=1">Выйти</a>';
            }
          }
          ?>

          <?=$str?> <a href="#">My Wishlist</a> | <a href="#">My Cart</a> | <a href="#">Checkout</a> | <?=$log_out?>
		</div>

        <div class="cleaner"></div>
    </div> <!-- END of templatemo_header -->

    <div id="templatemo_menu">
    	<div id="top_nav" class="ddsmoothmenu">
            <ul>
                <li><a href="/shop" style="<?=$home?>">Главная страница</a></li>
                <li><a href="/shop?l=1" style="<?=$product?>">Товары</a>
                    <ul>
                        <li><a href="#submenu1">Sub menu 1</a></li>
                        <li><a href="#submenu2">Sub menu 2</a></li>
                        <li><a href="#submenu3">Sub menu 3</a></li>
                  </ul>
                </li>
                <li><a href="/shop?l=2" style="<?=$about?>">О нас</a>
                    <ul>
                        <li><a href="#submenu1">Sub menu 1</a></li>
                        <li><a href="#submenu2">Sub menu 2</a></li>
                        <li><a href="#submenu3">Sub menu 3</a></li>
                        <li><a href="#submenu4">Sub menu 4</a></li>
                        <li><a href="#submenu5">Sub menu 5</a></li>
                  </ul>
                </li>
                <li><a href="/shop?l=3" style="<?=$faq?>">FAQs</a></li>
                <li><a href="/shop?l=4" style="<?=$contacts?>">Контакты</a></li>
            </ul>
            <br style="clear: left" />
        </div> <!-- end of ddsmoothmenu -->
        <div id="menu_second_bar">
        	<div id="top_shopping_cart">
            	В корзине: <strong><?=$count?> Товара</strong> ( <a href="/shop?l=5">Показать корзину</a> )
            </div>
        	<div id="templatemo_search">
                <form action="#" method="get">
                  <input type="text" value="Search" name="keyword" id="keyword" title="keyword" onfocus="clearText(this)" onblur="clearText(this)" class="txt_field" />
                  <input type="submit" name="Search" value=" Search " alt="Search" id="searchbutton" title="Search" class="sub_btn"  />
                </form>
            </div>
            <div class="cleaner"></div>
    	</div>
    </div> <!-- END of templatemo_menu -->
    <?php
    if($l == 0):
    ?>
    <div id="templatemo_middle" class="carousel">
    	<div class="panel">

				<div class="details_wrapper">

					<div class="details">

						<div class="detail">
							<h2><a href="#">Station Shop</a></h2>
                            <p>Station Shop is free website template by templatemo for ecommerce websites or online stores. Sed aliquam arcu. Donec urna massa, cursus et mattis at, mattis quis lectus. </p>
							<a href="#" title="Read more" class="more">Read more</a>
						</div><!-- /detail -->

						<div class="detail">
							<h2><a href="#">Fusce hendrerit</a></h2>
                            <p>Duis dignissim tincidunt turpis eget pellentesque. Nulla consectetur accumsan facilisis. Suspendisse et est lectus, at consectetur sem.</p>
							<a href="#" title="Read more" class="more">Read more</a>
						</div><!-- /detail -->

						<div class="detail">
							<h2><a href="#">Aenean massa cum</a></h2>
                            <p>Sed vel interdum sapien. Aliquam consequat, diam sit amet iaculis ultrices, diam erat faucibus dolor, quis auctor metus libero vel mi.</p>
							<a href="#" title="Read more" class="more">Read more</a>
						</div><!-- /detail -->

					</div><!-- /details -->

				</div><!-- /details_wrapper -->

				<div class="paging">
					<div id="numbers"></div>
					<a href="javascript:void(0);" class="previous" title="Previous" >Previous</a>
					<a href="javascript:void(0);" class="next" title="Next">Next</a>
				</div><!-- /paging -->

				<a href="javascript:void(0);" class="play" title="Turn on autoplay">Play</a>
				<a href="javascript:void(0);" class="pause" title="Turn off autoplay">Pause</a>

			</div><!-- /panel -->

			<div class="backgrounds">

				<div class="item item_1">
					<img src="images/slider/02.jpg" alt="Slider 01" />
				</div><!-- /item -->

				<div class="item item_2">
					<img src="images/slider/03.jpg" alt="Slider 02" />
				</div><!-- /item -->

				<div class="item item_3">
					<img src="images/slider/01.jpg" alt="Slider 03" />
				</div><!-- /item -->

			</div><!-- /backgrounds -->
    </div> <!-- END of templatemo_middle -->
  <?php endif; ?>
    <div id="templatemo_main">
   		<div id="sidebar" class="float_l">
        	<div class="sidebar_box"><span class="bottom"></span>
            	<h3>Категории</h3>
                <div class="content">
                	<ul class="sidebar_list">
                  <?php
                  //Получаем из базы список катигорий и жанров и днлаем динамические ссылки. Функции смотреть в каегории работа с каталогом.
                  $category = $obj->get_category();
                  $genre = $obj->get_genre();
                  $i = 1;
                  if(is_array($category)){
                    foreach($category as $val){
                      if($i = 1) $class = ' class="first"'; else $class = '';
                      echo "<li$class><a href='/shop?l=1&category={$val['category']}'>{$val['category']}</a></li>";
                      $i++;
                    }
                  }
                  echo '<li style="font-size:1.2em"><strong>Жанры</strong></li>';
                  $i = 1;
                  if(is_array($genre)){
                    foreach($genre as $val){
                      if($i = count($genre)) $class = ' class="last"'; else $class = '';
                      if($val['genre'] == false) continue;
                      echo "<li$class><a href='/shop?l=1&genre={$val['genre']}'>{$val['genre']}</a></li>";
                      $i++;
                    }
                  }
                  ?>

                    </ul>
                </div>
            </div>
            <div class="sidebar_box"><span class="bottom"></span>
            	<h3>Топ продаж</h3>
                <div class="content">
                	<div class="bs_box">
                    	<a href="#"><img src="files/images/1432285796-small.jpg" alt="Image 01" /></a>
                        <h4><a href="#">Donec nunc nisl</a></h4>
                        <p class="price">$10</p>
                        <div class="cleaner"></div>
                    </div>
                    <div class="bs_box">
                    	<a href="#"><img src="files/images/1432285796-small.jpg" alt="Image 02" /></a>
                        <h4><a href="#">Aenean eu tellus</a></h4>
                        <p class="price">$12</p>
                        <div class="cleaner"></div>
                    </div>
                    <div class="bs_box">
                    	<a href="#"><img src="files/images/1432285796-small.jpg" alt="Image 03" /></a>
                        <h4><a href="#">Phasellus ut dui</a></h4>
                        <p class="price">$20</p>
                        <div class="cleaner"></div>
                    </div>
                    <div class="bs_box">
                    	<a href="#"><img src="files/images/1432285796-small.jpg" alt="Image 04" /></a>
                        <h4><a href="#">Vestibulum ante</a></h4>
                        <p class="price">$16</p>
                        <div class="cleaner"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //Подключаем странички.

        switch($l){
          case 0: require_once 'inc/home_inc.php'; break;
          case 1: require_once 'inc/products_inc.php'; break;
          case 2: require 'inc/about_inc.php'; break;
          case 3: require 'inc/faqs_inc.php'; break;
          case 4: require 'inc/contact_inc.php'; break;
          case 5: require 'inc/shoppingcart_inc.php'; break;
          case 6: require 'inc/productdetail_inc.php'; break;
          case 7: require 'inc/checkout_inc.php'; break;
          case 8: require 'inc/authorization/login.php'; break;
          case 9: require 'inc/authorization/registration.php'; break;
          case 10: require 'inc/save_order_inc.php'; break;
        }
        ?>
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->

    <div id="templatemo_footer">
    	<p>
			<a href="/shop">Главная страница</a> | <a href="/shop?l=1">Товары</a> | <a href="/shop?l=2">О нас</a> | <a href="/shop?l=3">FAQs</a> | <a href="/shop?l=4">Контакты</a>
		</p>

    	Copyright © 2048 <a href="#">Your Company Name</a>
    </div> <!-- END of templatemo_footer -->

</div> <!-- END of templatemo_wrapper -->

</body>
</html>
