<?php
class Authorization_model extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }
    //-------------------Методы регистрации и авторизации пользователя------------------
    //Генерирует случайную строку из больших, маленьких букв и цифр.
    function generatePassword($length = 8){
      $chars = 'abcdefghijklmnoprstyzABDEFGHKNQRSTYZ23456789';
      $numChars = strlen($chars);
      $string = '';
      for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
      }
      return $string;
    }
    //Функция хеширования пароля
    function get_hash($string, $salt, $iteration){
      for($i = 0; $i<$iteration; $i++ ){
        $string = sha1($string . $salt);
        }
      return $string;
    }
    //Функция записи в базу инфы после регистрации пользователя.
    function registration($name, $last_name, $address, $phone, $email, $password, $salt){
      $data = array(
         'client_name' => $name ,
         'client_last_name' => $last_name ,
         'address'=> $address,
         'phone' => $phone,
         'client_email' => $email,
         'client_password' => $password,
         'salt' => $salt,
      );
      $this->db->insert('clients', $data);
      return $this->db->insert_id();
    }
    //Функция для проверки, есть ли такой email.
    function get_email($email){
      $this->db->select('client_email')->from('clients')->where('client_email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      if(!empty($arr['client_email'])) return $arr['client_email'];
      else return false;
    }
    //Функция для получения соли из базы.
    function get_salt($email){
      $this->db->select('salt')->from('clients')->where('client_email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['salt'];
    }
    //Функция получения пароля клиента из базы
    function get_password($email){
      $this->db->select('client_password')->from('clients')->where('client_email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['client_password'];
    }
    //Функция для записи инфы о пользователе при авторизации через вк.
    function registration_vk($email, $name='', $last_name='', $password, $salt){
      $data = array(
         'client_name' => $name ,
         'client_last_name' => $last_name ,
         'client_email'=> $email,
         'client_password' => $password,
         'salt' => $salt,
      );
      $this->db->insert('clients', $data);
      return $this->db->insert_id();
    }
    //Функция получения id пользователя
    function get_id($email){
      $this->db->select('client_id')->from('clients')->where('client_email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['client_id'];
    }
    //Функция для генерации случайного хеша при авторизации и регистрации для записи в куки и в базу.
    function create_cookie_hash($id){
      $salt = $this->generatePassword();
      $pass = $this->generatePassword();
      $password = $this->get_hash($pass, $salt, 50);
      $this->db->where('client_id', $id);
      $this->db->update('clients', array('cookie_hash'=>$password));
      return $password;
    }
    //Функция для извлечения временного хеша из базы.
    function get_cookie_hash($id){
      $this->db->select('cookie_hash')->from('clients')->where('client_id', $id);
      $result = $this->db->get();
      $arr = $result->row_array();
      if(isset($arr['cookie_hash']))
        return $arr['cookie_hash'];
      else return false;
    }
}
