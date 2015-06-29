<?php
class Auth_class extends CI_Model {


    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
    }
    public $client_id = '4937362'; // ID приложения
    public $client_secret = 'q2BH4aPqssUuqWy1KyXb'; // Защищённый ключ
    public $redirect_uri = 'http://test1.com/authorization'; // Адрес странички для обратного редиректа.
    public $url = 'http://oauth.vk.com/authorize'; //URL при получени кода
    public $email;

    //Получаем и выводим ссылку на получение 'code'.
    function get_code(){
      $params = array(
        'client_id'=> $this->client_id,
        'redirect_uri'=> $this->redirect_uri,
        'response_type'=> 'code');
        $link = '<p><a href="' . $this->url . '?' . urldecode(http_build_query($params)) . '&scope=email">Аутентификация через ВКонтакте</a></p>';
        return $link;
    }
    //Получение токена и email пользователя.
    function get_token($code){
      if(isset($code)){
        $params = array(
          'client_id' => $this->client_id,
          'client_secret' => $this->client_secret,
          'code' => $code,
          'redirect_uri' => $this->redirect_uri
        );
        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
        return $token;
      }
    }
    //Получение имени и фамилии пользователя
    function get_name($token){
      if (isset($token['access_token'])) {
        $params = array(
                'uids' => $token['user_id'],
                'fields'=> 'uid,first_name,last_name',
                'access_token' => $token['access_token']
                );

      $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['uid'])) {
          $userInfo = $userInfo['response'][0];
          return $userInfo;
        }else return false;
      }
    }
}
