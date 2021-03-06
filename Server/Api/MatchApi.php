<?php
  require_once "ApiUtils.php";
  require_once "../Engine/Match/MatchService.php";
  require_once "../Engine/Card/CardsService.php";


  session_start();

  $request = getRequestType($_SERVER['REQUEST_URI']);
  switch ($request) {
    case "playersMove":
    if(isset($_SESSION['loggedUserId'])){
      if( isset($_POST['cardPosition']) && isset($_POST['isDiscarded']) && isset($_POST['target']) ){
        $matchService = new MatchService();
        $response = $matchService->playersMove($_SESSION['loggedUserId'],
         $_POST['cardPosition'], $_POST['isDiscarded'], $_POST['target']);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "Please set cardPosition, isDiscarded and target");
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
        $matchService = new MatchService();
        $gameState = $matchService->getGameStateForPlayer($_SESSION['loggedUserId']);
        $response = array('Status' => "Ok", "GameState" => $gameState, "Id" => $_SESSION['loggedUserId']);
        echo(json_encode($response));
      }
      else{
        $response = array('Status' => "Error", "Message" => "You are not logged");
        echo(json_encode($response));
      }
    break;
    case "cards":
      $cardsService = new CardsService();
      $response = $cardsService->getCardsFile();
      echo(json_encode($response));
      break;
  }



?>
