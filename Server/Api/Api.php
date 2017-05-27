<?php
  require_once "ApiUtils.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Users/UsersService.php";

  session_start();

  if (isset($_SESSION['user'])){
		echo('Already logged');
	}
	else{
    $request = getRequestType($_SERVER['REQUEST_URI']);
    switch ($request) {
      case 'login':
        if(isset($_POST['login']) && isset($_POST['password'])){
          if($_POST['login'] == "user123" && $_POST['password'] = "123"){
            $response = array('Status' => "Ok", "Message" =>"Welcome ".$_POST['login'], "Login"=>$_POST['login']);
            echo(json_encode($response));
          }
          else{
            $response = array('Status' => "Error", "Message" =>"No such user");
            echo(json_encode($response));
          }
        }
        else{
          $response = array('Status' => "Error", "Message" =>"Type login and password");
          echo(json_encode($response));
        }
      break;

      case 'register':
        if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
          $userService = new UserService();
          $response = $userService->registerUser($_POST['login'],$_POST['password'],$_POST['email']);
          echo(json_encode($response));
        }
        else{
          $response = array('Status' => "Error", "Message" =>"Type login, password and email");
          echo(json_encode($response));
        }
      break;
    }


  }



?>
