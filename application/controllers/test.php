<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller{

	public function index()
	{
		$this->load->model('basket_model');
		$this->load->model('admin_model');
		
		//$this->data['goods'] = $this->admin_model->get_genres();
		//$arr[40] = 2;
		//$this->session->set_userdata('basket', $arr);
		//$this->data['x'] = $this->session->userdata('basket');

		$this->load->view('test', $this->data);
		//$this->basket_model->saveBasket();
}
}
