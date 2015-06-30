<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $data = array();

  public function __construct(){
    parent::__construct();

		ob_start();
		$this->load->model('basket_model');
		$this->load->model('catalog_model');
		$this->load->model('authorization_model');

		$this->data['count'] = $this->basket_model->basketInit();
		$this->data['categorys'] = $this->catalog_model->get_category();
		$this->data['genres'] = $this->catalog_model->get_genre();

		//Проверяем куки, делаем сверку пароля, который пришел с куки и если все ок даем ссылку на личный кабинет и открываем сессию.
		$this->data['session'] = $this->session->userdata('auth');
		if(!($this->data['session'] == 1)){
		  if(isset($_COOKIE['auth'])){
		    $auth = json_decode(urldecode($_COOKIE['auth']), true);
		    $password_cookie = $auth['password_cookie'];
		    $id = $auth['id'];
		    if(!$id){
		      echo 'Вы злосный злоумышленник. Доступ вам запрещен';
		      exit;
		    }
		    $pass_bd = $this->authorization_model->get_cookie_hash($id);
		    if($pass_bd == $password_cookie){
		      $this->session->set_userdata('email', $auth['email']);
		      $this->session->set_userdata('id', $auth['id']);
		      $this->session->set_userdata('auth', 1);
		      header('Location: /');
		    }else{
					setcookie("auth", "", time()-3600, '/');
					header('Location: /');
				}
		  }
		}
		//Выход авторизированного пользователя.
		if(isset($_GET['exit'])){
		  setcookie("auth", "", time()-3600, '/');
		  setcookie('ci_session', '', time()-3600, '/');
		  header('Location: /shop');
		}
  }

}
