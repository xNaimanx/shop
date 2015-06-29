<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
			// вызываем конструктор класса
			parent::__construct();
			$this->load->model('admin_model');
			$this->load->model('catalog_model');
	}

//Страница авотризации //////////////////////////////////////////////////////////////////////////
public function index(){
	$this->load->library('form_validation');
	if(isset($_POST['add'])){
		$this->load->model('rules_model');
		$this->form_validation->set_rules($this->rules_model->authorization_admin_rules);
		$check = $this->form_validation->run();
		if($check == TRUE){
			$email = $this->input->post('email', TRUE);
			$id = $this->admin_model->get_id($email);
			$status = $this->admin_model->get_status($email);
			$this->session->set_userdata('admin_auth', 1);
			$this->session->set_userdata('admin_id', $id);
			$this->session->set_userdata('admin_email', $email);
			$this->session->set_userdata('admin_status', $status);
			//setcookie('auth', $auth, time()+1209600, '/');
			header('Location: /admin/products');
		}else{
			$this->load->view('admin/login_view');
		}
	}else $this->load->view('admin/login_view');
}
//Коллбэк функция для проверки email в базе.//////////////////////////////////////////////////////
public function email_check(){
	$email = $this->input->post('email', TRUE);
	$email = $this->admin_model->get_email($email);
	if(!empty($email))
		return TRUE;
	else{
		$this->form_validation->set_message('email_check', '');
		return FALSE;
	}
}
//Коллбэк функция для проверки password в базе.///////////////////////////////////////////////////
public function password_check(){
	if(!$this->email_check()){
		$this->form_validation->set_message('password_check', 'Неверный логин или пароль');
		return FALSE;
	}
	$this->load->model('authorization_model');
	$email = $this->input->post('email', TRUE);
	$password = $this->input->post('password', TRUE);
	$salt = $this->admin_model->get_salt($email);
	$pas = $this->authorization_model->get_hash($password, $salt, 50);
	$password = $this->admin_model->get_password($email);
	if($pas != $password){
		$this->form_validation->set_message('password_check', 'Неверный логин или пароль');
		return FALSE;
	}else return TRUE;
}

