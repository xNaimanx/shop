<?php
class Admin_model extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }

    //Метод ля ресайза картинки.
    public function resize($name, $tmp){
      $end =  end(explode('.', $name));
      $t = time();
      move_uploaded_file($tmp, "files/images/".$t.'-large.'.$end);
      copy("files/images/".$t.'-large.'.$end, "files/images/".$t.'-medium.'.$end);
      copy("files/images/".$t.'-large.'.$end, "files/images/".$t.'-small.'.$end);
      $image = new Resize_image();

      $image->load("files/images/".$t.'-large.'.$end);
      $image->resize(300, 450);
      $image->save("files/images/".$t.'-large.'.$end);

      $image->load("files/images/".$t.'-medium.'.$end);
      $image->resize(200, 300);
      $image->save("files/images/".$t.'-medium.'.$end);

      $image->load("files/images/".$t.'-small.'.$end);
      $image->resize(66, 100);
      $image->save("files/images/".$t.'-small.'.$end);

      $img = array();
      $img['image_large'] = '/files/images/'.$t.'-large.'.$end;
      $img['image_medium'] = '/files/images/'.$t.'-medium.'.$end;
      $img['image_small'] = '/files/images/'.$t.'-small.'.$end;

      return $img;
    }
    //Получение всего каталога товаров
    public function get_catalog(){
      $this->db->select('product_id, title, author, pubyear, category, genre, product_description, product_price')->from('products');
      $query = $this->db->get();
      $array = $query->result_array();
      return $array;
    }

    //Формируем таблицу товаров
    public function get_table(){
      $array = $this->get_catalog();
      $html = '';
      foreach($array as $val){
        $html.= <<<HTML
        <tr>
          <td>{$val['product_id']}</td>
          <td>{$val['title']}</td>
          <td>{$val['author']}</td>
          <td>{$val['pubyear']}</td>
          <td>{$val['category']}</td>
          <td>{$val['genre']}</td>
          <td>{$val['product_price']}</td>
          <td><a href="/admin/delete_products/{$val['product_id']}">Удалить</a>&nbsp<a href="/admin/edit_product/{$val['product_id']}">Редактировать</a></td>
        </tr>
HTML;
      }
      return $html;
    }
    //Удаление товара из каталога
    public function delete_product($i){
  		$id = (int)$i;
  		$this->db->delete('products', array('product_id' => $id));
  	}
    //Список категорий. Если передать flag 1, вернет html для options. Если 2 для table.
    public function get_categorys($flag=FALSE){
      $this->db->select('id, category')->from('categorys')->order_by("id");
      $result = $this->db->get();
      $array = $result->result_array();
      $html = '';
      if($flag == 1){
        foreach($array as $val){
          $html .= <<<HTML
            <option value="{$val['category']}">{$val['category']}</option>
HTML;
        }
        return $html;
      }elseif($flag == 2){
        foreach($array as $val){
          $html .= <<<HTML
            <tr>
              <form class="edit" method="post" action="/admin/edit_category">
                <td>{$val['id']}</td>
                <td><input class="edit" type="text" name="category" value="{$val['category']}"/></td>
                <td><a href="/admin/delete_categorys/{$val['id']}">Удалить</a>&nbsp<input class="edit_button" type="submit" value="Изменить" id="submit" name="submit"/></td>
                <input type="hidden" name="id" value="{$val['id']}">
              </form>
            </tr>
HTML;
        }
        return $html;
      }
      else return $array;
    }
    //Список жанров. Если передать 1, вернет html для options. Если 2 для table.
    public function get_genres($flag=FALSE){
      $this->db->select('genres_id, genre')->from('genres')->order_by("genres_id");
      $result = $this->db->get();
      $array = $result->result_array();
      $html = '';
      if($flag == 1){
        foreach($array as $val){
          $html .= <<<HTML
            <option value="{$val['genre']}">{$val['genre']}</option>
HTML;
        }
        return $html;
      }elseif($flag == 2){
        foreach($array as $val){
          $html .= <<<HTML
            <tr>
              <form class="edit" method="post" action="/admin/edit_genre">
                <td>{$val['genres_id']}</td>
                <td><input class="edit" type="text" name="genre" value="{$val['genre']}"/></td>
                <td><a href="/admin/delete_genres/{$val['genres_id']}">Удалить</a>&nbsp<input class="edit_button" type="submit" value="Изменить" id="submit" name="submit"/></td>
                <input type="hidden" name="id" value="{$val['genres_id']}">
              </form>
            </tr>
HTML;
        }
        return $html;
      }
      else return $array;
    }
    //Метод для апдейта товара в БД.
    public function update_product($id, $title, $author, $pubyear, $category, $genre, $product_description, $product_price){
      $data = array(
       'title' => $title,
       'author' => $author,
       'pubyear' => $pubyear,
       'category' => $category,
       'genre' => $genre,
       'product_description' => $product_description,
       'product_price' => $product_price,
      );
      $this->db->where('product_id', $id);
      $this->db->update('products', $data);
    }
    //Метод для апдейта ссылок на картинки.
    public function update_image($id, $image_large, $image_medium, $image_small){
      $data = array(
       'image_large' => $image_large,
       'image_medium' => $image_medium,
       'image_small' => $image_small,
      );
      $this->db->where('product_id', $id);
      $this->db->update('products', $data);
    }
    //Метод для удаления категории
    public function delete_category($i){
      $id = (int)$i;
  		$this->db->delete('categorys', array('id' => $id));
    }
    //Метод апдейта категории
    public function update_category($id, $category){
      $this->db->where('id', $id);
      $this->db->update('categorys', array('category' => $category));
    }
    //Метод добавления категории
    public function add_categoty($category){
      if($this->validate_category($category))
        $this->db->insert('categorys', array('category' => $category));
      else return FALSE;
    }
    //Метод для удаления жанра
    public function delete_genre($i){
      $id = (int)$i;
  		$this->db->delete('genres', array('genres_id' => $id));
    }
    //Метод апдейта жанра.
    public function update_genre($id, $genre){
      $this->db->where('genres_id', $id);
      $this->db->update('genres', array('genre' => $genre));
    }
    //Метод добавления жанра
    public function add_genre($genre){
      if($this->validate_genre($genre))
        $this->db->insert('genres', array('genre' => $genre));
      else return FALSE;
    }
