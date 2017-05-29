<?php
  require_once "ApiUtils.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Users/UsersService.php";

  session_start();

  $request = getRequestType($_SERVER['REQUEST_URI']);
  switch ($request) {
    case 'login':
      if (isset($_SESSION['loggedUserId'])){
        $response = array('Status' => "Ok", "Message" =>"You are already logged in ".$_POST['login'], "Login"=>$_POST['login']);
        echo(json_encode($response));
    	}
      else{
        if(isset($_POST['login']) && isset($_POST['password'])){
          $userService = new UserService();
          $user = $userService->loginUser($_POST['login'],$_POST['password']);
          if($user['status'] == "Ok"){
            //TO DO session
            $_SESSION['loggedUserId'] = $user['id'];
            $response = array('Status' => "Ok", "Message" =>"Welcome ".$_POST['login'], "Login"=>$_POST['login']);
            echo(json_encode($response));
          }
          else{
            $response = $user;
            echo(json_encode($response));
          }
        }
        else{
          $response = array('Status' => "Error", "Message" => "Type login and password");
          echo(json_encode($response));
        }
      }
    break;

    case 'logout':
      if(isset($_SESSION['loggedUserId'])){
        session_unset();
        $response = array('Status' => "Ok", "Message" => "You are logged out");
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are logged out");
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


?>
