<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends MY_Controller {


	//Метод подтверждения заказа
	public function index(){
		if($this->data['count'] == 0){
			header('Location: /shop');
			exit;
		}
		$this->data['title'] = 'Подтверждение заказа';
		$goods = $this->basket_model->myBasket();
		$i = 1;
		$this->data['total'] = 0;
		foreach($goods as &$val){
			unset($val['product_id']);
			unset($val['image_medium']);
			array_unshift($val, $i);
			$i++;
			$this->data['total'] += $val['product_price']*$val['quantity'];
		}
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" width="600px">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('№', 'Название', 'Автор', 'Цена', 'Количество');
		$this->data['t'] = $this->table->generate($goods);;

		$this->load->view('header', $this->data);
		$this->load->view('inc/confirmation_order_inc');
		$this->load->view('footer');
	}
	//Метод обработки заказа
	public function procesing_order()
	{
		if($this->data['count'] == 0){
			header('Location: /shop');
			exit;
		}
		$this->data['title'] = 'Оформление заказа';
		$this->load->model('basket_model');
		$this->load->model('order_model');
		$this->load->model('auth_class');
		//Оформление заказа авторизированного пользователя.
		$auth = $this->session->userdata('auth');
		  if($auth == 1){
		    $date  = new DateTime();
		    $date = $date->format('Y-m-d H:i:s');
		    if($this->order_model->saveOrder($date)){
		      header('Location: /checkout/save_order');
					exit;
		    }
		  }
		//Оформление заказа неавторизированного пользователя.
		$this->load->library('form_validation');
		if(isset($_POST['submit'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->checkout_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				$name = $this->input->post('name', TRUE);
			  $email = $this->input->post('email', TRUE);
			  $addres = $this->input->post('addres', TRUE);
			  $phone = $this->input->post('phone', TRUE);
				$date  = new DateTime();
		    $date = $date->format('Y-m-d H:i:s');
		    $this->order_model->saveOrder_unauthorized($name, $email, $addres, $phone, $date);
		    header('Location: /checkout/save_order');
				exit;
			}
		}
		$this->load->view('header', $this->data);
		$this->load->view('inc/checkout_inc');
		$this->load->view('footer');
	}
	//Метод отображение информации о сохраненном заказе
	public function save_order()
	{
		$this->data['title'] = 'Сохранение заказа';
		//$this->load->model('shop_model');
		//$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/save_order_inc');
		$this->load->view('footer');
	}
}
