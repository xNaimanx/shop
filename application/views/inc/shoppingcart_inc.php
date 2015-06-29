<div id="content" class="float_r">
  <h1>Корзина</h1>
  <?php
  if(!$arr) echo '<p>Корзина пуста</p>';
  ?>
  <table width="680px" cellspacing="0" cellpadding="5">
                 <tr bgcolor="#ddd">
                  <th width="220" align="left">Фото </th>
                  <th width="180" align="left">Описание </th>
                     <th width="100" align="center">Количество </th>
                  <th width="60" align="right">Цена </th>
                  <th width="60" align="right">Общая </th>
                  <th width="90"> </th>
                </tr>
              <?php
              $total = 0;
              foreach($arr as $val){
                $t = $val['product_price']*$val['quantity'];
                $total +=$t;
                echo <<<HTML
              <tr>
                  <td><a href="/products/productdetail?id={$val['product_id']}"><img src="{$val['image_medium']}" alt="{$val['title']}" /></a></td>
                  <td>{$val['author']}-{$val['title']}</td>
                    <td align="center"><input class="{$val['product_id']}" type="text" value="{$val['quantity']}" style="width: 20px; text-align: right" /><img class="{$val['product_id']}" src="/images/arrow.png" alt="Изменить количество" title="Изменить количество" style="margin-left:10px; cursor:pointer"/></td>
                    <td class="{$val['product_id']}" align="right">{$val['product_price']} </td>
                    <td id="{$val['product_id']}" align="right">$t</td>
                    <td align="center"> <a href="/shoppingcart/delete_from_basket?del={$val['product_id']}">Удалить</a> </td>
              </tr>
HTML;
              }
              ?>
                <tr>
                  <td colspan="3" align="right"  height="30px">Have you modified your basket? Please click here to <a href="shoppingcart.html"><strong>Update</strong></a>&nbsp;&nbsp; <br /> </td>
                    <td align="right" style="background:#ddd; font-weight:bold"> Всего </td>
                    <td align="right" style="background:#ddd; font-weight:bold"><?=$total?> </td>
                    <td style="background:#ddd; font-weight:bold"> </td>
    </tr>
  </table>
            <div style="float:right; width: 215px; margin-top: 20px;">

  <?php if ($count) echo '<p><a href="/checkout">Оформить заказ</a></p>';?>
            <!--<p><a href="javascript:history.back()">Продолжить покупки</a></p>-->
            <?php
            $server = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            if($count){
              if($server != $_SERVER['HTTP_REFERER'])
                echo '<p><a href="'.$_SERVER['HTTP_REFERER'].'">Продолжить покупки</a></p>';
              else  echo '<p><a href="/shop">Вернуться на главную страницу</a></p>';
              }else echo '<p><a href="/shop">Вернуться на главную страницу</a></p>';
            ?>
            </div>
            <script>

              $('img').on("click", function(event){
                var id = $(event.target).attr('class');
                var q = $("input."+id).val();
                var price = $("td."+id).html();
                $.post('/shoppingcart/addQ', {quantity: q, id: id}, function(){
                  $('td#'+id).html(price*q);
                });
                //alert ($(event.target).attr('class'));
                //alert(price);
              });
            </script>

</div>
