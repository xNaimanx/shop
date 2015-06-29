<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>Администраторы</h1></div>
<table border="1"  cellpadding="0" cellspacing="0" class="catalog">
  <tr>
    <th class="edit">id</th>
    <th>Имя</th>
    <th>Фамилия</th>
    <th>email</th>
    <th>Статус</th>
    <th class="opt">Действие</th>
  </tr>

  <?=$html;?>
</table>
<div class="clear">&nbsp;</div>
<button class="add_cat">Добавить администратора</button>
<div class="clear">&nbsp;</div>
<!-- Форма добавления админа. Вызывается по клику button.-->
<div class="add_cat">
  <form method="post" name="contact" action="/admin/admins">
    <label for="name">Имя:</label>
    <div class="clear">&nbsp;</div>
    <input type="text" name="name" id="name" value="<?php echo set_value('name');?>"/>
    <div class="clear">&nbsp;</div>
    <span class="admin"><?=form_error('name')?></span>
    <div class="clear">&nbsp;</div>

    <label for="last_name">Фамилия:</label>
    <div class="clear">&nbsp;</div>
    <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name');?>"/>
    <div class="clear">&nbsp;</div>
    <span class="admin"><?=form_error('last_name')?></span>
    <div class="clear">&nbsp;</div>

    <label for="email">email:</label>
    <div class="clear">&nbsp;</div>
    <input type="text" name="email" id="email" value="<?php echo set_value('email');?>"/>
    <div class="clear">&nbsp;</div>
    <span class="admin"><?=form_error('email')?></span>

    <label for="password">Пароль:</label>
    <div class="clear">&nbsp;</div>
    <input type="password" name="password" id="password" value="<?php echo set_value('password');?>"/>
    <div class="clear">&nbsp;</div>
    <span class="admin"><?=form_error('password')?></span>

    <label for="retype_password">Подтвердить пароль:</label>
    <div class="clear">&nbsp;</div>
    <input type="password" name="retype_password" id="retype_password" value="<?php echo set_value('retype_password');?>"/>
    <div class="clear">&nbsp;</div>
    <span class="admin"><?=form_error('retype_password')?></span>

    <input type="submit" class="button" value="Добавить админа" name="add"/>
    <input type="reset" class="button" value="очистить форму"/>
  </form>
</div>
<div class="clear">&nbsp;</div>
</div>

<div class="clear">&nbsp;</div>

<!--  end content -->


</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>

<?php
if(empty(form_error('name')) and empty(form_error('last_name')) and empty(form_error('email')) and empty(form_error('password')) and empty(form_error('retype_password'))):
?>
<script>
$(document).ready(function() {
  $('div.add_cat').hide();
  $('button.add_cat').click(function(){
    $('div.add_cat').show();
    $('button.add_cat').hide();
  });
});
</script>
<?php else:?>
<script>
  $(document).ready(function() {
    $('button.add_cat').hide();
  });
</script>
<?php endif;?>
