<div id="content" class="float_r">
  <h2 style="line-height:1.2"><?=$hed?></h2>
  <div class="cleaner h10"></div>
  <?php
  if($href != '/search'):
  ?>
  <a href="/products<?=$href.$name.'/'.($page+1).'/sort_by_price'?>" style="display:block; width:200px; margin: 0 auto">Отсортировать по стоимости</a>
  <div class="cleaner h30"></div>
  <?php
  endif;
  echo $html;
  // Выводим ссылки на страницы:
  echo '<div class="a" style= "text-align:center; width:600px; clear:both; margin: 0 auto;">';
  $num_pages=ceil($total_rows/$per_page);
  for($i=1;$i<=$num_pages;$i++) {
    if ($i-1 == $page) {
      echo $i." ";
    } else {
        echo '<a class="loader" href="/products'.$href.$name.'/'.$i.$sort.'">'.$i."</a> ";
      }
  }
  echo '</div>';
  ?>
  <div class="cleaner h10"></div>
  <?php
  //Аякс запрос на отображение дополнительных результатов.
  if(($page+1) < $num_pages)
    echo '<div class="loader" style="color:#08aee3;text-align:center; width: 100px; margin: 0 auto; cursor: pointer">Показать еще результаты</div>';
  ?>
</div>
<script>
  var pages = <?=$page+2?>;
  var num_pages = <?=$num_pages?>;
  var link = '/products'+ '<?=$href.$name?>' + '/' + pages + '<?=$sort?>';
  $('div.loader').on("click", function(){
    $.get(link, {}, function(data){
      $('div.a').before(data);
      $("div.float_r a:contains("+pages+")").replaceWith(function(index, oldHTML){
      return $("<span>").html(oldHTML);
      });
      pages = pages+1;
      link = '/products'+ '<?=$href.$name?>' + '/' + (pages) + '<?=$sort?>';
      if(pages > num_pages){
        $('div.loader').hide();
      }
    });
  });
</script>
