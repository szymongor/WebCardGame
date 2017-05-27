<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/DB/connect.php";


  class UserDao{

    private $db_connect;

    public function __construct(){}

    private function startConnection(){
      global $host, $db_user, $db_password, $db_name;
      $this->db_connect = @new mysqli($host, $db_user, $db_password, $db_name);
      if ($this->db_connect->connect_error) {
        return false;
        //die("Connection failed: " . $this->db_connect->connect_error);
      }
      else{
        return true;
      }
    }

    public function getUserById($id){
      $this->startConnection();
    	$queryStr = sprintf("SELECT * FROM `users` WHERE id = \"%s\"",$id);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$row = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $row;
    }

    public function getUserByLogin($login){
      $this->startConnection();
    	$queryStr = sprintf("SELECT * FROM `users` WHERE login = \"%s\"",$login);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$row = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $row;
    }

    public function getUserByEmail($email){
      $this->startConnection();
    	$queryStr = sprintf("SELECT * FROM `users` WHERE email = \"%s\"",$email);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$row = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $row;
    }

    public function addUser($login, $encyptedPass, $mail){
      $this->startConnection();
    	$queryStr = sprintf("INSERT INTO `users`(`login`, `password`, `email`) VALUES (\"%s\",\"%s\",\"%s\")",$login,$encyptedPass,$mail);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }

  }

  //$userDao = new userDao();
  //$response = $userDao->getUserByLogin('Szymon');
  //$userDao->addUser("Szymon123","12345678","ehe@gmal.com");
  //echo json_encode($response);




?>
