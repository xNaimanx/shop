<?php
class Catalog_model extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }
//--------------методы для работы с каталогом товаров. Запись/вывод.---------------------------------
//Функция сохранения данных в БД.
  function add2cat($title, $author, $pubyear, $category, $genre, $product_description, $product_price, $image_large, $image_medium, $image_small){
    $data = array(
       'title' => $title ,
       'author' => $author ,
       'pubyear'=> $pubyear,
       'category' => $category,
       'genre' => $genre,
       'product_description' => $product_description,
       'product_price' => $product_price,
       'image_large' => $image_large,
       'image_medium' => $image_medium,
       'image_small' => $image_small
    );
    $this->db->insert('products', $data);
    return true;
  }
  //Функция получения каталога товаров из базы.Если переданы доп. параметры то выводит по жанрам и категориям.
  function get_product($start,$per_page,$category='', $genre='', $keyword='', $price=''){
    if($price == 'sort_by_price')
      $order_by = 'product_price';
    else $order_by = 'product_id';
    if(!$category and !$genre and !$keyword)
      $this->db->select('product_id, title, author, product_price, image_medium')->from('products')->order_by($order_by, 'desc');
    if($category and !$genre)
      $this->db->select('product_id, title, author, product_price, image_medium')->from('products')->where('category', $category)->order_by($order_by, 'desc');
    if(!$category and $genre)
      $this->db->select('product_id, title, author, product_price, image_medium')->from('products')->where('genre', $genre)->order_by($order_by, 'desc');
    if(!$category and !$genre and $keyword)
      $this->db->select('product_id, title, author, product_price, image_medium')->from('products')->like('title', $keyword)->or_like('author', $keyword)->order_by($order_by, 'desc');
    $this->db->limit($per_page, $start);
    $query = $this->db->get();
    $array = $query->result_array();
    $class = '';
    $i = 1;
    $html = '';
    if(!$array) $html = '<div>По вашему запросу ничего не найдено.</div>';
    foreach($array as $val){
      if(!is_array($val)) continue;
      if($i%3){
        $class = "product_box";
      }else {
        $class = "product_box no_margin_right";
      }

      $html .= <<<HTML
      <div class="$class">
        <a href="/products/productdetail?id={$val['product_id']}"><img src={$val['image_medium']} alt={$val['title']} /></a>
          <div style="height:50px"><h3>{$val['author']}-{$val['title']}</h3></div>
          <p class="product_price">{$val['product_price']}</p>
          <a href="/shoppingcart?id={$val['product_id']}" class="add_to_card">Добавить в корзину</a>
          <a href="/products/productdetail?id={$val['product_id']}" class="detail">Описание</a>
      </div>
HTML;
    $i++;
    }
    return $html;
  }
  //Функция получения описания товара.
  function get_product_detail($id){
    $this->db->select('title, author, pubyear, category, genre, product_description, product_price, image_medium, image_large')->from('products')->where('product_id', $id);
    $query = $this->db->get();
    $array = $query->row_array();
    return $array;
  }
  //Функция для получения количества записей в таблице products. (В зависимости от жанра и категории если переданы доп. параметры)
  function get_count_rows($category='', $genre='', $keyword=''){
    if(!$category and !$genre){
      $this->db->select('COUNT(*) as count')->from('products');
      $result = $this->db->get();
    }
    if($category and !$genre){
      $this->db->select('COUNT(*) as count')->from('products')->where('category', $category);
      $result = $this->db->get();
    }
    if(!$category and $genre){
      $this->db->select('COUNT(*) as count')->from('products')->where('genre', $genre);
      $result = $this->db->get();
    }
    if(!$category and !$genre and $keyword){
      $this->db->select('COUNT(*) as count')->from('products')->like('title', $keyword)->or_like('author', $keyword);
      $result = $this->db->get();
    }
    $row = $result->row_array();
    $total_rows=$row['count'];
    return $total_rows;
  }
  //Функция получения категорий из базы.
  function get_category(){
    $this->db->select('category')->distinct()->from('products');
    $result = $this->db->get();
    $array = $result->result_array();
    return $array;
  }
  //Функция получения всех жанров из БД.
  function get_genre(){
    $this->db->select('genre')->distinct()->from('products');
    $result = $this->db->get();
    $array = $result->result_array();
    return $array;
  }
  //Метод получения из базы информации о ТОП-продажах
  function get_top(){
    $sql = 'SELECT products.product_id, products.title, products.product_description, products.product_price, products.image_medium, count(orders_product.product_id) AS count
    FROM products, orders_product
    WHERE products.product_id=orders_product.product_id
    GROUP BY orders_product.product_id
    ORDER BY count DESC
    LIMIT 5';
    $query = $this->db->query($sql);
    $array = $query->result_array();
    $cnt = 1;
    $detail = '';
    $item = '';
    $arr = array();
    foreach($array as $val){
      $detail .= <<<DETAIL
        <div class="detail">
          <h4><a href="products/productdetail?id={$val['product_id']}">{$val['title']}</a></h4>
          <p style="height:92px; overflow:hidden">{$val['product_description']}</p>
          <p>Цена: {$val['product_price']}</p>
          <a href="/shoppingcart?id={$val['product_id']}" title="Read more" class="more">В корзину</a>
        </div>
DETAIL;
      $item .= <<<ITEM
      <div class="item item_$cnt">
        <img src="{$val['image_medium']}" alt="{$val['title']}" />
      </div>
ITEM;
      $cnt++;
    }
    $arr['detail'] = $detail;
    $arr['item'] = $item;
    return $arr;
  }
}
