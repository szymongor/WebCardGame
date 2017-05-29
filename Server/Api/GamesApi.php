<?php
  require_once "ApiUtils.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Users/UsersService.php";

  session_start();

  $request = getRequestType($_SERVER['REQUEST_URI']);
  switch ($request) {
    case "games":
      if (isset($_SESSION['loggedUserId'])){
        $response = array('Status' => "Ok", "Message" => "Succes", "Games" => array('Game1'=>'id1'));
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }

    break;


  }






?>
