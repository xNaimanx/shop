<div id="content" class="float_r">
  <h2>Пожалуйста авторизируйтесь в нашем магазине.</h2>
  <div id="contact_form">
     <form method="post"  action="<?= $_SERVER['REQUEST_URI']?>">
          <label for="email">Email:</label> <input type="text" id="email" name="email" value="<?php echo set_value('email');?>" class="validate-email required input_field" /><span style="color: red; margin-right: 150px"><?=form_error('email')?></span>
          <div class="cleaner h10"></div>
          <label for="password">Пароль:</label> <input type="password" id="password" name="password" class="required input_field" /><span style="color: red; margin-right: 150px"><?=form_error('password')?></span>
          <div class="cleaner h10"></div>

          <input style="border-radius:8px; background: #464445; color:#fff" type="submit" value="Войти" id="submit" name="submit" class="submit_btn float_l" />
          <input style="border-radius:8px; background: #464445; color:#fff" type="reset" value="Очистить" id="reset" name="reset" class="submit_btn float_r" />

</form>
  </div>
  <div class="cleaner h50"></div>
<?php
$code = new auth_class;
echo $code->get_code();
echo '<a href="authorization/registration">Зарегистрироваться</a>';
?>
</div>
