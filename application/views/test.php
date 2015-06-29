<?php
/*echo '<pre>';
var_dump($goods);
echo '</pre>';*/
//$this->admin_model->update_product(46, 'asd', 'asd', 1984, 'asd', 'asd', 'asd', 200);
$array = $this->admin_model->parse_link('Лиса');
echo '<pre>';
var_dump($array);
echo '</pre>';
