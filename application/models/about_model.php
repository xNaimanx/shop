<?php
class About_model extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }
    //--------------------Методы добавления/чтения отзывов о магазине из БД-----------------------------
    //Функция добавления отзывов о магазине в БД.
    function put_reviews($name, $email, $msg, $date){
      $data = array(
         'name' => $name ,
         'email' => $email ,
         'msg'=> $msg,
         'date' => $date
      );
      $this->db->insert('reviews', $data);
    }
    //Функция получения всех отзывов о магазине из БД
    function get_reviews($per_page, $start){
      $this->db->select('reviews_id,name,email,msg,date')->from('reviews')->order_by('reviews_id', 'desc');
      $this->db->limit($per_page, $start);
      $query = $this->db->get();
      $array = $query->result_array();
      return $array;
    }
    //Метод получения количества записей в таблице reviews
    function count_reviews(){
      $this->db->select('COUNT(*) as count')->from('reviews');
      $result = $this->db->get();
      $row = $result->row_array();
      $total_rows=$row['count'];
      return $total_rows;
    }
}
