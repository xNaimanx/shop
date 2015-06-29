<div id="content" class="float_r">
  <h2>Подтверждение заказа</h2>
  <div class="cleaner h20"></div>
  <h4>Вы заказываете:</h4>
   <?=$t;?>
   <div class="cleaner h20"></div>
   <p style="font-size:1.2em">Всего книг на сумму: <?=$total?></p>
   <div class="cleaner h50"></div>
   <div class="cleaner h50"></div>


   <form action="/checkout/procesing_order" method="POST">
     <input style="border-radius:8px; background: #3E3E3E; color:#fff" type="submit" value="Подтвердить заказ"/>
   </form>
   <div class="cleaner h30"></div>
   <a href="/shop">Вернуться на главную страницу.</a>
 </div>