//////////////////////////////Управление администраторами////////////////////////////
    //Метод достает инфу по админам из базы. Если флаг 1 вернет html
    public function get_admins($flag = 1){
      $this->db->select('id, name, last_name, email, status')->from('admins')->order_by("id");
      $result = $this->db->get();
      $array = $result->result_array();
      $html = '';
      $admin = '';
      $super_admin = '';
      if($flag == 1){
        foreach($array as $val){
          if($val['status'] == 'admin')
              $admin = 'selected';
          if($val['status'] == 'super_admin')
              $super_admin = 'selected';
          $html .= <<<HTML
            <tr>
              <form class="edit" method="post" action="/admin/edit_admin">
                <td >{$val['id']}</td>
                <td ><input class="edit1" type="text" name="name" value="{$val['name']}"/></td>
                <td ><input class="edit1" type="text" name="last_name" value="{$val['last_name']}"/></td>
                <td ><input class="edit1" type="text" name="email" value="{$val['email']}"/></td>
                <td ><select class="edit1" name="status">
                  <option $admin value="admin">admin</option>
                  <option $super_admin value="super_admin">super_admin</option>
                </select></td>
                <td class="edit1"><a href="/admin/delete_admins/{$val['id']}">Удалить</a>&nbsp<a style="margin-left:30px" href="/admin/change_password_all?id={$val['id']}&email={$val['email']}">Изменить пароль</a>&nbsp<input class="edit_button" type="submit" value="Изменить" id="submit" name="submit"/>
                <input type="hidden" name="id" value="{$val['id']}">
              </form>
            </tr>
HTML;
            $admin = '';
            $super_admin = '';
        }
        return $html;
      }else return $array;
    }
    //Удаление админа
    public function delete_admin($id){
      $this->db->delete('admins', array('id' => $id));
    }
    //Метод апдейта админа.
    public function update_admin($id, $name, $last_name, $email, $status){
      $array = array(
          'name' => $name,
          'last_name' => $last_name,
          'email' => $email,
          'status' => $status
      );
      $this->db->where('id', $id);
      $this->db->update('admins', $array);
    }
    //Добавление админа
    public function add_admin($name, $last_name, $email, $password){
      $this->load->model('authorization_model');
      $salt = $this->authorization_model->generatePassword();
      $password = $this->authorization_model->get_hash($password, $salt, 50);
      $array = array(
        'name' => $name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => $password,
        'salt' => $salt
      );
      $this->db->insert('admins', $array);
    }
    //Смена пароля админа
    public function change_password($id, $password){
      $this->load->model('authorization_model');
      $salt = $this->authorization_model->generatePassword();
      $password = $this->authorization_model->get_hash($password, $salt, 50);
      $this->db->where('id', $id);
      $this->db->update('admins', array('password' => $password, 'salt' => $salt));
    }
    ////Функция для проверки, есть ли такой email.
    function get_email($email){
      $this->db->select('email')->from('admins')->where('email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      if(!empty($arr['email'])) return $arr['email'];
      else return false;
    }
    //Метод получения соли из базы
    public function get_salt($email){
      $this->db->select('salt')->from('admins')->where('email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['salt'];
    }
    //Функция получения пароля клиента из базы
    function get_password($email){
      $this->db->select('password')->from('admins')->where('email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['password'];
    }
    //Функция получения id пользователя
    function get_id($email){
      $this->db->select('id')->from('admins')->where('email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['id'];
    }
    //Функция получения статутса пользователя
    function get_status($email){
      $this->db->select('status')->from('admins')->where('email', $email);
      $result = $this->db->get();
      $arr = $result->row_array();
      return $arr['status'];
    }
    //Метод удаления отзыва из базы
    public function delete_reviews($id){
      $this->db->delete('reviews', array('reviews_id' => $id));
    }
    //Метод проверки на уникальность категории
    public function validate_category($category){
      $this->db->select('category')->from('categorys')->where('category', $category);
      $result = $this->db->get();
      $arr = $result->row_array();
      if($arr)
        return FALSE;
      else return TRUE;
    }
    //Метод проверки на уникальность жанра
    public function validate_genre($genre){
      $this->db->select('genre')->from('genres')->where('genre', $genre);
      $result = $this->db->get();
      $arr = $result->row_array();
      if($arr)
        return FALSE;
      else return TRUE;
    }
    //Метод парсинга ссылок/////////////////////////////////////////////////////////////////////
    public function parse_link($q){
      $url = 'http://price.ua/search';
      $agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';

      $ch = curl_init(); //инициализация библиотеки
      //указываем адрес страницы
      curl_setopt($ch, CURLOPT_URL,$url);
      //указываем заголовок User-Agent
      curl_setopt($ch, CURLOPT_USERAGENT, $agent);
      //указываем, что полученная страница должна быть сохранена в переменную
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      //указываем, что cURL должен переходить по редиректам
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      //Бустим время ожидания
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
      $referer = 'http://price.ua/';
      $postFields = array();
      $postFields['q'] = $q;
      $postFields['cat_id'] = '5022';
  //referer - адрес страницы с которой вы пришли,
      $referer = 'http://price.ua/';
      //т.е. нужно указать адрес страницы на которой находится форма
      curl_setopt($ch, CURLOPT_REFERER, $referer);
      //указываем, что мы отправляем данные методом post
      curl_setopt($ch, CURLOPT_POST, 1);
      //добавляем строку с post данными
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));

      //выполняем запрос
      $page = curl_exec($ch);
      preg_match_all('/<div class="clearer-block row">.*(?P<href>http.*?);/i', $page, $result);
      foreach($result['href'] as &$val){
          $val[strlen($val)-1]='';
      }
      $array = array();
      foreach($result['href'] as $val){
          $array[] = $this->parse_books($val);
      }
      //Делаем html для таблицы.
      $html = '';
      foreach($array as $v){
        $html .= <<<HTML
          <tr>
            <td>{$v['author']}</td>
            <td>{$v['title']}</td>
            <td>{$v['year']}</td>
            <td>{$v['genre']}</td>
            <td>{$v['description']}</td>
            <td>{$v['price']}</td>
          </tr>
HTML;
      }
      return $html;

    }
    //Метод парсенга книг, использоется после парсенга ссылок.
    public function parse_books($link){
      $login_url = trim($link);
      $agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
      $chc = curl_init(); //инициализация библиотеки
      $referer = 'http://price.ua';
      //указываем адрес страницы
      curl_setopt($chc, CURLOPT_URL, $login_url);
      //указываем заголовок User-Agent
      curl_setopt($chc, CURLOPT_USERAGENT, $agent);
      //указываем, что полученная страница должна быть сохранена в переменную
      curl_setopt($chc, CURLOPT_RETURNTRANSFER, 1);
      //указываем, что cURL должен переходить по редиректам
      curl_setopt($chc, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($chc, CURLOPT_REFERER, $referer);
      $page = curl_exec($chc);
      $page = mb_convert_encoding ($page ,"UTF-8" , "Windows-1251" );
      $result = array();
      preg_match('/<meta itemprop="author" content="(?P<author>.*)".*\s<meta itemprop="name".*content="(?P<title>.*)"/i', $page, $result);
      preg_match('/<span itemprop="datePublished">(?P<year>\d*)</i', $page, $year);
      preg_match('/<b>.*<a href="catalog.sect.*class="textlink">(?P<genre>.*)<\/a>/i', $page, $genre);
      preg_match('/<meta itemprop="description" content="[.]*(?P<description>.*)<meta itemprop="image"/s', $page, $description);
      preg_match('/<span itemprop="price".*hidden;">(?P<price>.*)<\/span/i', $page, $price);
      if(empty($result['title']))
        $result['title'] = '';
      if(empty($result['author']))
        $result['author'] = '';
      if(empty($year['year']))
        $year['year'] = '';
      if(empty($genre['genre']))
        $genre['genre'] = '';
      if(empty($description['description']))
        $description['description'] = '';
      if(empty($price['price']))
        $price['price'] = '';
      $description['description'] = str_replace('" />', '', $description['description']);
      $array = array(
          'title' => $result['title'],
          'author' => $result['author'],
          'year' => $year['year'],
          'genre' => $genre['genre'],
          'description' => $description['description'],
          'price' => trim($price['price']),
      );
      return $array;
    }
}
