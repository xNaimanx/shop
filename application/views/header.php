<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php
echo $title;
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
<?php
if(($title != 'Главная страница') and ($title != 'Описание товара') )
  echo '<script type="text/javascript" src="/js/jquery.min2.js"></script>';
?>


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
<script type="text/javascript" src="/js/zoom/zoom-c.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/js/zoom/zoom.css" />
</head>

<body>

<div id="templatemo_wrapper">
	<div id="templatemo_header">

    	<div id="site_title">
        	<h1><a href="#">Station Shop</a></h1>
        </div>

        <div id="header_right">
          <?php
          //Проверяем есть ли сессия, если да то дадим ссылку на личнй кабинет.
          $str = '';
          $log_out = '<a href="/authorization">Войти</a>';
          if($session == 1){
              $str = '<a href="#">'.$this->session->userdata('email').'</a> |';
              $log_out = '<a href="/shop?exit=1">Выйти</a>';

          }
          if($count != 0)
            $checkout = '<a href="/checkout">Оформить заказ</a> |';
          else $checkout = '';
          //Если юзер админ то  дадим ссылку на админку.
          $admin = '';
          if($this->session->userdata('admin_auth')==1)
            $admin = '<a href="/admin/products">Админка</a> |';
          ?>

          <?=$str.$admin?><a href="/shoppingcart">Корзина</a> | <?=$checkout?> <?=$log_out?>
		</div>

        <div class="cleaner"></div>
    </div> <!-- END of templatemo_header -->
    <?php
    $home = '';
    $product = '';
    $about = '';
    $faq = '';
    $contacts = '';
    switch($title){
      case 'Главная страница': {$home= "background: url(/images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
      case 'Товары': {$product= "background: url(/images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
      case 'О нас': {$about= "background: url(/images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
      case 'FAQs': {$faq= "background: url(/images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
      case 'Контакты': {$contacts= "background: url(/images/templatemo_menu_hover.jpg) repeat-x;color: #fff"; break;}
    }
    ?>
    <div id="templatemo_menu">
    	<div id="top_nav" class="ddsmoothmenu">
            <ul>
                <li><a href="/shop" style="<?=$home?>">Главная страница</a></li>
                <li><a href="/products" style="<?=$product?>">Товары</a>
                    <ul>

                  </ul>
                </li>
                <li><a href="/shop/about" style="<?=$about?>">О нас</a>
                    <ul>

                  </ul>
                </li>
                <li><a href="/shop/faqs" style="<?=$faq?>">FAQs</a></li>
                <li><a href="/shop/contacts" style="<?=$contacts?>">Контакты</a></li>
            </ul>
            <br style="clear: left" />
        </div> <!-- end of ddsmoothmenu -->
        <div id="menu_second_bar">
        	<div id="top_shopping_cart">
            	В корзине: <strong><?=$count?> Товара</strong> ( <a href="/shoppingcart">Показать корзину</a> )
            </div>
        	<div id="templatemo_search">
                <form action="/products/search" method="post">
                  <input type="text" name="keyword" id="keyword" title="keyword" onfocus="clearText(this)" onblur="clearText(this)" class="txt_field" />
                  <input type="submit"  value="Поиск" alt="Search" id="searchbutton" title="Search" class="sub_btn"  />
                </form>
            </div>
            <div class="cleaner"></div>
    	</div>
    </div> <!-- END of templatemo_menu -->
    <?php
    if($title == 'Главная страница'):
    ?>
    <div id="templatemo_middle" class="carousel">
    	<div class="panel">

				<div class="details_wrapper">

					<div class="details">

						<?=$detail?>

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

			     <?=$item?>

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

                  $i = 1;
                  if(is_array($categorys)){
                    foreach($categorys as $val){
                      if($i = 1) $class = ' class="first"'; else $class = '';
                      echo "<li$class><a href='/products/category/{$val['category']}'>{$val['category']}</a></li>";
                      $i++;
                    }
                  }
                  echo '<li style="font-size:1.2em"><strong>Жанры</strong></li>';
                  $i = 1;
                  if(is_array($genres)){
                    foreach($genres as $val){
                      if($i = count($genres)) $class = ' class="last"'; else $class = '';
                      if($val['genre'] == false) continue;
                      echo "<li$class><a href='/products/genre/{$val['genre']}'>{$val['genre']}</a></li>";
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
                    	<a href="#"><img src="/files/images/1432285796-small.jpg" alt="Image 01" /></a>
                        <h4><a href="#">Donec nunc nisl</a></h4>
                        <p class="price">$10</p>
                        <div class="cleaner"></div>
                    </div>
                    <div class="bs_box">
                    	<a href="#"><img src="/files/images/1432285796-small.jpg" alt="Image 02" /></a>
                        <h4><a href="#">Aenean eu tellus</a></h4>
                        <p class="price">$12</p>
                        <div class="cleaner"></div>
                    </div>
                    <div class="bs_box">
                    	<a href="#"><img src="/files/images/1432285796-small.jpg" alt="Image 03" /></a>
                        <h4><a href="#">Phasellus ut dui</a></h4>
                        <p class="price">$20</p>
                        <div class="cleaner"></div>
                    </div>
                    <div class="bs_box">
                    	<a href="#"><img src="/files/images/1432285796-small.jpg" alt="Image 04" /></a>
                        <h4><a href="#">Vestibulum ante</a></h4>
                        <p class="price">$16</p>
                        <div class="cleaner"></div>
                    </div>
                </div>
            </div>
        </div>