//Добавление товара в каталог/////////////////////////////////////////////////////////////
	public function add_product()
	{
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$this->load->model('catalog_model');
		$data['title'] = 'Добавление товара';
		$data['categorys'] = $this->admin_model->get_categorys(1);
		$data['genres'] = $this->admin_model->get_genres(1);
		$this->load->model('resize_image');
		$this->load->library('form_validation');

		if(isset($_POST['add'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->add_catalog_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//Принимаем данные, пришедшие из формы.
				$title = $this->input->post('title', TRUE);
				$author = $this->input->post('author', TRUE);
				$pubyear = $this->input->post('pubyear', TRUE);
				$category = $this->input->post('category', TRUE);
				$genre = $this->input->post('genre', TRUE);
				$product_description = $this->input->post('product_description', TRUE);
				$product_price = $this->input->post('product_price', TRUE);
				//Перемещаем файл и ресайзим картинку
				$tmp = $_FILES['image']['tmp_name'];
		    $name = $_FILES['image']['name'];
		    $image = $this->admin_model->resize($name, $tmp);
				//сохраняем пришедшие данные в БД.
				$this->catalog_model->add2cat($title, $author, $pubyear, $category, $genre, $product_description, $product_price, $image['image_large'], $image['image_medium'], $image['image_small']);
				header('Location: /admin/add_product');
			}else {
				$this->load->view('admin/header_view', $data);
				$this->load->view('admin/add_product_view', $data);
				$this->load->view('admin/footer_view', $data);
			}
		}
		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/add_product_view', $data);
		$this->load->view('admin/footer_view', $data);
	}

	//callback функция для проверки формата загруженной картинки///////////////////////////////////
	public function file_check(){
		if(preg_match('/[.](GPG)|(jpg)|(GPEG)|(jpeg)|(GIF)|(gif)|(PNG)|(png)$/', $_FILES['image']['name']))
			return TRUE;
		else{
			$this->form_validation->set_message('file_check', 'Некорректный формат картинки. Загрузите пожалуйста ваше изображениев формате: jpg или png или gif.');
			return FALSE;
		}
	}
	//Отображение всех товаров/////////////////////////////////////////////////////////////////////////////
	public function products(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Все товары';
		$data['html'] = $this->admin_model->get_table();

		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/products_view', $data);
		$this->load->view('admin/footer_view', $data);
	}
	//Удаление товара в каталоге //////////////////////////////////////////////////
	public function delete_products($id){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$this->admin_model->delete_product($id);
		header('Location: /admin/products');
	}
	//Редактирование товара.////////////////////////////////////////////////
	public function edit_product($id=1){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Редактирование товара';
		//Принимаем список категорий и жанров для отображения в форме
		$data['categorys'] = $this->admin_model->get_categorys(1);
		$data['genres'] = $this->admin_model->get_genres(1);
		$id = (int)$id;
		$data['id'] = $id;
		//Получаем описание товара для отображения в форме
		$data['product'] = $this->catalog_model->get_product_detail($id);
		$this->load->model('resize_image');
		//Приступаем к валидации формы
		$this->load->library('form_validation');
		if(isset($_POST['add'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->update_catalog_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//Принимаем данные, пришедшие из формы.
				$title = $this->input->post('title', TRUE);
				$author = $this->input->post('author', TRUE);
				$pubyear = $this->input->post('pubyear', TRUE);
				$category = $this->input->post('category', TRUE);
				$genre = $this->input->post('genre', TRUE);
				$product_description = $this->input->post('product_description', TRUE);
				$product_price = $this->input->post('product_price', TRUE);
				$id = $this->input->post('id', TRUE);
				//Перемещаем файл и ресайзим картинку если она пришла и апдейтим ссылки в БД.
				if(!empty($_FILES['image']['tmp_name'])){
					$tmp = $_FILES['image']['tmp_name'];
			    $name = $_FILES['image']['name'];
			    $image = $this->admin_model->resize($name, $tmp);
					$this->admin_model->update_image($id, $image['image_large'], $image['image_medium'], $image['image_small']);
				}
				$this->admin_model->update_product($id, $title, $author, $pubyear, $category, $genre, $product_description, $product_price);
				header('Location: /admin/products');
				}else {
					$this->load->view('admin/header_view', $data);
					$this->load->view('admin/edit_product_view', $data);
					$this->load->view('admin/footer_view', $data);
				}
		}
		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/edit_product_view', $data);
		$this->load->view('admin/footer_view', $data);

	}
	//callback функция для проверки формата загруженной картинки///////////////////////////////////
	public function file_check_update(){
		if(!empty($_FILES['image']['name'])){
			if(preg_match('/[.](GPG)|(jpg)|(GPEG)|(jpeg)|(GIF)|(gif)|(PNG)|(png)$/', $_FILES['image']['name']))
				return TRUE;
			else{
				$this->form_validation->set_message('file_check', 'Некорректный формат картинки. Загрузите пожалуйста ваше изображениев формате: jpg или png или gif.');
				return FALSE;
			}
		}else return TRUE;
	}
	//Отображение категорий//////////////////////////////////////////////////
	public function categorys(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Категории';
		$data['html'] = $this->admin_model->get_categorys(2);
		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/categorys_view', $data);
		$this->load->view('admin/footer_view', $data);
	}
	//Удаление категорий//////////////////////////////////////////
	public function delete_categorys($id){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$id = (int)$id;
		if(!empty($id))
			$this->admin_model->delete_category($id);
		header('Location: /admin/categorys');
	}
	//Редактирование категорий//////////////////////////////////////
	public function edit_category(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->input->post('id', TRUE);
			$category = $this->input->post('category', TRUE);
			if(!empty($category))
				$this->admin_model->update_category($id, $category);
			header('Location: /admin/categorys');
		}else header('Location: /admin/categorys');
	}
	//Добавление категории/////////////////////////////////
	public function add_category(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$category = $this->input->post('category', TRUE);
			if(!empty($category)){
				$this->admin_model->add_categoty($category);
			}
			header('Location: /admin/categorys');
		}else header('Location: /admin/categorys');
	}
	//Отображение жанров////////////////////////////////////////
	public function genres(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Жанры';
		$data['html'] = $this->admin_model->get_genres(2);
		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/genres_view', $data);
		$this->load->view('admin/footer_view', $data);
	}
	//Удаление жанров//////////////////////////////////////////
	public function delete_genres($id){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$id = (int)$id;
		if(!empty($id))
			$this->admin_model->delete_genre($id);
		header('Location: /admin/genres');
	}
	//Редактирование жанров//////////////////////////////////////
	public function edit_genre(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->input->post('id', TRUE);
			$genre = $this->input->post('genre', TRUE);
			if(!empty($genre))
				$this->admin_model->update_genre($id, $genre);
			header('Location: /admin/genres');
		}else header('Location: /admin/genres');
	}
	//Добавление жанров/////////////////////////////////
	public function add_genre(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$genre = $this->input->post('genre', TRUE);
			if(!empty($genre)){
				$this->admin_model->add_genre($genre);
			}
			header('Location: /admin/genres');
		}else header('Location: /admin/genres');
	}
	//Отображение инфы по администраторам.//////////////////////////////////////////////
	public function admins(){
		if(empty($this->session->userdata('admin_auth')) or ($this->session->userdata('admin_status') != 'super_admin')){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Администраторы';
		$data['html'] = $this->admin_model->get_admins(1);
		//Валидация формы при добавлении админа, прием данных и запись в БД
		$this->load->library('form_validation');
		if(isset($_POST['add'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->add_admin_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//Принимаем данные, пришедшие из формы.
				$name = $this->input->post('name', TRUE);
				$last_name = $this->input->post('last_name', TRUE);
				$email = $this->input->post('email', TRUE);
				$password = $this->input->post('password', TRUE);
				//сохраняем пришедшие данные в БД.
				$this->admin_model->add_admin($name, $last_name, $email, $password);
				$subject = 'Данные авторизации';
		    $mail = 'Ваш логин: '.$email. PHP_EOL . 'Ваш пароль: '. $password . PHP_EOL;
		    mail($email, $subject, $mail);
				header('Location: /admin/admins');
			}else {
					$this->load->view('admin/header_view', $data);
					$this->load->view('admin/admins_view', $data);
					$this->load->view('admin/footer_view', $data);
			}
		}else {
			$this->load->view('admin/header_view', $data);
			$this->load->view('admin/admins_view', $data);
			$this->load->view('admin/footer_view', $data);
		}

	}
	//Удаление админов//////////////////////////////////////////
	public function delete_admins($id){
		if(empty($this->session->userdata('admin_auth')) or ($this->session->userdata('admin_status') != 'super_admin')){
			header('Location: /admin');
			exit;
		}
		$id = (int)$id;
		if(!empty($id))
			$this->admin_model->delete_admin($id);
		header('Location: /admin/admins');
	}
	//Редактирование админов//////////////////////////////////////
	public function edit_admin(){
		if(empty($this->session->userdata('admin_auth')) or ($this->session->userdata('admin_status') != 'super_admin')){
			header('Location: /admin');
			exit;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->input->post('id', TRUE);
			$name = $this->input->post('name', TRUE);
			$last_name = $this->input->post('last_name', TRUE);
			$email = $this->input->post('email', TRUE);
			$status = $this->input->post('status', TRUE);
			if(empty($name) or empty($last_name) or empty($email) or empty($status)){
				header('Location: /admin/admins');
				exit;
			}
			$this->admin_model->update_admin($id, $name, $last_name, $email, $status);
			header('Location: /admin/admins');
		}else header('Location: /admin/admins');
	}
	//Смена пароля всем суперадмином.////////////////////////////////////////////////////////////////
	public function change_password_all(){
		if(empty($this->session->userdata('admin_auth')) or ($this->session->userdata('admin_status') != 'super_admin')){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Поменять пароль';
		$id = (int)$this->input->get('id', TRUE);
		$email = $this->input->get('email', TRUE);
		if(!empty($id)) $data['id'] = $id;
		if(!empty($email)) $data['email'] = $email;
		//Валидация формы при смене пароля, прием данных и запись в БД
		$this->load->library('form_validation');
		if(isset($_POST['add'])){
			$data['id'] = $this->input->post('id', TRUE);
			$data['email'] = $this->input->post('email', TRUE);
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->change_password_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//Принимаем данные, пришедшие из формы.
				$password = $this->input->post('password', TRUE);
				$this->admin_model->change_password($data['id'], $password);
				$subject = 'Смена пароля';
		    $mail = 'Ваш логин: '.$data['email']. PHP_EOL . 'Ваш пароль: '. $password . PHP_EOL;
		    mail($data['email'], $subject, $mail);
				header('Location: /admin/admins');
			}else {
						$this->load->view('admin/header_view', $data);
						$this->load->view('admin/change_password_all_view', $data);
						$this->load->view('admin/footer_view', $data);
			}
		}else{
			$this->load->view('admin/header_view', $data);
			$this->load->view('admin/change_password_all_view', $data);
			$this->load->view('admin/footer_view', $data);
		}
	}
	//Смена личного пароля.////////////////////////////////////////////////////////////////
	public function change_password(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$data['title'] = 'Поменять пароль';
		$id = $this->session->userdata('admin_id');
		$email = $this->session->userdata('admin_email');
		//Валидация формы при смене пароля, прием данных и запись в БД
		$this->load->library('form_validation');
		if(isset($_POST['add'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->change_password_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//Принимаем данные, пришедшие из формы.
				$password = $this->input->post('password', TRUE);
				$this->admin_model->change_password($id, $password);
				$subject = 'Смена пароля';
		    $mail = 'Ваш логин: '.$email. PHP_EOL . 'Ваш пароль: '. $password . PHP_EOL;
		    mail($email, $subject, $mail);
				header('Location: /admin/products');
			}else {
						$this->load->view('admin/header_view', $data);
						$this->load->view('admin/change_password_view', $data);
						$this->load->view('admin/footer_view', $data);
			}
		}else{
			$this->load->view('admin/header_view', $data);
			$this->load->view('admin/change_password_view', $data);
			$this->load->view('admin/footer_view', $data);
		}
	}
	//Logout///////////////////////////////////////////////////////
	public function logout(){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$this->session->unset_userdata('admin_auth');
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('admin_email');
		$this->session->unset_userdata('admin_status');
		header('Location: /admin');
	}
 //Удаление отзывов о магазине
	public function delete_reviews($id){
		if(empty($this->session->userdata('admin_auth'))){
			header('Location: /admin');
			exit;
		}
		$id = (int)$id;
		$this->admin_model->delete_reviews($id);
		header('Location: /shop/about');
	}
//Парсинг товаров.
public function parse_products(){
	if(empty($this->session->userdata('admin_auth'))){
		header('Location: /admin');
		exit;
	}
	$data['title'] = 'Парсер товаров';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$kw = trim($this->input->post('kw', TRUE));
		$data['html'] = '';
		$data['html'] = $this->admin_model->parse_link($kw);
		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/parse_products_view', $data);
		$this->load->view('admin/footer_view', $data);
	}else{
		$data['html'] = '';
		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/parse_products_view', $data);
		$this->load->view('admin/footer_view', $data);
	}
}




}
