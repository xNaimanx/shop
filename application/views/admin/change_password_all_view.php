<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>Сменить пароль</h1></div>

<div class="add_cat">
  <form method="post" name="contact" action="/admin/change_password_all">
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

  <input type="hidden" value="<?=$id?>" name="id"/>
  <input type="hidden" value="<?=$email?>" name="email"/>

  <input type="submit" class="button" value="Отправить" name="add"/>
  <input type="reset" class="button" value="очистить форму"/>
  </form>
</div>

</div>

<div class="clear">&nbsp;</div>

<!--  end content -->


</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
