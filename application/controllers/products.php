<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

	//Вывод всех товаров////////////////////////////////////////////////////
	public function index($page=1, $sort='')
	{
		$this->data['href'] = '/index';
		$this->data['title'] = 'Товары';
		$this->data['name'] = '';
		$this->load->model('catalog_model');
		$this->data['category'] = '';
		$this->data['genre'] = '';
		$this->data['sort'] = '/'.trim(strip_tags($sort));
		// количество записей, выводимых на странице
		$this->data['per_page'] = 9;
		//Получаем кол-во записей в таблице
		$this->data['total_rows'] = $this->catalog_model->get_count_rows();
		//Формируем заголовки и переменные для ссылок пагинации.
		$this->data['hed'] = 'Каталог книг: ';
		// получаем номер страницы
		if($page) $this->data['page']=((int)$page-1); else $this->data['page'] = 0;
		// вычисляем первый оператор для LIMIT
		$start = abs($this->data['page']*$this->data['per_page']);
		//Получаем данные для вывода из базы.
		$this->data['html'] = $this->catalog_model->get_product($start,$this->data['per_page'], '' ,'' ,'' , $sort);
		//Проверяем, был ли аякс запрос и отдаем ему html
		if($this->input->is_ajax_request()){
			echo $this->data['html'];
			exit;
		}
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/products_inc');
		$this->load->view('footer');
	}

	//Вывод товаров по категориям///////////////////////////////////////////////
	public function category($category = '', $page = 1, $sort = ''){
		$this->data['href'] = '/category';
		$this->data['title'] = 'Товары';
		$this->data['name'] = '/'.trim(strip_tags($category));
		$this->load->model('catalog_model');
		$this->data['category'] = trim(strip_tags(urldecode($category)));
		$this->data['sort'] = '/'.trim(strip_tags($sort));
		// количество записей, выводимых на странице
		$this->data['per_page'] = 9;
		//Получаем кол-во записей в таблице
		$this->data['total_rows'] = $this->catalog_model->get_count_rows($this->data['category']);
		//Формируем заголовки и переменные для ссылок пагинации.
		$this->data['hed'] = 'Книги по категориям: '.$this->data['category'];
		// получаем номер страницы
		if($page) $this->data['page']=((int)$page-1); else $this->data['page'] = 0;
		// вычисляем первый оператор для LIMIT
		$start = abs($this->data['page']*$this->data['per_page']);
		//Получаем данные для вывода из базы.
		$this->data['html'] = $this->catalog_model->get_product($start,$this->data['per_page'],$this->data['category'] ,'' ,'' , $sort);
		//Проверяем, был ли аякс запрос и отдаем ему html
		if($this->input->is_ajax_request()){
			echo $this->data['html'];
			exit;
		}
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/products_inc');
		$this->load->view('footer');
	}
	//Вывод товаров по жанрам//////////////////////////////////////////////////////////
	public function genre($genre = '', $page = 1, $sort = ''){
		$this->data['href'] = '/genre';
		$this->data['title'] = 'Товары';
		$this->data['name'] = '/'.trim(strip_tags($genre));
		$this->load->model('catalog_model');
		$this->data['genre'] = trim(strip_tags(urldecode($genre)));
		$this->data['sort'] = '/'.trim(strip_tags($sort));
		// количество записей, выводимых на странице
		$this->data['per_page'] = 9;
		//Получаем кол-во записей в таблице
		$this->data['total_rows'] = $this->catalog_model->get_count_rows('', $this->data['genre']);
		//Формируем заголовки и переменные для ссылок пагинации.
		$this->data['hed'] = 'Книги по жанрам: '.$this->data['genre'];
		// получаем номер страницы
		if($page) $this->data['page']=((int)$page-1); else $this->data['page'] = 0;
		// вычисляем первый оператор для LIMIT
		$start = abs($this->data['page']*$this->data['per_page']);
		//Получаем данные для вывода из базы.
		$this->data['html'] = $this->catalog_model->get_product($start,$this->data['per_page'], '' ,$this->data['genre'] , '' , $sort);
		//Проверяем, был ли аякс запрос и отдаем ему html
		if($this->input->is_ajax_request()){
			echo $this->data['html'];
			exit;
		}
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/products_inc');
		$this->load->view('footer');
	}
	//Вывод товаров по поиску//////////////////////////////////////////////////////////////////
	public function search($page = 1, $sort = ''){
		if(isset($_POST['keyword']))
			$this->data['search'] = $this->input->post('keyword', TRUE);
		else $this->data['search'] = '';
		$this->data['href'] = '/search';
		$this->data['title'] = 'Товары';
		$this->data['name'] = '/'.$this->data['search'];
		$this->load->model('catalog_model');
		$this->data['sort'] = '/'.trim(strip_tags($sort));
		// количество записей, выводимых на странице
		$this->data['per_page'] = 9;
		//Получаем кол-во записей в таблице
		$this->data['total_rows'] = $this->catalog_model->get_count_rows('', '', $this->data['search']);
		//Формируем заголовки и переменные для ссылок пагинации.
		$this->data['hed'] = 'Вы искали: '.$this->data['search'];
		// получаем номер страницы
		if($page) $this->data['page']=((int)$page-1); else $this->data['page'] = 0;
		// вычисляем первый оператор для LIMIT
		$start = abs($this->data['page']*$this->data['per_page']);
		//Получаем данные для вывода из базы.
		$this->data['html'] = $this->catalog_model->get_product($start,$this->data['per_page'], '' ,'' , $this->data['search'] , $sort);
		//Проверяем, был ли аякс запрос и отдаем ему html
		if($this->input->is_ajax_request()){
			echo $this->data['html'];
			exit;
		}
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/products_inc');
		$this->load->view('footer');
	}

	public function productdetail()
	{
		$this->data['title'] = 'Описание товара';
		$this->load->model('catalog_model');

		if(isset($_GET['id']))
		  $this->data['id'] = $this->input->get('id', TRUE);
		//Получаем описание из базы
		$this->data['arr'] = $this->catalog_model->get_product_detail($this->data['id']);

		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/productdetail_inc');
		$this->load->view('footer');
	}

}
