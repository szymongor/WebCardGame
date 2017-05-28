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
          $response = array('status' =>'Error' , "Message" =>"Wrong password");
        }
      }
      else{
        $response = array('status' =>'Error' , "Message" =>"No such user");
      }

      return $response;
    }

    public function registerUser($login, $password, $email){

      if((strlen($login) < 3) || (strlen($login) >20)){
  			$response = array('status' => 'Error', 'Message' => "Nick should have from 3 to 20 characters!");
        return $response;
  		}
      if(ctype_alnum($login)==false){
        $response = array('status' => 'Error', 'Message' => "Nick should contain only letters and numbers!");
        return $response;
  		}
      $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
  		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB != $email))
  		{
        $response = array('status' => 'Error', 'Message' => "Please enter a valid email");
        return $response;
  		}
      $user = $this->userDao->getUserByLogin($login);
      if($user != null){
        $response = array('status' => 'Error', 'Message' => 'Nickname already exists');
        return $response;
      }

      $pass_hash = password_hash($password, PASSWORD_DEFAULT);


      $this->userDao->addUser($login, $pass_hash, $email);
      $response = array('status' => 'Ok', 'Message' => 'Succes. A new account has been created.');
      return $response;

    }
  }


  //$userService = new UserService();

?>
