<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules_model extends CI_Model {

  //Правила для валидации формы about
  public $about_rules = array(
    array(
      'field'=> 'name',
      'label'=> 'Имя',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'email',
      'label'=> 'Email',
      'rules'=> 'required|xss_clean|valid_email|trim'
    ),
    array(
      'field'=> 'msg',
      'label'=> 'Текст',
      'rules'=> 'required|xss_clean|trim|max_length[255]'
    )
  );
  //Правила для валидации формы авторизации.
  public $auth_rules = array(
    array(
      'field'=> 'email',
      'label'=> 'email',
      'rules'=> 'required|xss_clean|trim|callback_email_check'
    ),
    array(
      'field'=> 'password',
      'label'=> 'Пароль',
      'rules'=> 'required|xss_clean|trim|callback_password_check'
    ),
  );
  //Правила для валидации формы регистрации.
  public $registration_rules = array(
    array(
      'field'=> 'email',
      'label'=> 'email',
      'rules'=> 'required|xss_clean|trim|valid_email|callback_email_registration_check'
    ),
    array(
      'field'=> 'client_name',
      'label'=> 'Имя',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'client_last_name',
      'label'=> 'Фамилия',
      'rules'=> 'xss_clean|trim'
    ),
    array(
      'field'=> 'address',
      'label'=> 'Адрес',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'phone',
      'label'=> 'Телефон',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'client_password',
      'label'=> 'Пароль',
      'rules'=> 'required|xss_clean|trim|min_length[5]'
    ),
    array(
      'field'=> 'retype_password',
      'label'=> 'Повторите пароль',
      'rules'=> 'required|xss_clean|trim|matches[client_password]'
    ),
  );
  //Правила для валидации формы заказа товара.
  public $checkout_rules = array(
    array(
      'field'=> 'name',
      'label'=> 'Имя',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'email',
      'label'=> 'email',
      'rules'=> 'required|xss_clean|trim|valid_email'
    ),
    array(
      'field'=> 'addres',
      'label'=> 'Адрес',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'phone',
      'label'=> 'Телефон',
      'rules'=> 'required|xss_clean|trim'
    ),
  );
  //Правила для валидации формы добавления товара.
  public $add_catalog_rules =array(
    array(
      'field'=> 'title',
      'label'=> 'Название книги',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'author',
      'label'=> 'Автор',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'category',
      'label'=> 'Категория',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'genre',
      'label'=> 'Жанр',
      'rules'=> 'xss_clean|trim'
    ),
    array(
      'field'=> 'pubyear',
      'label'=> 'Год публикации',
      'rules'=> 'required|xss_clean|trim|exact_length[4]|integer'
    ),
    array(
      'field'=> 'product_price',
      'label'=> 'Цена',
      'rules'=> 'required|xss_clean|trim|numeric'
    ),
    array(
      'field'=> 'product_description',
      'label'=> 'Описание',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'image',
      'label'=> 'Картинка',
      'rules'=> 'callback_file_check'
    )
  );
  //Правила для валидации формы добавления товара.
  public $update_catalog_rules =array(
    array(
      'field'=> 'title',
      'label'=> 'Название книги',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'author',
      'label'=> 'Автор',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'category',
      'label'=> 'Категория',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'genre',
      'label'=> 'Жанр',
      'rules'=> 'xss_clean|trim'
    ),
    array(
      'field'=> 'pubyear',
      'label'=> 'Год публикации',
      'rules'=> 'required|xss_clean|trim|exact_length[4]|integer'
    ),
    array(
      'field'=> 'product_price',
      'label'=> 'Цена',
      'rules'=> 'required|xss_clean|trim|numeric'
    ),
    array(
      'field'=> 'product_description',
      'label'=> 'Описание',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'image',
      'label'=> 'Картинка',
      'rules'=> 'callback_file_check_update'
    )
  );
  //Валидация формы добавления админа
  public $add_admin_rules = array(
    array(
      'field'=> 'name',
      'label'=> 'Имя',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'last_name',
      'label'=> 'Фамилия',
      'rules'=> 'required|xss_clean|trim'
    ),
    array(
      'field'=> 'email',
      'label'=> 'email',
      'rules'=> 'required|xss_clean|trim|valid_email|is_unique[admins.email]'
    ),
    array(
      'field'=> 'password',
      'label'=> 'пароль',
      'rules'=> 'required|xss_clean|trim|min_length[8]'
    ),
    array(
      'field'=> 'retype_password',
      'label'=> 'Подтвердить пароль',
      'rules'=> 'required|xss_clean|trim|matches[password]'
    ),
  );
  //Валидация формы смены пароля
  public $change_password_rules = array(
    array(
      'field'=> 'password',
      'label'=> 'пароль',
      'rules'=> 'required|xss_clean|trim|min_length[8]'
    ),
    array(
      'field'=> 'retype_password',
      'label'=> 'Подтвердить пароль',
      'rules'=> 'required|xss_clean|trim|matches[password]'
    ),
  );
  //Валидация формы авотризации в админке
  public $authorization_admin_rules = array(
    array(
      'field'=> 'email',
      'label'=> 'email',
      'rules'=> 'required|xss_clean|trim|callback_email_check'
    ),
    array(
      'field'=> 'password',
      'label'=> 'пароль',
      'rules'=> 'required|xss_clean|trim|callback_password_check'
    ),
  );
}
