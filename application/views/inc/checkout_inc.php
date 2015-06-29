<div id="content" class="float_r">
  <h2>Оформление заказа</h2>
    <h5><strong>Ваши данные:</strong></h5>
    <div class="content_half float_l">


        <div id="contact_form">
           <form method="post" name="contact" action="#">

                <label for="name">Имя:</label> <input type="text" id="name" name="name" value="<?php echo set_value('name');?>" class="required input_field" /><span style="color: red"><?=form_error('name')?></span>
                <div class="cleaner h10"></div>
                <label for="email">Email:</label> <input type="text" id="email" name="email" value="<?php echo set_value('email');?>" class="validate-email required input_field" /><span style="color: red"><?=form_error('email')?></span>
                <div class="cleaner h10"></div>
                <label for="addres">Адрес:</label> <input type="text" name="addres" id="addres" value="<?php echo set_value('addres');?>" class="input_field" /><span style="color: red"><?=form_error('addres')?></span>
                <div class="cleaner h10"></div>
                <label for="phone">Телефон:</label> <input type="text" name="phone" id="phone" value="<?php echo set_value('phone');?>" class="input_field" /><span style="color: red"><?=form_error('phone')?></span>
                <div class="cleaner h10"></div>
                <input type="submit" value="Отправить" id="submit" name="submit" class="submit_btn float_l" />
                <input type="reset" value="Очистить" id="reset" name="reset" class="submit_btn float_r" />

          </form>
        </div>
    </div>
    <div class="cleaner h20"></div>

    <div class="cleaner h50"></div>
    <div class="cleaner h50"></div>

</div>
