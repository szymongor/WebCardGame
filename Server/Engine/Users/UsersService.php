<?php
  require_once "UserDao.php";


  class UserService{

    private $userDao;

    public function __construct(){
      $userDao = new UserDao();
    }

    public function loginUser($login, $password){

      return "Hello";
    }

    public function registerUser($login, $password, $email){
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);
      $response = array('login' => $login, '$pass' => $pass_hash, '$email' => $email);
      return $response;

    }


  }


  //$userService = new UserService();

?>
