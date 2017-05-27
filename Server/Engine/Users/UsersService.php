<?php
  require_once "UserDao.php";


  class UserService{

    private $userDao;

    public function __construct(){
      $this->userDao = new UserDao();
    }

    public function loginUser($login, $password){
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);
      $user = $this->userDao->getUserByLogin($login);

      if($user['password'] = $pass_hash){
        $response = array('login' => $login, 'id'=> $user['id']);
      }
      else{
        $response = false;
      }

      return $response;
    }

    public function registerUser($login, $password, $email){
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);
      $response = array('login' => $login, '$pass' => $pass_hash, '$email' => $email);
      return $response;

    }
  }


  //$userService = new UserService();

?>
