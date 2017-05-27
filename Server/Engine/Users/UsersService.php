<?php
  require_once "UserDao.php";


  class UserService{

    private $userDao;

    public function __construct(){
      $this->userDao = new UserDao();
    }

    public function loginUser($login, $password){

      $user = $this->userDao->getUserByLogin($login);
      if($user){
        if(password_verify($password, $user['password'])){
          $response = array('status' =>'Ok' ,'login' => $login, 'id'=> $user['id']);
        }
        else{
          $response = array('status' =>'Error' , "Message" =>"Wrong password:");
        }
      }
      else{
        $response = array('status' =>'Error' , "Message" =>"No such user");
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
