<?php
  require_once "ApiUtils.php";
  require_once "../Engine/Match/MatchService.php";

  session_start();

  $request = getRequestType($_SERVER['REQUEST_URI']);
  switch ($request) {
    case "playersMove":
    if (isset($_SESSION['loggedUserId'])){
      $gamesService = new GamesService();
      if(isset($_SESSION['cardPosition']) && isset($_SESSION['isDiscarded'])){
        $response = $gamesService->playersMove($_SESSION['loggedUserId'], $cardsPositionInHand, $isDiscarded);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "Please set cardPosition and isDiscarded");
        echo(json_encode($response));
      }
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
  }



?>
