<div id="content" class="float_r">
  <h2>Страница регистрации</h2>
  <div id="contact_form">
     <form method="post"  action="/authorization/registration">
          <label for="client_email">* Email:</label> <input type="text" id="client_email" name="email" value="<?php echo set_value('email');?>" class="validate-email required input_field" /><span style="color: red"><?=form_error('email')?></span>
          <div class="cleaner h10"></div>
          <label for="name">* Имя:</label> <input type="text" id="name" name="client_name" value="<?php echo set_value('client_name');?>" class="validate-email required input_field" /><span style="color: red"><?=form_error('client_name')?></span>
          <div class="cleaner h10"></div>
          <label for="client_last_name">Фамилия:</label> <input type="text" id="client_last_name" name="client_last_name" value="<?php echo set_value('client_last_name');?>" class="validate-email required input_field" /><span style="color: red"><?=form_error('client_last_name')?></span>
          <div class="cleaner h10"></div>
          <label for="address">* Адрес:</label> <input type="text" id="address" name="address" value="<?php echo set_value('address');?>" class="validate-email required input_field" /><span style="color: red"><?=form_error('address')?></span>
          <div class="cleaner h10"></div>
          <label for="phone">* Телефон:</label> <input type="text" id="phone" name="phone" value="<?php echo set_value('phone');?>" class="validate-email required input_field" /><span style="color: red"><?=form_error('phone')?></span>
          <div class="cleaner h10"></div>
          <label for="password">* Пароль:</label> <input type="password" id="password" name="client_password" value="<?php echo set_value('client_password');?>" class="required input_field" /><span style="color: red"><?=form_error('client_password')?></span>
          <div class="cleaner h10"></div>
          <label for="retype_password"style="width:150px">* Повторите пароль:</label> <input type="password" id="retype_password" name="retype_password" value="<?php echo set_value('retype_password');?>" class="required input_field" /><span style="color: red"><?=form_error('retype_password')?></span>
          <div class="cleaner h10"></div>

          <input type="submit" value="Зарегистрироваться" id="submit" name="submit" class="submit_btn float_l" />
          <input type="reset" value="Очистить" id="reset" name="reset" class="submit_btn float_r" />

      </form>
    </div>
  <div class="cleaner h30"></div>
</div>
