<?php
class Basket_model extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }
    //--------------------Функции корзины---------------------------------
    function saveBasket(){
      $basket = serialize($this->session->userdata('basket'));
      setcookie('basket', $basket, 0x7FFFFFFF, '/');
    }
    //Проверяем, были ли отосланы куки,если нет то добавляем в пустой массив $basket уникальный orderid и
    //  добавляем его к массиву после чего отправляем куки. Если да, то вытаскиваем из кук массив и
    //подсчитываем количестао ячеек этого массива и записываем в $count
    function basketInit(){
    if(empty($this->session->userdata('basket'))){
      if(!isset($_COOKIE['basket'])){
        $b = $this->session->userdata('basket');
        if(empty($b)){
          $this->session->set_userdata('basket', array());
          $this->saveBasket();
          $count = 0;
          return $count;
        }else{
          $count = count($this->session->userdata('basket'));
          $this->saveBasket();
          return $count;
        }
      }else{
        $this->session->set_userdata('basket', unserialize($_COOKIE['basket']));
        $count = count($this->session->userdata('basket'));
        return $count;
      }
    }else{
      $count = count($this->session->userdata('basket'));
      return $count;
    }
  }
    //Функция сохранения товара в корзину.
    function add2basket($id){
      $arr = $this->session->userdata('basket');
      $arr[$id] = 1;
      $this->session->set_userdata('basket', $arr);
      $this->saveBasket();
    }
    //Зачитываем корзину из базы в массив.
    function myBasket(){
      $b = $this->session->userdata('basket');
      $goods = array_keys($this->session->userdata('basket'));
      if(!$goods)
        return array();
      $arr = array();
      foreach($goods as $val){
        $this->db->select('product_id, title, author, product_price, image_medium')->from('products')->where('product_id', $val);
        $result = $this->db->get();
        $row = $result->row_array();
          $row['quantity'] = $b[$row['product_id']];
          $arr[] = $row;
        }
      return $arr;
    }
    //Функция удаления товара из корзины
    function deleteFromBasket($id){
      $arr = $this->session->userdata('basket');
      unset($arr[$id]);
      $this->session->set_userdata('basket', $arr);
      $this->saveBasket();
    }
    //Метод изменения количества товаров
    function addQuantity($q, $id){
      if($q){
        $arr = $this->session->userdata('basket');
        $arr[$id] = $q;
        $this->session->set_userdata('basket', $arr);
        $this->saveBasket();
        return TRUE;
      }else return FALSE;
    }
}
