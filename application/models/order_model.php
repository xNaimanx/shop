<?php
class Order_model extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }
    //---------------------Методы заказа---------------------------------
    //Функция сохранения заказа авторизированного пользователя.
    function saveOrder($dt){
      $goods = $this->basket_model->myBasket();
      foreach($goods as $val){
        $t = $val['product_price']*$val['quantity'];
        $total +=$t;
      }
      $user_id = $this->session->userdata('id');
      $data = array(
         'order_price' => $total ,
         'order_client_id' => $user_id ,
         'date'=> $dt
      );
      $this->db->insert('orders', $data);
      $id_order = $this->db->insert_id();
      foreach($goods as $v){
        $data = array(
           'order_id' => $id_order ,
           'product_id' => $v['product_id'] ,
           'product_amount'=> (int)$v['quantity'],
           'product_price'=> $v['product_price']
        );
        $this->db->insert('orders_product', $data);
      }
      $this->session->unset_userdata('basket');
      setcookie("basket", "", time()-3600, '/');
      $subject = 'Новый заказ';
      $mail1 = 'Поступил новый заказ №'.$id_order.PHP_EOL;
      mail('1viktorpavlenko1@gmail.com', $subject, $mail1);
      $subject = 'Информация о заказе';
      $mail2 = 'Номер вашего заказа:'.$id_order.PHP_EOL.'Вы заказали товаров на суму:'.$total;
      mail($this->session->userdata('email'), $subject, $mail2);
      return true;
    }
    //Функция сохранения заказа неавторизированного пользователя.
    function saveOrder_unauthorized($name, $email, $addres, $phone, $dt){
      $goods = $this->basket_model->myBasket();
      foreach($goods as $val){
        $t = $val['product_price']*$val['quantity'];
        $total +=$t;
      }
      $data = array(
         'order_price' => $total ,
         'date' => $dt ,
         'name'=> $name,
         'addres'=> $addres,
         'phone'=> $phone,
         'email'=> $email,
         'authorization'=> 'no'
      );
      $this->db->insert('orders', $data);
      $id_order = $this->db->insert_id();
      foreach($goods as $v){
        $data = array(
           'order_id' => $id_order ,
           'product_id' => $v['product_id'] ,
           'product_amount'=> (int)$v['quantity'],
           'product_price'=> $v['product_price']
        );
        $this->db->insert('orders_product', $data);
      }
      $subject = 'Новый заказ';
      $mail1 = 'Поступил новый заказ №'.$id_order.PHP_EOL;
      mail('1viktorpavlenko1@gmail.com', $subject, $mail1);
      $subject = 'Информация о заказе';
      $mail2 = 'Номер вашего заказа:'.$id_order.PHP_EOL.'Вы заказали товаров на суму:'.$total;
      mail($email, $subject, $mail2);
      $this->session->unset_userdata('basket');
      setcookie("basket", "", time()-3600, '/');
      return true;
    }
}
