<?php


  session_start();

  if (isset($_SESSION['user'])){
		echo('Already logged');
	}
	else{
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

  }



?>
