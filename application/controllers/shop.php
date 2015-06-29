<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends MY_Controller {

	public function index()
	{
		$this->data['title'] = 'Главная страница';
		$this->load->model('catalog_model');
		$this->data['html'] = $this->catalog_model->get_product(0,6);
		//Инфа для слайдера
		$arr = $this->catalog_model->get_top();
		$this->data['detail'] = $arr['detail'];
		$this->data['item'] = $arr['item'];

		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/home_inc');
		$this->load->view('footer');
	}
	public function about()
	{
		$this->data['title'] = 'О нас';
		$this->load->model('about_model');
		// количество записей, выводимых на странице
		$per_page = 4;
		//Получаем кол-во записей в таблице
		$total_rows = $this->about_model->count_reviews();
		// получаем номер страницы
		if (isset($_GET['page'])) $this->data['page'] =(((int)$this->input->get('page', TRUE))-1); else $this->data['page'] = 0;
		// вычисляем первый оператор для LIMIT
		$start = abs($this->data['page']*$per_page);
		//Получаем данные для вывода из базы.
		$this->data['array'] = $this->about_model->get_reviews($per_page, $start);
		//Отображение гостевой книги
		$this->data['html'] = '';
		$delete = '';
		foreach($this->data['array'] as $val){
			if($this->session->userdata('admin_auth')==1)
				$delete = '<a href="/admin/delete_reviews/'.$val['reviews_id'].'" style="float:right;">Удалить</a>';
			$name = $val['name'];
			$email = $val['email'];
			$msg = $val['msg'];
			$datetime = new Datetime($val['date']);
			$this->data['html'] .= <<<HTML
			<hr>
			<p>
			<a href="mailto:$email">$name</a> @ {$datetime->format('d-m-Y H:i:s')}
			<br>$msg
			$delete
			</p>
HTML;
		}
		//Проверяем, был ли аякс запрос и отдаем ему html
		if($this->input->is_ajax_request()){
			echo $this->data['html'];
			exit;
		}
		// Делаем ссылки на страницы:
		$this->data['num_pages']=ceil($total_rows/$per_page);
		$this->data['a'] = '';
		for($i=1;$i<=$this->data['num_pages'];$i++) {
	    if ($i-1 == $this->data['page']) {
				$this->data['a'] .= $i." ";
			} else {
		        $this->data['a'] .= '<a class="loader" href="/shop/about?page='.$i.'">'.$i."</a> ";
		    }
		}
		//Валидация формы и прием данных
		$this->load->library('form_validation');
		$this->form_validation->set_rules('filename', 'фото', 'callback_file_check');
		if(isset($_POST['add'])){
			$this->load->model('rules_model');
			$this->form_validation->set_rules($this->rules_model->about_rules);
			$check = $this->form_validation->run();
			if($check == TRUE){
				//принимаем даные из формы.
				$name = $this->input->post('name', TRUE);
		    $email = $this->input->post('email', TRUE);
		    $msg = $this->input->post('msg', TRUE);
		    $date  = new DateTime();
		    $date = $date->format('Y-m-d H:i:s');
				$this->about_model->put_reviews($name, $email, $msg, $date);

				if(isset($_FILES['filename']['name'])){
					$tmp = $_FILES['filename']['tmp_name'];
		      $folder = "/files/images/";
		      $name = $_FILES['filename']['name'];
		      $end =  end(explode('.', $name));
		      move_uploaded_file($tmp, "files/about_images/".time().'.'.$end);
					}
					$this->load->model('auth_class');
					$this->load->view('header', $this->data);
					$this->load->view('inc/about_inc');
					$this->load->view('footer');
					header('Location: /shop/about');
			}else{
				$this->load->model('auth_class');
				$this->load->view('header', $this->data);
				$this->load->view('inc/about_inc');
				$this->load->view('footer');
			}
		}
		else{
			$this->load->model('auth_class');
			$this->load->view('header', $this->data);
			$this->load->view('inc/about_inc');
			$this->load->view('footer');
		}
	}
	//Коллбэк функция для валидации типа файла. Юзается вконтроллере about.
	public function file_check(){
		if(!empty($_FILES['filename']['name'])){
			if(preg_match('/[.](GPG)|(jpg)|(GPEG)|(jpeg)|(GIF)|(gif)|(PNG)|(png)$/', $_FILES['filename']['name']))
				return TRUE;
			else{
				$this->form_validation->set_message('file_check', 'Некорректный формат картинки. Загрузите пожалуйста ваше изображениев формате: jpg или png или gif.');
				return FALSE;
			}
		}else return TRUE;
	}

	public function faqs()
	{
		$this->data['title'] = 'FAQs';
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/faqs_inc');
		$this->load->view('footer');
	}
	public function contacts()
	{
		$this->data['title'] = 'Контакты';
		$this->load->model('auth_class');
		$this->load->view('header', $this->data);
		$this->load->view('inc/contact_inc');
		$this->load->view('footer');
	}
}
