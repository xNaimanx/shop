<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shoppingcart extends MY_Controller {
	//Отображение корзины
	public function index()
	{
		$this->data['title'] = 'Корзина';
		$this->load->model('basket_model');
		//Добавление товара в корзину
		if(isset($_GET['id'])){
		  $id = $this->input->get('id', TRUE);
		  $this->basket_model->add2basket($id);
		  header('Location: /shoppingcart');
		  exit;
		}
		$this->data['arr'] = $this->basket_model->myBasket();
		$this->data['count'] = $this->basket_model->basketInit();

		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/shoppingcart_inc');
		$this->load->view('footer');
	}
	//Удаление товара из корзины
	public function delete_from_basket()
	{
		$this->load->model('basket_model');
		$this->load->model('auth_class');

		$del = $this->input->get('del', TRUE);
		$this->basket_model->deleteFromBasket($del);
	  header('Location: /shoppingcart');
	}
	//Изменение количество товаров в корзине после аякс зароса.
	public function addQ(){
		$this->load->model('basket_model');
		$id = $this->input->post('id', TRUE);
		$quantity = $this->input->post('quantity', TRUE);
		$this->basket_model->addQuantity($quantity, $id);
	}
}
