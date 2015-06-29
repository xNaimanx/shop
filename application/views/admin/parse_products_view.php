<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>Парсер</h1></div>
<div class="add_cat" style="margin-bottom: 20px">
  <form method="post" name="contact" action="/admin/parse_products">
    <label for="category">Введите название книги:</label>
    <div class="clear">&nbsp;</div>
    <input type="text" name="kw" id="category"/>
    <div class="clear">&nbsp;</div>
    <input type="submit" value="Выполнить запрос"/>
  </form>
</div>
<div class="clear">&nbsp;</div>
<table border="1" width="100%" cellpadding="0" cellspacing="0" class="catalog">
  <tr>
    <th>Автор</th>
    <th>Название</th>
    <th>Год издания</th>
    <th>Жанр</th>
    <th>Описание</th>
    <th>Цена</th>
  </tr>

  <?=$html;?>
</table>
<div class="clear">&nbsp;</div>



<div class="clear">&nbsp;</div>
</div>

<div class="clear">&nbsp;</div>

<!--  end content -->


</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
