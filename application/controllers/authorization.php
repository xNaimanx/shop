<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorization extends MY_Controller {

	public function index()
	{
		$this->data['title'] = 'Страница авторизации';
		$this->load->model('authorization_model');
		$this->load->model('auth_class');
		//Авторизация через вк
		if (isset($_GET['code'])) {
			$token = new Auth_class;
		  $token = $token->get_token($_GET['code']);
		  $email = $token['email'];
		  $fields = new Auth_class;
		  $fields = $fields->get_name($token);
		  $name = $fields['first_name'];
		  $last_name = $fields['last_name'];
		  $em = $this->authorization_model->get_email($email);
			if(!$em){
		    $salt = $this->authorization_model->generatePassword();
		    $pas = $this->authorization_model->generatePassword();
		    $password = $this->authorization_model->get_hash($pas, $salt, 50);
		    if(!($id = $this->authorization_model->registration_vk($email, $name, $last_name, $password, $salt))) echo 'Не удалось записать в БД';
		    $subject = 'Данные авторизации';
		    $mail = 'Ваш логин: '.$email. PHP_EOL . 'Ваш пароль: '. $pas . PHP_EOL;
		    mail($email, $subject, $mail);
		    $password_cookie = $this->authorization_model->create_cookie_hash($id);
		    $arr = array("id"=>$id, "email"=>$email, "password_cookie"=>$password_cookie);
		    $auth = urlencode(json_encode($arr));
		    $this->session->set_userdata('auth', 1);
		    $this->session->set_userdata('id', $id);
		    $this->session->set_userdata('email', $email);
		    setcookie('auth', $auth, time()+1209600, '/');
		    header('Location: /shop');
		    exit;
		  }else{
		    $id = $this->authorization_model->get_id($email);
		    $password_cookie = $this->authorization_model->create_cookie_hash($id);
		    $arr = array("id"=>$id, "email"=>$email, "password_cookie"=>$password_cookie);
		    $auth = urlencode(json_encode($arr));;
		    $this->session->set_userdata('auth', 1);
		    $this->session->set_userdata('id', $id);
		    $this->session->set_userdata('email', $email);
		    setcookie('auth', $auth, time()+1209600, '/');
		    header('Location: /shop');
		    exit;
		  }
		}
		//Авторизация через форму
		$this->load->library('form_validation');
		if(isset($_POST['submit'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->auth_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				$email = $this->input->post('email', TRUE);
				$password = $this->input->post('password', TRUE);
				$id = $this->authorization_model->get_id($email);
		    $password_cookie = $this->authorization_model->create_cookie_hash($id);
		    $arr = array("id"=>$id, "email"=>$email, "password_cookie"=>$password_cookie);
		    $auth = urlencode(json_encode($arr));
		    $this->session->set_userdata('auth', 1);
		    $this->session->set_userdata('id', $id);
		    $this->session->set_userdata('email', $email);
		    setcookie('auth', $auth, time()+1209600, '/');
		    header('Location: /shop');

			}else{
				$this->data['title'] = 'Страница авторизации';
				$this->load->view('header', $this->data);
				$this->load->view('inc/authorization/login');
				$this->load->view('footer');
			}
		}else
		$this->data['title'] = 'Страница авторизации';
		$this->load->view('header', $this->data);
		$this->load->view('inc/authorization/login');
		$this->load->view('footer');
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////
	//Коллбэк функция для проверки email в базе.
	public function email_check(){
		$email = $this->input->post('email', TRUE);
		$email = $this->authorization_model->get_email($email);
		if(!empty($email))
			return TRUE;
		else{
			$this->form_validation->set_message('email_check', '');
			return FALSE;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////
	//Коллбэк функция для проверки password в базе.
	public function password_check(){
		if(!$this->email_check()){
			$this->form_validation->set_message('password_check', 'Неверный логин или пароль');
			return FALSE;
		}
		$this->load->model('authorization_model');
		$email = $this->input->post('email', TRUE);
		$password = $this->input->post('password', TRUE);
		$salt = $this->authorization_model->get_salt($email);
		$pas = $this->authorization_model->get_hash($password, $salt, 50);
		$password = $this->authorization_model->get_password($email);
		if($pas != $password){
			$this->form_validation->set_message('password_check', 'Неверный логин или пароль');
			return FALSE;
		}else return TRUE;
}
	///////////////////////////////////Регистрация//////////////////////////////////////////////////
	public function registration()
	{
		$this->data['title'] = 'Страница регистрации';
		$this->load->model('authorization_model');
		$this->load->model('auth_class');
		$this->load->library('form_validation');
		if(isset($_POST['submit'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->registration_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//Принимаем данные из формы.
				$email = $this->input->post('email', TRUE);
			  $name = $this->input->post('client_name', TRUE);
			  $last_name = $this->input->post('client_last_name', TRUE);
			  $address = $this->input->post('address', TRUE);
			  $phone = $this->input->post('phone', TRUE);
			  $password = $this->input->post('client_password', TRUE);
				//Приводим пароль в вид, пригодный для хранения в базе.
				$salt = $this->authorization_model->generatePassword();
		    $password = $this->authorization_model->get_hash($password, $salt, 50);
				//Пишем в базу данные о пользователе.
		    $id = $this->authorization_model->registration($name, $last_name, $address, $phone, $email, $password, $salt);
		    $password_cookie = $this->authorization_model->create_cookie_hash($id);
		    $arr = array("id"=>$id, "email"=>$email, "password_cookie"=>$password_cookie);
		    $auth = urlencode(json_encode($arr));
		    $this->session->set_userdata('auth', 1);
		    $this->session->set_userdata('id', $id);
		    $this->session->set_userdata('email', $email);
		    setcookie('auth', $auth, time()+1209600, '/');
		    header('Location: /authorization/save_client');
			}else{
				$this->load->view('header', $this->data);
				$this->load->view('inc/authorization/registration');
				$this->load->view('footer');
			}
		}else{
			$this->load->view('header', $this->data);
			$this->load->view('inc/authorization/registration');
			$this->load->view('footer');
		}

	}
	/////////////////////////////////////////////////////////////////////////////////////
	//Коллбэк функция для для проверки на предмет свободного имени email.
	public function email_registration_check(){
		$email = $this->input->post('email', TRUE);
		$email = $this->authorization_model->get_email($email);
		if(empty($email))
			return TRUE;
		else{
			$this->form_validation->set_message('email_registration_check', 'Такой email уже существует.');
			return FALSE;
		}
	}
////////////////////////////////////////////////////////////////////////////////////////
	public function save_client()
	{
		$this->data['title'] = 'Успешная регистрация';
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/authorization/save_client');
		$this->load->view('footer');
	}
}
