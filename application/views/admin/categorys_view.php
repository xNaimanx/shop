<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>Категории</h1></div>
<table border="1" width="50%" cellpadding="0" cellspacing="0" class="catalog">
  <tr>
    <th class="edit">id</th>
    <th>Категория</th>
    <th>Действие</th>
  </tr>

  <?=$html;?>
</table>
<div class="clear">&nbsp;</div>
<button class="add_cat">Добавить категорию</button>
<div class="clear">&nbsp;</div>
<!-- Форма добавления категории. Вызывается по клику button.-->
<div class="add_cat">
  <form method="post" name="contact" action="/admin/add_category">
    <label for="category">Введите категорию:</label>
    <div class="clear">&nbsp;</div>
    <input type="text" name="category" id="category"/>
    <div class="clear">&nbsp;</div>
    <input type="submit" value="Добавить категорию"/>
  </form>
</div>
<div class="clear">&nbsp;</div>
</div>

<div class="clear">&nbsp;</div>

<!--  end content -->


</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>

<script>
$(document).ready(function() {
  $('div.add_cat').hide();
  $('button.add_cat').click(function(){
    $('div.add_cat').show();
    $('button.add_cat').hide();
  });
});
</script>
