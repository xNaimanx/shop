<div id="content" class="float_r">
<h1>О нас</h1>
  <h2>History of our online shop</h2>
<p>Nam cursus facilisis nibh nec eleifend. Mauris nulla leo, tempus ac laoreet in, aliquet eu sem. Nullam est est, imperdiet vitae mollis nec, aliquet varius ante. Donec laoreet <a href="#">eleifend velit a tristique</a>. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed vehicula elit vel ante venenatis laoreet. Station Shop is free <a rel="nofollow" href="http://www.templatemo.com">website template</a> by templatemo for ecommerce websites or online stores.</p>
<ul class="templatemo_list">
  <li>Donec aliquam metus a odio molestie eu consequat.</li>
    <li>Sed a rutrum risus, nam sed ligula et nunc fermentum.</li>
    <li>Maecenas sit amet diam quis sem euismod porttitor.</li>
    <li>Aliquam fermentum cursus risus aliquam erat volutpat.</li>
    <li>Sed fermentum tempus enim, eget iaculis purus imperdiet eget.</li>
</ul>
<div class="cleaner h20"></div>
<h4>Напишите пожалуйста отзыв о нашем магазине.</h4>
<form method="post" action="<?= $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
  <label for="author">* Имя:&nbsp&nbsp</label> <input type="text" id="author" name="name" value="<?php echo set_value('name');?>" /><span style="float: right; color: red; margin-right: 150px"><?=form_error('name')?></span>
  <div class="cleaner h10"></div>
  <label for="email">* Email:</label> <input type="text" id="email" name="email" value="<?php echo set_value('email');?>"/><span style="float: right; color: red; margin-right: 150px"><?=form_error('email')?></span>
  <div class="cleaner h10"></div>
  <lable for="text">* Текст:</lable> <textarea name='msg' id="text" rows="5"><?php echo set_value('msg');?></textarea><span style="float: right; color: red; margin-right: 150px"><?=form_error('msg')?></span>
  <div class="cleaner h10"></div>
  <lable for="file">Прикрепить фото:</lable> <input  type="file" name="filename" id="file"><span style="color: red; width: 400px"><?=form_error('filename')?></span>
  <div class="cleaner h10"></div>
  <input style="border-radius:8px; background: #464445; color:#fff" type="submit" value="Отправить" name="add"/>
  <input style="border-radius:8px; background: #464445; color:#fff" type="reset" value="Очистить" />
</form>
<div class="cleaner h20"></div>
<p style="color: red"><?//=$error?></p>
<div class="cleaner h10"></div>
<?php
echo $html;
?>
<h3></h3>
<p></p>
<div class="cleaner"></div>
<div class="a" style="width:200px; margin:0 auto; text-align: center"><?=$a;?></div>
<div class="cleaner"></div>
<?php
//Аякс запрос на отображение дополнительных результатов.
if(($page+1) < $num_pages)
  echo '<div class="loader" style="text-align:center; width: 100px; margin: 0 auto; cursor: pointer">Показать еще отзывы</div>';
?>
<div class="cleaner"></div>
<blockquote>Пишите нам, не стесняйтесь :)
</blockquote>
</div>
<script>
  var pages = <?=$page+2?>;
  var num_pages = <?=$num_pages?>;
  $('div.loader').on("click", function(){
    $.get('/shop/about', {page: pages}, function(data){
      $('div.a').before(data);
      $("div.float_r a:contains("+pages+")").replaceWith(function(index, oldHTML){
      return $("<span>").html(oldHTML);
      });
      pages = pages+1;
      if(pages > num_pages){
        $('div.loader').hide();
      }
    });
  });
</script>
