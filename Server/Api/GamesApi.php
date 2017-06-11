<?php
  require_once "ApiUtils.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Users/UsersService.php";
  require_once "../Engine/Games/GamesService.php";

  session_start();

  $request = getRequestType($_SERVER['REQUEST_URI']);
  switch ($request) {
    case "pendingGames":
      if (isset($_SESSION['loggedUserId'])){
        $gamesService = new GamesService();
        $games = $gamesService->getAllPendingGames();
        $response = array('Status' => "Ok", "Message" => "Succes", "Games" => $games);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
    case "addNewGame":
      if (isset($_SESSION['loggedUserId'])){
        if(isset($_POST['gameName'])){
          $gamesService = new GamesService();
          $response = $gamesService->createNewGame($_SESSION['loggedUserId'],$_POST['gameName']);
          echo(json_encode($response));
        }
        else{
          $response = array('Status' => "Error", "Message" => "Please set game name");
          echo(json_encode($response));
        }
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
    case "deleteGame":
      if (isset($_SESSION['loggedUserId'])){
        $gamesService = new GamesService();
        $response = $gamesService->deleteGameByOwner($_SESSION['loggedUserId']);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
    case "getGameState":
      if (isset($_SESSION['loggedUserId'])){
        $gamesService = new GamesService();
        $response = $gamesService->getStateForPlayer($_SESSION['loggedUserId']);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
    case "joinGame":
      if (isset($_SESSION['loggedUserId'])){
        if(isset($_POST['gameName'])){
          $gamesService = new GamesService();
          $response = $gamesService->setPlayerPlayingGame($_SESSION['loggedUserId'], $_POST['gameName']);
          echo(json_encode($response));
        }
        else{
          $response = array('Status' => "Error", "Message" => "Please set game name");
          echo(json_encode($response));
        }
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
    case "startGame":
      if (isset($_SESSION['loggedUserId'])){
        $gamesService = new GamesService();
        $response = $gamesService->startGameByOwner($_SESSION['loggedUserId']);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
  }






?>
